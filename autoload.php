<?php



if(!function_exists("__autoload")) {
    function __autoload($class) {
        if(file_exists("clases/".$class.".php")) {
            include("clases/$class.php");
        }
    }
}

if(!class_exists("PHPMailer")) {
    include("PHPMailer/class.phpmailer.php");
}
if(!class_exists("SMTP")) {
    include("PHPMailer/class.smtp.php");
}