<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends My_Controller {

	protected $_data;

	public function __construct() {
        parent::__construct();
        $this->load->model('transaction_model');
        $this->load->library('session');
    }

    public function changeCommitType()
    {
    	if($this->login()) {
	    	$vetctransaction_ticketid = $this->input->post("vetctransaction_ticketid");
	    	$content = "Điều chỉnh giao dịch (Pending -> Commit) ETC cho giao dịch có mã " . $vetctransaction_ticketid;
	    	$data_update = array(
				"vetctransaction_committype" => 1,
	        );
	        $result = $this->transaction_model->changeCommitType($data_update,$vetctransaction_ticketid);
	        if($result == 1)
	        {
	        	$date = date('Y-m-d H:i:s');
				$dataval = $this->session->userdata('logged_in');
		    	$userid = $dataval['id'];
				$content = "Điều chỉnh giao dịch (Pending -> Commit) ETC cho giao dịch có mã " . $vetctransaction_ticketid;
				$data_inserLog = array(
					"log_time" => $date,
			        "log_user" => $userid,
			        "log_type" => 10,
			        "log_description" => $content
				);
				$this->writeLog($data_inserLog);
	        }
	        echo $result;
	    }
	    else {
	    	echo json_encode("403 forbidden");
	    }
    }

    public function lockTransaction()
    {
    	if($this->login()) {
	    	$vetctransaction_ticketid = $this->input->post("vetctransaction_ticketid");
	    	$result = $this->transaction_model->lockTransaction($vetctransaction_ticketid);
	    	if($result == 1)
	    	{
	    		$date = date('Y-m-d H:i:s');
				$dataval = $this->session->userdata('logged_in');
		    	$userid = $dataval['id'];
				$content = "Xóa giao dịch ETC,giao dịch có mã " . $vetctransaction_ticketid;
				$data_inserLog = array(
					"log_time" => $date,
			        "log_user" => $userid,
			        "log_type" => 11,
			        "log_description" => $content
				);
				$this->writeLog($data_inserLog);
	    	}
	    	echo $result;
	    }
    	else {
	    	echo json_encode("403 forbidden");
	    }
    }
}