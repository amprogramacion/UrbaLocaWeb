<?php

class Inventario extends Web {
    public static function GetInventario($user) {
        $sql = "SELECT * FROM inventario WHERE id_usuario='$user'";
        $query = self::query($sql);
        if (self::rowCount($query) >= 1) {
            return self::fetchAll($query);
        }
    }
}