<?php
require_once DIR_SYSTEM . 'library/redepay/redepay-api.class.php';

class ControllerExtensionPaymentRedePay extends Controller {
    public function index() {
		$this->load->language('extension/payment/redepay');
		$config = $this->getConfig();

		$data['public_key'] = $config->public_key;
		$data['script'] = $config->script_url;
		$data['post'] = $config->post_url;
		$data['delay'] = $config->auto_start_delay;
		$data['auto_start'] = $config->auto_start;
		$data['loading'] = $this->language->get('text_loading');

        return $this->load->view('extension/payment/redepay', $data);
    }

	public function order() {
        $this->load->model('checkout/order');
        $this->load->model('tool/upload');

		$RedePay = new RedePayAPI();
		$config = $this->getConfig();

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$order_info['shipping'] = $this->session->data['shipping_method'];
		$order_info['products'] = $this->getProducts($order_info, $this->cart);
		$order_info['total'] = $this->getTotal($order_info);
		$order_info['shipping']['cost'] = $this->getShippingCost($order_info);
		$order_info['discount'] = $this->getDiscount($order_info, $this->cart);
		$order_info['address_street'] = $this->getStreet($order_info, $config);
		$order_info['address_number'] = $this->getNumber($order_info, $config);
		$order_info['address_complement'] = $this->getComplement($order_info, $config);
		$order_info['address_district'] = $this->getDistrict($order_info, $config);
		$order_info['customer_cellphone'] = $this->getCellphone($order_info, $config);
		$order_info['customer_phone'] = $this->getPhone($order_info, $config);
		$order_info['customer_document'] = $this->getDocument($order_info, $config);

		$response = $RedePay->createOrderId($order_info, $config);
		$response = json_decode($response);

		$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('config_order_status_id'));

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));
	}

	public function callback() {
		$orderId = (isset($_POST['orderId']) && trim($_POST['orderId']) != "") ? trim(urldecode($_POST['orderId'])) : null;
		$transactionId = (isset($_POST['transactionId']) && trim($_POST['transactionId']) != "") ? trim(urldecode($_POST['transactionId'])) : null;
		$reference = (isset($_POST['reference']) && trim($_POST['reference']) != "") ? trim(urldecode($_POST['reference'])) : null;
		$status = (isset($_POST['status']) && trim($_POST['status']) != "") ? trim(urldecode($_POST['status'])) : null;
		$token = (isset($_POST['token']) && trim($_POST['token']) != "") ? trim(urldecode($_POST['token'])) : null;

		if($reference && $status && $token && ($orderId || $transactionId)) {
			$config = $this->getConfig();

			if($config->token_nip == $token) {
				$this->updateOrder($reference, $status, $token, $orderId, $transactionId);
			}
			else {
				$this->language->load('extension/payment/redepay');
				$this->log->write(sprintf($this->language->get('error_token'), $reference, $token));
			}
		}
		else {
			$this->language->load('extension/payment/redepay');
			$this->log->write($this->language->get('error_parameters'));
		}
	}

	private function updateOrder($reference, $status, $token, $orderId, $transactionId) {
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($reference);

		if($order_info) {
			$comment = $orderId ? "OrderId: ".$orderId : "TransactionId: ".$transactionId;
			$alert = true;

			switch ($status) {
				case 'IN_ANALISYS':
					$this->model_checkout_order->addOrderHistory($reference, $this->config->get('redepay_order_payment_analisys'), $comment, $alert);
					break;
				case 'COMPLETED':
					$this->model_checkout_order->addOrderHistory($reference, $this->config->get('redepay_order_approved_payment'), $comment, $alert);
					break;
				case 'CANCELLED':
					if($orderId) {
						$this->model_checkout_order->addOrderHistory($reference, $this->config->get('redepay_order_canceled_payment'), $comment, $alert);
					}
					break;
				case 'IN_DISPUTE':
					if($orderId) {
						$this->model_checkout_order->addOrderHistory($reference, $this->config->get('redepay_order_payment_dispute'), $comment, $alert);
					}
					break;
				case 'REVERSED':
					if($orderId) {
						$this->model_checkout_order->addOrderHistory($reference, $this->config->get('redepay_order_reversed_payment'), $comment, $alert);
					}
					break;
				case 'CHARGEBACK':
					if($orderId) {
						$this->model_checkout_order->addOrderHistory($reference, $this->config->get('redepay_order_chargeback_payment'), $comment, $alert);
					}
					break;
			}
		}
		else {
			$this->language->load('extension/payment/redepay');
			$this->log->write(sprintf($this->language->get('error_order'), $reference));
		}
	}

	private function getProducts($order_info, $cart) {
		$products = $cart->getProducts();
		$currencyValue = $order_info['currency_value'];
		
		foreach ($products as $key => $value) {
			$products[$key]['price'] = ($value['price'] * $currencyValue);
			$products[$key]['total'] = ($value['total'] * $currencyValue);
		}
		return $products;
	}

	private function getTotal($order_info) {
		return ($order_info['total'] * $order_info['currency_value']);
	}

	private function getShippingCost($order_info) {
		return ($order_info['shipping']['cost'] * $order_info['currency_value']);
	}

	private function getDiscount($order_info, $cart) {
		return ((($cart->getSubTotal() * $order_info['currency_value']) - $order_info['total']) + $order_info['shipping']['cost']);
	}

	private function getStreet($order_info, $config) {
		$street = null;
		if(is_numeric($config->config_address)) {
			if($this->customFieldLocation($config->config_address) == "address") {
				$street = $this->getArrayValue($order_info['shipping_custom_field'], $config->config_address);
			}
			else{
				$street = $this->getArrayValue($order_info['custom_field'], $config->config_address);
			}
		}
		else {
			$street = $order_info['shipping_'.$config->config_address];
		}
		return $street;
	}

	private function getNumber($order_info, $config) {
		$number = null;
		if(is_numeric($config->config_number)) {
			if($this->customFieldLocation($config->config_number) == "address") {
				$number = $this->getArrayValue($order_info['shipping_custom_field'], $config->config_number);
			}
			else {
				$number = $this->getArrayValue($order_info['custom_field'], $config->config_number);
			}
		}
		else {
			$number = $order_info['shipping_'.$config->config_number];
		}
		return $number;
	}

	private function getComplement($order_info, $config) {
		$complement = null;
		if(is_numeric($config->config_complement)) {
			if($this->customFieldLocation($config->config_complement) == "address"){
				$complement = $this->getArrayValue($order_info['shipping_custom_field'], $config->config_complement);
			}
			else {
				$complement = $this->getArrayValue($order_info['custom_field'], $config->config_complement);
			}
		}
		else {
			if($config->config_complement == "") {
				$complement = "";
			}
			else {
				$complement = $order_info['shipping_'.$config->config_complement];
			}
		}
		return $complement;
	}

	private function getDistrict($order_info, $config) {
		$district = null;
		if(is_numeric($config->config_neighborhood)) {
			if($this->customFieldLocation($config->config_neighborhood) == "address") {
				$district = $this->getArrayValue($order_info['shipping_custom_field'], $config->config_neighborhood);
			}
			else {
				$district = $this->getArrayValue($order_info['custom_field'], $config->config_neighborhood);
			}
		}
		else {
			$district = $order_info['shipping_'.$config->config_neighborhood];
		}
		return $district;
	}

	private function getPhone($order_info, $config) {
		$phone = null;
		if(is_numeric($config->config_phone)) {
			if($this->customFieldLocation($config->config_phone) == "address") {
				$phone = $this->getArrayValue($order_info['shipping_custom_field'], $config->config_phone);
			}
			else {
				$phone = $this->getArrayValue($order_info['custom_field'], $config->config_phone);
			}
		}
		else {
			if($config->config_phone == "") {
				$phone = "";
			}
			else {
				$phone = $order_info[$config->config_phone];
			}
		}
		return $phone;
	}

	private function getCellphone($order_info, $config) {
		$cellphone = null;
		if(is_numeric($config->config_cellphone)) {
			if($this->customFieldLocation($config->config_cellphone) == "address") {
				$cellphone = $this->getArrayValue($order_info['shipping_custom_field'], $config->config_cellphone);
			}
			else {
				$cellphone = $this->getArrayValue($order_info['custom_field'], $config->config_cellphone);
			}
		}
		else {
			$cellphone = $order_info[$config->config_cellphone];
		}
		return $cellphone;
	}

	private function getDocument($order_info, $config) {
		$document = null;
		if(is_numeric($config->config_document)) {
			if($this->customFieldLocation($config->config_document) == "address") {
				$document = $this->getArrayValue($order_info['shipping_custom_field'], $config->config_document);
			}
			else {
				$document = $this->getArrayValue($order_info['custom_field'], $config->config_document);
			}
		}
		else {
			$document = $order_info[$config->config_document];
		}
		return $document;
	}

	private function customFieldLocation($field_id) {
		$result = $this->db->query("SELECT `location` FROM `". DB_PREFIX ."custom_field` WHERE `custom_field_id` = ".(int)$field_id);
		return $result->row['location'];
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
		$RedePay = new RedePayApi();
		$config = $RedePay->getConfig();

		$config->status = $this->config->get('redepay_status');
		$config->max_installments = $this->config->get('redepay_max_installments');
		$config->api_key = $this->config->get('redepay_api_key');
		$config->token_nip = $this->config->get('redepay_token_nip');
		$config->public_key = $this->config->get('redepay_public_token');
		$config->config_document = $this->config->get('redepay_document');
		$config->config_address = $this->config->get('redepay_address');
		$config->config_number = $this->config->get('redepay_number');
		$config->config_complement = $this->config->get('redepay_complement');
		$config->config_neighborhood = $this->config->get('redepay_neighborhood');
		$config->config_phone = $this->config->get('redepay_phone');
		$config->config_cellphone = $this->config->get('redepay_cellphone');
		$config->notification_url = $this->config->get('redepay_notification_url');
		$config->redirect_url = $this->config->get('redepay_redirect_url');
		$config->cancel_url = $this->config->get('redepay_cancel_url');
		$config->min_value_installment = $this->config->get('redepay_min_value_installment');
		$config->min_installment_value = $this->config->get('redepay_min_installment_value');
		return $config;
	}
}
