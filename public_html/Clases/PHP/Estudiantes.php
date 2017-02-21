<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Estudiantes
 *
 * @author Gustavo
 */
session_start();
require_once('../../framework/db_abstract.php');
class Estudiantes extends DB_Abstract{
    //put your code here
    Public $alum_codi;
    Public $alum_nomb;
    Public $alum_apel;
    Public $curs_deta;
    Public $para_deta;
    
    public function get_all_alumnos($busq=""){
        $this->parametros = array($busq,$this->peri_codi);
        $this->sp = "alum_peri_busq_matri";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Estudiantes encontrados";
            $this->cant_estudiante=count($this->rows);
        }else{
            $this->mensaje="Estudiantes no encontrados";
            $this->cant_estudiante=0;
        }
    }
    
    # Método constructor
    function __construct() {
        $this->peri_codi = $_SESSION['peri_codi'];
    }
    # Método destructor del objeto
    function __destruct() {
        unset($this);
    }
}
