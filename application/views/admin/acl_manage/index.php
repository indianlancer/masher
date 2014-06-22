<style>
    .tog_row_main td{
        background-color: #BFDCF5;
        border-top: 1px solid #5EB0F7;
        border-bottom: 1px solid #5EB0F7; 
        font-weight:  bold;
    }
    .tog_row_main .tog_row
    {
        cursor: pointer;
    }
    .tog_row_main td:hover{
        color: #666;
        font-weight:  bold;
    }
    .permission_togg
    {
        cursor: pointer;
    }

</style>
<script>
    $().ready(function(){
       $(".tog_row").click(function(e){
            e.preventDefault();
            var this_class = $(this).attr("class");
            this_class = $.trim(this_class.split("tog_row")[1]);
            $(".tog_row_"+this_class).slideToggle('fast');
            var icon_class = $(this).find("i").attr("class");
            if(icon_class=="icon-chevron-up")
                $(this).find("i").attr("class",'icon-chevron-down');
            else
                $(this).find("i").attr("class",'icon-chevron-up');
            
       });
       $(".permission_togg").click(function(e){
            e.preventDefault();
            var aro_aco = $(this).attr("rel");
            var val_set = $(this).attr("data-val");
            var aro = aro_aco.split("-")[0];
            var aco = aro_aco.split("-")[1];
            if(aro==1)
                return false;
            else
            {
                var ret_data = ajaxJsonData(ADMIN_HTTP_PATH+"acl_manage/tog_perm/","aro="+aro+"&aco="+aco+"&val_set="+val_set,"","","");
                var parent_class = $(this).parent().parent().attr('class');
                var set_class = $(this).parent().parent().attr('data-row');
                if(val_set==1)
                {
                    var n_set_class = 'icon-remove';
                    var set_val = 0;

                }
                else
                {
                    var n_set_class = 'icon-ok';
                    var set_val = 1;

                }
                $(this).find("i").attr("class",n_set_class);
                $(this).attr("data-val",set_val);
                if(parent_class == "tog_row_main")
                {
                    var ind = $(this).parent().index();
                    $(".tog_row_"+set_class).each(function(){
                         $(this).find("td:eq("+ind+") a").attr("data-val",set_val);   
                         $(this).find("td:eq("+ind+") i").attr("class",n_set_class)   
                    });
                }
            }
       });
       
       $(".generate_acos").click(function(e){
            e.preventDefault();
            
            blockcont("body","Generating please wait...");
            var ajax = $.ajax({     
                        type: "POST",
                        url: ADMIN_HTTP_PATH+"acl_manage/recreate_all_acos_aros/",
                        cache: false,
                        data: "",
                        dataType: "json"
            });
            ajax.complete(function(){
               unblockcont("body"); 
            });
            ajax.success(function(data){
                bootbox.alert("Generated successfully..",function(){
                    window.location.reload();
                })
            }); 
       });
       
    });
</script>
        <!-- Bread Crumb Navigation -->
        <div class="span<?php if(isset($spans_arr['center'])) echo $spans_arr['center'];?>">

        <?php
            if(isset($bread_crumb) && !empty($bread_crumb))
                breadcrumb($bread_crumb);

            if(isset($load_file) && strlen($load_file)>0)
                $this->content->element($load_file,array('spans_arr' => $spans_arr)); 
            
          set_print_success_error();  
           // echo "<pre>";
            //print_r($acos_list);
        ?>
            <a class="btn-large btn-success generate_acos" href="#" >Generate ACL</a>
            <table class="table" >
                <thead>
                    <tr>
                        <th width="10%" class="left">Id</th>
                        <th width="30%" class="left"><?php echo tr("Alias"); ?></th>
<?php
                        foreach ($aros_list as $ar_list)
                        {
?>
                        <th width="20%" class="left"><?php echo $ar_list->alias; ?></th>
<?php
                        }
?>
                    </tr>
                </thead>
                <tbody>
<?php
unset($acos_list[0]);
$set_parent="";
                        foreach ($acos_list as $data)
                        {
                            if($data->parent_id==1)
                            {
                                
?>
                    <tr class="tog_row_main" data-row="<?php echo $set_parent = createItemUrl($data->alias);?>">
                        <td><?php echo $data->id;?></td>
                        <td><div class="tog_row <?php echo $set_parent;?>"><i class="icon-chevron-up"></i> <?php echo $data->alias;?></div></td>
<?php
                        foreach ($aros_list as $ar_list)
                        {
                            $icon_val = $this->aclauth->get_aro_aco_icon($ar_list->id,$data->id);
                            $icon = explode("|", $icon_val);
                            $val = $icon[1];
                            $icon = $icon[0];
?>
                        <td><a class="permission_togg" data-val="<?php echo $val;?>" rel="<?php echo $ar_list->id;?>-<?php echo $data->id;?>"><i class="<?php echo $icon;?>"></i></a></td>
<?php
                        }
?>
                    </tr>
<?php
                            }
                            else
                            {
?>
                    <tr class="tog_row_<?php echo $set_parent;?> displaynone">
                        <td><?php echo $data->id;?></td>
                        <td><?php echo $data->alias;?></td>
<?php
                        foreach ($aros_list as $ar_list)
                        {
                            $icon_val = $this->aclauth->get_aro_aco_icon($ar_list->id,$data->id);
                            $icon = explode("|", $icon_val);
                            $val = $icon[1];
                            $icon = $icon[0];
?>
                        <td><a class="permission_togg" data-val="<?php echo $val;?>" rel="<?php echo $ar_list->id;?>-<?php echo $data->id;?>"><i class="<?php echo $icon;?>"></i></a></td>
<?php
                        }
?>
                    </tr>
<?php
                            }
                        }
?>
                </tbody>
            </table>
            
            
        </div>
    

