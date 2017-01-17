<?php
class ControllerExtensionPaymentRedePay extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/payment/redepay');
        $this->load->model('setting/setting');

		$texts = array(
			"heading_title",
			"button_save",
			"button_cancel",
			"entry_max_installments",
			"entry_min_value_installment",
			"entry_min_installment_value",
			"entry_min_value_enable",
			"entry_api_key",
			"entry_token_nip",
			"entry_public_token",
			"entry_notification_url",
			"entry_redirect_url",
			"entry_cancel_url",
			"entry_document",
			"entry_address",
			"entry_number",
			"entry_complement",
			"entry_neighborhood",
			"entry_phone",
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
			"text_success",
			"text_enabled",
			"text_disabled",
			"text_edit",
			"text_edit_tokens",
			"text_edit_installments",
			"text_edit_notifications",
			"text_edit_redirects",
			"text_edit_fields",
			"text_edit_order_status",
			"text_edit_settings",
			"text_register",
			"help_max_installments",
			"help_min_value_installment",
			"help_min_installment_value",
			"help_min_value_enable",
			"help_api_key",
			"help_token_nip",
			"help_public_token",
			"help_notification_url",
			"help_redirect_url",
			"help_cancel_url",
			"help_document",
			"help_address",
			"help_number",
			"help_complement",
			"help_neighborhood",
			"help_phone",
			"help_cellphone",
			"help_order_waiting_payment",
			"help_order_payment_analisys",
			"help_order_approved_payment",
			"help_order_payment_dispute",
			"help_order_canceled_payment",
			"help_order_reversed_payment",
			"help_order_chargeback_payment",
			"error_api_key",
			"error_token_nip",
			"error_public_token",
			"error_notification_url",
			"error_redirect_url",
			"error_cancel_url",
			"error_document",
			"error_address",
			"error_number",
			"error_neighborhood",
			"error_cellphone"
		);

		foreach ($texts as $text) {
			$data[$text] = $this->language->get($text);
		}

        if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('redepay', $this->request->post);
            $this->session->data['success'] = $data["text_success"];
            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
        }

		$config = $this->getConfig();
		$base_url = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

        $this->document->setTitle($data['heading_title']);

		$data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $data["text_home"],
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $data["text_payment"],
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=payment', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $data["heading_title"],
            'href' => $this->url->link('extension/payment/redepay', 'token=' . $this->session->data['token'], true)
        );

		$data['notification_url'] = $base_url . $config->notification_url;
		$data['redirect_url'] = $base_url . $config->redirect_url;
		$data['cancel_url'] = $base_url . $config->cancel_url;

		$data['action'] = $this->url->link('extension/payment/redepay', 'token=' . $this->session->data['token'], true);
        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'] . '&type=payment', true);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

		$data['util_installments_range'] = $this->getInstallmentsRange();
		$data['util_fields'] = $this->getFields();
		$data['util_status'] = $this->getStatus();

		/* get */
		$fields_get = array(
			"redepay_max_installments",
			"redepay_min_value_installment",
			"redepay_min_installment_value",
			"redepay_min_value_enable",
			"redepay_api_key",
			"redepay_token_nip",
			"redepay_public_token",
			"redepay_notification_url",
			"redepay_redirect_url",
			"redepay_cancel_url",
			"redepay_document",
			"redepay_address",
			"redepay_number",
			"redepay_complement",
			"redepay_neighborhood",
			"redepay_phone",
			"redepay_cellphone",
			"redepay_status",
			"redepay_sort_order",
			"redepay_order_waiting_payment",
			"redepay_order_payment_analisys",
			"redepay_order_approved_payment",
			"redepay_order_payment_dispute",
			"redepay_order_reversed_payment",
			"redepay_order_chargeback_payment",
			"redepay_order_canceled_payment"
		);

		foreach ($fields_get as $field) {
			if(isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			}
			else {
				$data[$field] = $this->config->get($field);
			}
		}

		/* errors */
		$fields_error = array(
			"public_token",
			"max_installments",
			"api_key",
			"token_nip",
			"notification_url",
			"redirect_url",
			"cancel_url",
			"document",
			"address",
			"number",
			"neighborhood",
			"cellphone",
			"warning"
		);

		foreach ($fields_error as $field) {
			if(isset($this->error[$field])) {
				$data["error_" . $field] = $this->error[$field];
			}
			else {
				$data["error_" . $field] = '';
			}
		}
        $this->response->setOutput($this->load->view('extension/payment/redepay', $data));
    }

	private function getInstallmentsRange() {
		return array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
			'6' => '6',
			'7' => '7',
			'8' => '8',
			'9' => '9',
			'10' => '10',
			'11' => '11',
			'12' => '12'
		);
	}

	private function getFields() {
		$this->load->language('customer/customer');
		$this->load->model('customer/custom_field');
		$custom_fields = $this->model_customer_custom_field->getCustomFields();

		$texts = array(
			"entry_address_1",
			"entry_address_2",
			"entry_telephone",
			"entry_fax",
			"entry_company"
		);

		foreach ($texts as $text) {
			$data[$text] = $this->language->get($text);
		}

		$fields = array();
		$filter_data = array(
			'sort'  => 'cf.sort_order',
			'order' => 'ASC'
		);

		$fields['address_1'] = $data["entry_address_1"];
		$fields['address_2'] = $data["entry_address_2"];
		$fields['telephone'] = $data["entry_telephone"];
		$fields['fax'] = $data["entry_fax"];
		$fields['company'] = $data["entry_company"];

		foreach($custom_fields as $custom_field) {
			$fields[$custom_field['custom_field_id']] = $custom_field['name'];
		}
		return $fields;
	}

	private function getStatus() {
		$this->load->model('localisation/order_status');
		$statuses = $this->model_localisation_order_status->getOrderStatuses();
		$status = array();

		foreach ($statuses as $stats) {
			$status[$stats['order_status_id']] = $stats['name'];
		}
        return $status;
	}

    protected function validate() {
		$texts = array(
			"error_permission",
			"error_api_key",
			"error_token_nip",
			"error_public_token",
			"error_notification_url",
			"error_redirect_url",
			"error_cancel_url",
			"error_document",
			"error_address",
			"error_number",
			"error_neighborhood",
			"error_redepay_cellphone"
		);

		foreach ($texts as $text) {
			$data[$text] = $this->language->get($text);
		}

        if(!$this->user->hasPermission('modify', 'extension/payment/redepay')) {
            $this->error['warning'] = $data["error_permission"];
        }

        if(!$this->request->post['redepay_min_installment_value']) {
            $this->request->post['redepay_min_installment_value'] = 0;
        }

        if(!$this->request->post['redepay_min_value_enable']) {
            $this->request->post['redepay_min_value_enable'] = 0;
        }

        if(!$this->request->post['redepay_api_key']) {
            $this->error['api_key'] = $data["error_api_key"];
        }

        if(!$this->request->post['redepay_token_nip']) {
            $this->error['token_nip'] = $data["error_token_nip"];
        }

        if(!$this->request->post['redepay_public_token']) {
            $this->error['public_token'] = $data["error_public_token"];
        }

        if(!$this->request->post['redepay_notification_url']) {
            $this->error['notification_url'] = $data["error_notification_url"];
        }

        if(!$this->request->post['redepay_redirect_url']) {
            $this->error['redirect_url'] = $data["error_redirect_url"];
        }

        if(!$this->request->post['redepay_cancel_url']) {
            $this->error['cancel_url'] = $data["error_cancel_url"];
        }

        if(!$this->request->post['redepay_document']) {
            $this->error['document'] = $data["error_document"];
        }

        if(!$this->request->post['redepay_address']) {
            $this->error['address'] = $data["error_address"];
        }

        if(!$this->request->post['redepay_number']) {
            $this->error['number'] = $data["error_number"];
        }

        if(!$this->request->post['redepay_neighborhood']) {
            $this->error['neighborhood'] = $data["error_neighborhood"];
        }

        if(!$this->request->post['redepay_cellphone']) {
            $this->error['redepay_cellphone'] = $data["error_redepay_cellphone"];
        }
        return !$this->error;
    }

	private function getConfig() {
		return (object) parse_ini_file(DIR_SYSTEM . 'library/redepay/redepay-config.ini');
	} 
}
