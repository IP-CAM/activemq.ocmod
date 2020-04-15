<?php

class ControllerExtensionModuleActivemq extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('extension/module/activemq');

        $data['heading_title'] = $this->language->get('heading_title');
        $this->document->setTitle($data['heading_title']);

        $this->load->model('setting/setting');

	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
                $this->model_setting_setting->editSetting('module_activemq', $this->request->post);
		$this->session->data['success'] = $this->language->get('text_success');
		$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
	}

        $data['text_enabled']     = $this->language->get('text_enabled');
        $data['text_disabled']    = $this->language->get('text_disabled');
        $data['text_edit']        = $this->language->get('text_edit');
        $data['button_save']      = $this->language->get('button_save');
        $data['button_cancel']    = $this->language->get('button_cancel');
        $data['entry_status']     = $this->language->get('entry_status');
        $data['error_permission'] = $this->language->get('error_permission');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } elseif (isset($this->session->data['warning'])) {
            $data['error_warning'] = $this->session->data['warning'];
            unset($this->session->data['warning']);
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('marketplace/extension','user_token=' . $this->session->data['user_token'] . '&type=module', true),
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/activemq','user_token=' . $this->session->data['user_token'],true),
        );

        $data['action'] = $this->url->link('extension/module/activemq', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension','user_token=' . $this->session->data['user_token'] . '&type=module',true );

        if (isset($this->request->post['module_activemq_server'])) {
            $data['module_activemq_server'] = $this->request->post['module_activemq_server'];
        } else {
            $data['module_activemq_server'] = $this->config->get('module_activemq_server');
        }
        if (isset($this->request->post['module_activemq_port'])) {
            $data['module_activemq_port'] = $this->request->post['module_activemq_port'];
        } else {
            $data['module_activemq_port'] = $this->config->get('module_activemq_port');
        }
        if (isset($this->request->post['module_activemq_login'])) {
            $data['module_activemq_login'] = $this->request->post['module_activemq_login'];
        } else {
            $data['module_activemq_login'] = $this->config->get('module_activemq_login');
        }
        if (isset($this->request->post['module_activemq_password'])) {
            $data['module_activemq_password'] = $this->request->post['module_activemq_password'];
        } else {
            $data['module_activemq_password'] = $this->config->get('module_activemq_password');
        }
        if (isset($this->request->post['module_activemq_queue'])) {
            $data['module_activemq_queue'] = $this->request->post['module_activemq_queue'];
        } else {
            $data['module_activemq_queue'] = $this->config->get('module_activemq_queue');
        }
	if (isset($this->request->post['module_activemq_status'])) {
  	   $data['module_activemq_status'] = $this->request->post['module_activemq_status'];
	} else {
	   $data['module_activemq_status'] = $this->config->get('module_activemq_status');
	}

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/activemq', $data));
    }

    protected function validate()
    {
        $this->load->language('extension/module/activemq');

        if (!$this->user->hasPermission('modify', 'extension/module/activemq')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }

    public function session()
    {
        $this->load->language('extension/module/activemq');

        if (!$this->user->hasPermission('modify', 'extension/module/activemq')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }

    ###########
    ## Events
    ###########

    public function install()
    {
        $this->load->model('setting/event');
        $this->load->model('setting/setting');

        $activemq_data['module_activemq_port'] = '61613';

        $this->model_setting_setting->editSetting('module_activemq', $activemq_data);

        $action = 'extension/module/activemq/orderadd';
        $this->model_setting_event->addEvent('activemq',  'catalog/model/checkout/order/addOrderHistory/before', $action);
    }

    public function uninstall()
    {
        $this->load->model('setting/event');
        $this->load->model('extension/module/activemq');
        $this->model_setting_event->deleteEventByCode('activemq');
    }
}
