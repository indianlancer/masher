/*
 * @author Rishi Raj Tripathi
 * @created 3rd SEptember 2012
 * @modified 3rd September 2012
 * 
 * 
 */

var gl_timestamp = new Date().getTime();

var $j = jQuery.noConflict();
$j(document).ready(function(){
    
    // place holder for IE < 10
    if(typeof nwplaceholder == "function")
        $j('body').nwplaceholder();

    $j(document).ajaxComplete(function(e, xhr, settings){
        var check_account = $j.parseJSON(xhr.responseText);
        if(check_account.error == 2)
        {
            
        }
    });
    
    $j("body").on('click',"#checkallitem",function(e) {
        if(this.checked)
        {
            $j("input.actionsid").each(function() {
                    this.checked = true;
            });
        }
        else
        {
            $j("input.actionsid").each(function() {
                    this.checked = false;
            });

        }
    });

    $j("body").on('click','input.actionsid',function(){
            $j("input.actionsid").each(function() {
                if(!(this.checked))
                {
                    $j("#checkallitem").removeAttr("checked");
                }
            });
    });
    $j("body").on('click','.set-status',function(e){
        e.preventDefault();
        $j(this).parent().toggleClass("open");
    });

    
    /*==  form submit code ===== */
            
    $j(".submit_form_cl").click(function(){
        $j("#sub_form").submit();
    });

    $j(".cancel_form_cl").click(function(e){
        e.preventDefault();
        var data_path = $j(this).attr("data-path");
        window.location = data_path;
    });


    $j(".btn-tool-frm").click(function(){
        var thisid=this.id;
        thisid=thisid.split("-")[1];
        $j("#tooltask").val(thisid);
        $j("#sub_form").submit();
    });
            
    
});


function callAjax(url,dataString)
{
    return $j.ajax({     
                type: "POST",
                url: url,
                cache: false,
                data: dataString,
                dataType: "json"
        });
}

function openloginalert()
{
    bootbox.alert("Your are logged out",function(){
            window.location = HTTP_PATH+"user";
            return false;
    });
    
}

function openblockeralert(msg,path)
{
    bootbox.alert(msg,function(){
            window.location = path;
    });
}
function random_num_gen(numLow,numHigh)
{
    var adjustedHigh = (parseFloat(numHigh) - parseFloat(numLow)) + 1;

    var numRand = Math.floor(Math.random()*adjustedHigh) + parseFloat(numLow);

    return numRand;
}

function showtext()
{
        $j(this).find('div').slideToggle();
}

function hidetext()
{
        $j(this).find('div').slideToggle();
}


function timeConverter(UNIX_timestamp , h_i_s){
    if(h_i_s == undefined)
        h_i_s = false;
    var a = new Date(UNIX_timestamp*1000);
    var months = ['January','Feburary','March','April','May','June','July','August','September','October','November','December'];
    var year = a.getFullYear();
    var month = months[a.getMonth()];
    var date = a.getDate();

    var hour = a.getHours();
    var min = a.getMinutes();
    var sec = a.getSeconds();
    var time = month+' '+date+', '+year ;
    if(h_i_s)
    {
        time += ' '+hour+':'+min+':'+sec;
    }
    return time;
 }


function inArray(ctr,docArray)
{
        var length = docArray.length;
        for(c=0;c<length;c++)
        {
                if(ctr==docArray[c])
                {
                        return 1
                }
        }

        return 0;
}