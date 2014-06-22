<?php
$rtDescription = ('Radiator|');
$this->content =& get_instance(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php //echo $this->Html->charset(); ?>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>
		<?php echo $rtDescription ?>
		<?php echo $title_for_layout; ?>
	</title>
<?php
		echo $this->html->meta(array('icon'),array('fullPath'=>true));

		echo $this->html->css(array('admin/default','admin/admin','admin/rtcalendar','bootstrap/admin_bootstrap','bootstrap/bootstrap-toggle-buttons','other/file_uploader','bootstrap/ie','bootstrap/media-queries'),array(),array("fullPath"=>true));
?>
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo ASSETS_PATH; ?>uniform/css/uniform.default.css" />
<!-- Chosen multiselect -->
  <link type="text/css" href="<?php echo ASSETS_PATH; ?>chosen/chosen.intenso.css" rel="stylesheet" />  
<?php
                echo $this->html->script('jquery_latest/jquery',array("fullBase"=>true));
?>
  <script>
      <?php      include_once 'constants.js.php';?>
  </script>
</head>
<body>
    <?php
    if(!isset($spans_arr))
        $spans_arr= array();
    ?>
        <div class="container-fluid">
            <div class="row-fluid">
                <?php echo $this->content->fetch('content'); ?>
            </div>
        </div>
        <?php echo $this->content->element('admin_footer',array('spans_arr' => $spans_arr)); ?>
</body>
</html>
