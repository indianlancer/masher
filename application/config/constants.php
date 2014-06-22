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


define('REMEMBER_ME_KEY','rmtoken_' . str_replace('.', '_', $_SERVER['SERVER_NAME']));
define('MD5_PREFIX_PASS','rishi_');

define('BASE_PATH','masher/');

define('SECURE_URL',false);

if(SECURE_URL)
{
    define('HTTP_PATH', "https://".$_SERVER['HTTP_HOST'].'/'.BASE_PATH);
}
else
    define('HTTP_PATH', "http://".$_SERVER['HTTP_HOST'].'/'.BASE_PATH);

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.BASE_PATH);


define('ADMIN_HTTP_PATH', "http://".$_SERVER['HTTP_HOST'].'/'.BASE_PATH.'admin/');
define('ADMIN_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.BASE_PATH.'admin/');


define('ASSETS_PATH', HTTP_PATH.'assets/');
define('IMG_PATH', ASSETS_PATH.'img/');
define('UPLOAD_PATH', ASSETS_PATH.'files/');
define('CSS_PATH', ASSETS_PATH.'css/');
define('JS_PATH', ASSETS_PATH.'js/');
define('CUSTOM_JS_PATH', JS_PATH.'custom/');
define('ICONS_PATH', IMG_PATH.'icons/');
define('CKEDITOR_PATH',ASSETS_PATH.'/ckeditor/');



define('ASSETS_ROOT_PATH', ROOT_PATH.'assets/');
define('IMG_ROOT_PATH', ASSETS_ROOT_PATH.'img/');
define('UPLOAD_ROOT_PATH', ASSETS_ROOT_PATH.'files/');
define('CSS_ROOT_PATH', ASSETS_ROOT_PATH.'css/');
define('JS_ROOT_PATH', ASSETS_ROOT_PATH.'js/');
define('ICONS_ROOT_PATH', IMG_ROOT_PATH.'icons/');


// =================== Admin defined constants ========================//

define('ADMIN_CUSTOM_JS_PATH', JS_PATH.'admin/custom/');
define('ADMIN_ICONS_PATH', ICONS_PATH.'admin/');


define('ADMIN_ASSETS_ROOT_PATH', ROOT_PATH.'assets/admin/');
define('ADMIN_LANG_ROOT_PATH', ROOT_PATH.'application/language/');

define('POSTS_IMAGES', "600x300,400x200,200x100,100x50");
// =================== Admin defined constants ========================//

define('SHOW_LANG_SWITCH',1);
// =================== client defined constants ======================//

define("MAIL_PROTOCOL","");


global $global_payment_status;

global $global_month_arr;
$global_month_arr = array("CAL_JAN","CAL_FEB","CAL_MAR","CAL_APR","CAL_MAY","CAL_JUNE","CAL_JUL","CAL_AUG","CAL_SEPT","CAL_OCT","CAL_NOV","CAL_DEC");


//============== Regex patterns ============================================


define("DATE_PATTERN","^(((0[1-9]|[12]\d|3[01])-(0[13578]|1[02])-((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)-(0[13456789]|1[012])-((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])-02-((19|[2-9]\d)\d{2}))|(29-02-((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$");

//define("PASSWORD_PATTERN","(?=^.{5,12}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$");
define("PASSWORD_PATTERN","^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$");
define("USERNAME_PATTERN","^[0-9a-zA-Z]{4,15}$");
define("ZIP_CODE_PATTERN","(\d{5}([\-]\d{4})?)");
define("FAX_NUM_PATTERN","^[0-9]+[\- ]*[0-9]+$");
define("PHONE_NUM_PATTERN","^[0-9]+[\- ]*[0-9]+$");
define("WEBSITE_URL_PATTERN","^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$");



define("EMAIL_VERIFY_EXPIRE","3600");




/* End of file constants.php */
/* Location: ./application/config/constants.php */
