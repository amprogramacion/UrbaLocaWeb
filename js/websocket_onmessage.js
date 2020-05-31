/**
 * Recibe los comandos del servidor en formato JSON
 * 
 * @param {array} event (event.data) datos recibidos del servidor
 */

function WebSocketOnMessageEvent(event) {

    try {
        var obj = JSON.parse(event.data);

        switch (obj.command) { //obj.params
            case "JoinAccepted":
                JoinRoom();
            break;
            default:
                console.log("Estado no parseado 0: " + obj.command);
                break;
        }
    } catch (error) {
        console.log("[WebSocketOnMessageEvent][error] " + error);
    }
}