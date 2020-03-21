<?php
include("controller.php");
Users::BorrarCuenta($_SESSION['username']);
session_unset();
session_destroy();
die(header("Location: /"));