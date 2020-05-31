<?php

echo "<pre>".print_r($_REQUEST, true)."</pre>";
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
        <input type="text" id="urbaloca_username" value="<?=$user;?>">
        <input type="text" id="mix">
        <input type="text" id="miy">
    </body>
</html>