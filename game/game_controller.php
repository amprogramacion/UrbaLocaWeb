<?php
if(!function_exists("__autoload")) {
    function __autoload($clase) {
        $file = $_SERVER['DOCUMENT_ROOT']."/clases/".$clase.".php";
        if(file_exists($file)) {
            include($file);
        }
    }
}
