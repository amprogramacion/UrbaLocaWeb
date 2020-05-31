/* global miWebsocket, QueryString */

/**
 * Se ejecuta cuando la conexión con el socket servidor es positiva
 * 
 * @param {array} event
 */
function WebSocketOpened(event) {
    console.log(event);
    console.log("Conectado al servidor");
    
    try {
        //Pintamos el div de conectado
        $("#idl_websocket_status").html("CONECTADO");

        //Le digo donde estoy
        miWebsocket.send('{"command": "JoinRoom", "params": {"roomid": "'+QueryString.id+'"}}');
    } catch (error) {
        console.log("[WebSocketOpened][error] " + error);
    }
}