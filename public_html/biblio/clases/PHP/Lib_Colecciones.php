<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Consultas_Estudiantes
 *
 * @author Gustavo
 */
session_start();
include('../framework/db_abstract.php');
include('file:///X|/framework/db_abstract.php');

class Colecciones extends DB_Abstract {
    //put your code here
    public $libr_cole_codi;
	
 
	
	public function lib_cole_view($busq=""){
        $this->parametros = array();
        $this->sp = "lib_cole_view";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Colecciones encontrados";
            $this->cant_colecciones=count($this->rows);
        }else{
            $this->mensaje="Colecciones  no encontrados";
            $this->cant_colecciones=0;
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
