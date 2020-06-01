<?php
$user = empty($_GET['user']) ? "escavo" : $_GET['user'];
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php
        include("meta_game.php");
        ?>
    </head>
    <body style="height: 98vh; padding: 0px; margin: 0px;">

        <div style="border: 2px solid red; height: 90%;">
            <div id="idl_websocket_status" class="label label-default">Espera...</div>
            <input type="hidden" id="urbaloca_username" value="<?= $user; ?>">
            <input type="hidden" id="mix">
            <input type="hidden" id="miy">
            <input type="hidden" id="charx">
            <input type="hidden" id="chary">
            <?php
            include("navegador.php");
            ?>
        </div>
        <?php
        include("footer.php");
        ?>
    </body>
</html>