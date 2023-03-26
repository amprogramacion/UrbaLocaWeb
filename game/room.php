

<!-- Individual Scripts from CDN -->
<script src="https://zimjs.org/cdn/1.3.4/createjs.js"></script>
<script src="https://zimjs.org/cdn/00/zim_min.js"></script>

<!-- bring in EasyStar for path finding and game module for Board -->
<script src="https://d309knd7es5f10.cloudfront.net/easystar-0.4.3.min.js"></script>
<script src="https://zimjs.org/cdn/game_2.4.js"></script>

<script>
    const assets = ["/game/muebles/10_1.png", "/img/logoul.png", "/game/interfaz/ciudad.png", "/imager/loko.png"];
    const frame = new Frame(FULL, 1024, 768, "#6FB7FF", dark, assets);
    frame.on("ready", () => {
        const stage = frame.stage;
        let stageW = frame.width;
        let stageH = frame.height;

        var board = new Board({
            cols: 12,
            rows: 9,
            backgroundColor: grey,
            arrows: false,
            size: 30
        });
        board.center();

        player = new Person(green, red, purple);
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
                //socket.setProperties({path: path, x: player.boardCol, y: player.boardRow, boardCol: player.boardCol, boardRow: player.boardRow, accion: 'caminar'});
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
        // FOOTER
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        new Sprite(asset("/img/logoul.png")).center().loc(20, 20);
        new Sprite(asset("/game/interfaz/ciudad.png")).pos(0, 0, LEFT, BOTTOM, stage);
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

        stage.update();
    });
</script>

