$(document).ready(function () {
    var username = $("#urbaloca_username").val();

  
    miWebsocket = new WebSocket("ws://localhost:8080/" + username + "/");
    
    miWebsocket.debug = true;
    miWebsocket.timeoutInterval = 5400;
});