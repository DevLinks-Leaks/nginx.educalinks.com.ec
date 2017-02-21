<?php


session_start();
include("../../../framework/funciones.php");
session_activa();

$_SESSION['timeout'] = time();
if (($_SESSION['timeout'] + 25 * 60) < time()) {header("Location: ../index.php");}


 

if(isset($_POST['usua_codi'])){	$usua_codi=$_POST['usua_codi'];}	else{$usua_codi="";}
if(isset($_POST['usua_tipo_codi'])){	$usua_tipo_codi=$_POST['usua_tipo_codi'];}	else{$usua_tipo_codi="";}
if(isset($_POST['visi_tipo_codi'])){	$visi_tipo_codi=$_POST['visi_tipo_codi'];}	else{$visi_tipo_codi="";}


if(isset($_POST['visi_fech'])){$visi_fech=$_POST['visi_fech'];$visi_fech=substr($_POST['visi_fech'], 6,4).substr($_POST['visi_fech'], 3,2).substr($_POST['visi_fech'], 0,2);}else{$visi_fech="";}


if(isset($_POST['visi_fech_ini'])){$visi_fech_ini=$_POST['visi_fech_ini'];$visi_fech_ini=substr($_POST['visi_fech_ini'], 6,4).substr($_POST['visi_fech_ini'], 3,2).substr($_POST['visi_fech_ini'], 0,2);}else{$visi_fech_ini="";}
if(isset($_POST['visi_fech_fin'])){$visi_fech_fin=$_POST['visi_fech_fin'];$visi_fech_fin=substr($_POST['visi_fech_fin'], 6,4).substr($_POST['visi_fech_fin'], 3,2).substr($_POST['visi_fech_fin'], 0,2);}else{$visi_fech_fin="";}


if(isset($_POST['visi_obse'])){	$visi_obse=$_POST['visi_obse'];}	else{$visi_obse="";} 
 


 

if(isset($_POST['option'])){$option=$_POST['option'];}else{$option="";}
switch ($option){
 
   
		
	case "visi_add":
		
		include("../../clases/PHP/Lib_Visitas.php");
		$Visitas = new Visitas();
		$Visitas->lib_visi_add($usua_codi,$usua_tipo_codi,$visi_tipo_codi,$visi_fech,$visi_obse);
	 	
		echo $usua_codi,$usua_tipo_codi,$visi_tipo_codi,$visi_fech,$visi_obse;
	 	 
		echo $Visitas->mensaje;
       
        break; 
		
	
		
		
    default:
        break;
}