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
            case "UserEnterRoom":
                UserEnterRoom(obj.params.username);
                SendMyPosition(obj.params.username);
                break;
            case "SendPosition":
                UserEnterRoom(obj.params.username, obj.params.x, obj.params.y);
            break;
            case "MoveChar":
                MoveOtherChar(obj.params.username, obj.params.x, obj.params.y);
                break;
            default:
                console.log("Estado no parseado 0: " + obj.command);
                break;
        }
    } catch (error) {
        console.log("[WebSocketOnMessageEvent][error] " + error);
    }
}