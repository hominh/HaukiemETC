<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base {

	private $tmp_datetime = '-2 minutes';
	private $tmp_datetime2 = '+2 minutes';

	public function getDateTimeBegin($time)
	{
		$time = strtotime($time);
		$from_time = strtotime($this->tmp_datetime, $time);
		$from_time = date('Y-m-d H:i:s', $from_time);
		return $from_time;
	}

	public function getDateTimeEnd($time)
	{
		$time = strtotime($time);
		$to_time = strtotime($this->tmp_datetime2, $time);
		$to_time = date('Y-m-d H:i:s', $to_time);
		return $to_time;
	}

	public function getRangeTimeByDay($day,$month,$year)
	{
		$result = array();
		$tmpHour = " 06:00:00";
		$inputDate = $year . "-" . $month . "-" . $day;
		$strTimeStart = $inputDate . $tmpHour;
		$inputDate = strtotime($inputDate);
		$nextDate = date('Y-m-d', strtotime("+1 day", $inputDate));
		$strTimeEnd = $nextDate.$tmpHour;
		array_push($result,$strTimeStart);
		array_push($result,$strTimeEnd);
		return $result;
	}
}