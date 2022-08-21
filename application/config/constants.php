<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Param filter soatve
|--------------------------------------------------------------------------
*/

define('TRANSACTION_TYPE_PENDING_INT',		0);
define('TRANSACTION_TYPE_COMMIT_INT',		1);
define('TRANSACTION_TYPE_ROOLBACK_INT',		2);
define('TRANSACTION_TYPE_PENDING_STR',		'Pending');
define('TRANSACTION_TYPE_COMMIT_STR',		'Commit');
define('TRANSACTION_TYPE_ROOLBACK_STR',		'Roolback');
define('TRANSACTION_TYPE_WHITELIST_STR',	'Whitelist');
define('TRANSACTION_TYPE_OFFLINE_STR',		'Offline');

define('VETC_VELUOT_CONVERT_2_CADPRO',		5);
define('VETC_VETHANG_CONVERT_2_CADPRO',		6);
define('VETC_VEQUY_CONVERT_2_CADPRO',		7);
define('VETC_WHITELIST_CONVERT_2_CADPRO',	8);
define('VETC_OFFLINE_CONVERT_2_CADPRO',		15);

define('VAOLAN_KIN_INT',					15);
define('VAOLAN_KIN_STR',					'Lượt vào');
define('CPR_VELUOT_INT',					1);
define('CPR_VELUOT_STR',					'Lượt');
define('CPR_VETHANG_INT',					2);
define('CPR_VETHANG_STR',					'Tháng');
define('CPR_VEQUY_INT',						3);
define('CPR_VEQUY_STR',						'Quý');
define('CPR_LUOT_VE_GIAY_INT',				13);
define('CPR_LUOT_VE_GIAY_STR',				'Lượt vé giấy');
define('CPR_QUOC_LO_LUOT_INT',				9);
define('CPR_QUOC_LO_LUOT_STR',				'Quốc lộ lượt');
define('CPR_TOAN_QUOC_INT',					10);
define('CPR_TOAN_QUOC_STR',					'Toàn quốc');
define('CPR_DOANXE_INT',					12);
define('CPR_DOANXE_STR',					'Đoàn xe');
define('CPR_VUOTTRAM_INT',					0);
define('CPR_VUOTTRAM_STR',					'Vượt trạm');
define('CPR_MIENPHIDONCHIEC_INT',			11);
define('CPR_THUHOI_STR',					'Vé thu hồi');
define('CPR_BANBOXUNG_STR',					'Bán bổ xung');
define('CPR_BANMOI_STR',					'Bán mới');

/*
|--------------------------------------------------------------------------
| Role user
|--------------------------------------------------------------------------
*/
define('BIT6', 								0x40);

/*
|--------------------------------------------------------------------------
| Einvoice
|--------------------------------------------------------------------------
*/
define('NOT_CREATE_STR',						'Chưa tạo');
define('NOT_SIGN_STR',							'Chưa kí');
define('SIGNED_STR',							'Đã kí');
define('DESTROY_STR',							'Bị hủy');
define('SKIP_STR',								'Bỏ qua');
define('RECALLED_STR',							'Đã thu hồi');
define('INVALID_LOOKUP_CODE',					'Thiếu mã tra cứu');
define('SUCCESS_INVOICE',						'Hợp lệ');

define('NOT_CREATE_INT',						0);
define('NOT_SIGN_INT',							1);
define('SIGNED_INT',							2);
define('DESTROY_INT',							4);
define('URL_LOOKUP_VETC',						'http://10.86.2.21/searchebill/index2.php?s=');

/*
|--------------------------------------------------------------------------
| Cartype VETC EXCEL
|--------------------------------------------------------------------------
*/

define('CARTYPE_1_STR',											'Xe < 12 chỗ, xe tải < 2 tấn; xe buýt công cộng');
define('CARTYPE_2_STR',											'Xe 12-30 chỗ; xe tải 2 đến <4 tấn');
define('CARTYPE_3_STR',											'Xe >= 31 chỗ; xe tải 4 đến <10 tấn');
define('CARTYPE_4_STR',											'Xe tải 10 đến <18 tấn; xe Container 20 fit');
define('CARTYPE_5_STR',											'Xe tải >= 18 tấn; xe Container 40 fit');

define('TICKETTYPE_VELUOT_STR',									'Vé lượt');
define('TICKETTYPE_VETHANG_STR',								'Vé tháng');
define('TICKETTYPE_VEQUY_STR',									'Vé quý');

define('CARTYPE_1_INT',											1);
define('CARTYPE_2_INT',											2);
define('CARTYPE_3_INT',											3);
define('CARTYPE_4_INT',											4);
define('CARTYPE_5_INT',											5);

define('TICKETTYPE_VELUOT_INT',									1);
define('TICKETTYPE_VETHANG_INT',								0);
define('TICKETTYPE_VEQUY_INT',									2);


/* End of file constants.php */
/* Location: ./application/config/constants.php */

