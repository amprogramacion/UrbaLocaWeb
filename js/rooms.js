
/* global QueryString, miWebsocket */

$(document).on("mousemove", function (event) {
    $("#mix").val(event.pageX);
    $("#miy").val(event.pageY);
});

$(document).ready(function () {
    $("body").click(function () {
        var username = $("#urbaloca_username").val();
        var mix = $("#mix").val();
        var miy = $("#miy").val();

        MoveLoko(username, mix, miy);

        $("#charx").val(mix);
        $("#chary").val(miy);


        miWebsocket.send('{"command": "MoveChar", "params": {"username": "' + username + '", "roomid": "' + QueryString.id + '", "x": "' + mix + '", "y": "' + miy + '"}}');
    });
});

function SendMyPosition(user) {
    var username = $("#urbaloca_username").val();
    if (user != username) {
        var username = $("#urbaloca_username").val();
        var mix = $("#charx").val();
        var miy = $("#chary").val();

        miWebsocket.send('{"command": "SendPosition", "params": {"username": "' + username + '", "roomid": "' + QueryString.id + '", "x": "' + mix + '", "y": "' + miy + '"}}');
    }
}

function MoveLoko(loko, x, y) {
    $("#loko_" + loko).animate({"top": y, "left": x});
}

function JoinRoom() {
    var username = $("#urbaloca_username").val();

    $("body").append("<div id='loko_" + username + "' class='loko'>" + username + "</div>");

    var y = $("#loko_" + username).css("top");
    var x = $("#loko_" + username).css("left");
    $("#charx").val(x);
    $("#chary").val(y);
}

function UserEnterRoom(user, x = null, y = null) {
    var username = $("#urbaloca_username").val();
    if (user != username) {
        $("#loko_" + user).remove();
        $("body").append("<div id='loko_" + user + "' class='loko'>" + user + "</div>");

        if (x != "" && y != "") {
            $("#loko_" + user).css({"top": y, "left": x});
        }
}
}

function MoveOtherChar(user, x, y) {
    var username = $("#urbaloca_username").val();
    if (user != username) {
        MoveLoko(user, x, y);
    }
}

function LeaveRoom() {

}