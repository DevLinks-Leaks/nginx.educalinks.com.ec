<?php
session_start();
include("../../framework/funciones.php");
session_activa();
$_SESSION['timeout'] = time();
if (($_SESSION['timeout'] + 25 * 60) < time()) {header("Location: ../index.php");}

if(isset($_POST['option'])){$option=$_POST['option'];}else{$option="";}
switch ($option){
    case "busq_profesores_load":
        include("../HTML/busq_profesores.php");
        break;
    default:
        break;
}