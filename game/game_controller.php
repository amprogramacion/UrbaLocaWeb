<?php
echo "<pre>".print_r($_SERVER['DOCUMENT_ROOT'], true)."</pre>";
if(!function_exists("__autoload")) {
    function __autoload($clase) {
        $file = $_SERVER['DOCUMENT_ROOT']."/clases/".$clase.".php";
        if(file_exists($file)) {
            include($file);
        }
    }
}
