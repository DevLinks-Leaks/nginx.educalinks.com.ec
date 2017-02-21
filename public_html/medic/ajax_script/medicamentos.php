<?php
session_start();
include("../../framework/funciones.php");
session_activa();
$_SESSION['timeout'] = time();
if (($_SESSION['timeout'] + 25 * 60) < time()) {header("Location: ../index.php");}

if(isset($_POST['option'])){$option=$_POST['option'];}else{$option="";}
if(isset($_POST['med_codigo'])){$med_codigo=$_POST['med_codigo'];}else{$med_codigo="";}
if(isset($_POST['med_descripcion'])){$med_descripcion=$_POST['med_descripcion'];}else{$med_descripcion="";}
if(isset($_POST['med_stock'])){$med_stock=$_POST['med_stock'];}else{$med_stock="";}
switch ($option){   
    case "edit_medicamento":
        include_once("../clases/medicamentos.php");
        $medicamentos = new Medicamentos();
        $medicamentos->edit_medicamentos($med_codigo,$med_descripcion);
        $medicamentos->get_all_medicamentos();
        include_once("../medi_medicinas/tabla_medicinas.php");
        break; 
    case "egreso_medicamento":
        include_once("../clases/medicamentos.php");
        $medicamentos = new Medicamentos();
        $medicamentos->egreso_medicamentos($med_codigo,$med_stock);
        $medicamentos->get_all_medicamentos();
        include_once("../medi_medicinas/tabla_medicinas.php");
        break; 
    case "delete_medicamento":
        include_once("../clases/medicamentos.php");
        $medicamentos = new Medicamentos();
        $medicamentos->delete_medicamentos($med_codigo);
        $medicamentos->get_all_medicamentos();
        include_once("../medi_medicinas/tabla_medicinas.php");
        break; 
    case "carga_stock":
        include_once("../clases/medicamentos.php");
        $medicamentos = new Medicamentos();
        $medicamentos->get_medicamento_info($med_codigo);
        echo "<div class='input-group'>
                <span class='input-group-addon' id='stock_med_addon'>Stock:</span>
                <input type='text' class='form-control' id='stock_med' name='stock_med' placeholder='Stock' aria-describedby='stock_med_addon' value='".$medicamentos->med_stock."' readonly>
            </div>";
        break; 
    default:
        break;
}