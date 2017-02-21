<?php
session_start();
include("../../framework/funciones.php");
session_activa();
$_SESSION['timeout'] = time();
if (($_SESSION['timeout'] + 25 * 60) < time()) {header("Location: ../index.php");}

if(isset($_POST['option'])){$option=$_POST['option'];}else{$option="";}
if(isset($_POST['pres_codigo'])){$pres_codigo=$_POST['pres_codigo'];}else{$pres_codigo="";}
if(isset($_POST['pres_descripcion'])){$pres_descripcion=$_POST['pres_descripcion'];}else{$pres_descripcion="";}
if(isset($_POST['pres_baja_automatica'])){$pres_baja_automatica=$_POST['pres_baja_automatica'];}else{$pres_baja_automatica="";}
switch ($option){  
    case "cambia_baja_inventario":
        include("../clases/Presentaciones.php");
        $presentaciones = new Presentaciones();
        $presentaciones->edit_presentaciones_baja_automatica($pres_codigo,$pres_baja_automatica);
        echo $presentaciones->mensaje;
        break; 
    case "edit_presentacion":
        include("../clases/Presentaciones.php");
        $presentaciones = new Presentaciones();
        $presentaciones->edit_presentaciones($pres_codigo,$pres_descripcion);
        $presentaciones->get_all_presentaciones();
        include("../medi_presentaciones/tabla_presentaciones.php");
        break; 
    case "delete_presentacion":
        include("../clases/Presentaciones.php");
        $presentaciones = new Presentaciones();
        $presentaciones->delete_presentaciones($pres_codigo);
        $presentaciones->get_all_presentaciones();
        include("../medi_presentaciones/tabla_presentaciones.php");
        break; 
    default:
        break;
}