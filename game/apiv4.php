<?php
include("../controller.php");
switch($_REQUEST['accion']) {
    case "getInventario":
        $inventario = Inventario::GetInventario($_SESSION['id']);
        break;
}
