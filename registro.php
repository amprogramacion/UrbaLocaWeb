<?php
if (!empty($_SESSION['username'])) {
    die("Ya has iniciado sesión.");
}
?>
<br><br><br><br>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 fondokekos2" style="padding: 40px;">
        ¡Bienvenid@ a UrbaLoca! <a href="/registro" style="font-weight: bold; color: #e7eafc;">Inicia sesión</a>  o regístrate si ya tienes una cuenta:<br><br>

        <div class="col-md-3"></div>
        <div class="col-md-6">
            <?php
            if(isset($_POST['enviar'])) {
                Users::Registro($_POST);
            }
            ?>
            <form method="POST">
                <table class="table">
                    <tr>
                        <td>Usuario</td>
                        <td><input type="text" name="user" placeholder="Tu usuario" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Contraseña</td>
                        <td><input type="password" name="pass" placeholder="Contraseña" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Repetir Contraseña</td>
                        <td><input type="password" name="pass2" placeholder="Repetir Contraseña" class="form-control"></td>
                    </tr>
                     <tr>
                        <td>Email</td>
                        <td><input type="email" name="email" placeholder="Tu Email" class="form-control"></td>
                    </tr>
                     <tr>
                        <td>Repetir Email</td>
                        <td><input type="email" name="email2" placeholder="Repetir Email" class="form-control"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="enviar" value="Registrarme" class="btn btn-success"></td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="col-md-2"></div>
</div>
<br>