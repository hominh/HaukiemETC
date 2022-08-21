<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicle extends My_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('vehicle_model');
        $this->load->library('session');
    }

    public function getVehicleByPlate()
    {
    	if($this->login())
    	{
    		$vehicle = $this->vehicle_model->getVehicleByPlate($this->input->post("plate"));
    		echo json_encode($vehicle);
    	}
    	else
    		echo json_encode("403 forbidden");
    }

    public function update()
    {
    	if($this->login())
    	{
    		$date = date('Y-m-d H:i:s');
			$dataval = $this->session->userdata('logged_in');
	    	$userid = $dataval['id'];
    		$data = array(
				"xe_bienso" => $this->input->post("xe_bienso"),
		        "xe_loaixe" => $this->input->post("xe_loaixe"),
		        "xe_canhbao" => $this->input->post("xe_canhbao"),
		        "xe_ghichu" => $this->input->post("xe_ghichu"),
		        "xe_ngaynhap" => $date,
		        "xe_nsd" => $userid
			);
			$vehicle = $this->vehicle_model->update($data);
			if($vehicle == 1)
			{
				$content = "Cập nhật xe chuẩn cho xe biển số: " . $this->input->post("xe_bienso");
				$data_insertLog = array(
					"log_time" => $date,
			        "log_user" => $userid,
			        "log_type" => 3,
			        "log_description" => $content
				);
				$this->writeLog($data_insertLog);
			}
			echo $vehicle;
    	}
    	else
    		echo json_encode("403 forbidden");
    }

}