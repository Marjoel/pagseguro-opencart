<?php
class ModelExtensionPaymentpagseguro extends Model {
    public function getMethod($address, $total) {
		$this->load->language("extension/payment/pagseguro");

		if($this->show()) {
			$this->load->model("localisation/currency");

			$currencies = $this->model_localisation_currency->getCurrencies();
			$currency_value = $currencies["BRL"]["value"];
			$total = ($total * $currency_value);
			$min_value = $this->config->get("pagseguro_min_value_enable");

			$status = ($total >= $min_value) ? true : false;

			$method_data = array();

			if ($status) {
				$method_data = array(
					"code"       => "pagseguro",
					"title"      => $this->language->get("text_title"),
					"terms"      => "",
					"sort_order" => $this->config->get("pagseguro_sort_order"),
				);
			}
			return $method_data;
		}
		else {
			$this->log->write(sprintf($this->language->get("error_currency"), $this->session->data["currency"]));
		}
    }

	private function show() {
		if($this->session->data["currency"] === "BRL") {
			return true;
		}
		return false;
	}
}
