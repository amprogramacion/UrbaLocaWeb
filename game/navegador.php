<?php
include("game_controller.php");
$salas = Rooms::GetRooms();
?>
<div class="window window-blue draggable navegador">
    <div class="window-header drag-header">
        <span class="window-header-text">
            NAVEGADOR DE SALAS
        </span>
        <span class="window-header-btn">
            <a href="javascript:void(0);" class="btn btn-danger btn-xs cerrar_ventana" data-id="navegador"><i class="fa fa-times"></i></a>
        </span>
    </div>
    <div class="window-body">
        <?php
        if (is_array($salas)) {
            foreach ($salas as $room) {
                echo '<div data-id="' . $room['id'] . '" class="room-itemlist">' . $room['nombre'] . '</div>';
            }
        }
        ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".draggable").draggable({containment: "#game-container", scroll: false, handle: ".drag-header"});
    });
</script>