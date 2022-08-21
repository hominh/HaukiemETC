<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Einvoice extends My_Controller {

	protected $_data;
	protected $companyName;
	protected $tollName;

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('lane_model');
		$this->load->model('einvoice_model');
		$this->load->library('form_validation');
		$this->load->library('excel');
		$this->load->model('param_model');
		$this->companyName = $this->param_model->getParamByName('DonVi');
		$this->tollName = $this->param_model->getParamByName('TramThuPhi');
	}

	public function index()
	{
		if ($this->login()) {
			$this->_data['lanes'] = $this->lane_model->getList();
			$this->_data ['subview'] = 'page/einvoice';
			$this->load->view('layout/master', $this->_data);
		}
		else
    		$this->load->view ( 'page/login' );
	}

	private static function cmp($a, $b)
	{
	    return strcmp($a[9], $b[9]);
	}

	private static function cmp2($a, $b)
	{
	    return strcmp($b[9], $a[9]);
	}

	public function filter()
	{
		if ($this->login()) {
			$data = array();
			$columns = array("source_org","source_system","source_trans_id","back_date","price","secure_id","license_plate","price_type","start_date","end_date","source_systemname","loaive_ten","loaive_mucphi","soatve_loaiphi","soatve_loaixe","soatve_mave","soatve_id","soatve_malan","ThuHoi","extbillmsg_invoiceno","extbillmsg_status","extbillmsg_statusstr","ThuHoiStr","thuhoive_id","thuhoive_ngaygio");
			$timestart = $this->input->post("timestart");
    		$timeend = $this->input->post("timeend");
    		$time = $this->input->post("time");
    		$type = $this->input->post("type");
    		$ca = $this->input->post("ca");
    		$lane = $this->input->post("lane");
    		$limit = $this->input->post('start');
	        $length = $this->input->post('length');
	        $draw = $this->input->post('draw');
	        $order = $this->input->post('order');
	        $order = $order[0];
	        $column = $order['column'];

	        $column = $columns[$column];
	        $sort = $order['dir'];

	        $listInvoice = $this->einvoice_model->filter($timestart,$timeend,$time,$type,$ca,$lane,$limit,$length,$draw,$column,$sort);
	        $ch = curl_init();
	        foreach($listInvoice as $row)
	        {
	        	$url_lookupVETC = URL_LOOKUP_VETC;
	        	$sub_array = array();
	        	$sub_array[] = $row->soatve_id;
	        	$sub_array[] = $row->back_date;
	        	$sub_array[] = $row->license_plate;
	        	$sub_array[] = $row->soatve_malan;
	        	$sub_array[] = $row->loaive_ten;
	        	$sub_array[] = $row->loaive_mucphi;
	        	$sub_array[] = $row->secure_id;
	        	$sub_array[] = $row->ThuHoiStr;
	        	$sub_array[] = $row->extbillmsg_statusstr;

	        	$url_lookupVETC.= $row->secure_id;

	        	curl_setopt_array($ch, array(
				    CURLOPT_RETURNTRANSFER => TRUE,
				    CURLOPT_URL => $url_lookupVETC,
				    CURLOPT_USERAGENT => 'lookup bill vetc',
				    CURLOPT_SSL_VERIFYPEER => false
				));

	        	$dataCheckVETC = curl_exec($ch);
	        	$dataCheckVETC = json_decode($dataCheckVETC);
	        	if($dataCheckVETC->status == 404)
	        		$sub_array[] = "Chưa có";
	        	if($dataCheckVETC->status == 200 && $dataCheckVETC->isSigned == 0)
	        		$sub_array[] = "Chưa kí";
	        	if($dataCheckVETC->status == 200 && $dataCheckVETC->isSigned == 1)
	        		$sub_array[] = "Đã kí";
	        	$data[] = $sub_array;
	        }
	        curl_close($ch);

	        if($column == "end_date" && $sort == "asc") {
	        	usort($data, array('Einvoice','cmp'));
	        }
	        if($column == "end_date" && $sort == "desc") {
	        	usort($data, array('Einvoice','cmp2'));
	        }
	        $output = array(
	            "draw" => $draw,
	            "recordsTotal"    => $this->einvoice_model->countListInvoice($timestart,$timeend,$time,$type,$ca,$lane),
	            "recordsFiltered" => $this->einvoice_model->countListInvoice($timestart,$timeend,$time,$type,$ca,$lane),
	            "data" => $data
	        );
	        echo json_encode($output);
		}
		else
			echo json_encode("403 forbidden");
	}

	public function export() {
		if($this->login())
		{
			$timestart = $this->input->post("timestart");
    		$timeend = $this->input->post("timeend");
    		$time = $this->input->post("time");
    		$type = $this->input->post("type");
    		$ca = $this->input->post("ca");
    		$lane = $this->input->post("lane");

    		$timeStr = "";

    		if($type == 0)
    		{
    			$timeStr = "Ca ".$ca . " ". $time;
    		}

    		$styleArrayHeader = array(
			    'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => '000000'),
			        'size'  => 16,
			        'name'  => 'Arial'
			    )
			);

			$styleArrayReportName = array(
			    'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => '000000'),
			        'size'  => 14,
			        'name'  => 'Arial'
			    )
			);

			$styleArrayParam = array(
			    'font'  => array(
			        'bold'  => false,
			        'color' => array('rgb' => '000000'),
			        'size'  => 14,
			        'name'  => 'Arial'
			    )
			);

			$styleArrayData = array(
			    'font'  => array(
			        'bold'  => false,
			        'color' => array('rgb' => '000000'),
			        'size'  => 14,
			        'name'  => 'Arial'
			    ),
			    'alignment' => array(
            		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        		),
        		'borders' => array(
			        'allborders' => array(
			            'style' => PHPExcel_Style_Border::BORDER_THIN,
			            'color' => array('argb' => '000000'),
			        ),
			    ),
			);

			$styleArrayHeaderColumn = array(
			    'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => '000000'),
			        'size'  => 14,
			        'name'  => 'Arial'
			    ),
			    'alignment' => array(
            		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        		),
        		'borders' => array(
			        'allborders' => array(
			            'style' => PHPExcel_Style_Border::BORDER_THIN,
			            'color' => array('argb' => '000000'),
			        ),
			    ),
			);

			$listInvoice = $this->einvoice_model->getListInvoice2Export($timestart,$timeend,$time,$type,$ca,$lane);
			$ch = curl_init();

	        $this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('DANH SÁCH HÓA ĐƠN');
			$this->excel->getActiveSheet()->mergeCells('A1:L1');
			$this->excel->getActiveSheet()->mergeCells('A2:L2');

			$this->excel->getActiveSheet()->setCellValue('A1', $this->companyName);
			$this->excel->getActiveSheet()->setCellValue('A2', $this->tollName);
			$this->excel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArrayHeader);
			$this->excel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArrayHeader);

			$this->excel->getActiveSheet()->mergeCells('G4:L4');
			$this->excel->getActiveSheet()->mergeCells('F5:N5');
			$this->excel->getActiveSheet()->setCellValue('G4', 'CHI TIẾT HÓA ĐƠN');
			$this->excel->getActiveSheet()->setCellValue('F5', $timeStr);
			$this->excel->getActiveSheet()->getStyle('G4')->applyFromArray($styleArrayReportName);
			$this->excel->getActiveSheet()->getStyle('F5')->applyFromArray($styleArrayReportName);

			foreach(range('A','K') as $columnID) {
    			$this->excel->getActiveSheet()->getColumnDimension($columnID)
        				->setAutoSize(true);
			}

			for($i = 0; $i < count($listInvoice); $i++)
			{
				$url_lookupVETC = URL_LOOKUP_VETC;
				$url_lookupVETC.= $listInvoice[$i]->secure_id;
				curl_setopt_array($ch, array(
				    CURLOPT_RETURNTRANSFER => TRUE,
				    CURLOPT_URL => $url_lookupVETC,
				    CURLOPT_USERAGENT => 'lookup bill vetc',
				    CURLOPT_SSL_VERIFYPEER => false
				));
				$dataCheckVETC = curl_exec($ch);
	        	$dataCheckVETC = json_decode($dataCheckVETC);
	        	if($dataCheckVETC->status == 404)
	        		$listInvoice[$i]->vetcstatus = "Chưa có";
	        	if($dataCheckVETC->status == 200 && $dataCheckVETC->isSigned == 0)
	        		$listInvoice[$i]->vetcstatus = "Chưa kí";
	        	if($dataCheckVETC->status == 200 && $dataCheckVETC->isSigned == 1)
	        		$listInvoice[$i]->vetcstatus = "Đã kí";
				$index = $i + 1;
				$row = $i + 7;
				$this->excel->getActiveSheet()->setCellValue("A".$row."", $index);
				$this->excel->getActiveSheet()->setCellValue("B".$row."", $listInvoice[$i]->soatve_id);
				$this->excel->getActiveSheet()->setCellValue("C".$row."", $listInvoice[$i]->back_date);
				$this->excel->getActiveSheet()->setCellValue("D".$row."", $listInvoice[$i]->license_plate);
				$this->excel->getActiveSheet()->setCellValue("E".$row."", $listInvoice[$i]->soatve_malan);
				$this->excel->getActiveSheet()->setCellValue("F".$row."", $listInvoice[$i]->loaive_ten);
				$this->excel->getActiveSheet()->setCellValue("G".$row."", $listInvoice[$i]->loaive_mucphi);
				$this->excel->getActiveSheet()->setCellValue("H".$row."", $listInvoice[$i]->secure_id);
				$this->excel->getActiveSheet()->setCellValue("I".$row."", $listInvoice[$i]->ThuHoiStr);
				$this->excel->getActiveSheet()->setCellValue("J".$row."", $listInvoice[$i]->extbillmsg_statusstr);
				$this->excel->getActiveSheet()->setCellValue("K".$row."", $listInvoice[$i]->vetcstatus);
			}

			$this->excel->getActiveSheet()->setCellValue('A6', 'STT');
			$this->excel->getActiveSheet()->setCellValue('B6', 'MÃ GIAO DỊCH');
			$this->excel->getActiveSheet()->setCellValue('C6', 'THỜI GIAN');
			$this->excel->getActiveSheet()->setCellValue('D6', 'BIỂN SỐ');
			$this->excel->getActiveSheet()->setCellValue('E6', 'LÀN');
			$this->excel->getActiveSheet()->setCellValue('F6', 'LOẠI PHIẾU THU');
			$this->excel->getActiveSheet()->setCellValue('G6', 'ĐƠN GIÁ');
			$this->excel->getActiveSheet()->setCellValue('H6', 'MÃ TRA CỨU');
			$this->excel->getActiveSheet()->setCellValue('I6', 'TRẠNG THÁI PHIẾU THU');
			$this->excel->getActiveSheet()->setCellValue('J6', 'TRẠNG THÁI HÓA ĐƠN CPR');
			$this->excel->getActiveSheet()->setCellValue('K6', 'TRẠNG THÁI HÓA ĐƠN VETC');

			$tmpSuminvoice = count($listInvoice) + 6;

			$this->excel->getActiveSheet()->getStyle("A6:K12")->applyFromArray($styleArrayHeaderColumn);
			$this->excel->getActiveSheet()->getStyle("A7:K".$tmpSuminvoice."")->applyFromArray($styleArrayData);

			$filename ='invoice.xls';
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			ob_start();
			$objWriter->save("php://output");
			$xlsData = ob_get_contents();
			ob_end_clean();
	        $response =  array(
	            'status' => TRUE,
	            'filename' => $filename,
	            'file' => "data:application/vnd.ms-excel;base64,". base64_encode($xlsData)
	        );
	        die(json_encode($response));
		}
		else
			die("403 forbidden");
	}

}