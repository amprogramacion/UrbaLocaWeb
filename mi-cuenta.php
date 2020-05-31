<?php
include("controller.php");
?>
<div class="row" style="background-color: #F9FBE6; text-align: center;">
    <br><br><br>
    <h2>¡Bienvenid@ <?=$_SESSION['username'];?>!</h2>
    <br>
</div>

<div class="row" style="text-align: center; padding: 40px;">
    <h1>¡LA RELEASE 1 DE URBALOCA NO HA SALIDO TODAVÍA</h1>
    <p>Pero te mantendremos informado de todas las actualizaciones...</p>
    <br><br><br>
    
    <a href="/borrar-cuenta" class="btn btn-danger" onclick="javascript:seguro(this.href);return false;">Deseo borrar mi cuenta</a>
</div>