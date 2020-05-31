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
            if(isset($_POST['enviar'])) {
                Users::RecuperarClave($_POST);
            }
            ?>
            <form method="POST">
                <table class="table">
                    <tr>
                        <td>Email</td>
                        <td><input type="text" name="email" placeholder="Tu correo electrónico" class="form-control"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="enviar" value="Recuperar Contraseña" class="btn btn-success"></td>
                    </tr>
                </table>
            </form>
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