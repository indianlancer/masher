/*
 * @author Rishi Raj Tripathi
 * 
 * Created date:- 26-July-2012
 * 
 * Last Modified:-26-July-2012  
 * 
 */


(function($) {
    
    $.fn.sort_inedit = function(options) {
        var settings = 
            $.extend({}, {
                inputs_arr: new Array(),
                select_tag_arr: new Array(),
                save_url: "/",
                edit_url: false,
                block_mess: "Please wait..",
                reply_mess_id:"rep_mess",
                block_id: "t_header_tabs",
                save_button: false,
                edit_button: false,
                act_deact_button: false,
                req_error: "required"
            }, options);
        
        var mainthis=this;
        var savebtn = $(".save_ac");
        savebtn.live("click",function(e){e.preventDefault();saveClick(this);});
        
        var addrowbtn = $("#add_row");
        addrowbtn.click(function(e){e.preventDefault();addrowClick(mainthis);});
        
        var add_row=0;
        
        function addrowClick(thisObj)
        {
                if(add_row==0)
                {
                    var rowdata=in_add_row_dyna(settings.inputs_arr,settings.save_button,settings.edit_button,settings.act_deact_button);
                    $(thisObj).append(rowdata);
                }
                add_row=1;
        };
        
        function saveClick(thisObj)
        {
            var thisid=thisObj.id;
            thisid=thisid.split("_")[1];
            var data = in_dataarray(thisObj);
            var url=settings.save_url;
            var dataString="data="+JSON.stringify(data);
            
            var returndata=ajaxJsonData(url,dataString,settings.block_id,settings.block_mess,settings.reply_mess_id);
            add_row = in_set_row_updated(thisObj,settings.inputs_arr,returndata,settings.edit_url);
        }
        

        // inline editing functions defined here

        function in_dataarray(thisobj)
        {
            var data= new Array();
            $(thisobj).closest("tr").find('input').each(function(index) {
                data[index] =$(this).val();
            });
            return data;
        }

        function in_handle_error(thisobj,returndata_p)
        {
            var error_tab=returndata_p[1];
            $(thisobj).closest("tr").find("span").remove(".required");
            $(thisobj).closest("tr").find("td:eq("+error_tab+")").append("<span class='required'>"+settings.req_error+"</span>");
        }


        function in_addrow_open()
        {
            var aa='<tr id="tr_new" class="nodrop nodrag"><td style=""><input name="selected[]" class="" disabled="disabled" value="new" type="checkbox"></td>';
            return aa;
        }

        function in_add_inputs(inputs_arr)
        {
            var aa="";
            for(var i in inputs_arr)
                aa += '<td class="left"><input type="text" value="" id="'+inputs_arr[i]+'_new" name="'+inputs_arr[i]+'_new" /></td>';
            var tags=settings.select_tag_arr;
            if(tags.length>0)
            {
                // first index is class
                // second index is id and name
                // 3rd index is options
                // 4th index is hidden input
                
                for(var i in tags)
                {
                    var this_tag='<td class="left">';
                    if(tags[i][0]!=undefined || tags[i][1]!=undefined || tags[i][2]!=undefined || tags[i][3]!=undefined || tags[i][4]!=undefined)
                    {    
                        this_tag += '<select class="'+tags[i][0]+'" id="'+tags[i][1]+'_new" name="'+tags[i][1]+'_new" >';
                        this_tag += tags[i][2];
                        this_tag += '</select>';
                        this_tag += '<input type="hidden" value="'+tags[i][4]+'" id="'+tags[i][3]+'_new" name="'+tags[i][3]+'_new" />';
                    }
                    this_tag += '</td>';
                    aa +=this_tag;
                }
                
            }
            return aa;
        }

        function in_add_row_dyna(inputs_arr,save_button,edit_button,act_deact_button)
        {
            var aa=in_addrow_open()+in_add_inputs(inputs_arr)+'<td class="right"><div class="btn-toolbar">';
            if(save_button)
            aa += save_button;
            if(edit_button)
            aa += edit_button;
            if(act_deact_button)
            aa += act_deact_button;
            aa += '</div></td></tr>';
            return aa;
        }


        function in_set_row_updated(thisobj,inputs_arr,returndata,edit_link)
        {
            var add_row=1;
            var returndata_p=returndata.split("_");
            returndata=returndata_p[0];
            if(returndata==2)
            {
                in_handle_error(thisobj,returndata_p);
            }
            if(returndata==1)
            {
                $(thisobj).closest("tr").find("span").remove(".required");
                var last_id=returndata_p[1];
                $("#tr_"+last_id+" span").remove(".required");
                if(last_id!=0)
                {
                    $("#tr_new").removeAttr('class');
                    $("#tr_new").find("td:eq(0)").find("input").removeAttr("disabled");
                    $("#tr_new").find("td:eq(0)").find("input").addClass("actionsid");
                    $("#tr_new").find("td:eq(0)").find("input").val(last_id);
                    var j=1;
                    for(var i in inputs_arr)
                    {
                        $("#tr_new").find("td:eq("+j+")").find("input").attr("id",inputs_arr[i]+"_"+last_id);
                        $("#tr_new").find("td:eq("+j+")").find("input").attr("name",inputs_arr[i]+"_"+last_id);
                        j++;
                    }
                    var tags=settings.select_tag_arr;
                    if(tags.length>0)
                    for(var i in tags)
                    {
                        $("#tr_new").find("td:eq("+j+")").find("select").attr("id",tags[i][1]+"_"+last_id);
                        $("#tr_new").find("td:eq("+j+")").find("select").attr("name",tags[i][1]+"_"+last_id);
                        
                        $("#tr_new").find("td:eq("+j+")").find("input").attr("id",tags[i][3]+"_"+last_id);
                        $("#tr_new").find("td:eq("+j+")").find("input").attr("name",tags[i][3]+"_"+last_id);
                        j++;
                    }
                    $("#tr_new").find("td:eq("+j+")").find(".save_ac").attr("id","save_"+last_id);
                    $("#tr_new").find("td:eq("+j+")").find(".btn-group").removeClass("displaynonehard");
                    $("#tr_new").find("td:eq("+j+")").find(".edit_ac_link").removeClass("displaynonehard");
                    if(edit_link)
                    $("#tr_new").find("td:eq("+j+")").find(".edit_ac_link").attr("reflink",edit_link+last_id);
                    $("#tr_new").find("td:eq("+j+")").find("div#new").attr("id",last_id);
                    $("#tr_new").attr("id","tr_"+last_id);
                    add_row=0;
                }
            }
            return add_row;
        }
    };
})(jQuery);
