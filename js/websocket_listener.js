/* global miWebsocket */

$(document).ready(function () {

    miWebsocket.addEventListener('open', function (event) {
        WebSocketOpened(event);
        miWebsocket.send('{"command": "RealTimeQueues"}');
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