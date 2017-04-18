<?php
session_start();
$alum_codi=$_GET['alum_codi'].".jpg";
$ruta=$_SESSION['ruta_foto_alumno'];
$nombre = $alum_codi;
if (!file_exists($ruta))
{	mkdir($ruta, 0777);
}
$full_name=$ruta.$nombre;

if (!empty($_FILES))
{	foreach ($_FILES as $key)
	{	if($key['error'] == UPLOAD_ERR_OK )
		{	$temporal = $key['tmp_name'];
			$tamano= ($key['size'] / 1000)."Kb";
			move_uploaded_file($temporal,$full_name);
		}
		else
		{	echo $key['error']."."; //Si no se cargo mostramos el error
		}
	}
}

/*Este número aleatorio es para "amagar" al navegador
para que no busqué en la caché la foto*/
$aleatorio = rand(1,2000);
if (file_exists($full_name)) 
{
	$ruta_foto_final=$full_name."?".$aleatorio;
} 
else 
{
	$ruta_foto_final=$_SESSION["foto_default"];
}
echo "<img src='$ruta_foto_final' height='200' width='150' border='1' style='border-color:#F0F0F0;' />";
?>