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

class Editoriales extends DB_Abstract {
    //put your code here
    public $edit_codi;
	
 
	
	public function edit_view($busq=""){
        $this->parametros = array();
        $this->sp = "lib_edit_view";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Editoriales encontrados";
            $this->cant_estudiante=count($this->rows);
        }else{
            $this->mensaje="Editoriales  no encontrados";
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
