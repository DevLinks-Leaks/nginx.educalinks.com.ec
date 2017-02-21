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

class libros extends DB_Abstract {
    //put your code here
    public $libr_codi;
	
    public function lib_libr_add($libr_codi_impr,$libr_titu,$libr_auto_codi,$libr_cole_codi,$libr_edit_codi,$libr_tipo_codi,$libr_isbn,$libr_issn,$libr_revi_nume,$libr_fech_publ,$libr_fech_ingr,$libr_obse,$libr_vide_dire,$libr_vide_acto,$libr_vide_inte,$libr_vide_orig,$libr_vide_dura,$libr_vide_gene,$libr_vide_resu){
        $this->parametros = array($libr_codi_impr,$libr_titu,$libr_auto_codi,$libr_cole_codi,$libr_edit_codi,$libr_tipo_codi,$libr_isbn,$libr_issn,$libr_revi_nume,$libr_fech_publ,$libr_fech_ingr,$libr_obse,$libr_vide_dire,$libr_vide_acto,$libr_vide_inte,$libr_vide_orig,$libr_vide_dura,$libr_vide_gene,$libr_vide_resu,$_SESSION['usua_codi']);
        $this->sp = "lib_libr_add";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Se ingresó correctamente el medicamento.</div>";
        }else{
            $this->mensaje="<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Ocurrió un problema al guardar el medicamento.  Por favor intente nuevamente.</div>";
        }
    }
	
	public function lib_libr_upd($libr_codi_DD,$libr_codi_impr,$libr_titu,$libr_auto_codi,$libr_cole_codi,$libr_edit_codi,$libr_tipo_codi,$libr_isbn,$libr_issn,$libr_revi_nume,$libr_fech_publ,$libr_fech_ingr,$libr_obse,$libr_vide_dire,$libr_vide_acto,$libr_vide_inte,$libr_vide_orig,$libr_vide_dura,$libr_vide_gene,$libr_vide_resu){
        $this->parametros = array($libr_codi_DD,$libr_codi_impr,$libr_titu,$libr_auto_codi,$libr_cole_codi,$libr_edit_codi,$libr_tipo_codi,$libr_isbn,$libr_issn,$libr_revi_nume,$libr_fech_publ,$libr_fech_ingr,$libr_obse,$libr_vide_dire,$libr_vide_acto,$libr_vide_inte,$libr_vide_orig,$libr_vide_dura,$libr_vide_gene,$libr_vide_resu,$_SESSION['usua_codi']);
        $this->sp = "lib_libr_upd";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Se ingresó correctamente el medicamento.</div>";
        }else{
            $this->mensaje="<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Ocurrió un problema al guardar el medicamento.  Por favor intente nuevamente.</div>";
        }
    }
	
	public function libr_view($busq=""){
        $this->parametros = array();
        $this->sp = "lib_libr_view";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Estudiantes encontrados";
            $this->cant_libros=count($this->rows);
        }else{
            $this->mensaje="Estudiantes no encontrados";
            $this->cant_libros=0;
        }
    }
	
	public function libr_ejem_view($busq=""){
        $this->parametros = array();
        $this->sp = "lib_libr_ejem_view";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Libros encontrados";
            $this->cant_libros=count($this->rows);
        }else{
            $this->mensaje="Libros no encontrados";
            $this->cant_libros=0;
        }
    }
    
	public function libr_ejem_view_libr($libr_codi=""){
        $this->parametros = array($libr_codi);
        $this->sp = "lib_libr_ejem_view_libr";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Libros encontrados";
            $this->cant_libros=count($this->rows);
        }else{
            $this->mensaje="Libros no encontrados";
            $this->cant_libros=0;
        }
    }
	
	
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
    # Método constructor
    function __construct() {
        $this->peri_codi = $_SESSION['peri_codi'];
    }
    # Método destructor del objeto
    function __destruct() {
        unset($this);
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
	
}
