<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Controller extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('log_model');
        $this->load->library('session');
    }

    protected function login() {
        $logged = $this->session->userdata('logged_in');
        if ($logged) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    protected function writeLog($data)
    {
      	$this->log_model->insert($data);
    }
}