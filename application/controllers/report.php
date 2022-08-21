<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends My_Controller {

	protected $_data;

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('soatve_model');
		$this->load->model('lane_model');
		$this->load->model('cartype_model');
		$this->load->model('employee_model');
		$this->load->library('pdf');
		$this->load->library('base');
	}

	public function index()
	{
		if ($this->login()) {
			$this->_data ['subview'] = 'page/report';
			$this->load->view('layout/master', $this->_data);
		}
		else
    		$this->load->view ( 'page/login' );
	}

	public function getParamReport()
	{
		if($this->login())
		{
			$report = $this->input->post("report");
			$timestart = $this->input->post("timestart");
			$timeend = $this->input->post("timeend");
			$ca = $this->input->post("ca");
			$day = $this->input->post("day");
			$month = $this->input->post("month");
			$year = $this->input->post("year");

			switch($ca)
			{
				case 0:
					$this->generateReport0($day,$month,$year);
				break;

				default:
					echo json_encode("error");
			}
		}
		else
			echo json_encode("403 forbidden");
	}

	public function generateReport0($day,$month,$year)
	{
		if($this->login())
		{
			$rangeDate = $this->base->getRangeTimeByDay($day,$month,$year);
			$timestart = $rangeDate[0];
			$timeend = $rangeDate[1];
			
		}
		else
			die("403 forbidden");
	}
}