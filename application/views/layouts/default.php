<?php
$rtDescription = ('Indianlancer');
$this->content =& get_instance(); 
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> 
<html lang="en"> <!--<![endif]-->  
<head>
<?php include 'seo_data.php';?>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <!-- CSS Global Compulsory-->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400" />
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans" />
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png" />
<?php
    echo $this->html->css(array('headers/header1','responsive','themes/default','chat','smileys'),array(),array("fullPath"=>true));
?>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
<?php
    echo $this->html->script('http://html5shim.googlecode.com/svn/trunk/html5.js');
?>
        <![endif]-->
        <!-- Favicon and touch icons -->
<?php
        echo $this->html->script(array('jquery_latest/jquery'),array("fullBase"=>true));
?>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH;?>plugins/bootstrap/css/bootstrap.css">
<?php
    echo $this->html->css(array('style'),array(),array("fullPath"=>true));
?>
    <?php echo $this->html->meta(array('icon'),array('fullPath'=>true));?>
    <!-- CSS Implementing Plugins -->    
    <link rel="stylesheet" href="<?php echo ASSETS_PATH;?>plugins/font-awesome/css/font-awesome.css">
    
</head>	

<body>

    <?php echo $this->content->element(array('header'),array('cake_desc' => $rtDescription)); ?>
    <?php echo $this->content->fetch('content'); ?>
    <?php echo $this->content->element('footer',array('cake_desc' => $rtDescription)); ?>    
</body>
</html>
