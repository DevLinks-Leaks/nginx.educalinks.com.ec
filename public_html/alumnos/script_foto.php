<?php
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'alum_upd':
		$uploadOk = 1;
		$alum_codi=$_SESSION['alum_codi'].".jpg";
		$nombre = $alum_codi;
		$ruta=$_SESSION['ruta_foto_alumno'];
		if (!file_exists($ruta))
		{	mkdir($ruta, 0777);
		}
		$target_file = $ruta.$nombre;
		// Check if image file is a actual image or fake image
	    $check = getimagesize($_FILES["alum_foto"]["tmp_name"]);
	    $imageFileType = pathinfo($_FILES["alum_foto"]["name"],PATHINFO_EXTENSION);
	    // echo basename($_FILES["alum_foto"]["name"]);
	    if($check == true or $_FILES["alum_foto"]["size"]>0) {
	        //echo "File is an image - " . $check["mime"] . ".";
	        // Check file size
			// if ($_FILES["alum_foto"]["size"] > 400000) {
			//     $mensaje .= "la imagen de alumno es muy grande. ";
			//     $uploadOk = 0;
			// }
			// Allow certain file formats
			if( strtolower($imageFileType) == "jpg" || strtolower($imageFileType) == "png" || strtolower($imageFileType) == "jpeg" ) {}else{
			    $mensaje .= "solo archivos JPG, PNG, JPEG son permitidos. ";
			    $uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				$result= json_encode(array ('state'=>'warning',
						'result'=>'Lo sentimos, tu imagen de caratula no fue subida debido a.. '.$mensaje ));
			    
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["alum_foto"]["tmp_name"], $target_file)) {
			    	$result= json_encode(array ('state'=>'success',
							'result'=>'¡La foto del alumno fue actualizada!' ));
			        
			    } else {
			    	$uploadOk=0;
			        $result= json_encode(array ('state'=>'warning',
						'result'=>'Lo sentimos, hubo un error al subir la imagen de caratula.' ));
			    }
			}
		}
		echo $result;
	break;
}
?>