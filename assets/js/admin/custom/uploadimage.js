/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


      var elemId="pure-id";
      $(document).ready(function(){
         $(".pure-cancel").click(function(e){
             uploadCanceled(elemId,e)
         });
         
         $("#fileToUpload").change(function(e){
             fileSelected()
         });
         
         $("#uploadstart").click(function(e){
             var fileToUpload=$("#fileToUpload").val();
             if(fileToUpload.length==0)
                 return false;
             var url=$(this).attr("reflink");
             uploadFile(url)
         });
         
         
         
         
      });
        function fileSelected() 
        {
            var file = document.getElementById('fileToUpload').files[0];
            showThumbnail(file);
            $(".pure-entry").show();
            if (file) 
            {
                var fileSize = 0;
                if (file.size > 1024 * 1024)
                fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
                else
                fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';

                $('#fileName').html('Name: ' + file.name);
                $('#fileSize').html('Size: ' + fileSize);
                $('#fileType').html('Type: ' + file.type);
            }
        }
      
        function remainingTimeReadable(speed, sizeRemaining)
        {
                if (speed == 0)
                {
                        return 'Unknown time remaining';
                }

                var seconds = Math.round(sizeRemaining / speed);
                var str = '';
                if (seconds < 60)
                {
                        str = (seconds == 1) ? '1 second' : seconds + ' seconds';
                }
                else if (seconds >= 60 && seconds < 3600)
                {
                        var minutes = Math.round(seconds / 60);
                        str = (minutes == 1) ? 'a minute' : minutes  + ' minutes';
                }
                else
                {
                        var hours = Math.round(seconds / 3600);
                        str = (hours == 1) ? 'an hour' : hours  + ' hours';
                }
                return str + ' remaining';
        }
      
      
        function uploadFile(url) 
        {
            var fd = new FormData();
            fd.append("fileToUpload", document.getElementById('fileToUpload').files[0]);
            var xhr = new XMLHttpRequest();
            xhr.upload.addEventListener("progress", uploadProgress, false);
            xhr.addEventListener("load", uploadComplete, false);
            xhr.addEventListener("error", uploadFailed, false);
            xhr.addEventListener("abort", uploadCanceled, false);
            xhr.open("POST", url);
            xhr.send(fd);
        }

        function uploadProgress(evt) 
        {
            var speed = getUploadSpeed(elemId, evt);
            var progress = bytesHumanReadable(evt.position);
            var percentComplete = Math.round((evt.position / evt.totalSize) * 100);
            var remainingTime = remainingTimeReadable(speed, evt.totalSize - evt.position);
            $('#' + elemId + ' .pure-speed').text('Uploading at ' + bytesHumanReadable(speed) + '/s');
            $('#' + elemId + ' .pure-bar').width(percentComplete + '%');
            $('#' + elemId + ' .pure-upload-progress').text(progress);
            $('#' + elemId + ' .pure-percent').text(' (' + percentComplete + '%)');
            $('#' + elemId + ' .pure-remaining-time').text(' - ' + remainingTime);
        }
      
        function bytesHumanReadable(bytes)
        {
                var units = ['B', 'KB', 'MB', 'GB', 'TB'];
                var i = 0;
                while (bytes >= 1024)
                {
                        bytes = bytes / 1024;
                        i++;
                }
                return Math.round(bytes) + ' ' +  units[i];
        }
      
        function getUploadSpeed(elemId, e)
        {
            var uploadAverage = true;
            var elem = $("#"+elemId)[0];
            var pos = elem.position;
            var now = new Date().getTime();
            var speed = 0;

            if (pos)
            {
                    // Convert this to seconds.
                    var elapsed = (now - elem.now) / 1000;
                    var uploaded = (uploadAverage) ? e.position : e.position - pos;
                    speed = uploaded / elapsed;
            }

            elem.now = (!pos || !uploadAverage) ? now : elem.now;
            elem.position = e.position;

            return speed;
        }

        function uploadComplete(evt) {
            /* This event is raised when the server send back a response */
            //alert(evt.target.responseText);
            completeEntry(elemId, 'complete', 'Done');
            loadimgs();
            $("#fileToUpload").val("");
        }

        function uploadFailed(evt) {
            completeEntry(elemId, 'error', 'An Error Occurred');
        }

        function uploadCanceled(elemId,evt) {
            $("#fileToUpload").val("");
            completeEntry(elemId, 'aborted', 'Cancelled');
            $(".pure-entry").fadeOut(2000);
            $("#thumbnail img").remove();
            
        }
      
      
        function completeEntry(elemId, className, message)
        {
            $('#' + elemId).addClass(className);
            $('#' + elemId + ' .pure-speed').text(message); // Message down the bottom.
            $('#' + elemId + ' .pure-remaining-time').text('');
            $('#' + elemId + ' .pure-upload-progress').text('');
            $('#' + elemId + ' .pure-percent').text('');
            $('#' + elemId + ' .pure-size').text('');
        }
    
    
        function showThumbnail(file)
        {
                var imageType = /image.*/
                if(!file.type.match(imageType))
                {
                    console.log("Not an Image");
                    return;
                }

                var image = document.createElement("img");
                // image.classList.add("")
                var thumbnail = $("#thumbnail");
                image.file = file;
                //if(thumbnail.removeChild(image));
                thumbnail.html(image);

                var reader = new FileReader()
                reader.onload = (function(aImg)
                {

                    return function(e)
                    {
                        aImg.src = e.target.result;
                    };
                }(image))
                var ret = reader.readAsDataURL(file);
                var canvas = document.createElement("canvas");
                ctx = canvas.getContext("2d");
                image.onload= function()
                {
                    ctx.drawImage(image,100,100)
                }

        }