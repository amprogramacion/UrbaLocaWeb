<?php
$user = empty($_GET['user']) ? "escavo" : $_GET['user'];
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php
        include("meta_game.php");
        ?>
        <style type="text/css">
            .loko {
                border: 2px solid black;
                width: 50px;
                height: 50px;
                background-color: black;
                color: white;
                position: absolute;
            }
        </style>
    </head>
    <body style="height: 98vh;">
        <div id="idl_websocket_status">Espera...</div>
        <input type="hidden" id="urbaloca_username" value="<?=$user;?>">
        <input type="hidden" id="mix">
        <input type="hidden" id="miy">
        <input type="hidden" id="charx">
        <input type="hidden" id="chary">
    </body>
</html>