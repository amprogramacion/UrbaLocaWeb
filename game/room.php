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
            #footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                border-top: 2px solid black;
                padding: 20px;
            }
            .navegador {
                border: 2px solid black;
                width: 350px;
                padding: 10px;
            }
            .navegador-header {
                border: 2px solid red;
                margin-bottom: 10px;
            }
            .navegador-body {
                border: 2px solid green;
            }
        </style>
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