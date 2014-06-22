<?php
        echo $this->html->script(array('jquery.hoverIntent'
                        ,'admin/custom/common_functions','admin/custom/jquery.sort_in_edit','jquery.dataTables'
            ,'blockUI/chili-1.7.pack','blockUI/jquery.blockUI','bootstrap','jquery.cookie','jquery.toggle.buttons','jqBootstrapValidation','bootbox.min','rtcalendar.min','admin/default',
            'jquery-ui/ui/minified/jquery.ui.core.min','jquery-ui/ui/minified/jquery.ui.widget.min','jquery-ui/ui/minified/jquery.ui.mouse.min'
            ,'jquery-ui/ui/minified/jquery.ui.sortable.min','jquery-ui/ui/minified/jquery.ui.draggable.min','jquery-ui/ui/minified/jquery.ui.droppable.min'
            ,'bootstrap-datepicker'
            ),array("fullBase"=>true));
?>    
 <!-- Chosen multiselect -->
    <script type="text/javascript" language="javascript" src="<?php echo ASSETS_PATH ;?>chosen/chosen.jquery.min.js"></script>  
    
    <!-- Uniform -->
    <script type="text/javascript" language="javascript" src="<?php echo ASSETS_PATH ;?>uniform/jquery.uniform.min.js"></script>