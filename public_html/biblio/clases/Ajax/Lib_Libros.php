<?php


session_start();
include("../../../framework/funciones.php");
session_activa();

$_SESSION['timeout'] = time();
if (($_SESSION['timeout'] + 25 * 60) < time()) {header("Location: ../index.php");}


if(isset($_POST['libr_codi'])){			$libr_codi=$_POST['libr_codi'];}			else{$libr_codi="";}
if(isset($_POST['libr_codi_impr'])){	$libr_codi_impr=$_POST['libr_codi_impr'];}	else{$libr_codi_impr="";}
if(isset($_POST['libr_titu'])){			$libr_titu=$_POST['libr_titu'];}			else{$libr_titu="";}

if(isset($_POST['libr_auto_codi'])){	$libr_auto_codi=$_POST['libr_auto_codi'];}	else{$libr_auto_codi="";}
if(isset($_POST['libr_cole_codi'])){	$libr_cole_codi=$_POST['libr_cole_codi'];}	else{$libr_cole_codi="";}
if(isset($_POST['libr_edit_codi'])){	$libr_edit_codi=$_POST['libr_edit_codi'];}	else{$libr_edit_codi="";}
if(isset($_POST['libr_tipo_codi'])){	$libr_tipo_codi=$_POST['libr_tipo_codi'];}	else{$libr_tipo_codi="";}

if(isset($_POST['libr_isbn'])){			$libr_isbn=$_POST['libr_isbn'];}			else{$libr_isbn="";}
if(isset($_POST['libr_issn	'])){		$libr_issn	=$_POST['libr_issn	'];}		else{$libr_issn	="";}
if(isset($_POST['libr_revi_nume	'])){		$libr_revi_nume	=$_POST['libr_revi_nume	'];}		else{$libr_revi_nume	="";}

if(isset($_POST['libr_fech_publ'])){$libr_fech_publ=$_POST['libr_fech_publ'];$libr_fech_publ=substr($_POST['libr_fech_publ'], 6,4).substr($_POST['libr_fech_publ'], 3,2).substr($_POST['libr_fech_publ'], 0,2);}else{$libr_fech_publ="";}
if(isset($_POST['libr_fech_ingr'])){$libr_fech_ingr=$_POST['libr_fech_ingr'];$libr_fech_ingr=substr($_POST['libr_fech_ingr'], 6,4).substr($_POST['libr_fech_ingr'], 3,2).substr($_POST['libr_fech_ingr'], 0,2);}else{$libr_fech_ingr="";}

if(isset($_POST['libr_obse'])){			$libr_obse=$_POST['libr_obse'];}			else{$libr_obse="";} 

if(isset($_POST['libr_vide_dire'])){			$libr_vide_dire=$_POST['libr_vide_dire'];}			else{$libr_vide_dire="";} 
if(isset($_POST['libr_vide_acto'])){			$libr_vide_acto=$_POST['libr_vide_acto'];}			else{$libr_vide_acto="";} 
if(isset($_POST['libr_vide_inte'])){			$libr_vide_inte=$_POST['libr_vide_inte'];}			else{$libr_vide_inte="";} 
if(isset($_POST['libr_vide_orig'])){			$libr_vide_orig=$_POST['libr_vide_orig'];}			else{$libr_vide_orig="";} 
if(isset($_POST['libr_vide_dura'])){			$libr_vide_dura=$_POST['libr_vide_dura'];}			else{$libr_vide_dura="";} 
if(isset($_POST['libr_vide_gene'])){			$libr_vide_gene=$_POST['libr_vide_gene'];}			else{$libr_vide_gene="";} 
if(isset($_POST['libr_vide_resu'])){			$libr_vide_resu=$_POST['libr_vide_resu'];}			else{$libr_vide_resu="";} 


if(isset($_POST['usua_codi'])){	$usua_codi=$_POST['usua_codi'];}	else{$usua_codi="";}
if(isset($_POST['usua_tipo_codi'])){	$usua_tipo_codi=$_POST['usua_tipo_codi'];}	else{$usua_tipo_codi="";}
if(isset($_POST['libr_ejem_codi'])){	$libr_ejem_codi=$_POST['libr_ejem_codi'];}	else{$libr_ejem_codi="";}
if(isset($_POST['pres_fech_inic'])){	$pres_fech_inic=$_POST['pres_fech_inic'];}	else{$pres_fech_inic="";}
if(isset($_POST['pres_obse_inic'])){	$pres_obse_inic=$_POST['pres_obse_inic'];}	else{$pres_obse_inic="";}
 



include("../../clases/PHP/Lib_Libros.php");
//include("../clases/PHP/Lib_Libros.php");
include("clases/PHP/Lib_Libros.php");
 
 

if(isset($_POST['option'])){$option=$_POST['option'];}else{$option="";}
switch ($option){
    case "busq_libr_ejem_load":
        include("../HTML/Lib_libr_busq.php");
        break;
 
    case "libr_add":
		 
		
		
		$Libro = new libros();
		$Libro->lib_libr_add($libr_codi_impr,$libr_titu,$libr_auto_codi,$libr_cole_codi,$libr_edit_codi,$libr_tipo_codi,$libr_isbn,$libr_issn,$libr_revi_nume,$libr_fech_publ,$libr_fech_ingr,$libr_obse,$libr_vide_dire,$libr_vide_acto,$libr_vide_inte,$libr_vide_orig,$libr_vide_dura,$libr_vide_gene,$libr_vide_resu);
	 
		echo $Libro->libr_codi;
		
	 	$libr_codi=44;
		$target_dir =  "fotos/" ; //. $_SESSION['directorio'] . "/";
		$target_file = $target_dir . "lib_" . $libr_codi . ".jpg";
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		
		// Check if image file is a actual image or fake image
		
		//if(isset($_POST["libr_add"])) {
			$check = getimagesize($_FILES["libr_cara"]["name"]);
			if($check !== false) {
				//echo "File is an image - " . $check["mime"] . ".";
				echo $target_file;
				move_uploaded_file($_FILES['libr_cara']['name'], $target_file);
				echo 'move';
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		//}
 
     
        break; 
		
	case "libr_upd":
		
 
		$Libro = new libros();
		
		$Libro->lib_libr_upd($libr_codi,$libr_codi_impr,$libr_titu,$libr_auto_codi,$libr_cole_codi,$libr_edit_codi,$libr_tipo_codi,$libr_isbn,$libr_issn,$libr_revi_nume,$libr_fech_publ,$libr_fech_ingr,$libr_obse,$libr_vide_dire,$libr_vide_acto,$libr_vide_inte,$libr_vide_orig,$libr_vide_dura,$libr_vide_gene,$libr_vide_resu);
	 
	  	 	
		 
		$target_dir =  $_SERVER['DOCUMENT_ROOT'] . "/files/" . $_SESSION['directorio'] . "/libros/";
		$target_file = $target_dir . "lib_" . $libr_codi . ".jpg";
		$target_file_mini = $target_dir . "lib_mini_" . $libr_codi . ".jpg";
		
		
		//$uploadOk = 1;
		//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["libr_cara"]["tmp_name"]);
	 
		if($check !== false) {
			 if (move_uploaded_file($_FILES["libr_cara"]["tmp_name"], $target_file)) {
				//echo "The file " . $target_file . "  -  ". basename( $_FILES["libr_cara"]["name"]). " has been uploaded.";
				$resizeObj = new resize($target_file);
				// IMagen Principal
				$resizeObj -> resizeImage(300, 500, 'auto'); 
				$resizeObj -> saveImage($target_file, 100);
				// IMagen Mini
				$resizeObj -> resizeImage(90, 150, 'auto'); 
				$resizeObj -> saveImage($target_file_mini, 100);
				
		
			} else {
				echo "Sorry, there was an error uploading your files.";
			}
		} else {
			echo "File is not an image.";			 
		}
		
	
		        
        break; 
		
	case "lib_pres_add":
		
		include("../../clases/PHP/Lib_Prestamos.php");
		$Prestamos = new Prestamos();
		$Prestamos->lib_pres_add($usua_codi,$usua_tipo_codi,$libr_ejem_codi,$pres_fech_inic,$pres_obse_inic);
	 	
		echo $usua_codi,$usua_tipo_codi,$libr_ejem_codi,$pres_fech_inic,$pres_obse_inic;
	 	 
		echo $Prestamos->mensaje;
       
        break; 
		
		
    default:
        break;
}

