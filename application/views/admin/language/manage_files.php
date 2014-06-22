<script>
    $(document).ready(function(){

        load_files("data=get_files&folder=0");
        $(".directory").live('click',function(e){
            e.preventDefault();
            $("#file_cont_frame").attr("src","");
            var folder=$(this).attr("folder");
            var dataString="data=get_files&folder="+folder;
            load_files(dataString);
        });

        $(".file a").live('click',function(e){ 
            e.preventDefault();
            blockcont(".content","<?php echo tr("PLEASE_WAIT_LOADING");?>");
            var thisObj=this;
            var file_loc=$(thisObj).attr("rel");
            $(".file").each(function(){
                $(this).removeClass("file_active");
            });
            $(thisObj).parent().addClass("file_active");
            var path_frame= "<?php echo ADMIN_HTTP_PATH;?>language/manage_macros/"+file_loc+"/1";
            $("#file_cont_frame").attr("src",path_frame);
        });

        $("#file_folder_back").live('click',function(e){
            e.preventDefault();
            load_files("data=get_files&folder=0");
        });

    });

    function loadingdone()
    {
        unblockcont(".content");
    }

    function load_files(dataString)
    {
        var url=ADMIN_HTTP_PATH+"language/load_lang_files";
        var returndata=ajaxJsonData(url,dataString,"content","<?php echo tr("PLEASE_WAIT");?>",'rep_mess');

        var dir_arr=returndata.dir_arr;
        var files_arr=returndata.files_arr;
        var back=returndata.back;
        var html='<ul style="" class="file_folder">';
        if(back==1)
        {
            html += '<li id="file_folder_back"><a rel="#" href="#"><?php echo tr("BACK");?></a></li>';
        }
        for (var i in dir_arr)
        {
            var dir = dir_arr[i];
            html += '<li class="directory" folder="'+dir+'"><a rel="#" href="#">'+dir+'</a></li>';
        }

        var files=files_arr.file;
        var enc_files=files_arr.enc_file;
        for (var i in files)
        {
            var file = files[i];
            var enc_file = enc_files[i];
            html += '<li class="file"><a rel="'+enc_file+'" href="#">'+file+'</a></li>';
        }
        html +="</ul>";
        $(".file_folder_tree").html(html);
    }
</script>        
<!-- Bread Crumb Navigation -->
<div class="span<?php if(isset($spans_arr['center'])) echo $spans_arr['center'];?>">

<?php
    if(isset($bread_crumb) && !empty($bread_crumb))
        breadcrumb($bread_crumb);
?>
    <div class="box" id="box-0">
      <h4 class="box-header round-top"><?php echo tr("DASHBOARD"); ?></h4>         
      <div class="box-container-toggle">
          <div class="box-content">
              <div class="file_folder_tree span3">
                </div>
                <div class="file_disp_cont span9">
                    <iframe id="file_cont_frame" src="" height="500" frameborder="0" style="overflow: hidden;width: 100%;"></iframe>
                </div>
                <div style="clear: both;height: 10px;"></div>
          </div>
      </div>
    </div><!--/span-->    
</div>
        
    

