/*
 * @author Ruby Sharma
 * @created 3rd September 2013
 * @modified 3rd September 2013
 * 
 * 
 */
var $j = jQuery.noConflict();
$j(function(){
        
        
        var curr_act = "1";
        
        $j("input,select,textarea").not("[type=submit]").jqBootstrapValidation({preventSubmit: true,
            submitSuccess: function ($form, event) {
                event.preventDefault();
                var url= HTTP_PATH+"signup/regsubmit";
                var dataString=$j("#signup_form").serialize()+"&curr_act="+curr_act;
                
                var ret_ajax = callAjax(url,dataString);
                ret_ajax.complete(function(){
                    
                });
                ret_ajax.success(function(data){
                    var success=data.success;
                    var success_mess=data.success_mess;
                    var error_mess=data.error_mess;
                    var error=data.error;
                    var error_tab_num=data.error_tab_num;
                    var error_tab=data.error_tab;
                    if(error==1)
                    {
                        $j(".form-group").removeClass("success");
                        $j("#signup_form .from-group").eq(error_tab_num).addClass("error");
                        
                        $j("#signup_form .help-block").eq(error_tab_num).html($j("<ul/>").attr("role","alert").html($j("<li/>").html(error_mess)));
                        $j("#txtSecurity").val('');
                        $j("#txtPassword").val('');
                        $j("#txtConfPassword").val('');
                        $j("#refresh_image").click();
                        return false;
                    }
                    if(success==1)
                    {
                        $j("#signup_form input").val("");
                        var location = HTTP_PATH+"signup/resendverifyemail";
                        $j("#verifyemailModal .body_o_cont").html("<iframe id='resend_iframe' style='height:50px;' frameborder='0' class='inner_panel_iframe' src='"+location+"'></iframe>")
                        $j("#verifyemailModal").modal("show")
                        
                        return false;      
                        
                    }
                });
                
            }
        });
        
        
        $j("#refresh_image").click(function(e){
                e.preventDefault();
                var tstamp=new Date().getTime();
                $j(".security_image_cont img").attr("src",HTTP_PATH+"commonclass/generate_captcha/"+tstamp);
        });
        
    });