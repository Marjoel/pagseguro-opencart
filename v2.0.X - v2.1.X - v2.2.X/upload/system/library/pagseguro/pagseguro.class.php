<?php
require_once "PagSeguroLibrary.php";

class PagSeguro {
	public function __construct() {
	}

	public function getConfig() {
		return (object) parse_ini_file("pagseguro-config.ini");
	} 

	public function createOrder($properties, $config) {
		PagSeguroConfig::setApplicationCharset("UTF-8");
		$pagseguro = new PagSeguroPaymentRequest();

		$pagseguro->setCurrency($this->getCurrencyCode($properties));
		$pagseguro->setSenderCpf($this->getDocument($properties));
		$pagseguro->setSenderName($this->getCustomerName($properties));
		$pagseguro->setSenderEmail($this->getCustomerEmail($properties));
		$pagseguro->setShippingType($this->getFreightType($config));
		$pagseguro->setShippingAddress($this->getShippingInformation($properties));
		$pagseguro->setReference($this->getReference($properties));
		
		//$pagseguro->setRedirectUrl($this->getRedirectUrl($properties, $config));
		//$pagseguro->setNotificationURL($this->getNotificationUrl($config));

		$pagseguro->setRedirectUrl("https://www.ancorastore.com/carrinho/confirmacao");
		$pagseguro->setNotificationURL("https://www.ancorastore.com/checkout/pagseguro/callback");
		
		$products = $this->getProducts($properties);
		foreach ($products as $product) {
			$pagseguro->addItem($product);
		}

		$cellphone = $this->getCustomerCellPhone($properties);
		if(strlen($cellphone) > 0) {
			$pagseguro->setSenderPhone(substr($cellphone, 0, 2), substr($cellphone, 2, strlen($cellphone) - 1));
		}

		$discount = $this->getDiscount($properties);
		$cost = $this->getShippingCost($properties);
		$extra = ($cost >= $discount) ? ($cost - $discount) : (($discount - $cost)*-1);
		$pagseguro->setExtraAmount($extra);

		try {
			$orderId = $pagseguro->register(new PagSeguroAccountCredentials($config->email, $config->token));
        }
		catch (PagSeguroServiceException $e) {
        	print($e->getOneLineMessage());
        }
		return $orderId;
	}

	private function getShippingCost($properties) {
		return $properties["shipping"]["cost"];
	}

	private function getCurrencyCode($properties) {
		return strval($properties["currency_code"]);
	}

	private function getReference($properties) {
		return strval($properties["order_id"]);
	}

	private function getDiscount($properties) {
		return strval($properties["discount"]);
	}

	private function getCustomerName($properties) {
		return ($properties["firstname"]." ".$properties["lastname"]);
	}

	private function getCustomerEmail($properties) {
		return $properties["email"];
	}

	private function getFreightType($config) {
		if($config->freight) {
			return $config->freight;
		}
		return 3;
	}

	private function getDocument($properties) {
		return strval(preg_replace("/[^0-9]/", "", $properties["customer_document"]));
	}

	private function getCustomerCellPhone($properties) {
		$cellphone = strval(preg_replace("/[^0-9]/", "", $properties["customer_cellphone"]));
		$cellphone = ltrim($cellphone, "0");

		if(strlen($cellphone) < 9) {
			$cellphone = "";
		}
		return $cellphone;
	}

	private function getShippingInformation($properties){
		return array(
			"street" => $properties["address_street"],
			"number" => strval($properties["address_number"]),
			"complement" => $properties["address_complement"],
			"district" => $properties["address_district"],
			"postalCode" => $this->unMask($properties["shipping_postcode"]),
			"city" => $properties["shipping_city"],
			"state" => $properties["shipping_zone_code"],
			"country" => $properties["shipping_iso_code_3"]
		);
	}

	private function unMask($value) {
		return strval(preg_replace("/[^0-9]/", "", $value));
	}

	private function getProducts($properties) {
		$products = $properties["products"];
		$productDetails = array();
		$i = 0;

		foreach ($products as $key => $value) {
			$productDetails[$i] = array(
				"id" => $value["product_id"],
				"amount" => $value["price"],
				"quantity" => strval($value["quantity"]),
				"description" => substr($value["name"], 0, (strlen($value["name"]) > 80 ? 80 : strlen($value["name"])))
			);
			$i++;
		}
		return $productDetails;
	}

	private function getNotificationUrl($config) {
		return $config->notification_url;
	}

	private function getRedirectUrl($properties, $config) {
		return $config->redirect_url . "&orderId=" . strval($properties["order_id"]);
	}

	private function getCancelUrl($config) {
		return $config->cancel_url;
	}
}
?>
