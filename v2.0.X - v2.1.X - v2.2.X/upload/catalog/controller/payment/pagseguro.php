<?php
require_once DIR_SYSTEM . "library/pagseguro/pagseguro.class.php";

class ControllerPaymentPagSeguro extends Controller {
    public function index() {
		$this->load->language("payment/pagseguro");
		$config = $this->getConfig();

		$data["script"] = $config->script_url;
		$data["cancel"] = $config->cancel_url;
		$data["redirect"] = $config->redirect_url;
		$data["post"] = $config->post_url;
		$data["delay"] = $config->auto_start_delay;
		$data["auto_start"] = $config->auto_start;
		$data["loading"] = $this->language->get("text_loading");
		$data["button"] = $this->language->get("text_button");

		if(version_compare(VERSION, "2.2.0.0") < 0) {
            if (file_exists(DIR_TEMPLATE . $this->config->get("config_template") . "/template/payment/pagseguro.tpl")) {
                return $this->load->view($this->config->get("config_template") . "/template/payment/pagseguro.tpl", $data);
            }
			else {
                return $this->load->view("default/template/payment/pagseguro.tpl", $data);
            }
        }
		else {
            return $this->load->view("payment/pagseguro", $data);
        }
    }

	public function order() {
        $this->load->model("checkout/order");
        $this->load->model("tool/upload");

		$PagSeguro = new PagSeguro();
		$config = $this->getConfig();

		$order_info = $this->model_checkout_order->getOrder($this->session->data["order_id"]);
		$order_info["shipping"] = $this->session->data["shipping_method"];
		$order_info["products"] = $this->getProducts($order_info, $this->cart);
		$order_info["total"] = $this->getTotal($order_info);
		$order_info["shipping"]["cost"] = $this->getShippingCost($order_info);
		$order_info["discount"] = $this->getDiscount($order_info, $this->cart);
		$order_info["address_street"] = $this->getStreet($order_info, $config);
		$order_info["address_number"] = $this->getNumber($order_info, $config);
		$order_info["address_complement"] = $this->getComplement($order_info, $config);
		$order_info["address_district"] = $this->getDistrict($order_info, $config);
		$order_info["customer_cellphone"] = $this->getCellPhone($order_info, $config);
		$order_info["customer_document"] = $this->getDocument($order_info, $config);

		$this->model_checkout_order->addOrderHistory($order_info["order_id"], $this->config->get("config_order_status_id"));

		$response = (object) array(
			"code" => substr($PagSeguro->createOrder($order_info, $config), 59)
		);

		$this->response->addHeader("Content-Type: application/json");
		$this->response->setOutput(json_encode($response)); 
	}

	public function callback() {
		$code = (isset($_POST["notificationCode"]) && trim($_POST["notificationCode"]) != "") ? trim($_POST["notificationCode"]) : null;
		$type = (isset($_POST["notificationType"]) && trim($_POST["notificationType"]) != "") ? trim($_POST["notificationType"]) : null;

		if($code && $type) {
			$notificationType = new PagSeguroNotificationType($type);
            $notificationType = $notificationType->getTypeFromValue();
			$config = $this->getConfig();

			switch ($notificationType) {
                case "TRANSACTION":
					$credentials = new PagSeguroAccountCredentials($config->email, $config->token);

					try {
						$transaction = PagSeguroNotificationService::checkTransaction($credentials, $code);
						$transactionStatus = $transaction->getStatus();
						$reference = $transaction->getReference();

						$this->updateOrder($reference, $transactionStatus->getTypeFromValue());
					}
					catch (PagSeguroServiceException $e) {
                        $this->log->write("PagSeguro :: " . $e->getOneLineMessage());
                    }
					break;
			}
		}
		else {
			$this->language->load("payment/pagseguro");
			$this->log->write($this->language->get("error_parameters"));
		}
	}

	private function updateOrder($reference, $status) {
		$this->load->model("checkout/order");
		$order_info = $this->model_checkout_order->getOrder($reference);

		if($order_info) {
			$comment = "";
			$alert = true;

			switch ($status) {
				case "IN_ANALISYS":
					$this->model_checkout_order->addOrderHistory($reference, $this->config->get("pagseguro_order_payment_analisys"), $comment, $alert);
					break;
				case "PAID":
					$this->model_checkout_order->addOrderHistory($reference, $this->config->get("pagseguro_order_approved_payment"), $comment, $alert);
					break;
				case "CANCELLED":
					if($orderId) {
						$this->model_checkout_order->addOrderHistory($reference, $this->config->get("pagseguro_order_canceled_payment"), $comment, $alert);
					}
					break;
				case "IN_DISPUTE":
					if($orderId) {
						$this->model_checkout_order->addOrderHistory($reference, $this->config->get("pagseguro_order_payment_dispute"), $comment, $alert);
					}
					break;
				case "REFUNDED":
					if($orderId) {
						$this->model_checkout_order->addOrderHistory($reference, $this->config->get("pagseguro_order_reversed_payment"), $comment, $alert);
					}
					break;
				case "SELLER_CHARGEBACK":
					if($orderId) {
						$this->model_checkout_order->addOrderHistory($reference, $this->config->get("pagseguro_order_chargeback_payment"), $comment, $alert);
					}
				case "CONTESTATION":
					if($orderId) {
						$this->model_checkout_order->addOrderHistory($reference, $this->config->get("pagseguro_order_chargeback_payment"), $comment, $alert);
					}
					break;
			}
		}
		else {
			$this->language->load("payment/pagseguro");
			$this->log->write(sprintf($this->language->get("error_order"), $reference));
		}
	}

	private function getProducts($order_info, $cart) {
		$products = $cart->getProducts();
		$currencyValue = $order_info["currency_value"];
		
		foreach ($products as $key => $value) {
			$products[$key]["price"] = ($value["price"] * $currencyValue);
			$products[$key]["total"] = ($value["total"] * $currencyValue);
			$products[$key]["weight"] = $this->getWeight(($value["weight"] / $value["quantity"]), $value["weight_class_id"]);
		}
		return $products;
	}

	private function getWeight($weight, $type) {
		if ($this->weight->getUnit($type) != "g") {
            return ($weight * 1000);
        }
        return $weight;
	}

	private function getTotal($order_info) {
		return ($order_info["total"] * $order_info["currency_value"]);
	}

	private function getShippingCost($order_info) {
		return ($order_info["shipping"]["cost"] * $order_info["currency_value"]);
	}

	private function getDiscount($order_info, $cart) {
		return ((($cart->getSubTotal() * $order_info["currency_value"]) - $order_info["total"]) + $order_info["shipping"]["cost"]);
	}

	private function getStreet($order_info, $config) {
		$street = null;
		if(is_numeric($config->config_address)) {
			if($this->customFieldLocation($config->config_address) == "address") {
				$street = $this->getArrayValue($order_info["shipping_custom_field"], $config->config_address);
			}
			else{
				$street = $this->getArrayValue($order_info["custom_field"], $config->config_address);
			}
		}
		else {
			$street = $order_info["shipping_".$config->config_address];
		}
		return $street;
	}

	private function getNumber($order_info, $config) {
		$number = null;
		if(is_numeric($config->config_number)) {
			if($this->customFieldLocation($config->config_number) == "address") {
				$number = $this->getArrayValue($order_info["shipping_custom_field"], $config->config_number);
			}
			else {
				$number = $this->getArrayValue($order_info["custom_field"], $config->config_number);
			}
		}
		else {
			$number = $order_info["shipping_".$config->config_number];
		}
		return $number;
	}

	private function getComplement($order_info, $config) {
		$complement = null;
		if(is_numeric($config->config_complement)) {
			if($this->customFieldLocation($config->config_complement) == "address"){
				$complement = $this->getArrayValue($order_info["shipping_custom_field"], $config->config_complement);
			}
			else {
				$complement = $this->getArrayValue($order_info["custom_field"], $config->config_complement);
			}
		}
		else {
			if($config->config_complement == "") {
				$complement = "";
			}
			else {
				$complement = $order_info["shipping_".$config->config_complement];
			}
		}
		return $complement;
	}

	private function getDistrict($order_info, $config) {
		$district = null;
		if(is_numeric($config->config_neighborhood)) {
			if($this->customFieldLocation($config->config_neighborhood) == "address") {
				$district = $this->getArrayValue($order_info["shipping_custom_field"], $config->config_neighborhood);
			}
			else {
				$district = $this->getArrayValue($order_info["custom_field"], $config->config_neighborhood);
			}
		}
		else {
			$district = $order_info["shipping_".$config->config_neighborhood];
		}
		return $district;
	}

	private function getCellPhone($order_info, $config) {
		$cellphone = null;
		if(is_numeric($config->config_cellphone)) {
			if($this->customFieldLocation($config->config_cellphone) == "address") {
				$cellphone = $this->getArrayValue($order_info["shipping_custom_field"], $config->config_cellphone);
			}
			else {
				$cellphone = $this->getArrayValue($order_info["custom_field"], $config->config_cellphone);
			}
		}
		else {
			if($config->config_cellphone == "") {
				$cellphone = "";
			}
			else {
				$cellphone = $order_info[$config->config_cellphone];
			}
		}
		return $cellphone;
	}

	private function getDocument($order_info, $config) {
		$document = null;
		if(is_numeric($config->config_document)) {
			if($this->customFieldLocation($config->config_document) == "address") {
				$document = $this->getArrayValue($order_info["shipping_custom_field"], $config->config_document);
			}
			else {
				$document = $this->getArrayValue($order_info["custom_field"], $config->config_document);
			}
		}
		else {
			$document = $order_info[$config->config_document];
		}
		return $document;
	}

	private function customFieldLocation($field_id) {
		$result = $this->db->query("SELECT `location` FROM `". DB_PREFIX ."custom_field` WHERE `custom_field_id` = ".(int)$field_id);
		return $result->row["location"];
	}

	private function getArrayValue($array, $key) {
		if(isset($array[$key])) {
			return $array[$key];
		}
		else {
			return "";
		}
	}

	private function getConfig() {
		$PagSeguro = new PagSeguro();
		$config = $PagSeguro->getConfig();

		$config->status = $this->config->get("pagseguro_status");
		$config->token = $this->config->get("pagseguro_token");
		$config->email = $this->config->get("pagseguro_email");
		$config->freight = $this->config->get("pagseguro_freight");
		$config->config_document = $this->config->get("pagseguro_document");
		$config->config_address = $this->config->get("pagseguro_address");
		$config->config_number = $this->config->get("pagseguro_number");
		$config->config_complement = $this->config->get("pagseguro_complement");
		$config->config_neighborhood = $this->config->get("pagseguro_neighborhood");
		$config->config_cellphone = $this->config->get("pagseguro_cellphone");
		$config->notification_url = $this->config->get("pagseguro_notification_url");
		$config->redirect_url = $this->config->get("pagseguro_redirect_url");
		$config->cancel_url = $this->config->get("pagseguro_cancel_url");
		return $config;
	}
}
