<?php
if ($_COOKIE['aviso'] == "yes" || $_SESSION['aviso'] == "yes") {
    $display = "none";
} else {
    $display = "block";
}
?>
<div class="footer navbar-fixed-bottom cookies-alert-window" id="avisocookies" style="display: <?=$display;?>;">
    <div class="col-md-10">
        Utilizamos cookies propias y de terceros para obtener datos estadísticos de la navegación de nuestros usuarios y mejorar nuestros servicios. <br>Si acepta o continúa navegando, consideramos que acepta su uso. Puede cambiar la configuración u obtener más información <a href="/cookies-policy">aquí</a>
    </div>
    <div class="col-md-2 text-center">
        <a href="/aceptarcookies.php" class="btn btn-success btn-lg">Entiendo</a>
    </div>
</div>