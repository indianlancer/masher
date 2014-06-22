/*

@author Rishi Raj Tripathi

@modifed date 28 Mar 2014

*/

var windowFocus = true;
var username;
var userid;
var chatHeartbeatCount = 0;
var minChatHeartbeat = 1000;
var maxChatHeartbeat = 33000;
var chatHeartbeatTime = minChatHeartbeat;
var originalTitle;
var blinkOrder = 0;

var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var chatDives = new Array();
var $j = jQuery.noConflict();
$j(document).ready(function(){
    
    $j("#srch_frnd_email").autocomplete({
            source: function( request, response ) {
                $j.ajax({
                    url: HTTP_PATH+"home/getUserContact/",
                    dataType: "json",
                    type: "POST",
                    data: {
                        page_limit: 5,
                        q: request.term
                    },
                    success: function( data ) {
                        response( 
                        $j.map(data.contacts, function( item ) 
                        {
                            return {
                                label: item.uname,
                                value: item.username
                            }
                        }
                        ));
                    }
                });
            },
            minLength: 1,
            maxLength:8,
            select: function( event, ui ) {
                    window.location.href =  HTTP_PATH+"home/getuser/"+ui.item.value;
            }
    });
    
    
    originalTitle = document.title;
    initiateUserChat();

    $j([window, document]).blur(function(){
            windowFocus = false;
    }).focus(function(){
            windowFocus = true;
            document.title = originalTitle;
    });
    
    $j("#main_container").on("click",".cht_wt",function(e){
        e.preventDefault();
        var chatuser = $j(this).attr("data-name");
        var chatid = $j(this).attr("data-id");
        
        chatToUser(chatuser,chatid);
    });
    $j("#main_container").on("click",".togBoxGrowth",function(e){
        e.preventDefault();
        var chatboxid = $j(this).attr("data-id");
        toggleChatDivGrowth(chatboxid);
    });
    $j("#main_container").on("click",".closeChatbox",function(e){
        e.preventDefault();
        var chatboxid = $j(this).attr("data-id");
        closeChatDiv(chatboxid);
    });
    $j("#main_container").on("keydown",".chatboxtextarea",function(e){
        var chatboxid = $j(this).attr("data-id");
        var chatboxtitle = $j(this).attr("data-name");
        return sendChatMessage(e,this,chatboxtitle,chatboxid);
    });
    $j(".changeStatus").on("click",function(e){
        $j(".changeStatus").removeClass("active");
        var status = $j(this).attr("data-status");
        $j(this).addClass("active");
        updateUserStatus(status);
    });
    
    $j("#main_container").on("click",".smileys-images",function(e){
        e.preventDefault();
        var name = $j(this).parent().attr("id");
        name = name.split("_");
        if(typeof name[2] == "undefined")
            return;
        name =name[2];
        var smiley = $j(this).attr("data-smiley");
        var curr_val = $j("#chatbox_"+name+" .chatboxtextarea").val();
        $j("#chatbox_"+name+" .chatboxtextarea").val(curr_val+smiley);
        $j("#chatbox_"+name+" .chatboxtextarea").focus();
        $j("#chatbox_"+name+" .smileys-list-all-cont").hide();
    });
    
    $j("#main_container").on("click",".open-smile",function(e){
        e.preventDefault();
        var name = $j(this).attr("data-name");
        $j("#chatbox_"+name+" .smileys-list-all-cont").toggle();
    });
    
    $j(".user_req_list").on("click",".accept_req",function(e){
        e.preventDefault();
        var _this = this;
        var user_id = $j(this).attr("data-id");
        $j(this).attr("disabled","disabled");
        var ret_ajax = callAjax(HTTP_PATH+"home/acceptReq","user_id="+user_id);
        ret_ajax.complete(function(){
            $j(_this).removeAttr("disabled");
        });
        ret_ajax.error(function(){
        });
        ret_ajax.success(function(data){
            if(data.success == 1)
            {
                alert("you both are now friends");
                friendChatRequestList();
                friendChatList();
                //window.location.href=HTTP_PATH+"home/chat/accept";
            }
        });
    });
    
    friendChatList();
    friendChatRequestList();
    function friendChatList()
    {
        var url = HTTP_PATH+"home/friendChatList/";
        var dataString = "load="+1;

        var ret_ajax = callAjax(url,dataString);
        ret_ajax.complete(function(){
            
        });
        ret_ajax.success(function(data){
            if(data.success == 1)
            {
                $j(".user_frnd_list").html(data.friends_list);
            }
        });
    }
    function friendChatRequestList()
    {
        var url = HTTP_PATH+"home/friendChatRequestList/";
        var dataString = "load="+1;

        var ret_ajax = callAjax(url,dataString);
        ret_ajax.complete(function(){
            
        });
        ret_ajax.success(function(data){
            if(data.success == 1)
            {
                $j(".user_req_list").html(data.friend_request_list);
            }
        });
    }
    
    
    function template(template,dataObj,appender)
    {
        template = $j(template).html();
        if(appender === 1)
        {
            var m_temp = $j.tmpl( template, dataObj);
            return m_temp;
        }
        else
        $j.tmpl( template, dataObj).appendTo( appender );
    }
        
    function arrangeChatDivs() {
        align = 0;
        for (x in chatDives) {
                chatboxtitle = chatDives[x];

                if ($j("#chatbox_"+chatboxtitle).css('display') != 'none') {
                        if (align == 0) {
                                $j("#chatbox_"+chatboxtitle).css('right', '20px');
                        } else {
                                width = (align)*(225+7)+20;
                                $j("#chatbox_"+chatboxtitle).css('right', width+'px');
                        }
                        align++;
                }
        }
    }

    function chatToUser(chatuser,chatid) {
            createChatDiv(chatuser,0,chatid, 1);
            $j("#chatbox_"+chatuser+" .chatboxtextarea").focus();
    }

    function createChatDiv(chatboxtitle,minimizeChatBox,chatboxid,forceOpen) {
        
            if ($j("#chatbox_"+chatboxtitle).length > 0) {
                    if ($j("#chatbox_"+chatboxtitle).css('display') == 'none') {
                            $j("#chatbox_"+chatboxtitle).css('display','block');
                            arrangeChatDivs();
                    }
                    $j("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
                    
                    if(typeof forceOpen !== "undefined" && forceOpen == 1)
                    {
                        $j('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','block');
                        $j('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','block');
                    }
                    return;
            }
            template("#chat_bx_tmpl",{"chatboxtitle" : chatboxtitle,"chatboxid":chatboxid},"#chat_boxes");
            $j( ).append('');

            $j("#chatbox_"+chatboxtitle).css('bottom', '0px');

            chatDiveslength = 0;

            for (x in chatDives) {
                    if ($j("#chatbox_"+chatDives[x]).css('display') != 'none') {
                            chatDiveslength++;
                    }
            }

            if (chatDiveslength == 0) {
                    $j("#chatbox_"+chatboxtitle).css('right', '20px');
            } else {
                    width = (chatDiveslength)*(225+7)+20;
                    $j("#chatbox_"+chatboxtitle).css('right', width+'px');
            }

            chatDives.push(chatboxtitle);

            if (minimizeChatBox == 1) {
                    minimizedChatDivs = new Array();

                    if ($j.cookie('chatbox_minimized')) {
                            minimizedChatDivs = $j.cookie('chatbox_minimized').split(/\|/);
                    }
                    minimize = 0;
                    for (j=0;j<minimizedChatDivs.length;j++) {
                            if (minimizedChatDivs[j] == chatboxtitle) {
                                    minimize = 1;
                            }
                    }

                    if (minimize == 1) {
                            $j('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
                            $j('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
                    }
            }
            
            chatboxFocus[chatboxtitle] = false;

            $j("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function(){
                    chatboxFocus[chatboxtitle] = false;
                    $j("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
            }).focus(function(){
                    chatboxFocus[chatboxtitle] = true;
                    newMessages[chatboxtitle] = false;
                    $j('#chatbox_'+chatboxtitle+' .chatboxhead').removeClass('chatboxblink');
                    $j("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
            });

            /*$j("#chatbox_"+chatboxtitle).click(function() {
                    if ($j('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') {
                            $j("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
                    }
            });*/

            $j("#chatbox_"+chatboxtitle).show();
    }


    function checkChatHeartbeat(){

            var itemsfound = 0;

            if (windowFocus == false) {

                    var blinkNumber = 0;
                    var titleChanged = 0;
                    for (x in newMessagesWin) {
                            if (newMessagesWin[x] == true) {
                                    ++blinkNumber;
                                    if (blinkNumber >= blinkOrder) {
                                            document.title = x+' says...';
                                            titleChanged = 1;
                                            break;	
                                    }
                            }
                    }

                    if (titleChanged == 0) {
                            document.title = originalTitle;
                            blinkOrder = 0;
                    } else {
                            ++blinkOrder;
                    }

            } else {
                    for (x in newMessagesWin) {
                            newMessagesWin[x] = false;
                    }
            }

            for (x in newMessages) {
                    if (newMessages[x] == true) {
                            if (chatboxFocus[x] == false) {
                                    //FIXME: add toggle all or none policy, otherwise it looks funny
                                    $j('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
                            }
                    }
            }

            $j.ajax({
              url: HTTP_PATH+"userchat/chatheartbeat",
              cache: false,
              dataType: "json",
              success: function(data) {
                    var user_friend_st = data.friend_st;
                    $j(".user_frnd_list").html(data.friend_st);
                    $j.each(data.items, function(i,item){
                            if (item)	{ // fix strange ie bug

                                    chatboxtitle = item.f;
                                    chatboxid = item.fid;

                                    if ($j("#chatbox_"+chatboxtitle).length <= 0) {
                                            createChatDiv(chatboxtitle,0,chatboxid);
                                    }
                                    if ($j("#chatbox_"+chatboxtitle).css('display') == 'none') {
                                            $j("#chatbox_"+chatboxtitle).css('display','block');
                                            arrangeChatDivs();
                                    }

                                    if (item.s == 1) {
                                            item.f = username;
                                    }

                                    if (item.s == 2) {
                                            $j("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
                                    } else {
                                            newMessages[chatboxtitle] = true;
                                            newMessagesWin[chatboxtitle] = true;
                                            $j("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.f+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+checkSmileys(item.m)+'</span></div>');
                                            $j.playSound(HTTP_PATH+'assets/sound/recieve');
                                    }

                                    $j("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($j("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
                                    itemsfound += 1;
                            }
                    });

                    chatHeartbeatCount++;

                    if (itemsfound > 0) {
                            chatHeartbeatTime = minChatHeartbeat;
                            chatHeartbeatCount = 1;
                    } else if (chatHeartbeatCount >= 10) {
                            chatHeartbeatTime *= 2;
                            chatHeartbeatCount = 1;
                            if (chatHeartbeatTime > maxChatHeartbeat) {
                                    chatHeartbeatTime = maxChatHeartbeat;
                            }
                    }
                    
            }});
    }

    function closeChatDiv(chatboxtitle) {
            $j('#chatbox_'+chatboxtitle).css('display','none');
            arrangeChatDivs();

            $j.post(HTTP_PATH+"userchat/closechat", { chatbox: chatboxtitle} , function(data){	
            });

    }
    
    function updateUserStatus(status) {
            
            $j.ajax({
                url: HTTP_PATH+"user/updateStatus",
                cache: false,
                type:"post",
                dataType: "json",
                data:{'status': status},
                success: function(data) {


                }
            });

    }

    function toggleChatDivGrowth(chatboxtitle) {
            if ($j('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'none') {  

                    var minimizedChatDivs = new Array();

                    if ($j.cookie('chatbox_minimized')) {
                            minimizedChatDivs = $j.cookie('chatbox_minimized').split(/\|/);
                    }

                    var newCookie = '';

                    for (i=0;i<minimizedChatDivs.length;i++) {
                            if (minimizedChatDivs[i] != chatboxtitle) {
                                    newCookie += chatboxtitle+'|';
                            }
                    }

                    newCookie = newCookie.slice(0, -1)


                    $j.cookie('chatbox_minimized', newCookie);
                    $j('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','block');
                    $j('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','block');
                    $j('#chatbox_'+chatboxtitle+' .open-smile-cont').css('display','block');

                    $j("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($j("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
            } else {

                    var newCookie = chatboxtitle;

                    if ($j.cookie('chatbox_minimized')) {
                            newCookie += '|'+$j.cookie('chatbox_minimized');
                    }


                    $j.cookie('chatbox_minimized',newCookie);
                    $j('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
                    $j('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
                    $j('#chatbox_'+chatboxtitle+' .open-smile-cont').css('display','none');
            }

    }

    function sendChatMessage(event,chatboxtextarea,chatboxtitle,chatboxid) {

            if(event.keyCode == 13 && event.shiftKey == 0)  {
                    message = $j(chatboxtextarea).val();
                    message = message.replace(/^\s+|\s+$/g,"");

                    $j(chatboxtextarea).val('');
                    $j(chatboxtextarea).focus();
                    $j(chatboxtextarea).css('height','44px');
                    if (message != '') {
                        
                        //$j.playSound(HTTP_PATH+'assets/sound/sent');
                            $j.post(HTTP_PATH+"userchat/sendchat", {to: chatboxid, message: message} , function(data){
                                
                                //checkSmileys
                                message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
                                $j("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+username+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+checkSmileys(message)+'</span></div>');
                                $j("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($j("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
                            });
                            comet.doRequest(message,chatboxid);
                    }
                    chatHeartbeatTime = minChatHeartbeat;
                    chatHeartbeatCount = 1;

                    return false;
            }

            var adjustedHeight = chatboxtextarea.clientHeight;
            var maxHeight = 94;

            if (maxHeight > adjustedHeight) {
                    adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
                    if (maxHeight)
                            adjustedHeight = Math.min(maxHeight, adjustedHeight);
                    if (adjustedHeight > chatboxtextarea.clientHeight)
                            $j(chatboxtextarea).css('height',adjustedHeight+8 +'px');
            } else {
                    $j(chatboxtextarea).css('overflow','auto');
            }

    }

    function initiateUserChat(){  
            $j.ajax({
              url: HTTP_PATH+"userchat/initiateuserchat",
              cache: false,
              dataType: "json",
              success: function(data) {

                    username = data.username;

                    $j.each(data.items, function(i,item){
                            if (item)	{ // fix strange ie bug

                                    chatboxtitle = item.f;
                                    chatboxid = item.fid;

                                    if ($j("#chatbox_"+chatboxtitle).length <= 0) {
                                            createChatDiv(chatboxtitle,1,chatboxid);
                                    }

                                    if (item.s == 1) {
                                            item.f = username;
                                    }

                                    if (item.s == 2) {
                                            $j("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+checkSmileys(item.m)+'</span></div>');
                                    } else {
                                            $j("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.f+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+checkSmileys(item.m)+'</span></div>');
                                    }
                            }
                    });

                    for (i=0;i<chatDives.length;i++) {
                            chatboxtitle = chatDives[i];
                            $j("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($j("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
                            setTimeout('$j("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($j("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);', 100); // yet another strange ie bug
                    }

            }});
    }
    initialize_smileys();
    function initialize_smileys()
    {
        var links = emoticons_smileyLinksnew(1);
        $j(".smileys-list-all").html(links);
    }
    function smileyShortArray()
    {
        return new Array(
                        ':)',		
                        ':(',
                        ':D',
                        '8)',
                        ':o',
                        ';(',
                        '(:|',
                        ':|',
                        ':*',
                        ':P',
                        ':$',
                        ':^)',
                        '|-)',
                        '|(',
                        '(inlove)',
                        ']:)',
                        '(talk)',
                        '(yawn)',
                        '(puke)',
                        '(doh)',
                        ':@',
                        '(wasntme)',
                        '(party)',
                        ':S',
                        '(mm)',
                        '8-|',
                        ':x',
                        '(hi)',
                        '(call)',
                        '(devil)',
                        '(angel)',
                        '(envy)',
                        '(wait)',
                        '(bear)',
                        '(makeup)',
                        '(giggle)',
                        '(clap)',
                        '(think)',
                        '(bow)',
                        '(rofl)',
                        '(whew)',
                        '(happy)',
                        '(smirk)',
                        '(nod)',
                        '(shake)',
                        '(punch)',
                        '(emo)',
                        '(y)',
                        '(n)',
                        '(handshake)',
                        '(h)',
                        '(u)',
                        '(e)',
                        '(f)',
                        '(rain)',
                        '(sun)',
                        '(o)',
                        '(music)',
                        '(~)',
                        '(mp)',
                        '(coffee)',
                        '(pizza)',
                        '(cash)',
                        '(muscle)',
                        '(cake)',
                        '(beer)',
                        '(d)',
                        '(dance)',
                        '(ninja)',
                        '(*)',
                        '(mooning)',
                        '(finger)',
                        '(bandit)',
                        '(drunk)',
                        '(smoking)',
                        '(toivo)',
                        '(rock)',
                        '(headbang)',
                        '(bug)',
                        '(fubar)',
                        '(poolparty)',
                        '(swear)',
                        '(tmi)',
                        '(heidy)',
                        '(tauri)',
                        '(priidu)'

            );
    }
    
    function smileyIconArray()
    {
        return new Array(
                        'smile',		
                        'sad',
                        'laugh',
                        'cool',
                        'wink',
                        'crying',
                        'sweating',
                        'speechless',
                        'kiss',
                        'tongueout',
                        'blush',
                        'wondering',
                        'sleepy',
                        'dull',
                        'inlove',
                        'evilgrin',
                        'talking',
                        'yawn',
                        'puke',
                        'doh',
                        'angry',
                        'itwasntme',
                        'party',
                        'worried',
                        'mmm',
                        'nerd',
                        'lipssealed',
                        'hi',
                        'call',
                        'devil',
                        'angel',
                        'envy',
                        'wait',
                        'bear',
                        'makeup',
                        'giggle',
                        'clapping',
                        'thinking',
                        'bow',
                        'rofl',
                        'whew',
                        'happy',
                        'smirk',
                        'nod',
                        'shake',
                        'punch',
                        'emo',
                        'yes',
                        'no',
                        'handshake',
                        'heart',
                        'brokenheart',
                        'mail',
                        'flower',
                        'rain',
                        'sun',
                        'time',
                        'music',
                        'movie',
                        'phone',
                        'coffee',
                        'pizza',
                        'cash',
                        'muscle',
                        'cake',
                        'beer',
                        'drink',
                        'dance',
                        'ninja',
                        'star',
                        'mooning',
                        'middlefinger',
                        'bandit',
                        'drunk',
                        'smoke',
                        'toivo',
                        'rock',
                        'headbang',
                        'bug',
                        'fubar',
                        'poolparty',
                        'swear',
                        'tmi',
                        'heidy',
                        'tauri',
                        'priidu'

            );
    }
    function emoticons_smileyLinksnew(hash){
            var links = '';
	
            var sArray = smileyShortArray();
	
            var cArray = smileyIconArray();

            for(i in sArray)
                links += emoteLink1(sArray[i], cArray[i], hash);

            return links;
        }


        // Generates the correct HTML code for an emoticon insertion tool
        function emoteLink1(smiley, image) { 

            return '<a href="javascript:void(0);" class="emoticon emoticon-' + image + ' smileys-images" data-smiley="' + smiley + '"  title="'+image+'"></a>';
        }

        // Emoticon links arrays

        // Generates a given emoticon HTML code
        function emoteImage(image ) {
            return '<img class="" alt="' + (image) + '" src="'+HTTP_PATH+'assets/img/icons/smileys/'+image+'.gif" />';
            // emoticon emoticon-brheart smileys-images
        }
        
        function checkSmileys(text)
        {
            var sArray = smileyShortArray();
	
            var cArray = smileyIconArray();
            
            for(i in sArray)
            {
                links = emoteImage(cArray[i]);
                text = text.replace(sArray[i], links);
            }
            return text;
        }
    
    
   
 var Comet = function(data_url,from_user)
 {
    this.timestamp = 0;
    this.url = data_url;  
    this.from_user = from_user;
    this.noerror = true;
    
    this.connect = function()
    {
        var self = this;
        $j.ajax({
            type : 'post',
            url : this.url,
            dataType : 'json', 
            timeout: 100000,
            data : {'timestamp' : self.timestamp,'from_user':from_user},
            success : function(response) {
                if(response != null)
                {
                self.timestamp = response.timestamp;
                self.handleResponse(response);
                self.noerror = true;  
                checkChatHeartbeat();
                }
            },
            complete : function(response) {
              // send a new ajax request when this request is finished
              if (!self.noerror) {
                // if a connection problem occurs, try to reconnect each 5 seconds
                setTimeout(function(){ comet.connect();checkChatHeartbeat(); }, 5000);           
              }else {
                // persistent connection
                self.connect(); 
              }

              self.noerror = false; 
            }
        });
      
    };
 
    this.disconnect = function()
    {
        
    };
 
    this.handleResponse = function(response)
    {
      // do nothing
    };
 
    this.doRequest = function(request,touser)
    {
        var self = this;
        $j.post(this.url+"send", {msg: request, to_user: touser,"from_user":self.from_user} , function(data){
                
        });
      
    }
  }
  
  //var comet = new Comet(HTTP_PATH+"user_chat/backend.php",this_user);
  var comet = new Comet(HTTP_PATH+"connect/",this_user);
  comet.connect();
    
});



 


/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
