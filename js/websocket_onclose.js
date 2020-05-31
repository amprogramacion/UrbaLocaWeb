/**
 * Se ejecuta cuando se pierde la conexión al servidor
 * 
 * @param {array} event
 */

function WebSocketClosed(event) {
    console.log(event);
    console.log("Desconectado del servidor");
    
    try {
        $("#idl_websocket_status").html("DESCONECTADO");
    } catch (error) {
        console.log("[WebSocketClosed][error] " + error);
    }
}