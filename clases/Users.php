<?php

class Users extends Web {

    public static function Login($post) {
        $sql = "SELECT * FROM usuarios WHERE usuario='" . $post['user'] . "'";
        $query = self::query($sql);
        if (self::rowCount($query) >= 1) {
            $ver = self::fetch($query);
            
            if (password_verify($post['pass'], $ver['pass'])) {
                self::GenerateLoginToken($ver['usuario']);
                $_SESSION['username'] = $ver['usuario'];
                $_SESSION['loks'] = $ver['loks'];
                echo self::Redir(0, "/");
            } else {
                echo self::Alerta("danger", "Ha ocurrido un error", "El usuario o la contraseña son incorrectos.");
            }
        } else {
            echo self::Alerta("danger", "Ha ocurrido un error", "El usuario o la contraseña son incorrectos.");
        }
    }

    public static function GenerateLoginToken($username) {
        $logintoken = sha1(strtotime("now") . rand(100000, 999999));
        $sql = "UPDATE usuarios SET logintoken='$logintoken' WHERE usuario='$username'";
        self::query($sql);
    }

    public static function BorrarCuenta($username) {
        $sql = "DELETE FROM usuarios WHERE usuario='$username'";
        self::query($sql);
    }

    public static function InfoUser($user) {
        $sql = "SELECT * FROM usuarios WHERE usuario='$user'";
        $query = self::query($sql);
        if (self::rowCount($query) >= 1) {
            return self::fetch($query);
        }
    }

    public static function InfoUserByEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email='$email'";
        $query = self::query($sql);
        if (self::rowCount($query) >= 1) {
            return self::fetch($query);
        }
    }

    public static function Registro($post) {
        //Verificar si el nombre de usuario esta disponible
        $checkuser = self::InfoUser($post['user']);
        if (is_array($checkuser)) {
            echo self::Alerta("danger", "Usuario no disponible", "El nombre de usuario que has elegido ya está reservado. Elige otro.");
        } else {
            //Comprobar si la clave coincide
            if ($post['pass'] != $post['pass2']) {
                echo self::Alerta("danger", "La contraseña no coincide", "La contraseña no coincide.");
            } else {
                if ($post['email'] != $post['email2']) {
                    echo self::Alerta("danger", "El email no coincide", "El email proporcionado no coincide.");
                } else {
                    //Comprobar si el email esta registrado
                    $checkemail = self::InfoUserByEmail($post['email']);
                    if (is_array($checkemail)) {
                        echo self::Alerta("danger", "Ya tienes una cuenta", "El email que has elegido ya está registrado. ¿Tienes una cuenta?. <a href='/recuperar'>Recupera la contraseña</a>");
                    } else {
                        //Todo correcto, se registra al usuario
                        $password_hash = password_hash($post['pass'], PASSWORD_DEFAULT);
                        $logintoken = sha1(strtotime("now") . rand(111, 999));
                        $sql = "INSERT INTO usuarios (usuario, pass, logintoken, loks, email, timestamp_registro) 
                               VALUES ('" . $post['user'] . "', '$password_hash', '$logintoken', '0', '" . $post['email'] . "', NOW())";
                        self::query($sql);
                        self::SendEmail($post['email'], "[URBALOCA] Registro en UrbaLoca Correcto", "Gracias por registrarte en UrbaLoca. Te mantendremos informado de todas las novedades.");

                        echo self::Alerta("success", "Registro correcto!", "Gracias por registrarte en UrbaLoca. Ya puedes iniciar sesión.");
                        echo self::Redir(3, "/entrar&u=" . $post['user']);
                    }
                }
            }
        }
    }

    function RecuperarClave($post) {
        $email = $post['email'];
        $checkemail = self::InfoUserByEmail($email);
        if (!is_array($checkemail)) {
            echo self::Alerta("danger", "El email no existe", "No parece que estés registrad@ en UrbaLoca. ¿Quieres una cuenta?. <a href='/registro'>Regístrate</a>");
        } else {
            //token
            $token = sha1(strtotime("now") . rand(111, 999));
            $sql = "UPDATE usuarios SET token='$token' WHERE email='$email'";
            self::query($sql);
            self::SendEmail($email, "[URBALOCA] Solicitud de clave de acceso", "Hola,<br>Recientemente nos has solicitado una clave.<br><br>Haz click aqui para generar una nueva clave:<br> <a href='http://urbaloca.es/recordar2&token=$token&email=$email'>http://urbaloca.es/recordar2&token=$token&email=$email</a><br><br>No respondas a este correo, se ha generado autom&aacute;ticamente.");
            echo self::Alerta("success", "Revisa tu email", "Te hemos enviado un email con un enlace para recuperar tu contraseña.");
            echo self::Redir(3, "/");
        }
    }

    public static function RecuperarClave2($token, $email) {
        $checkemail = self::InfoUserByEmail($email);
        if (!is_array($checkemail)) {
            echo self::Alerta("danger", "No se puede continuar", "No podemos recuperar tu contraseña.");
        } else {
            if ($token != $checkemail['token']) {
                echo self::Alerta("danger", "No se puede continuar", "No podemos recuperar tu contraseña.");
            } else {
                $nuevaclave = rand(100000, 999999);
                $hash = password_hash($nuevaclave, PASSWORD_DEFAULT);
                $sql = "UPDATE usuarios SET pass='$hash', token=NULL WHERE email='$email'";
                self::query($sql);
                self::SendEmail($email, "[URBALOCA] Nueva clave de acceso", "Hola,<br>Acabamos de generar una nueva clave para tu cuenta:.<br><br>Usuario: " . $checkemail['usuario'] . "<br>Clave: $nuevaclave");
                echo self::Alerta("success", "Clave regenerada", "Te hemos enviado un email con tu nueva contraseña.");
                echo self::Redir(3, "/");
            }
        }
    }

}
