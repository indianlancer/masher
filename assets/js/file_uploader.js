// common variables
var iBytesUploaded = 0;
var iBytesTotal = 0;
var iPreviousBytesLoaded = 0;

var oTimer = 0;
var sResultFileSize = '';

function secondsToTime(secs) { // we will use this function to convert seconds in normal time format
    var hr = Math.floor(secs / 3600);
    var min = Math.floor((secs - (hr * 3600))/60);
    var sec = Math.floor(secs - (hr * 3600) -  (min * 60));

    if (hr < 10) {hr = "0" + hr; }
    if (min < 10) {min = "0" + min;}
    if (sec < 10) {sec = "0" + sec;}
    if (hr) {hr = "00";}
    return hr + ':' + min + ':' + sec;
};

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
};

function fileSelected(thisObj) {

    // hide different warnings
    clear_all_display();

    // get selected file element
    var thisid=thisObj.id;
    var oFile = document.getElementById(thisid).files[0];

    // filter for image files
    var rFilter = files_allowed;
//	 var rFilter = /^(video\/wmv|video\/flv|video\/mp4|video\/avi|video\/mov)$/i;
    
    if($.isEmptyObject(oFile))
        return false;
    if (! rFilter.test(oFile.type)) {
        clear_all_display_info();
        $('#error').show();
        return false;
    }

    // little test for filesize
    if (oFile.size > iMaxFilesize) {
        clear_all_display_info();
        $('#warnsize').show();
        return false;
    }

    // get preview element
    var oImage = document.getElementById(preview_id);

    // prepare HTML5 FileReader
    var oReader = new FileReader();
        oReader.onload = function(e){

        // e.target.result contains the DataURL which we will use as a source of the image
        oImage.src = e.target.result;

        oImage.onload = function () { // binding onload event

            // we are going to display some custom image information here
            sResultFileSize = bytesToSize(oFile.size);
            $('#fileinfo').show();
            $('#filename').html('Name: ' + oFile.name);
            $('#filesize').html( 'Size: ' + sResultFileSize);
            $('#filetype').html( 'Type: ' + oFile.type);
            $('#filedim').html(  'Dimension: ' + oImage.naturalWidth + ' x ' + oImage.naturalHeight);
        };
    };

    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
    return true;
}

function startUploading(thisObj) {
    // get selected file element
    var thisid=thisObj.id;
    var oFile = document.getElementById(thisid).files[0];
    // filter for image files
    var rFilter = files_allowed;
//	 var rFilter = /^(video\/wmv|video\/flv|video\/mp4|video\/avi|video\/mov)$/i;
    if (! rFilter.test(oFile.type)) {
        $('#error').show();
        return false;
    }

    // little test for filesize
    if (oFile.size > iMaxFilesize) {
        $('#warnsize').show();
        return false;
    }
    // cleanup all temp states
    iPreviousBytesLoaded = 0;
    $('#upload_response').hide();
    $('#error').hide();
    $('#error2').hide();
    $('#abort').hide();
    $('#warnsize').hide();
    $('#progress_percent').html('');
    var oProgress = $('#progress');
    oProgress.show();
    oProgress.css("width", '0px');

    // get form data for POSTing
    //var vFD = document.getElementById('upload_form').getFormData(); // for FF3
    var vFD = new FormData(document.getElementById(form_up_id)); 
    // create XMLHttpRequest object, adding few event listeners, and POSTing our data
    var oXHR = new XMLHttpRequest();        
    oXHR.upload.addEventListener('progress', uploadProgress, false);
    oXHR.addEventListener('load', uploadFinish, false);
    oXHR.addEventListener('error', uploadError, false);
    oXHR.addEventListener('abort', uploadAbort, false);
    oXHR.open('POST', upload_link);
    oXHR.send(vFD);

    // set inner timer
    oTimer = setInterval(doInnerUpdates, 300);
}

function doInnerUpdates() { // we will use this function to display upload speed
    var iCB = iBytesUploaded;
    var iDiff = iCB - iPreviousBytesLoaded;

    // if nothing new loaded - exit
    if (iDiff == 0)
        return;

    iPreviousBytesLoaded = iCB;
    iDiff = iDiff * 2;
    var iBytesRem = iBytesTotal - iPreviousBytesLoaded;
    var secondsRemaining = iBytesRem / iDiff;

    // update speed info
    var iSpeed = iDiff.toString() + 'B/s';
    if (iDiff > 1024 * 1024) {
        iSpeed = (Math.round(iDiff * 100/(1024*1024))/100).toString() + 'MB/s';
    } else if (iDiff > 1024) {
        iSpeed =  (Math.round(iDiff * 100/1024)/100).toString() + 'KB/s';
    }

    $('#speed').html(iSpeed);
    $('#remaining').html('| ' + secondsToTime(secondsRemaining));        
}

function uploadProgress(e) { // upload process in progress
    if (e.lengthComputable) {
        iBytesUploaded = e.loaded;
        iBytesTotal = e.total;
        var iPercentComplete = Math.round(e.loaded * 100 / e.total);
        var iBytesTransfered = bytesToSize(iBytesUploaded);

        $('#progress_percent').html(iPercentComplete.toString() + '%');
        $('#progress').css("width" , (iPercentComplete * 4).toString() + 'px');
        $('#b_transfered').html(iBytesTransfered);
        if (iPercentComplete == 100) {
            var oUploadResponse = $('#upload_response');
            oUploadResponse.html('<h1>'+process_text+'</h1>');
            oUploadResponse.show();
        }
    } else {
        $('#progress').html(compute_error);
    }
}

function uploadFinish(e) { // upload successfully finished
    //var oUploadResponse = $('#upload_response');
    //oUploadResponse.html();
    //oUploadResponse.show();
    $('#progress_percent').html('100%');
    $('#progress').css("width", '250px');
    $('#filesize').html(sResultFileSize);
    $('#remaining').html('| 00:00:00');
    setTimeout(function(){
        clear_all_display();
        clear_all_display_info();
    },2000);
    var data=$.parseJSON(e.target.responseText);
    clearInterval(oTimer);
    process_returndata(data);
}

function uploadError(e) { // upload error
    $('#error2').show();
    clearInterval(oTimer);
}  

function uploadAbort(e) { // upload abort
    $('abort').show();
    clearInterval(oTimer);
}


function clear_all_display()
{
    $('#upload_response').hide();
    $('#error').hide();
    $('#error2').hide();
    $('#abort').hide();
    $('#warnsize').hide();
}

function clear_all_display_info()
{
    $('#fileinfo').hide();
    $('#filename').html('' );
    $('#filesize').html( '');
    $('#filetype').html( '');
    $('#filedim').html('');
    $('#b_transfered').html('');
    $("#speed").hide();
    clearInterval(oTimer);
    $('#progress_percent').html('');
    $('#progress').hide();
    $('#filesize').html('');
    $('#remaining').html('');
    $("#"+preview_id).attr("src","");
}