<?php
session_start();

if (!empty($_GET['id'])) {
    $__id = $_GET['id'];
    if (!file_exists($__id . '.php') && !empty($__id)) {
        header("HTTP/1.0 404 Not Found");
    }
}
include("autoload.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title><?= Web::getTitle($__id); ?></title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/carrusel.css">
        <meta name="robots" value="index, follow">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="cache-control" content="no-cache,private"/>
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700,700i" rel="stylesheet">
        <link rel="shortcut icon" type="image/ico" href="favicon.ico">
        <meta charset="utf-8">
        <meta name="author" content="UrbaLoca">
        <script type="application/ld+json">
            {
            "@context" : "http://schema.org",
            "@type" : "Organization",
            "name" : "UrbaLoca",
            "url" : "http://urbaloca.es",
            "sameAs" : [
            "https://www.facebook.com/UrbaLoca-Returns-863433524035746/"
            ]
            }
        </script>
        <script src="/js/jquery.3.3.1.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        include("cookies.php");
        ?>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/"><img src="img/logo.png" alt="UrbaLoca Logo"></a>
                </div>
                <div id="navbarCollapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li<?= Web::isActive("", $__id); ?>><a href="/">Inicio</a></li>
                        <li><a href="/client-v4.php" target="_blank">Entrar a la v4</a></li>
                        <?php
                        if (empty($_SESSION['username'])) {
                            ?>
                            <li<?= Web::isActive("entrar", $__id); ?>><a href="/entrar">Entrar</a></li>
                            <li<?= Web::isActive("registro", $__id); ?>><a href="/registro">Regístrate</a></li>
                            <?php
                        } else {
                            ?>
                            <li<?= Web::isActive("mi-cuenta", $__id); ?>><a href="/mi-cuenta">Mi Perfil (<?= $_SESSION['username']; ?>)</a></li>
                            <?php
                        }
                        ?>
                        <li<?= Web::isActive("releases", $__id); ?>><a href="/releases">Descargar UrbaLoca</a></li>
                        <?php
                        if (!empty($_SESSION['username'])) {
                            ?>
                            <li<?= Web::isActive("logout", $__id); ?>><a href="/logout" onclick="javascript:seguro(this.href); return false;">Cerrar Sesión</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content-fluid">
            <?php
            $idw = $_GET['id'];
            if (substr($idw, 0, 3) == "htt" || substr($idw, 0, 3) == "www" || substr($idw, 0, 3) == "../" || $idw == "index") {
                echo "<h1>Intento de hackeo <b>repelido</b>.</h1>";
            } else {
                if (!isset($idw) || $_GET['id'] == NULL) {
                    include("index2.php");
                } else {
                    if (!file_exists($idw . '.php')) {
                        include("error404.php");
                    } else {
                        include($idw . ".php");
                    }
                }
            }
            ?>
        </div>
        <div class="footerlbn">
            <?php
            include("footer.php");
            ?>
        </div>
        <script>
            function seguro(url) {
                var pregunta = confirm("¿Seguro que deseas realizar la acción seleccionada?");
                if (pregunta === true) {
                    document.location.href = url;
                }
            }
        </script>
    </body>
</html>
