<?php
if (!empty($_SESSION['username'])) {
    die("Ya has iniciado sesión.");
}
?>
<br><br><br><br>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 fondokekos2" style="padding: 40px;">
        ¡Bienvenid@ a UrbaLoca! Si has perdido la contraseña de tu cuenta, introduce tu correo electrónico y te enviaremos un enlace para restaurarla:<br><br>

        <div class="col-md-3"></div>
        <div class="col-md-6">
            <?php
            Users::RecuperarClave2($_GET['token'], $_GET['email']);
            ?>
            <a href="/entrar" style="font-weight: bold; color: #e7eafc; text-align: center;">Iniciar sesión en UrbaLoca</a>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="col-md-2"></div>
</div>
<br>
<div class="row" style="background-color: #F9FBE6; text-align: center;">
    <h2>¡Visita nuestro Foro!</h2>
    <center>
        <a href="/foro" class="btn btn-success btn-lg">Entrar al Foro de UrbaLoca</a>
    </center>
    <br>
</div>