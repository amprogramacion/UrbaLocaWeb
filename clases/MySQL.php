<?php

class MySQL {

    public static $conexion;

    public static function query($sql) {
        if (empty(self::$conexion)) {
            $mysqli = mysqli_connect("localhost", "urbaloca_user", 'Ryhl~9281', "urbaloca");
            if (mysqli_connect_errno($mysqli)) {
                echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
            }
            self::$conexion = $mysqli;
        }
        self::$conexion->set_charset("utf8mb4");
        $resultado = mysqli_query(self::$conexion, $sql);
        return $resultado;
    }
    
    public static function fetchAll($obj) {
        while($ver = $obj->fetch_assoc()) {
            $res[] = $ver;
        }
        return $res;
    }
    
    public static function fetch($obj) {
        $ver = $obj->fetch_assoc();
        return $ver;
    }

    public static function rowCount($obj) {
        return $obj->num_rows;
    }
}
