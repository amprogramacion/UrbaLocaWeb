<?php
session_start();
include("autoload.php");
if (empty($_SESSION['usuario'])) {
    die("No has iniciado sesión.");
}