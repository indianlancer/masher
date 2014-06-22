<?php
$this->content =& get_instance(); 
?>
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
    <div class="row-fluid">
        <?php echo $this->content->fetch('content'); ?>
    </div>
    
