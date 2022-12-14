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
define('VAOLAN_KIN_STR',					'L?????t v??o');
define('CPR_VELUOT_INT',					1);
define('CPR_VELUOT_STR',					'L?????t');
define('CPR_VETHANG_INT',					2);
define('CPR_VETHANG_STR',					'Th??ng');
define('CPR_VEQUY_INT',						3);
define('CPR_VEQUY_STR',						'Qu??');
define('CPR_LUOT_VE_GIAY_INT',				13);
define('CPR_LUOT_VE_GIAY_STR',				'L?????t v?? gi???y');
define('CPR_QUOC_LO_LUOT_INT',				9);
define('CPR_QUOC_LO_LUOT_STR',				'Qu???c l??? l?????t');
define('CPR_TOAN_QUOC_INT',					10);
define('CPR_TOAN_QUOC_STR',					'To??n qu???c');
define('CPR_DOANXE_INT',					12);
define('CPR_DOANXE_STR',					'??o??n xe');
define('CPR_VUOTTRAM_INT',					0);
define('CPR_VUOTTRAM_STR',					'V?????t tr???m');
define('CPR_MIENPHIDONCHIEC_INT',			11);
define('CPR_THUHOI_STR',					'V?? thu h???i');
define('CPR_BANBOXUNG_STR',					'B??n b??? xung');
define('CPR_BANMOI_STR',					'B??n m???i');

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
define('NOT_CREATE_STR',						'Ch??a t???o');
define('NOT_SIGN_STR',							'Ch??a k??');
define('SIGNED_STR',							'???? k??');
define('DESTROY_STR',							'B??? h???y');
define('SKIP_STR',								'B??? qua');
define('RECALLED_STR',							'???? thu h???i');
define('INVALID_LOOKUP_CODE',					'Thi???u m?? tra c???u');
define('SUCCESS_INVOICE',						'H???p l???');

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

define('CARTYPE_1_STR',											'Xe < 12 ch???, xe t???i < 2 t???n; xe bu??t c??ng c???ng');
define('CARTYPE_2_STR',											'Xe 12-30 ch???; xe t???i 2 ?????n <4 t???n');
define('CARTYPE_3_STR',											'Xe >= 31 ch???; xe t???i 4 ?????n <10 t???n');
define('CARTYPE_4_STR',											'Xe t???i 10 ?????n <18 t???n; xe Container 20 fit');
define('CARTYPE_5_STR',											'Xe t???i >= 18 t???n; xe Container 40 fit');

define('TICKETTYPE_VELUOT_STR',									'V?? l?????t');
define('TICKETTYPE_VETHANG_STR',								'V?? th??ng');
define('TICKETTYPE_VEQUY_STR',									'V?? qu??');

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

