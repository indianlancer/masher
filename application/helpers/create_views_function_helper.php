<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('create_calendar_js'))
{
        function create_calendar_js() 
        {
            $CI =& get_instance();
?>
            <script src="<?php echo ASSETS_PATH ;?>jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
            <script src="<?php echo ASSETS_PATH ;?>jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
            <script src="<?php echo ASSETS_PATH ;?>jquery-ui/development-bundle/ui/jquery.ui.datepicker.js"></script>
            <script src="<?php echo ASSETS_PATH ;?>jquery-ui/development-bundle/ui/i18n/jquery.ui.datepicker-<?php if($CI->coresession->userdata('admin_cchl')!="") echo $CI->coresession->userdata('admin_cchl'); else echo 'en';?>.js"></script>
            <script>
                $(function() {
                    $.datepicker.setDefaults( $.datepicker.regional[ "<?php echo $CI->coresession->userdata('admin_cchl');?>" ] );
                });
            </script>
<?php            
        }
}

if(!function_exists('show_image'))
{
    function show_image($image,$image_type)
    {
        header("Content-Type: ".$image_type);
        echo $image;
    }
}



if(!function_exists('error404_disp'))
{
    function error404_disp($message,$heading=false)
    {
?>
<title>Error</title>
<style type="text/css">

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	-webkit-box-shadow: 0 0 8px #D0D0D0;
}

p 
{
    margin: 12px 15px 12px 15px;
    color: red;
}
</style>

	<div id="container">
            <?php
            if(strlen($heading)>0)
            {
?>
		<h1><?php echo $heading; ?></h1>
<?php
            }
?>
                <p><?php echo $message; ?></p>
	</div>
<?php
        die;
    }
    
}

if(!function_exists('handle_error'))
{

    function handle_error($mess=false)
    {
        $error_controller= APPPATH.'controllers/error404.php';
        if(file_exists($error_controller))
        {
            include_once $error_controller;
            $error = new Error404();
            $error->index();
        }
        else
        {
            error404_disp($mess);
        }

    }
}


if(!function_exists('breadcrumb'))
{
    function breadcrumb($crumbs)
    {
?>
    <div>
        <ul class="breadcrumb">
<?php
    foreach($crumbs as $key=>$crumb)
    {
?>
            <li>
                <a href="<?php echo $crumb;?>"><?php echo tr($key); ?></a> <span class="divider">/</span>
            </li>
<?php
    }
?>
        </ul>
    </div> 
<?php
    }
}


if(!function_exists('default_admin_left_menu'))
{
    function default_admin_left_menu()
    {
        $arr =   array(
                    array('MAIN',false,'home'),
                    array('DASHBOARD',ADMIN_HTTP_PATH.'home','home'),
                    array('ACL_MANAGE',ADMIN_HTTP_PATH.'acl_manage','download-alt'),
                    array('LANGUAGES',ADMIN_HTTP_PATH.'language','folder-close'),
                );
        return $arr;
    }
}


/* End of file common_function_helper.php */
/* Location: /helpers/common_function_helper.php */
