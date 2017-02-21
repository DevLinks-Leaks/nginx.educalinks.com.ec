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
include('../../framework/db_abstract.php'); 
include('../../../framework/db_abstract.php'); 

class Prestamos extends DB_Abstract {
    //put your code here
    public $pres_codi;
	
 
	
	public function lib_pres_view(){
        $this->parametros = array();
        $this->sp = "lib_pres_view";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Prestamos encontrados";
            $this->cant_libros=count($this->rows);
        }else{
            $this->mensaje="Prestamos no encontrados";
            $this->cant_libros=0;
        }
    }
	
	public function lib_pres_add($usua_codi,$usua_tipo_codi,$libr_ejem_codi,$pres_fech_inic,$pres_obse_inic){
        $this->parametros = array($usua_codi,$usua_tipo_codi,$libr_ejem_codi,$pres_fech_inic,$pres_obse_inic,$_SESSION['usua_codi']);
        $this->sp = "lib_pres_add";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="ddddd";
        }else{
            $this->mensaje="KO";
        }
    }
	
	public function lib_pres_entr($pres_codi,$pres_fech_entr){
        $this->parametros = array($pres_codi,$pres_fech_entr,$_SESSION['usua_codi']);
        $this->sp = "lib_pres_entr";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="OK";
        }else{
            $this->mensaje="KO";
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
