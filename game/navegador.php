<?php
include("game_controller.php");
$salas = Rooms::GetRooms();
?>
<div class="window window-blue draggable">
    <div class="window-header drag-header">NAVEGADOR DE SALAS</div>
    <div class="window-body">
        <?php
        if(is_array($salas)) {
            foreach($salas as $room) {
                echo '<div data-id="'.$room['id'].'" class="room-itemlist">'.$room['nombre'].'</div>';
            }
        }
        ?>
    </div>
</div>
<script>
    $(document).ready(function() {
       $( ".draggable" ).draggable({ containment: "body", scroll: false, handle: ".drag-header" });
    });
</script>