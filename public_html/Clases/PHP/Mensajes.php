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
class Mensajes extends DB_Abstract{
	
    //put your code here
    Public $mens_codi;
    Public $mens_de;
    Public $mens_de_tipo;
    Public $mens_para;
	Public $mens_para_tipo;
	Public $mens_titu;
	Public $mens_fech_envi;
	Public $mens_fech_lect;
	Public $mens_esta;
	
	Public $mens_cab_codi;
	Public $mens_deta;
	
    
    public function get_mensaje($mens_codi){
        $this->parametros = array($mens_codi);
        $this->sp = "mens_info";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Mensaje No encontrados";
            $this->cant_estudiante=count($this->rows);
        }else{
            $this->mensaje="Mensaje No encontrados";
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
