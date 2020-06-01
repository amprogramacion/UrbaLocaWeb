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
        <div id="idl_websocket_status">Espera...</div>
        <input type="hidden" id="urbaloca_username" value="<?= $user; ?>">
        <input type="hidden" id="mix">
        <input type="hidden" id="miy">
        <input type="hidden" id="charx">
        <input type="hidden" id="chary">
        <?php
        include("navegador.php");
        ?>
        <div id="footer">
            <div class="row">
                <div class="col-md-1">
                    <a href="javascript:void(0);">SALAS</a>
                </div>
                
            </div>
        </div>
    </body>
</html>