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

$json_enfermedades=array();

include("clases/Enfermedades.php");
$enfermedades = new Enfermedades();
$enfermedades->get_all_enfermedades();
$i=0;
foreach($enfermedades->rows as $enfermedad){
    $json_enfermedades[$i] = array("id"  => "".$enfermedad['enfe_codigo']."","name" => $enfermedad['enfe_descripcion']);
    $i++;
}
echo json_encode ($json_enfermedades);