<?php
session_start();
include("autoload.php");
if (empty($_SESSION['username'])) {
    die("No has iniciado sesión.");
}