<?php
if (!empty($_SESSION['username'])) {
    die("Ya has iniciado sesión.");
}
?>
<br><br><br><br>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 fondokekos2" style="padding: 40px;">
        ¡Bienvenid@ a UrbaLoca! Inicia sesión o <a href="/registro" style="font-weight: bold; color: #e7eafc;">regístrate</a> si no tienes una cuenta:<br><br>

        <div class="col-md-3"></div>
        <div class="col-md-6">
            <?php
            if(isset($_POST['enviar'])) {
                Users::Login($_POST);
            }
            ?>
            <form method="POST">
                <table class="table">
                    <tr>
                        <td>Usuario</td>
                        <td><input type="text" name="user" placeholder="Tu usuario" class="form-control" value="<?=$_GET['u'];?>"></td>
                    </tr>
                    <tr>
                        <td>Contraseña</td>
                        <td><input type="password" name="pass" placeholder="Contraseña" class="form-control"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="enviar" value="Entrar" class="btn btn-success"></td>
                    </tr>
                </table>
            </form>
            <a href="/recordar" style="font-weight: bold; color: #e7eafc; text-align: center;">¿Has olvidado la contraseña o el usuario?</a>
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