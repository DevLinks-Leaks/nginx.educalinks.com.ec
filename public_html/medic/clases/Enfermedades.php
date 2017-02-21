<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Enfermedades
 *
 * @author Gustavo
 */
session_start();
include_once('../../framework/db_abstract.php');
include_once('../framework/db_abstract.php');
class Enfermedades  extends DB_Abstract{
    Protected $enfe_codigo;
    Public $enfe_descripcion;
    Public $enfe_estado;
    
    public function get_all_enfermedades(){
        $this->parametros = array();
        $this->sp = "med_enfermedades_all";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Enfermedades encontradas";
        }else{
            $this->mensaje="Enfermedades no encontradas";
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
