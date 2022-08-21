<?php
ob_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logout extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    function index() {
        $this->session->sess_destroy();
        $this->load->view('page/login');
    }
}

?>