<?php

echo "<pre>".print_r($_REQUEST, true)."</pre>";

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php
        include("meta_game.php");
        ?>
    </head>
    <body>
        <div id="idl_websocket_status">Espera...</div>
        <input type="text" id="urbaloca_username" value="escavo">
    </body>
</html>