<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __('My first blog - on Cakephp');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400" />
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans" />
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster" />
        <link rel="shortcut icon" href="ico/favicon.ico"/>
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png" />
<?php
		echo $this->Html->meta(array('icon'));

		echo $this->Html->css(array('other/autocomplete','bootstrap/bootstrap.min','other/file_uploader','bootstrap/ie','bootstrap/media-queries','andia-agency/style','andia-agency/font-awesome','prettyPhoto/prettyPhoto.css'),array(),array("fullBase"=>true));
                
?>
            <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
            <!--[if lt IE 9]>
            <?php
            echo $this->Html->script('http://html5shim.googlecode.com/svn/trunk/html5.js');
            echo $this->fetch('script');
?>
        <![endif]-->
        <!-- Favicon and touch icons -->
<?php
                
		//echo $this->Html->script(array('jquery_latest/jquery','custom/common_functions'),array("fullBase"=>true));
		echo $this->Html->script('jquery_latest/jquery',array("fullBase"=>true));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
?>
</head>
<body>
	
                <?php echo $this->element('header',array('cake_desc' => $cakeDescription)); ?>
                <?php echo $this->element('site_desc',array('cake_desc' => $cakeDescription)); ?>
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->fetch('content'); ?>
                <?php echo $this->element('footer',array('cake_desc' => $cakeDescription)); ?>
                <div class="container cake_log_cont"><?php echo $this->element('sql_dump'); ?></div>
</body>
</html>
