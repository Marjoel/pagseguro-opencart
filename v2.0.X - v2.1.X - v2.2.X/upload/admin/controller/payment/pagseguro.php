<?php
/**
*  @author   Marjoel Moreira [marjoel@marjoel.com]
*  @license  https://www.gnu.org/licenses/gpl-3.0.en.html
*/

class ControllerPaymentPagSeguro extends Controller {
	private $error = array();

	public function index() {
		if(version_compare(VERSION, "2.2.0.0") < 0) {
			$ssl = "SSL";
			$tpl = ".tpl";
		}
		else {
			$ssl = true;
			$tpl = "";
		}

		if(($this->request->server["REQUEST_METHOD"] == "POST") && $this->validate()) {
			$this->load->model("setting/setting");
			$this->model_setting_setting->editSetting("pagseguro", $this->request->post);
			$this->session->data["success"] = $this->language->get("text_success");
			$this->response->redirect($this->url->link("extension/payment", "token=" . $this->session->data["token"], $ssl));
		}

		$this->load->language("payment/pagseguro");

		/* get all texts */
		$texts = $this->getAllTexts();
		foreach ($texts as $text) {
			$data[$text] = $this->language->get($text);
		}

		$config = $this->getConfig();

		/* opencart default */
		$this->document->setTitle($data["heading_title"]);
		$data["breadcrumbs"] = $this->getBreadcrumbs($data, $ssl);
		$data["action"] = $this->url->link("payment/pagseguro", "token=" . $this->session->data["token"], $ssl);
		$data["cancel"] = $this->url->link("extension/payment", "token=" . $this->session->data["token"], $ssl);
		$data["header"] = $this->load->controller("common/header");
		$data["column_left"] = $this->load->controller("common/column_left");
		$data["footer"] = $this->load->controller("common/footer");

		/* utils */
		$data["util_fields"] = $this->getFields();
		$data["util_status"] = $this->getStatus();
		$data["util_freight"] = $this->getFreightTypes();
		$data["notification_url"] = $this->getUrlBase() . $config->notification_url;
		$data["redirect_url"] = $this->getUrlBase() . $config->redirect_url;
		$data["cancel_url"] = $this->getUrlBase() . $config->cancel_url;

		/* get all fields */
		$fields = $this->getAllFields();
		foreach ($fields as $field) {
			$data[$field] = isset($this->request->post[$field]) ? $this->request->post[$field] : $this->config->get($field);
		}

		/* if there are errors, show them */
		$fields = $this->getAllRequiredFields();
		$fields[] = "warning";

		foreach ($fields as $field) {
			$data["error_" . $field] = isset($this->error[$field]) ? $this->error[$field] : "";
		}
		$this->response->setOutput($this->load->view("payment/pagseguro".$tpl, $data));
	}

	protected function validate() {
		if(!$this->user->hasPermission("modify", "payment/pagseguro")) {
			$this->error["warning"] = $this->language->get("error_permission");
			return !$this->error;
		}

		if(!$this->request->post["pagseguro_min_value_enable"]) {
			$this->request->post["pagseguro_min_value_enable"] = 0;
		}

		/* validate required fields */
		$fields = $this->getAllRequiredFields();
		foreach ($fields as $field) {
			if(!$this->request->post["pagseguro_" .$field]) {
				$this->error[$field] = $this->language->get("error_" . $field);
			}
		}
		return !$this->error;
	}

	private function getFields() {
		if(version_compare(VERSION, "2.1.0.1") < 0) {
			$this->load->language("sale/customer");
			$this->load->model("sale/custom_field");
			$custom_fields = $this->model_sale_custom_field->getCustomFields();
		}
		else {
			$this->load->language("customer/customer");
			$this->load->model("customer/custom_field");
			$custom_fields = $this->model_customer_custom_field->getCustomFields();
		}

		$fields = array();

		/* get default fields */
		$default_fields = array(
			"address_1",
			"address_2",
			"telephone",
			"fax",
			"company"
		);

		foreach ($default_fields as $field) {
			$fields[$field] = $this->language->get("entry_" . $field);
		}

		/* get custom fields */
		foreach($custom_fields as $field) {
			$fields[$field["custom_field_id"]] = $field["name"];
		}
		return $fields;
	}

	private function getFreightTypes() {
		$texts = array(
			"text_freight_store",
			"text_freight_pac",
			"text_freight_sedex",
			"text_freight_pac_sedex"
		);

		foreach ($texts as $text) {
			$data[$text] = $this->language->get($text);
		}

		return array(
			"0" => $data["text_freight_store"],
			"1" => $data["text_freight_pac"],
			"2" => $data["text_freight_sedex"],
			"3" => $data["text_freight_pac_sedex"]
		);
	}

	private function getStatus() {
		$this->load->model("localisation/order_status");
		$statuses = $this->model_localisation_order_status->getOrderStatuses();
		$status = array();

		foreach ($statuses as $stats) {
			$status[$stats["order_status_id"]] = $stats["name"];
		}
		return $status;
	}

	private function getConfig() {
		return (object) parse_ini_file(DIR_SYSTEM . "library/pagseguro/pagseguro-config.ini");
	}

	private function getUrlBase() {
		if (isset($this->request->server["HTTPS"]) && (($this->request->server["HTTPS"] == "on") || ($this->request->server["HTTPS"] == "1"))) {
			return $this->config->get("config_ssl");
		}
		return $this->config->get("config_url");
	}

	private function getBreadcrumbs($data, $ssl) {
		$breadcrumbs = array();

		$breadcrumbs[] = array(
			"text" => $data["text_home"],
			"href" => $this->url->link("common/dashboard", "token=" . $this->session->data["token"], $ssl)
		);

		$breadcrumbs[] = array(
			"text" => $data["text_payment"],
			"href" => $this->url->link("extension/payment", "token=" . $this->session->data["token"], $ssl)
		);

		$breadcrumbs[] = array(
			"text" => $data["heading_title"],
			"href" => $this->url->link("payment/pagseguro", "token=" . $this->session->data["token"], $ssl)
		);
		return $breadcrumbs;
	}

	private function getAllRequiredFields() {
		return array(
			"token",
			"email",
			"notification_url",
			"redirect_url",
			"cancel_url",
			"document",
			"address",
			"number",
			"neighborhood",
			"cellphone"
		);
	}

	private function getAllFields() {
		return array(
			"pagseguro_min_value_enable",
			"pagseguro_token",
			"pagseguro_email",
			"pagseguro_notification_url",
			"pagseguro_redirect_url",
			"pagseguro_cancel_url",
			"pagseguro_freight",
			"pagseguro_document",
			"pagseguro_address",
			"pagseguro_number",
			"pagseguro_complement",
			"pagseguro_neighborhood",
			"pagseguro_cellphone",
			"pagseguro_status",
			"pagseguro_sort_order",
			"pagseguro_order_waiting_payment",
			"pagseguro_order_payment_analisys",
			"pagseguro_order_approved_payment",
			"pagseguro_order_payment_dispute",
			"pagseguro_order_reversed_payment",
			"pagseguro_order_chargeback_payment",
			"pagseguro_order_canceled_payment"
		);
	}

	private function getAllTexts() {
		return array(
			"heading_title",
			"button_save",
			"button_cancel",
			"entry_min_value_enable",
			"entry_token",
			"entry_email",
			"entry_notification_url",
			"entry_redirect_url",
			"entry_cancel_url",
			"entry_freight",
			"entry_document",
			"entry_address",
			"entry_number",
			"entry_complement",
			"entry_neighborhood",
			"entry_cellphone",
			"entry_sort_order",
			"entry_status",
			"entry_order_waiting_payment",
			"entry_order_payment_analisys",
			"entry_order_approved_payment",
			"entry_order_payment_dispute",
			"entry_order_canceled_payment",
			"entry_order_reversed_payment",
			"entry_order_chargeback_payment",
			"text_home",
			"text_payment",
			"text_enabled",
			"text_disabled",
			"text_edit",
			"text_edit_freight",
			"text_edit_tokens",
			"text_edit_installments",
			"text_edit_notifications",
			"text_edit_redirects",
			"text_edit_fields",
			"text_edit_order_status",
			"text_edit_settings",
			"text_register",
			"help_freight",
			"help_min_value_enable",
			"help_token",
			"help_email",
			"help_notification_url",
			"help_redirect_url",
			"help_cancel_url",
			"help_document",
			"help_address",
			"help_number",
			"help_complement",
			"help_neighborhood",
			"help_cellphone",
			"help_order_waiting_payment",
			"help_order_payment_analisys",
			"help_order_approved_payment",
			"help_order_payment_dispute",
			"help_order_canceled_payment",
			"help_order_reversed_payment",
			"help_order_chargeback_payment",
			"error_token",
			"error_email",
			"error_notification_url",
			"error_redirect_url",
			"error_cancel_url",
			"error_document",
			"error_address",
			"error_number",
			"error_neighborhood",
			"error_cellphone"
		);
	}
}
