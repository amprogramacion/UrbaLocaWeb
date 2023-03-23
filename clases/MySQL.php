<?php

class MySQL {

    public static $conexion;

    public static function query($sql, $error = false) {
      
       $mysqli = mysqli_connect("77.68.26.231", "urbaloca_user", 'Ryhl~9281', "urbaloca");
       // $mysqli = new mysqli("localhost", "ferchu", 'ferchu', "amcitaprevia_web");
        //Si no se puede conectar
        if ($mysqli->connect_errno) {
            echo "Error: Failed to make a MySQL connection, here is why: \n";
            echo "Errno: " . $mysqli->connect_errno . "\n";
            echo "Error: " . $mysqli->connect_error . "\n";
            echo "<p style='color: red;'><b>Error de conexión: " . $mysqli->connect_error . " (connect)</b></p>";
            exit;
        }

        $mysqli->set_charset("utf8mb4");

        if (!$result = $mysqli->query($sql)) {
            if ($error == false) {
                $html = "<p style='color: red;'><b>Error: una consulta SQL ha fallado:</b></p>";
                $html .= "<p>Query: <b>" . $sql . "</b></p>";
                $html .= "<p>Errno: " . $mysqli->errno . "</p>";
                $html .= "<p>Error: " . $mysqli->error . "</p>";
                $html .= "<p style='color: red;'><b>Error de conexión: " . $mysqli->connect_error . " (query)</b></p>";
                throw new Exception($html);
            } else {
                $error = array();
                $error['error'] = "<p style='color: red;'><b>Error: una consulta SQL ha fallado:</b></p>";
                $error['sql'] = $sql;
                $error['errno'] = $mysqli->errno;
                $error['error'] = $mysqli->error;
                return $error;
            }
        }
           
        

        //Si todo correcto, cierro la conexion -.- devolvemos el objeto mysqli y lo manejamos
        mysqli_close($mysqli);
        return $result;
    }

    public static function fetchAll($obj) {
        while ($ver = $obj->fetch_assoc()) {
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
