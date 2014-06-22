
/*
 * @author Rishi Raj Tripathi
 * 
 * Created date:- 26-July-2012
 * 
 * Last Modified:-26-July-2012  
 * 
 */
$(document).ready(function(){
    $("#dashboard-buttons li").hoverIntent(showtext,hidetext); 
            $("#checkallitem").click(function(e) {
                if(this.checked)
                {
                    $("input.actionsid").each(function() {
                            this.checked = true;
                    });
                }
                else
                {
                    $("input.actionsid").each(function() {
                            this.checked = false;
                    });

                }
            });

            $("input.actionsid").click(function(){

                    $("input.actionsid").each(function() {
                        if(!(this.checked))
                        {
                            $("#checkallitem").removeAttr("checked");
                        }
                    });
            });
            
            $("#delete_rows").click(function(e){
                    e.preventDefault();
                    var checkval = [];
                    $('.actionsid:checkbox:checked').each(function(i){
                        checkval[i] = $(this).val();
                    });
                    if(checkval.length==0)
                    {
                        return false;
                    }
                    var r=confirm(DELETE_CONFIRM);
                    if (r==true)
                    {
                        var tab_d=$(this).attr('tab_d');
                        
                        var url=ADMIN_HTTP_PATH+"commonclass/deleterows/";
                        var dataString="tab_d="+tab_d+"&checkval="+checkval;
                        var returndata=ajaxJsonData(url,dataString,"t_header_menus",'Please wait..','rep_mess');
                        returndata=returndata.split("_")[0];
                        if(returndata==1)
                        {
                                $('.actionsid:checkbox:checked').each(function(i){
                                    $(this).parent().parent().remove();
                                });
                        }
                    }
            });
            
            $(".enable_disable").live('click',function(e){
                    e.preventDefault();
                    var tab_d=$(this).attr('tab_d');
                    var set_en=$(this).attr('set_en');
                    var id=this.id;
                    var url=ADMIN_HTTP_PATH+"commonclass/endisable/";
                    var dataString="tab_d="+tab_d+"&set_en="+set_en+"&id="+id;
                    var returndata=ajaxJsonData(url,dataString,"t_header_menus",'Please wait..','rep_mess');
                    var seten="";
                    var seten_img=ADMIN_ICONS_PATH;
                    returndata=returndata.split("_")[0];
                    if(returndata==1)
                    {
                        
                        if(set_en==1)
                        {
                            seten=0;
                            seten_img=seten_img+"enable.png";
                        }
                        else
                        {
                            seten=1;
                            seten_img=seten_img+"disable.png";
                        }
                        $(this).attr('set_en',seten);
                        $(this).attr('src',seten_img);
                    }
            });
            
            $(".active_deactive").live('click',function(e){
                    e.preventDefault();
                    var tab_d=$(this).parent().attr('tab_d');
                    var set_en=$(this).parent().attr('set_en');
                    var id=$(this).parent().attr("id");
                    var url=ADMIN_HTTP_PATH+"commonclass/endisable/";
                    var dataString="tab_d="+tab_d+"&set_en="+set_en+"&id="+id;
                    var returndata=ajaxJsonData(url,dataString,"t_header_menus",'Please wait..','rep_mess');
                    var seten="";
                    returndata=returndata.split("_")[0];
                    if(returndata==1)
                    {
                        if(set_en==1)
                        {
                            seten=0;
                            $(this).parent().find(".active").removeClass("btn-danger");
                            $(this).addClass("btn-success");
                        }
                        else
                        {
                            seten=1;
                            $(this).parent().find(".active").removeClass("btn-success");
                            $(this).addClass("btn-danger");
                        }
                        
                        $(this).removeClass('active_deactive');
                        $(this).parent().find(".active").addClass('active_deactive');
                        $(this).parent().find(".active_deactive").removeClass('active');
                        $(this).addClass('active');
                        $(this).parent().attr('set_en',seten);
                    }
            });
            $(".status_change").live('click',function(e){
                    e.preventDefault();
                    var tab_d=$(this).attr('tab_d');
                    var col_d=$(this).attr('col_d');
                    var set_en=$(this).attr('set_en');
                    var id=this.id;
                    var url=ADMIN_HTTP_PATH+"commonclass/set_row_data/";
                    var dataString="tab_d="+tab_d+"&col_d="+col_d+"&set_en="+set_en+"&id="+id;
                    var returndata=ajaxJsonData(url,dataString,"t_header_menus",'Please wait..','rep_mess');
                    var seten="";
                    var seten_img=ADMIN_ICONS_PATH;
                    var seten_title="";
                    returndata=returndata.split("_")[0];
                    if(returndata==1)
                    {
                        
                        if(set_en==1)
                        {
                            seten=0;
                            seten_img=seten_img+"yes.png";
                            seten_title=SET_AS_UNPAID;
                        }
                        else
                        {
                            seten=1;
                            seten_img=seten_img+"no.png";
                            seten_title=SET_AS_PAID;
                        }
                        $(this).attr('set_en',seten);
                        $(this).attr('src',seten_img);
                    }
            });
            
            
            $(".open_pop").live('click',function(e){
                e.preventDefault();
                var openlink=$(this).attr("pop_link");
                var set_width=$(this).attr("set_width");
                var set_height=$(this).attr("set_height");
                var set_iframe=$(this).attr("set_iframe");
                $.colorbox({href:openlink,slideshow:false,top:10,width:set_width,height:set_height,iframe:set_iframe});
            });
            
            /*==  form submit code ===== */
            
            $(".submit_form_cl").click(function(){
                $("#sub_form").submit();
            });
            
            $(".cancel_form_cl").click(function(){
                window.history.back();
            });
            
            
            $(".btn-tool-frm").click(function(){
                var thisid=this.id;
                thisid=thisid.split("-")[1];
                $("#tooltask").val(thisid);
                $("#sub_form").submit();
            });
            
            
            $("#add_row_link").click(function(e){
                    e.preventDefault();
                    var reflink=$(this).attr("reflink");
                    window.location.href=reflink;
                    
                    
            });
            $(".edit_ac_link").live('click',function(e){
                    e.preventDefault();
                    var reflink=$(this).attr("reflink");
                    window.location.href=reflink;
                    
            });
            
            
            
            $(".valid_num_text").live('keydown',function(evt){
                valid_num_text(this,evt);
            });
            
            $(".valid_currency_chk_txt").live('keydown',function(evt){
                valid_currency_chk_txt(this,evt);
            });
            


            $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(
            {
                    submitError: function($form, event, errors) {

                    },
                    submitSuccess: function($form, event) {

                    },
                    filter: function() {
                        return $(this).is(":visible");
                    }
            });
            
            
            /*/ Stick the #nav to the top of the window
            var nav = $('#tool_box_btn');
            if(nav.offset()!=null)
            {    
                var navHomeY = nav.offset().top;
                var isFixed = false;
                var $w = $(window);
                $w.scroll(function() {
                    var scrollTop = $w.scrollTop()+navHomeY;
                    var shouldBeFixed = scrollTop > navHomeY;
                    if (shouldBeFixed && !isFixed) {
                        nav.css({
                            position: 'fixed',
                            top: 40,
                            left: nav.offset().left,
                            width: nav.width(),
                            background: "white",
                            "z-index": "100"
                        });
                        isFixed = true;
                    }
                    else if (!shouldBeFixed && isFixed)
                    {
                        nav.removeAttr("style");
                        nav.css({
                            position: 'static'
                        });
                        isFixed = false;
                    }
                });
            }*/


            
            
        });
        
        function valid_num_text(thisobj,evt)
        {
            var newVal= $(thisobj).val();
            var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
            ((evt.which) ? evt.which : 0));
            if(parseInt(charCode) > 95 && parseInt(charCode) < 106)
            {
                return false;
            }
           
            if (charCode > 31 && (charCode < 48 || charCode > 57)) 
            {
                evt.preventDefault();
                return false;
            }
            return true;
        }
        
        function valid_currency_chk_txt(thisobj,evt)
        {
            var thisval= $(thisobj).val();
            var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
            ((evt.which) ? evt.which : 0));
            
            if((parseInt(charCode) > 95 && parseInt(charCode) < 106) || (parseInt(charCode) == 188 || parseInt(charCode) == 190))
            {
                return false;
            }
           
            if (charCode > 31 && (charCode < 48 || charCode > 57)) 
            {
                evt.preventDefault();
                return false;
            }
            return true;
            
        }
        var timer_is_on=0;
        var timer="";
        function ajaxJsonData(url,dataString,blockid,message,mess_id)
        {
            var block_d=$("#"+blockid);
            var mess_s=$("#"+mess_id);
                block_d.block({ 
                    css: 
                    { 
                        border: 'none', 
                        padding: '5px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: .8, 
                        color: '#fff' 
                    },
                    message: '<h1>'+message+'</h1>' 
                });
                var retd="";
                $.ajax({     
                        type: "POST",
                        url: url,
                        cache: false,
                        data: dataString,
                        dataType: "json",
                        async: false, // <-- heres the key !
                        success: function(data)
                        {
                                block_d.unblock();
                                var success=data.success;
                                var success_mess=data.success_mess;
                                var error_mess=data.error_mess;
                                var error=data.error;
                                var datap=data.datap;
                                if(datap==1)
                                {
                                    retd=data;
                                }
                                else
                                if(success==1)
                                {
                                    block_d.unblock();
                                    mess_s.html(success_mess);
                                    mess_s.show(1000);
                                    if (!timer_is_on)
                                    {
                                        timer_is_on=1;
                                        timer = setTimeout(function(){mess_s.hide(1000);},3000);
                                    }
                                    else
                                    {
                                            clearTimeout(timer);
                                            timer_is_on=0;
                                    }
                                    
                                    var last_id=data.last_id;
                                    retd= "1_"+last_id;
                                }
                                else
                                if(error==1)
                                {
                                    if(data.error_tab==0)
                                    {
                                        $("#"+blockid).unblock();
                                        $("#rep_mess_w").html(error_mess);
                                        $("#rep_mess_w").slideDown(1000);
                                        retd= "0";
                                    }
                                    else
                                    {
                                        $("#"+blockid).unblock();
                                        var error_tab=data.error_tab;
                                        retd= "2_"+error_tab;
                                    }
                                }
                                else
                                if(error=="logged_out")
                                {
                                    openloginalert();
                                    $(".ui-dialog-titlebar").hide();
                                }
                        }
                });
                return retd;
        }
        
        
        function tableSortDrag(thisObj)
        {
            var path=$(thisObj).attr('path');
            var tab_d=$(thisObj).attr('tab_d');
            var dataString=$.tableDnD.serialize();
            ajaxJsonData(ADMIN_HTTP_PATH+path,dataString,tab_d,'Please wait..','rep_mess');
        }
        
        function setLanguage(lang, cCode,cCodeId) {
            $('#hdnContryCode').val(cCode);
            $('#hdnContryCodeId').val(cCodeId);
        }
        
        function switchLanguage(lang, cCode,cCodeId) {
            document.getElementById('selLangHl').value = lang;
            document.getElementById('selContryCode').value = cCode;
            document.getElementById('selContryCodeId').value = cCodeId;
            var sellang=document.getElementById('langSwitchFrm');
            sellang.action= ADMIN_HTTP_PATH+"switchlang";
            sellang.target='sellang'; 
            sellang.submit();
        }
        
        // Open login alert box
        function openloginalert(){
                $('#loginalertbox').dialog('open');
                return false;
        }
        
        function showtext()
        {
                $(this).find('div').slideToggle();
        }

        function hidetext()
        {
                $(this).find('div').slideToggle();
        }


        function cleanQueryString(string)
        {
            string=string.replace("&","%26");
            return string;
        }
        
function number_format (number, decimals, dec_point, thousands_sep) {
    // Formats a number with grouped thousands
    //
    // version: 906.1806
    // discuss at: http://phpjs.org/functions/number_format
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     bugfix by: Michael White (http://getsprink.com)
    // +     bugfix by: Benjamin Lupton
    // +     bugfix by: Allan Jensen (http://www.winternet.no)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +     bugfix by: Howard Yeend
    // +    revised by: Luke Smith (http://lucassmith.name)
    // +     bugfix by: Diogo Resende
    // +     bugfix by: Rival
    // +     input by: Kheang Hok Chin (http://www.distantia.ca/)
    // +     improved by: davook
    // +     improved by: Brett Zamir (http://brett-zamir.me)
    // +     input by: Jay Klehr
    // +     improved by: Brett Zamir (http://brett-zamir.me)
    // +     input by: Amir Habibi (http://www.residence-mixte.com/)
    // +     bugfix by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: number_format(1234.56);
    // *     returns 1: '1,235'
    // *     example 2: number_format(1234.56, 2, ',', ' ');
    // *     returns 2: '1 234,56'
    // *     example 3: number_format(1234.5678, 2, '.', '');
    // *     returns 3: '1234.57'
    // *     example 4: number_format(67, 2, ',', '.');
    // *     returns 4: '67,00'
    // *     example 5: number_format(1000);
    // *     returns 5: '1,000'
    // *     example 6: number_format(67.311, 2);
    // *     returns 6: '67.31'
    // *     example 7: number_format(1000.55, 1);
    // *     returns 7: '1,000.6'
    // *     example 8: number_format(67000, 5, ',', '.');
    // *     returns 8: '67.000,00000'
    // *     example 9: number_format(0.9, 0);
    // *     returns 9: '1'
    // *     example 10: number_format('1.20', 2);
    // *     returns 10: '1.20'
    // *     example 11: number_format('1.20', 4);
    // *     returns 11: '1.2000'
    // *     example 12: number_format('1.2000', 3);
    // *     returns 12: '1.200'
    var n = number, prec = decimals;

    var toFixedFix = function (n,prec) 
    {
        var k = Math.pow(10,prec);
        return (Math.round(n*k)/k).toString();
    };

    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
    var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;

    var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;

    var abs = toFixedFix(Math.abs(n), prec);
    var _, i;

    if (abs >= 1000) 
    {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;

        _[0] = s.slice(0,i + (n < 0)) +
              _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
        s = _.join(dec);
    } 
    else 
    {
        s = s.replace('.', dec);
    }

    var decPos = s.indexOf(dec);
    if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) 
    {
        s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
    }
    else if (prec >= 1 && decPos === -1) 
    {
        s += dec+new Array(prec).join(0)+'0';
    }
    return s; 

}        


function timestamp_to_date(timestamp)
{
    var dt = new Date(timestamp * 1000);
    var mm = MM_TO_MONTH[dt.getMonth()];
    return dt.getDate()+"-" +mm+ "-" +dt.getFullYear() +" "+ dt.getHours()+ ":"+ dt.getMinutes();
}


function print_money_with_symbol(value,currency_symbol,decimal_symbol,thousand_seprator,place,space)
{
    value=print_money_by_data(value,decimal_symbol, thousand_seprator);
    value=add_symbol_by_data(value,currency_symbol,place,space);
    return value;
    
}

function print_money_by_data(value,decimal_symbol, thousand_seprator)
{
    value=number_format(value,MONEY_PLACE, decimal_symbol, thousand_seprator);
    return value;
}

function add_symbol_by_data(value,currency,place,space)
{
    var ret_val=currency;
    switch(place)
        {
            case "1": // 1 means first/before
                    if(space=='1')
                    {
                        ret_val= ret_val+" ";
                    }
                    ret_val = ret_val+value;
                    break;

            case "2": // 2 means second/after
                    if(space=='1')
                    {
                        ret_val= " "+ret_val;
                    }
                    ret_val = value+ret_val;
                    break;
        }
    return ret_val;
}

function blockcont(block,message)
{
    $(block).block({
        css: 
        { 
            border: 'none', 
            padding: '5px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .8, 
            color: '#fff' 
        },
        message: '<h1>'+message+'</h1>' 
    });
}

function unblockcont(block)
{
    $(block).unblock();
}

function import_data_process(confirm_text,dataString,block_id,block_mess,reply_mess_id,e,thisObj)
{
    e.preventDefault();
    var confirmtest= confirm(confirm_text);
    if(confirmtest==true)
    {
        var reflink = $(thisObj).attr("reflink");
        var returndata=ajaxJsonData(reflink,dataString,block_id,block_mess,reply_mess_id);
        var success=returndata.success
        var error=returndata.error
        var error_mess=returndata.error_mess
        var success_mess=returndata.success_mess
        if(success==1)
        {

            $("#rep_mess").html(success_mess);
            $("#rep_mess").show();
            return 1;
        }
        if(error==1)
        {
            $("#rep_mess_w").html(error_mess);
            $("#rep_mess_w").show();
            return false;
        }
    }
    return false;
}