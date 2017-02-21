<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
$json_enfermedades[0] = array("id"  => "tablaid1","name" => "tabla 1");
$json_enfermedades[1] = array("id"  => "tablaid2","name" => "tabla 2");
$json_enfermedades[2] = array("id"  => "tablaid3","name" => "tabla 3");
$json_enfermedades[3] = array("id"  => "tablaid4","name" => "tabla 4");
echo json_encode ($json_enfermedades);*/

$json_medicamentos=array();

include("clases/medicamentos.php");
$medicamentos_json = new Medicamentos();
$medicamentos_json->get_all_medicamentos();
$i=0;
foreach($medicamentos_json->rows as $medicamento_json){
    $json_medicamentos[$i] = array("id"  => "".$medicamento_json['med_codigo']."","name" => $medicamento_json['med_descripcion']);
    $i++;
}
echo json_encode ($json_medicamentos);