<!--=== Footer ===-->

<!--=== Copyright ===-->
<div class="copyright">
	<div class="container">
		<div class="row">
			<div class="col-md-6">						
	            <p class="copyright-space">
                    2014 &copy; IndianLancer. ALL Rights Reserved. 
                    <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
                </p>
			</div>
			<div class="col-md-6">	
				<a href="<?php echo HTTP_PATH;?>">
                    <img id="logo-footer" src="<?php echo IMG_PATH;?>logo2-default-200.png" class="pull-right" alt="Indianlancer logo" />
                </a>
			</div>
		</div><!--/row-->
	</div><!--/container-->	
</div><!--/copyright-->	
<!--=== End Copyright ===-->

<?php
    echo $this->html->script(array('custom/common_functions','custom/jquery.cstm-fn','bootbox.min'),array("fullBase"=>true));
?>

<script>
    $j(document).ready(function(){
      
    });
</script>
<!-- JS Global Compulsory -->			
<script type="text/javascript" src="<?php echo ASSETS_PATH;?>plugins/bootstrap/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo ASSETS_PATH;?>plugins/hover-dropdown.min.js"></script> 

<!-- JS Implementing Plugins -->           
<!-- JS Page Level -->           

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-39918957-1', 'indianlancer.com');
  ga('send', 'pageview');

</script>
<?php echo $this->content->element('constants_js'); ?>