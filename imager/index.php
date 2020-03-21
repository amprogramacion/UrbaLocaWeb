<?php
include("../conectar.php");
$query = mysql_query("SELECT * FROM users WHERE nombre='".$_GET['user']."'");
if(mysql_num_rows($query)) {
$ver = mysql_fetch_array($query);
$pelo = $ver['pelo'];
$camisa = $ver['camisa'];
$pants = $ver['pants'];
$zapatos = $ver['zapatos'];
header( "Content-type: image/png" );
// Creamos las dos imágenes a utilizar
$imagen1 = imagecreatefrompng( "loko.png" );
$imagen2 = imagecreatefrompng("pelo/".$pelo.".png");
$imagen3 = imagecreatefrompng("camisa/".$camisa.".png");
$imagen4 = imagecreatefrompng("pantalones/".$pants.".png");
$imagen5 = imagecreatefrompng("zapato/".$zapatos.".png");

// Copiamos una de las imágenes sobre la otra
imagecopy( $imagen1, $imagen2, 0, 0, 0, 0, 200, 150 );
imagecopy($imagen1, $imagen4, 0, 0, 0, 0, 200, 150);
imagecopy($imagen1, $imagen3, 0, 0, 0, 0, 200, 150);
imagecopy($imagen1, $imagen5, 0, 0, 0, 0, 200, 150);

// Damos salida a la imagen final
$blanco = imagecolorallocate($imagen1, 255, 255, 255);
imagecolortransparent($imagen1, $blanco);
$png = imagepng($imagen1);
imagepng($png);

// Destruimos ambas imágenes
imagedestroy( $imagen1 );
imagedestroy( $imagen2 );
imagedestroy( $imagen3 );
imagedestroy( $imagen4 );
imagedestroy( $imagen5 );
}
?>