<?php
include("../controller.php");
?>
<!-- Individual Scripts from CDN -->
<script src="https://zimjs.org/cdn/1.3.4/createjs.js"></script>
<script src="https://zimjs.org/cdn/00/zim_min.js"></script>
<script src="https://zimjs.org/cdn/2.3.0/socket.io.js"></script>
<script src="https://zimjs.org/cdn/zimserver_urls.js"></script>
<script src="https://zimjs.org/cdn/zimsocket_1.1.js"></script>

<!-- bring in EasyStar for path finding and game module for Board -->
<script src="https://d309knd7es5f10.cloudfront.net/easystar-0.4.3.min.js"></script>
<script src="https://zimjs.org/cdn/game_2.4.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
    toastr.options.preventDuplicates = true;
    var others = {};
    const assets = [
        "/game/muebles/10_1.png",
        "/img/logoul.png",
        "/game/interfaz/ciudad.png",
        "/game/interfaz/inventario.png",
        "/game/interfaz/bg_loks.png",
        "/imager/loko.png"
    ];
    const frame = new Frame(FULL, 1024, 768, "#6FB7FF", dark, assets);
    frame.on("ready", () => {
        const stage = frame.stage;
        let stageW = frame.width;
        let stageH = frame.height;
        var server = zimSocketURL;
        var app = "urbaloca";
        var room = "UrbaLocav4-alpha"; // just use the default room
        var maxPeople = null; // just use the default of 0 which means unlimited
        var fill = null; // just use the default of fill where clients leave
        var username = "<?= $_SESSION['usuario'].rand(1,1000); ?>";
        var initObj = {x: 4, y: 0, boardCol: 4, boardRow: 0, username: username};
        //prompt("Nombre de usuario:");

        // we can send an optional initial object to the server
        // this information will get sent to all the other clients in an otherjoin event

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        // PLAYER - DEFINIR EL TAMAÑO DE LA SALA Y EL JUGADOR (ME)
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        var board = new Board({
            cols: 12,
            rows: 9,
            backgroundColor: grey,
            arrows: false,
            size: 30
        });
        board.center();

        player = new Person(green, red, purple);
        playerRectangle = new Rectangle({width: 110, height: 40, color: white, corner: [10, 10, 10, 10]}).sca(0.5).center().pos(0, -30, CENTER, TOP, player);
        playerUsrLabel = new Label(username, null, null, black).pos(0, 0, CENTER, CENTER, playerRectangle);
        board.add(player, 4, 0);

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        // SOCKETS - HACEN QUE LOS LOKOS SE VEAN ENTRE SI ENTRE OTRAS COSAS
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        socket = new Socket(server, app, room, maxPeople, fill, initObj);

        socket.on("ready", function (avatars) {
            toastr.success("Conectado al servidor");
            ServerConectado();

            player.on("moving", function () {
                //socket.setProperties({x: player.x, y: player.y});
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
                    createAvatar(id, data.username, data.boardCol, data.boardRow);
                }
            }
            stage.update();

            socket.on("otherjoin", function (data) {
                if (data) {
                    createAvatar(data.id, data.username, data.boardCol, data.boardRow);
                    toastr.info(data.username + " ha entrado en la sala");
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
                stage.update();
            });

            socket.on("error", function () {
                ServerDesconectado();
                socket.disconnect();
            });
        });

        function createAvatar(id, name, x, y) {
            var personx = new zim.Person(yellow, silver, brown);
            var playerRectanglet = new Rectangle({width: 110, height: 40, color: white, corner: [10, 10, 10, 10]}).sca(0.5).center().pos(0, -30, CENTER, TOP, personx);
            var playerUsrLabelt = new Label(name, null, null, black).pos(0, 0, CENTER, CENTER, playerRectanglet);
            others[id] = personx;
            board.add(others[id], x, y);
            stage.update();
        }



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
                socket.setProperties({path: path, x: player.boardCol, y: player.boardRow, boardCol: player.boardCol, boardRow: player.boardRow, accion: 'caminar'});
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
        // HEADER - MOD TOOL, LOGO, LOKS, STATUS
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        var contenedorLoks = new Sprite(asset("/game/interfaz/bg_loks.png")).sca(0.8).center().pos(20, 20, RIGHT, TOP, stage);
        var misLoks = new Label("250", null, null, black).sca(0.8).pos(30, 27, RIGHT, TOP, contenedorLoks);

        statusConextionContainer = new Rectangle({width: 220, height: 50, color: yellow, corner: [20, 20, 20, 20]}).sca(0.8).center().pos(20, 20, CENTER, TOP, stage);
        textoStatusConexion = new Label("Conectando...", null, null, black).sca(0.8).pos(0, 0, CENTER, CENTER, statusConextionContainer);

        function ServerConectado() {
            textoStatusConexion.text = "Conectado";
            statusConextionContainer.color = green;
        }

        function ServerDesconectado() {
            textoStatusConexion.text = "No Conectado";
            statusConextionContainer.color = red;
        }
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        // FOOTER
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        new Sprite(asset("/img/logoul.png")).center().loc(20, 20);
        var barraInferior = new Sprite(asset("/game/interfaz/ciudad.png")).pos(0, 0, LEFT, BOTTOM, stage);
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
        }).pos(-210, 0, RIGHT, CENTER, input).tap(function () {
            pane.show();
            if (input.text == "") {
                MostrarError("Debes escribir algo.");
            } else {
                hablar(username, input.text);
                socket.setProperties({username: username, decir: input.text, accion: 'hablar'});
                input.text = "";
            }
        });

        var inventarioBtn = new Sprite(asset("/game/interfaz/inventario.png")).sca(0.6).pos(25, 18, RIGHT, BOTTOM, barraInferior);
        new Label("Mi inventario", null, null, white).sca(0.3).pos(25, 5, RIGHT, BOTTOM, inventarioBtn);
        //new Circle(20, grey).pos(70, 10, RIGHT, BOTTOM, barraInferior);
        //new Circle(20, grey).pos(120, 10, RIGHT, BOTTOM, barraInferior);


        inventarioBtn.on("click", function () {
            MostrarInventario();
            stage.update();
        });

        function MostrarInventario() {
            var btnMover = new Button({label: "Mover"}).sca(0.4);
            var inventarioPanel = new Panel({titleBar: "INVENTARIO", draggable: true, width: 480, height: 340, spacingV: 25, spacingH: 10, close: true}).center();
            var btnMover = new Button({label: "Mover"}).sca(0.4).pos(10, 10, RIGHT, BOTTOM, inventarioPanel);
        }


        function MostrarInfoMueble(id_mueble, nombre, desc) {
            var informacionContainer = new Rectangle(190, 200, "#666666").pos(20, 85, RIGHT, BOTTOM, stage);
            var btnMover = new Button({label: "Mover"}).sca(0.4).pos(10, 10, RIGHT, BOTTOM, informacionContainer);
            var btnGirar = new Button({label: "Girar"}).sca(0.4).pos(10, 10, LEFT, BOTTOM, informacionContainer);
            var btnRecoger = new Button({label: "Recoger"}).sca(0.4).pos(10, 40, RIGHT, BOTTOM, informacionContainer);
        }

        function hablar(usr, texto) {
            var messages = zid("messages");
            var current = messages.innerHTML;
            messages.innerHTML = current + usr + ": " + texto + "<br>"; // just so not always reading at the very bottom
            messages.scrollTop = messages.scrollHeight;
            messages.style.paddingBottom = "40px";
        }

        stage.update();
    });


</script>

