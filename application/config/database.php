<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'local';
$active_record = TRUE;

/*========================   Localhost connection =======================*/


$db['local']['hostname'] = 'dbhost';
$db['local']['username'] = 'dbuser';
$db['local']['password'] = 'dbpass';
$db['local']['database'] = 'dbname';
$db['local']['dbdriver'] = 'mysql';
$db['local']['dbprefix'] = 'rlst_';
$db['local']['pconnect'] = TRUE;
$db['local']['db_debug'] = TRUE;
$db['local']['cache_on'] = FALSE;
$db['local']['cachedir'] = '';
$db['local']['char_set'] = 'utf8';
$db['local']['dbcollat'] = 'utf8_general_ci';
$db['local']['swap_pre'] = '';
$db['local']['autoinit'] = TRUE;
$db['local']['stricton'] = FALSE;


/*========================   dev connection =======================*/

$db['dev']['hostname'] = 'dev connection';
$db['dev']['username'] = 'dev';
$db['dev']['password'] = 'dev pass';
$db['dev']['database'] = 'devdb';
$db['dev']['dbdriver'] = 'mysql';
$db['dev']['dbprefix'] = '';
$db['dev']['pconnect'] = TRUE;
$db['dev']['db_debug'] = TRUE;
$db['dev']['cache_on'] = FALSE;
$db['dev']['cachedir'] = '';
$db['dev']['char_set'] = 'utf8';
$db['dev']['dbcollat'] = 'utf8_general_ci';
$db['dev']['swap_pre'] = '';
$db['dev']['autoinit'] = TRUE;
$db['dev']['stricton'] = FALSE;

/*========================   live connection =======================*/

$db['live']['hostname'] = 'live conection';
$db['live']['username'] = 'live user';
$db['live']['password'] = 'live pass';
$db['live']['database'] = 'livedb';
$db['live']['dbdriver'] = 'mysql';
$db['live']['dbprefix'] = '';
$db['live']['pconnect'] = TRUE;
$db['live']['db_debug'] = TRUE;
$db['live']['cache_on'] = FALSE;
$db['live']['cachedir'] = '';
$db['live']['char_set'] = 'utf8';
$db['live']['dbcollat'] = 'utf8_general_ci';
$db['live']['swap_pre'] = '';
$db['live']['autoinit'] = TRUE;
$db['live']['stricton'] = FALSE;



/* End of file database.php */
/* Location: ./application/config/database.php */