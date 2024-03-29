<!doctype html>
<html>
    <head>

        <!-- for CreateJS and ZIMjs https://zimjs.com - free to modify - Dan Zen 2015 -->
        <!-- see https://zimjs.com/templates for more templates and meta tags -->

        <script src="https://zimjs.org/cdn/1.3.2/createjs.js"></script>
        <script src="https://zimjs.org/cdn/nft/00/zim.js"></script>
        <script src="https://zimjs.org/cdn/2.3.0/socket.io.js"></script>
        <script src="https://zimjs.org/cdn/zimserver_urls.js"></script>
        <script src="https://zimjs.org/cdn/zimsocket_1.1.js"></script>

        <!-- bring in EasyStar for path finding and game module for Board -->
        <script src="https://d309knd7es5f10.cloudfront.net/easystar-0.4.3.min.js"></script>
        <script src="https://zimjs.org/cdn/game_2.4.js"></script>


        <style>
            body {
                margin:0px;
                padding:0px;
                background-color:#FFF;
                background-image:url("images/avatarBacking3.jpg");
            }
            #messages {
                border: 2px solid red;
                width: 350px;
                height: 100vh;
                position: absolute;
                top: 0;
                left: 0;
                z-index: 9999;
                background-color: white;
            }
        </style>

        <script>
            var others = {};
            var player = null;
            var buttonEntrar = null;

            var scaling = "full"; // this will resize to fit inside the screen dimensions
            var width = 1024;
            var height = 768;
            var color = "#6FB7FF";
            var outerColor = darker;
            var initObj = {x: 4, y: 7, boardCol: 4, boardRow: 7, username: null};
            var username = "escavo";//prompt("Nombre de usuario:");
            if (username == null) {
                alert("Necesito un usuario para identificarte. Es temporal.");
                window.location.reload();
            } else {
                initObj.username = username;
            }
            const assets = ["game/muebles/10_1.png", "img/logoul.png", "game/interfaz/ciudad.png", "imager/loko.png"];
            const path = "./";
            const waiter = new Waiter();

            var frame = new Frame({scaling, width, height, color, outerColor, assets, path, waiter});
            frame.on("ready", function () {
                var stage = frame.stage;
                var stageW = frame.width;
                var stageH = frame.height;

                ZIMONON = true; // set this to true if using ZIMON - like JSON but with any object

                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                // IMPLEMENTACION LOCAL DEL MAPA
                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~




                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                // IMPLEMENTACION DEL SOCKET
                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

                function begin() { // called from interface button at end of section below
                    // set parameters for the zim.Socket object
                    var server = zimSocketURL;
                    var app = "urbaloca";
                    var room = "UrbaLocav4-alpha"; // just use the default room
                    var maxPeople = null; // just use the default of 0 which means unlimited
                    var fill = null; // just use the default of fill where clients leave
                    // we can send an optional initial object to the server
                    // this information will get sent to all the other clients in an otherjoin event

                    socket = new Socket(server, app, room, maxPeople, fill, initObj);

                    // the ready event is triggered when a client first joins
                    // the event object holds all the data of the others in the room
                    // in this case, we have one big room as the default maxPeople is unlimited (the second null above)
                    socket.on("ready", function (avatars) {
                        player.on("moving", function () {
                            socket.setProperties({x: player.x, y: player.y});
                        });

                        player.on("moved", function () {
                            socket.setProperties({boardCol: player.boardCol, boardRow: player.boardRow, accion: 'estoyparado'});
                        });

                        // populate the room using the data sent from the server - something like this:
                        // {id:{property:value, p2:v2}, id2:{property:value, p2:v2}, etc.}
                        // note, the data will also hold an id so data.id would give the id too
                        var data;
                        for (var id in avatars) {
                            data = avatars[id];
                            if (data) {
                                createAvatar(id, data.boardCol, data.boardRow);
                            }
                        }
                        stage.update();
                    });

                    socket.on("otherjoin", function (data) {
                        if (data) {
                            createAvatar(data.id, data.boardCol, data.boardRow);
                            hablar("[UL]", data.username + " ha entrado.");
                        }
                    });
                    socket.on("data", function (data) {
                        switch (data.accion) {
                            case "caminar":
                                board.followPath(others[data.id], data.path); //caminar
                                break;
                            case "hablar":
                                hablar(data.username, data.decir);
                                break;
                        }
                    });

                    socket.on("otherleave", function (data) {
                        board.remove(others[data.id]);
                        hablar("[UL]", data.username + " ha salido.");
                        stage.update();
                    });

                    socket.on("error", function () {
                        MostrarError("Error de conexión");
                        socket.disconnect();
                    });

//Crear y actualizar mapa
                    board.center();
                    stage.update();
                }

                function createAvatar(id, x, y) {
                    others[id] = new Person(yellow, silver, brown);
                    board.add(others[id], x, y);
                    stage.update();
                }

                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                // BOARD
                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

                // the Board() class - not to be confused with the LeaderBoard() class ;-)
                // this defaults to isometric but can be used with top view
                // or toggled later with board.isometric = false;

                var board = new Board({
                    cols: 12,
                    rows: 9,
                    backgroundColor: grey,
                    arrows: false,
                    size: 30
                });

                var tree;
                var player;


                // if (localStorage) localStorage.clear(); // if want to reset
                // first time so let's set up the board how we want it

                // example - adding extra rows and columns
                // can also add row(index) and col(index) to insert rows
                // or adjust info parameter.
                // Then positioning the board
                /*loop(10, function () {
                 board.addCol();
                 board.addRow();
                 });*/
                //board.positionBoard(6, 5);
                board.center();

                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                // BOARD ITEMS
                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

                /*var colors = series(red, orange);
                 loop(8, function (j) {
                 loop (8, function (i) {
                 var p = board.add(new zim.Person(colors,grey,brown), i, j);
                 });
                 });*/

                // add a tree and set the data as it is added to -
                board.add(new Tree().alp(.9), 5, 3, "-", purple); // - will mean can't change color
                board.add(new Sprite(asset("game/muebles/10_1.png")), 5, 4, "-", purple); // - will mean can't change color
                board.add(new Sprite(asset("game/muebles/10_1.png")), 5, 3, "-", purple); // - will mean can't change color
                board.add(new Sprite(asset("game/muebles/10_1.png")), 5, 2, "-", purple); // - will mean can't change color
                //Añadimos al jugador local
                player = new Circle();
                board.add(player, 4, 0);

                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                // BOARD INTERACTION
                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~




                // tapping on the tiles (the board also includes arrows so do not tap on board)
                // to either set the color or set the path depending on toggle button at bottom right
                // we are increasing score when collecting orbs
                // but decreasing score if no orb is collected - oooo what a game!
                // each time we tap we will set orbCollect false
                // if we hit an orb this will be set to true and the score increased
                // then when the path is done, we check to see if we need to decrease the score
                board.tiles.tap(function (e) {
                    if (player.moving) {
                        return;
                    }
                    if (path) { // because rolled over already
                        board.followPath(player, path);
                        socket.setProperties({path: path, x: player.boardCol, y: player.boardRow, boardCol: player.boardCol, boardRow: player.boardRow, accion: 'caminar'});
                        path = null;
                    } else { // could be tapping or on mobile with no rollover
                        getPath(true, player); // true to follow it once found
                        alert("getPath(true, player)");
                    }
                    stage.update();
                });

                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                // PATH FINDING
                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

                var AI = new EasyStar.js();
                AI.setTileCost("r", 80); // red
                AI.setTileCost("g", 0); // green - will want to travel on green
                AI.setTileCost("x", 20); // nothing
                AI.setTileCost("o", 40); // orange
                AI.setAcceptableTiles(["r", "g", "x", "o"]); // not 0 and not -
                var pathID;
                var ticker;
                var path;
                board.on("change", function () { // change triggers when rolled over square changes
                    getPath(null, player);
                });

                function getPath(go, player) { // called from change (mouseover) and from tap
                    AI.setGrid(board.data);
                    AI.cancelPath(pathID); // cancel any previous path and ticker
                    if (ticker)
                        Ticker.remove(ticker);
                    if (!board.currentTile) {
                        board.clearPath();
                        path = null;
                        return;
                    }
                    // get a path from the player to the currentTile (selected or highlighted tile)
                    pathID = AI.findPath(
                            player.boardCol,
                            player.boardRow,
                            board.currentTile.boardCol,
                            board.currentTile.boardRow,
                            function (thePath) { // the callback function when path is found
                                path = thePath;
                                Ticker.remove(ticker);
                                board.showPath(path);
                                if (go) {
                                    alert("GO " + path);
                                    path = null;
                                }
                            }
                    );
                    // must calculate the path in a Ticker
                    ticker = Ticker.add(function () {
                        AI.calculate();
                    });
                }


                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                // COLLECTING AND SCORING
                // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

                begin();

                new Sprite(asset("img/logoul.png")).center().loc(20, 20);
                new Sprite(asset("game/interfaz/ciudad.png")).pos(0, 0, LEFT, BOTTOM, stage);
                var rectangleBottom = new Rectangle(stage.width, 65, "#666666").pos(0, 0, RIGHT, BOTTOM, stage);

                const input = new TextInput({
                    placeholder: "Hablar...",
                    shadowColor: -1,
                    maxLength: 250,
                    width: 600
                }).sca(0.7).pos(20, 0, LEFT, CENTER, rectangleBottom);

                new Button({
                    label: "HABLAR",
                    group: "shading"
                }).loc(650, 703).tap(function () {
                    pane.show();
                    if (input.text == "") {
                        MostrarError("Debes escribir algo.");
                    } else {
                        hablar(username, input.text);
                        socket.setProperties({username: username, decir: input.text, accion: 'hablar'});
                        input.text = "";
                    }
                });


                const pane = new Pane({width: 600, height: 450, modal: false, displayClose: true, draggable: true});
                const cancel = new Button(220, 100, "CERRAR", red).sca(0.3).center(pane).mov(-130, 190);
                const confirm = new Button(220, 100, "CONFIRMAR", green).sca(0.3).center(pane).mov(130, 190);
                new Label("Mi inventario", null, null, black).center(pane).mov(20, -200);
                console.error(pane);
                cancel.on("click", () => {
                    pane.hide();
                });
                confirm.on("click", () => {
                    zgo("http://zimjs.com")
                });




                stage.update(); // this is needed to show any changes

            }); // end of ready

            function hablar(usr, texto) {
                var messages = zid("messages");
                var current = messages.innerHTML;
                messages.innerHTML = current + usr + ": " + texto + "<br>"; // just so not always reading at the very bottom
                messages.scrollTop = messages.scrollHeight;
                messages.style.paddingBottom = "40px";
            }

            function MostrarError(txt) {
                const errorLabel = new Label(txt, null, null, "white");
                var error = new Pane(400, 100, errorLabel, "red");
                error.sca(1.5).show();
            }
        </script>


    </head>

    <body>
        <!-- canvas with id="myCanvas" is made by zim Frame -->
        <div id="messages" style="display: none;"></div>
    </body>
</html>
