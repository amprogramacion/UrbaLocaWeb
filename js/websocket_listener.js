/* global miWebsocket, QueryString */

$(document).ready(function () {

    miWebsocket.addEventListener('open', function (event) {
        WebSocketOpened(event);
        //Le digo donde estoy
        miWebsocket.send('{"command": "JoinRoom", "params": {"roomid": "'+QueryString.id+'"}}');
    });

    miWebsocket.addEventListener('message', function (event) {
        WebSocketOnMessageEvent(event);
    });

    miWebsocket.addEventListener('close', function (event) {
        WebSocketClosed(event);
    });

    miWebsocket.addEventListener('connecting', function (event) {
        $("#idl_websocket_status").html("CONECTANDO");
    });
});