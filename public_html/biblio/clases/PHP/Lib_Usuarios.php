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

class Usuarios extends DB_Abstract {
    //put your code here
    public $usua_codi;
	
 
	
	public function usua_all_view(){
        $this->parametros = array();
        $this->sp = "usua_all_view";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Usuarios encontrados";
            $this->cant_autores=count($this->rows);
        }else{
            $this->mensaje="Usuarios  no encontrados";
            $this->cant_autores=0;
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
