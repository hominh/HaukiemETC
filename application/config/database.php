<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = '10.10.72.140';
$db['default']['username'] = 'cadpro';
$db['default']['password'] = 'cadprojsc';
$db['default']['database'] = 'CadProETC-BBT2022';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = TRUE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['otherdb']['hostname'] = '10.86.2.21';
$db['otherdb']['username'] = 'cadpro';
$db['otherdb']['password'] = 'cadprojsc';
$db['otherdb']['database'] = 'localvnm';
$db['otherdb']['dbdriver'] = 'mysqli';
$db['otherdb']['dbprefix'] = '';
$db['otherdb']['pconnect'] = TRUE;
$db['otherdb']['db_debug'] = TRUE;
$db['otherdb']['cache_on'] = TRUE;
$db['otherdb']['cachedir'] = '';
$db['otherdb']['char_set'] = 'utf8';
$db['otherdb']['dbcollat'] = 'utf8_general_ci';
$db['otherdb']['swap_pre'] = '';
$db['otherdb']['autoinit'] = TRUE;
$db['otherdb']['stricton'] = FALSE;

$db['second_db']['hostname'] = '10.86.2.21';
$db['second_db']['username'] = 'cadpro';
$db['second_db']['password'] = 'cadprojsc';
$db['second_db']['database'] = 'CadProTFC-BBT2022';
$db['second_db']['dbdriver'] = 'mysqli';
$db['second_db']['dbprefix'] = '';
$db['second_db']['pconnect'] = TRUE;
$db['second_db']['db_debug'] = TRUE;
$db['second_db']['cache_on'] = TRUE;
$db['second_db']['cachedir'] = '';
$db['second_db']['char_set'] = 'utf8';
$db['second_db']['dbcollat'] = 'utf8_general_ci';
$db['second_db']['swap_pre'] = '';
$db['second_db']['autoinit'] = TRUE;
$db['second_db']['stricton'] = FALSE;



/* End of file database.php */
/* Location: ./application/config/database.php */