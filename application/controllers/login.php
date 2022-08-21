<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('employee_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    function index() {
    	$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_login');

        if ($this->form_validation->run() == FALSE)
        	$this->load->view('page/login');
        	//echo "false";
        else
        	//echo "true";
        	redirect(base_url() . "soatve");
    }

    function check_login($password) {
    	$username = $this->input->post('username');
    	$result = $this->employee_model->login($username, $password);
    	if ($result) {
    		$session_array = array();
    		foreach ($result as $row) {
    			$session_array = array(
                    'id' => $row->nsd_id,
                    'username' => $row->nsd_ten,
                    'role' => $row->nsd_quyen,
                    'group' => $row->nsd_nhom
                );
                $this->session->set_userdata('logged_in', $session_array);
    		}
    		return TRUE;
    	}
    	else {
    		$this->form_validation->set_message('check_login', 'Invalid username or password');
            return false;
    	}
    }
}