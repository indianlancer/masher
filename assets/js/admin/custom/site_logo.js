       var upload_link_def=ADMIN_HTTP_PATH+"settings/update_site_logo/";
        var upload_link=upload_link_def;
        var preview_id="preview";
        //var max_file_size = "1048576"; // 1MB
        var iMaxFilesize = (1024*1024); // 1MB
        var files_allowed=/^(image\/bmp|image\/gif|image\/jpeg|image\/png|image\/tiff)$/i;
        var process_text="Please wait...processing";
        var compute_error="Unable to compute";
        $(document).ready(function(){
            $(".upload_image").live('change',function(){
                    var aa=fileSelected(this);
                    if(aa)
                    {
                        startUploading(this);
                    }
                    $(this).val('');
            });
        });


function process_returndata(data)
{
    var timestamp=new Date().getTime();
    var img_set='<img width="200" src="'+IMG_PATH+'img/'+data.up_file+"?"+timestamp+'" />';
    $("#uploaded_image").html(img_set);
}