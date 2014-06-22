<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('toolbar_buttons'))
{
        function toolbar_buttons($buttons=false)
        {
            if($buttons==false)
                return false;
            
            if(array_search("save", $buttons)!==false)
            {
?>
            <div id="toolbar-save" class="btn-group btn-tool-frm">
                <button class="btn btn-long btn-success">
                    <i class="icon-edit icon-white"></i>
                    <?php echo tr("SAVE");?>
                </button>
            </div>
<?php
            }
            if(array_search("save_new", $buttons)!==false)
            {
?>            
            <div id="toolbar-savenew" class="btn-group btn-tool-frm">
                <button class="btn btn-small">
                    <i class="icon-plus-sign"></i>
                    <?php echo tr("SAVE_NEW");?>
                </button>
            </div>
<?php
            }            
            if(array_search("save_close", $buttons)!==false)
            {
?>
            <div id="toolbar-saveclose" class="btn-group btn-tool-frm">
                <button class="btn btn-primary">
                    <i class="icon-ok"></i>
                    <?php echo tr("SAVE_CLOSE");?>
                </button>
            </div>
<?php
            }            
            if(array_search("cancel", $buttons)!==false)
            {
?>
            <div id="toolbar-cancel" class="btn-group cancel_form_cl">
                <button class="btn btn-small">
                    <i class="icon-remove"></i>
                    <?php echo tr("CANCEL");?>
                </button>
            </div>
<?php
            }            
            
            if(array_search("help", $buttons)!==false)
            {
?>
            <div id="toolbar-help" class="btn-group">
                <button class="btn btn-small">
                    <i class="icon-question-sign"></i>
                    <?php echo tr("HELP");?>
                </button>
            </div>
<?php
            }
        }
}

if(!function_exists('print_success_error'))
{
        function print_success_error($sucessmessage,$error)
        {
            if ($sucessmessage!="") 
            {
?>
                <div class="alert alert-success alert-dismissable">
                    <?php echo tr($sucessmessage);?>
                </div>
<?php
            }
            if($error!="")
            {
?>
            <div class="alert alert-danger alert-dismissable">
                
                <strong>!</strong> <?php echo tr($error);?>
            </div>

<?php
            }
        }
}
if(!function_exists('set_print_success_error'))
{
        function set_print_success_error()
        {
?>
            <div class="alert alert-success displaynone alert-dismissable" id="rep_mess">
                <button href="#" data-dismiss="alert" class="close">×</button></div>
            <div class="alert alert-danger displaynone alert-dismissable" id="rep_mess_w">
                <button href="#" data-dismiss="alert" class="close">×</button>
            </div>
<?php
            
        }
}

if(!function_exists('toolbar_def_buttons'))
{
        function toolbar_def_buttons($text="NEW",$link=HTTP_PATH)
        {
?>
            <div class="btn-group">
                <a reflink="<?php echo $link;?>" class="btn btn-primary edit_ac_link">
                    <i class="icon-th-large icon-white"></i>
                    <?php echo tr($text); ?>
                </a>
            </div>
<?php
        }
}

if(!function_exists('toolbar_ajax_button'))
{
        function toolbar_ajax_button($text="UPDATE",$link=HTTP_PATH,$id=false)
        {
?>
                <a reflink="<?php echo $link;?>" id="<?php echo $id;?>" class="btn btn-success">
                    <?php echo tr($text); ?>
                </a>
<?php
        }
}

if(!function_exists('toolbar_pop_button'))
{
        function toolbar_pop_button($text="POPUP",$link=HTTP_PATH,$set_width=400,$set_height=200,$set_iframe=true)
        {
?>
            <div class="btn-group">
                <a pop_link="<?php echo $link;?>" class="btn btn-primary open_pop" set_width="<?php echo $set_width;?>" set_height="<?php echo $set_height;?>" set_iframe="<?php echo $set_iframe;?>">
                    <i class="icon-share icon-white"></i>
                    <?php echo tr($text); ?>
                </a>
            </div>
<?php
        }
}

if(!function_exists('toolbar_import_data_button'))
{
        function toolbar_import_data_button($text="NEW",$link=HTTP_PATH)
        {
?>
            <div class="btn-group">
                <a reflink="<?php echo $link;?>" id="import_data_link" class="btn btn-primary">
                    <i class="icon-th-large icon-white"></i>
                    <?php echo tr($text); ?>
                </a>
            </div>
<?php
        }
}

if(!function_exists('inline_button'))
{
        function inline_button($insert=true,$delete=true,$del_tab=false)
        {
            if($insert)
            {
?>
            <div class="btn-group">
                <a href="#" class="btn btn-long btn-success" id="add_row">
                    <i class="icon-plus-sign icon-white"></i>
                    <span><?php echo tr("INSERT"); ?></span>
                </a>
            </div>
<?php
            }
            if($delete)
            {
                if(!$del_tab || strlen($del_tab)<1)
                    return false;
?>
            <div class="btn-group">
                <a id="delete_rows" class="btn btn-danger" tab_d="<?php echo encode_id($del_tab);?>">
                    <i class="icon-trash icon-white"></i>
                    <span><?php echo tr("DELETE"); ?></span>
                </a>
            </div>
<?php
            }
        }
}
if(!function_exists('insert_button'))
{
        function insert_button($link=HTTP_PATH)
        {
?>
            <div class="btn-group">
                <a href="#" class="btn btn-long btn-success edit_ac_link" reflink="<?php echo $link;?>">
                    <i class="icon-plus-sign icon-white"></i>
                    <span><?php echo tr("INSERT"); ?></span>
                </a>
            </div>
<?php
        }
}
if(!function_exists('edit_button'))
{
        function edit_button($link=HTTP_PATH,$display="")
        {
?><div class="btn-group"><a href="#" class="btn btn-info edit_ac_link <?php echo $display;?>" reflink="<?php echo $link;?>"><i class="icon-edit icon-white"></i><span><?php echo tr("EDIT"); ?></span></a></div><?php
        }
}
if(!function_exists('inline_save_button'))
{
        function inline_save_button($id)
        {
?><div class="btn-group"><a href="#" class="btn btn-primary save_ac" id="save_<?php echo $id;?>"><i class="icon-briefcase icon-white"></i><span><?php echo tr("SAVE"); ?></span></a></div><?php
        }
}

if(!function_exists('active_deactive_btn'))
{
        function active_deactive_btn($is_enabled,$encodedid,$tab_d="",$text1="ENABLE",$text2="DISABLE",$display="")
        {
?><div class="btn-group <?php echo $display;?>" tab_d="<?php echo encode_id($tab_d);?>" set_en="<?php if($is_enabled==1) echo '0'; else echo '1';?>" id="<?php echo $encodedid; ?>" ><label class="btn <?php if($is_enabled==1) echo "active btn-success"; else echo "active_deactive"; ?>"><?php echo tr($text1);?></label><label class="btn <?php if($is_enabled==0) echo "active btn-danger"; else echo "active_deactive";?>"><?php echo tr($text2);?></label></div><?php
        }
}
if(!function_exists('paging_container'))
{
        function paging_container($curr_data,$total_rows)
        {
            $CI =& get_instance();
?>
            <div class="row-fluid">
                <div class="span6">
                    <div class="dataTables_info" id="datatable_info">
                        Showing <?php echo $curr_data;?> of <?php echo $total_rows;?>
                    </div>
                </div>
                <div class="span6">
                    <div class="dataTables_paginate paging_bootstrap pagination">
                            <?php echo $CI->pagination->create_links();?>
                    </div>
                </div>
            </div> 
<?php
            
        }
}

if(!function_exists('rt_validation'))
{
        function rt_validation($type,$val=false,$message=false) 
        {
            $type_ext="";
            $mess_ext="";
            
            switch($type)
            {
                case "email":
                                $mess_ext=tr("EMAIL_ERROR");
                                break;
                case "number":
                                $mess_ext=tr("NUMBER_ERROR");
                                break;
                case "required":
                                $type_ext='required="'.$val.'"';
                                $mess_ext=tr("REQ_ERROR");
                                break;
                case "max":
                                $type_ext='max="'.$val.'"';
                                $mess_ext=tr("MAX_ERROR");
                                break;
                case "min":
                                $type_ext='min="'.$val.'"';
                                $mess_ext=tr("MIN_ERROR");
                                break;
                case "maxlength":
                                $type_ext='maxlength="'.$val.'"';
                                $mess_ext=tr("MAX_LENGTH1_ERROR")." ".$val." ".tr("MAX_LENGTH2_ERROR");
                                break;
                case "minlength":
                                $type_ext='minlength="'.$val.'"';
                                $mess_ext=tr("MIN_LENGTH1_ERROR")." ".$val." ".tr("MIN_LENGTH2_ERROR");
                                break;
                case "pattern":
                                $type_ext='pattern="'.$val.'"';
                                $mess_ext=tr("PATTERN_ERROR");
                                break;
                case "match":
                                $type_ext='data-validation-match-match="'.$val.'"';
                                $mess_ext=tr("MATCH_ERROR");
                                break;
                case "maxchecked":
                                $type_ext='data-validation-maxchecked-maxchecked="'.$val.'"';
                                $mess_ext=tr("MAX_CHECKED1_ERROR")." ".$val." ".tr("MAX_CHECKED2_ERROR");
                                break;
                case "minchecked":
                                $type_ext='data-validation-minchecked-minchecked="'.$val.'"';
                                $mess_ext=tr("MIN_CHECKED1_ERROR")." ".$val." ".tr("MIN_CHECKED2_ERROR");
                                break;
                case "regex":
                                $type_ext='data-validation-regex-regex="'.$val.'"';
                                $mess_ext=tr("REGEX_ERROR");
                                break;
                case "callback":
                                $type_ext='data-validation-callback-callback="'.$val.'"';
                                $mess_ext=tr("CALLBACK_ERROR");
                                break;
                case "ajax":
                                $type_ext='data-validation-ajax-ajax="'.$val.'"';
                                $mess_ext=tr("AJAX_ERROR");
                                break;
            }
            
            if($message)
            {
                $mess_ext=tr($message);
            }
?>
            data-validation-<?php echo $type;?>-message="<?php echo $mess_ext;?>" <?php echo $type_ext;?>  
<?php            
        }
}

/* End of file bootstrap_helper.php */
/* Location: /helpers/bootstrap_helper.php */
