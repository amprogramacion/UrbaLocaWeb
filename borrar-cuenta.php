<?php
include("controller.php");
?>
<div class="row" style="background-color: red; color: white; text-align: center;">
    <br><br><br>
    <h2>¡VAS A BORRAR TU CUENTA DE URBALOCA, <?=$_SESSION['username'];?>!</h2>
    <br>
</div>

<div class="row" style="text-align: center; padding: 40px;">
    <h1>¡LAMENTAMOS QUE HAYAS DECIDIDO IRTE!</h1>
    <p>Lamentamos que hayas decidido irte, <?=$_SESSION['username'];?>, pero la nueva LOPD nos obliga a dejarte volar.</p>
    <p>Siempre que lo desees puedes volver a registrarte en UrbaLoca. Sólo una cosa más: Confirma la eliminación de tu cuenta haciendo click en el botón que se encuentra más abajo.</p>
    <br><br><br>
    
    <a href="/borrar-cuenta-confirm" class="btn btn-danger" onclick="javascript:seguro(this.href);return false;">Confirmo que deseo borrar mi cuenta y todos mis datos en UrbaLoca</a>
</div>