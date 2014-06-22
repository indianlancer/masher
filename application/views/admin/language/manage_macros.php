    <script>
        $(document).ready(function(){
<?php 
            if(isset($othercall))
            {
?>
               parent.loadingdone(); 
<?php
            }
?>
               $("body").keypress(function(e){
                   if(e.ctrlKey && e.which==115)
                   {
                       e.preventDefault();
                       $("#sub_form").submit();
                   }
               });
               
               $(".incre_button").click(function() {
                    var $button = $(this);
                    var oldValue = $("#to_pos_text").val();
                    if(isNaN(parseInt(oldValue)))
                    {
                        $("#to_pos_text").val(total_include);
                        return false;
                    }
                    var newVal=total_include;
                    if ($button.text() == "+") 
                    {
                        if(oldValue < total_include)
                            newVal = total_include;
                        else
                            newVal = parseInt(oldValue) + 1;
                        // AJAX save would go here
                    }
                    else
                    {
                        // Don't allow decrementing below zero
                        if (oldValue >= total_include) 
                        {
                            newVal = parseInt(oldValue) - 1;
                            // AJAX save would go here
                        }
                    }
                    if(newVal<total_include)
                        newVal=total_include;
                    if(newVal > total_rows)
                        newVal=total_rows;
                        $("#to_pos_text").val(newVal);
                });
                $("#to_pos_text").keypress(function(evt){
                    checknumcorrect(evt);
                });
                $("#to_pos_text").keyup(function(evt){
                    checknumcorrect(evt);
                });
                $("#to_pos_text").keydown(function(evt){
                    checknumcorrect(evt);
                });
                
                
                $("#add_lang_row").click(function(){
                        var to_pos_text=$("#to_pos_text").val();
                        var html='<tr><td>'+to_pos_text+'</td><td class="left"><input type="text" name="langs_key_'+getlangcommentnum()+'" class="input-xlarge" value="" /></td><td class="left"><input type="text" class="input-xlarge" name="langs_value_'+getlangcommentnum()+'" value="" /></td></tr>';
                        
                        addlangcommentrow(to_pos_text,html);
                        total_rows++;
                        total_langs++;
                        $("#total_num_langs").val(total_langs);
                        $("#total_num_rows").val(total_rows);
                        rearrangenum();
                });
                
                $("#add_comment").click(function(){
                        var to_pos_text=$("#to_pos_text").val();
                        var html='<tr><td>'+to_pos_text+'</td><td class="left"><input type="hidden" name="comment_key_'+getlangcommentnum()+'" value="" /><b><?php echo tr("COMMENT");?></b></td><td class="left"><input type="text" name="comment_value_'+getlangcommentnum()+'" value="" /></td></tr>';
                        addlangcommentrow(to_pos_text,html);
                        total_rows++;
                        total_comments++;
                        $("#total_num_comments").val(total_comments);
                        $("#total_num_rows").val(total_rows);
                        rearrangenum();
                });
                
        });
        
        
        function addlangcommentrow(to_pos_text,html)
        {
            if(parseInt(to_pos_text) >= parseInt(total_include))
            {
                $('#manage_macros_tab tbody tr').eq(parseInt(to_pos_text)-1).after(html);
                return false;
            }
        }
        
        function getlangcommentnum()
        {
            var ret_val= parseInt(total_langs);
            return ret_val;
        }
        
        function rearrangenum()
        {
            $("#manage_macros_tab tbody tr").each(function (index) { // traverse through all the rows
                    $(this).find("td:first").html(parseInt(index)+1); // set the index number in the first 'td' of the row
            });

        }
        function checknumcorrect(evt)
        {
            var newVal= $("#to_pos_text").val();
                    if(parseInt(newVal) > parseInt(total_rows))
                    {
                        evt.preventDefault();
                        $("#to_pos_text").val(total_rows);
                        return false;
                    }
                     if(newVal<total_include)
                        $("#to_pos_text").val(total_include);
                    var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
                    ((evt.which) ? evt.which : 0));
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) 
                    {
                        evt.preventDefault();
                        $("#to_pos_text").val(total_include);
                        return false;
                    }
        }
    </script>
<style>
    body
    {
        padding-top: 0px;
    }
    input[type=text]
    {
        border: none;
        width: 100%;
        padding: 1px 0px;
        height: 20px;
    }
    .quick_actions
    {
        width: 95%;
        border: 2px solid #4275c6;
        bottom: 0px;
        background-color: #FFF;
        padding: 15px 0px;
    }
    .incre_button {
        background: url("<?php echo ADMIN_ICONS_PATH.'icons/';?>incre_button.png") no-repeat 0 0;
        background-origin: padding-box;
        cursor: pointer;
        float: left;
        height: 29px;
        margin: 0 0 0 5px;
        text-align: center;
        text-indent: -9999px;
        width: 29px;
    }
    .dec {
       background-position: 0 -29px;
    }
    .incre_text
    {
        border: 1px solid #CCC!important;
        padding: 5px;
        float: left;
        width:100px!important;
    }
    .table-bordered td{
        padding-bottom: 2px; 
        padding-top: 2px; 
    }
    .table-bordered td input{
        margin-bottom: 0px!important;
    }
</style>
    <?php
        
        if($error!="")
        {
?>
        <div class="alert alert-error">
            <a href="#" data-dismiss="alert" class="close">×</a>
            <strong>!</strong> <?php echo tr($error);?>
        </div>
<?php
        die();
        }
        if ($sucessmessage!="") 
        {
    ?>
            <div class="alert alert-success">
                <a href="#" data-dismiss="alert" class="close">×</a>
                <?php echo tr($sucessmessage);?>
            </div>
    <?php
        }
        if($error=="")
        {
?>
            <form action="" method="post" name="sub_form" id="sub_form" autocomplete="off">

    <table class="table table-bordered" style="margin-bottom:10px;">
        <tr>
            <td><div style="width: 12px;"></div></td>
            <td class="left"><input type="text" class="input-xlarge uneditable-input" disabled="disabled" value="<?php echo tr("KEY");?>" /></td>
            <td class="left"><input type="text" class="input-xlarge uneditable-input" disabled="disabled" value="<?php echo tr("VALUE");?>" /></td>
        </tr>
    </table>
    <div style="height: 345px;overflow-y: scroll;overflow-x: hidden;">
    <table class="table table-bordered" id="manage_macros_tab">
<?php
   //echo "<pre>";
    //print_r($handle);
    //die;
$j=0;
        if(isset($handle['include_file']))
        foreach ($handle['include_file'] as $key=>$data)
        {
?>
        <tr>
            <td><?php echo ++$j;?></td>
            <td class="left"><?php echo tr("INCLUDE_FILES");?></td> 
            <td><input type="hidden" name="include_files_<?php echo ($key);?>" value="<?php echo $data;?>" /><?php echo $data;?></td>
        </tr>
<?php
        }
        $total_include=$j;
        $i=++$j;
        $total_rows=0;
        $total_comments=0;
        $total_langs=0;
        if(isset($handle['langs']))
        foreach ($handle['langs'] as $key=>$data)
        {
            if(isset($data["comment"]))
            {
                $total_comments++;
?>
         <tr>
             <td><?php echo $i;?></td>
             <td class="left"><input type="hidden" name="comment_key_<?php echo ($key);?>" value="" /><b><?php echo tr("COMMENT");?></b></td>
             <td class="left"><input type="text" name="comment_value_<?php echo ($key);?>" value="<?php echo $data["comment"];?>" /></td>
        </tr>
<?php
            }
            else
            {
                $total_langs++;
?>
        <tr>
            <td><?php echo $i;?></td>
            <td class="left"><input type="text" name="langs_key_<?php echo ($key);?>" class="input-xlarge" value="<?php echo $data["key"];?>" /></td>
            <td class="left"><input type="text" class="input-xlarge" name="langs_value_<?php echo ($key);?>" value="<?php echo $data["value"];?>" /></td>
        </tr>
<?php
            }
            
            $i++;
        }
        $total_rows=$i-1;
?>
    </table>
    
    
    <input type="hidden" name="save" id="save" value="<?php echo md5(rand());?>">
    <input type="hidden" name="total_num_rows" id="total_num_rows" value="<?php echo $total_rows;?>">
    <input type="hidden" name="total_num_comments" id="total_num_comments" value="<?php echo $total_comments;?>">
    <input type="hidden" name="total_num_include" id="total_num_include" value="<?php echo $total_include;?>">
    <input type="hidden" name="total_num_langs" id="total_num_langs" value="<?php echo $total_langs;?>">
    </div>
    <div class="quick_actions">
        <span class="submit_form_cl" id="save_this">
            <img alt="save" title="<?php echo tr("SAVE");?>" src="<?php echo ADMIN_ICONS_PATH.'icons/';?>save.png" />
        </span>
        <span id="add_lang_row">
            <img alt="<?php echo tr("ADD_LANGUAGE");?>" title="<?php echo tr("ADD_LANGUAGE");?>" src="<?php echo ADMIN_ICONS_PATH.'icons/';?>addrow.png" />
        </span>
        <span id="to_position">
            <label for="to_pos_text" style="float: left;"><?php echo tr("PLACE_AFTER_TO_POSITION");?></label>
            <input class="incre_text" type="text" id="to_pos_text" value="<?php echo $total_rows;?>"/>
            <div class="inc incre_button">+</div><div class="dec incre_button">-</div>
        </span>
    </div>
</form>
<?php
        }
?>
<script>
    var total_rows=<?php echo $total_rows;?>;
    var total_comments=<?php echo $total_comments;?>;
    var total_include=<?php echo $total_include;?>;
    var total_langs=<?php echo $total_langs;?>;
</script>