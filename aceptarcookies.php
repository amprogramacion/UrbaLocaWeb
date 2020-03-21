<?php
session_start();
setcookie("aviso", "yes", time()+360000, "/", "flatearth.es", 1);
$_SESSION['aviso'] = "yes";
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=/">';