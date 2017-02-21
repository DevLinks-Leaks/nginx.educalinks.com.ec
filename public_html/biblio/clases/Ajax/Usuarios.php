<?php
session_start();
include("../../framework/funciones.php");
session_activa();
$_SESSION['timeout'] = time();
if (($_SESSION['timeout'] + 25 * 60) < time()) {header("Location: ../index.php");}

if(isset($_POST['option'])){$option=$_POST['option'];}else{$option="";}
switch ($option){
    case "busq_estudiante_load":
        include("clases/HTML/busq_usuarios.php");
        break;
    default:
        break;
}