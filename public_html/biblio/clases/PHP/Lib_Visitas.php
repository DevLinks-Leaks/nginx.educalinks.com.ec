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

class Visitas extends DB_Abstract {
    //put your code here
    public $visi_codi;
	
  
	
	public function lib_visi_add($usua_codi,$usua_tipo_codi,$visi_tipo_codi,$visi_fech,$visi_obse){
        $this->parametros = array($usua_codi,$usua_tipo_codi,$visi_tipo_codi,$visi_fech,$visi_obse,$_SESSION['usua_codi']);
        $this->sp = "lib_visi_add";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="OK";
        }else{
            $this->mensaje="KO";
        }
    }
	
	public function visi_view_busq($visi_fech_ini,$visi_fech_fin,$usua_codi,$usua_tipo_codi){
        $this->parametros = array($visi_fech_ini,$visi_fech_fin,$usua_codi,$usua_tipo_codi);
        $this->sp = "lib_visi_busq";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Visitas encontrados";
            $this->cant_libros=count($this->rows);
        }else{
            $this->mensaje="Visitas dd no encontrados";
            $this->cant_libros=0;
        }
    }
	
	public function visi_tipo_view(){
        $this->parametros = array();
        $this->sp = "lib_visi_tipo_view";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Visitas encontrados";
            $this->cant_libros=count($this->rows);
        }else{
            $this->mensaje="Visitas dd no encontrados";
            $this->cant_libros=0;
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
