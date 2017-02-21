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
include('../../../framework/db_abstract.php'); 

class Categorias extends DB_Abstract {
    //put your code here
    public $cate_codi;
	
  
	
	public function lib_cate_add($usua_codi,$usua_tipo_codi,$cate_tipo_codi,$cate_fech,$cate_obse){
        $this->parametros = array($usua_codi,$usua_tipo_codi,$cate_tipo_codi,$cate_fech,$cate_obse,$_SESSION['usua_codi']);
        $this->sp = "lib_cate_add";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="OK";
        }else{
            $this->mensaje="KO";
        }
    }
	
	public function lib_cate_view(){
        $this->parametros = array();
        $this->sp = "lib_cate_view";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Categorias encontrados";
            $this->cantidad=count($this->rows);
        }else{
            $this->mensaje="Categorias no encontradas";
            $this->cantidad=0;
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
