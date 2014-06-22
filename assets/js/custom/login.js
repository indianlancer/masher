/*
 * @author Rishi Raj Tripathi
 * @created 3rd SEptember 2012
 * @modified 3rd September 2012
 * 
 * 
 */
var $j = jQuery.noConflict();
$j(function(){

        var signup_height = $j("#signup_form").height();
        
        $j(".signin_up_divider").css({height:signup_height,'border-left':'1px solid #CCC'});
        
       
       $j("#ajax_login_btn").click(function(e){
                e.preventDefault();
                var _this = $j(this);
                _this.addClass("disabled");
                var url= HTTP_PATH+"login/ajax_login";
                var dataString=$j("#login_form").serialize();
                //blockcont("body","Please wait while processing....");
                var ret_ajax = callAjax(url,dataString);
                ret_ajax.complete(function(){
                    _this.removeClass("disabled");
                   // unblockcont("body");  
                });
                ret_ajax.success(function(data){
                    var success=data.success;
                    var success_mess=data.success_mess;
                    var error_mess=data.error_mess;
                    var error=data.error;
                    if(error==1)
                    {
                        $j("#rep_mess_w").html(error_mess).show();
                        $j("#rep_mess").hide();
                        $j(".LoginForm").css("height","435px");
                        return false;
                    }
                    if(success!=0)
                    {
                        $j("#rep_mess").html(success_mess).show();
                        $j("#rep_mess_w").hide();
                        
                        if(success==1)
                        {
                            window.location=HTTP_PATH+"home/chat";
                            return false;
                        }
                        if(success == 2)
                        {
                            window.location=HTTP_PATH+"home/chat";
                            return false;
                        }
                        if(success == 3)
                        {
                            window.location = data.redirect_link;
                            return false;
                        }
                    }
                });
            
        });

    });