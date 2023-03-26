<?php
include("controller.php");
?>
<div class="row" style="background-color: #F9FBE6; text-align: center;">
    <br><br><br>
    <h2>¡Bienvenid@ <?=$_SESSION['username'];?>!</h2>
    <br>
</div>

<div class="row" style="text-align: center; padding: 40px;">
    <h1>¡Ya ha salido la versión Beta de UrbaLoca 2023!</h1>
    <p>Entra ahora!</p>
    <a href="/game" class="btn btn-primary btn-lg">JUGAR AHORA</a>
    <br><br><br>
    
    <a href="/borrar-cuenta" class="btn btn-danger" onclick="javascript:seguro(this.href);return false;">Deseo borrar mi cuenta</a>
</div>