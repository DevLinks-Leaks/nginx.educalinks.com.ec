<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
include_once('../../framework/db_abstract.php');
include_once('../framework/db_abstract.php');
class Medicamentos extends DB_Abstract{
    //put your code here
    Protected $med_codigo;
    Public $med_descripcion;
    Public $med_estado;
    Public $med_stock;
    Public $pres_codigo;
    Public $pres_descripcion;
    Public $pres_estado;
    Public $pres_baja_automatica;
    
    
    public function get_all_medicamentos(){
        $this->parametros = array();
        $this->sp = "med_medicamentos_all";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Medicamentos encontrados";
        }else{
            $this->mensaje="Medicamentos no encontrados";
        }
    }
	public function get_all_kardex_medicamento($med_codigo,$fecha_ini_ymd,$fecha_fin_ymd){
		$this->parametros = array($med_codigo,$fecha_ini_ymd,$fecha_fin_ymd);
        $this->sp = "med_medicamentos_kardex";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Movimientos encontrados";
        }else{
            $this->mensaje="Movimientos no encontrados";
        }
	}
    public function ingresa_medicamento($med_codigo,$med_descripcion,$med_stock,$pres_codigo){
        $this->parametros = array($med_codigo,$med_descripcion,$med_stock,$pres_codigo,$_SESSION['usua_codi']);
        $this->sp = "med_medicamentos_ingresa";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Se ingresó correctamente el medicamento.</div>";
        }else{
            $this->mensaje="<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Ocurrió un problema al guardar el medicamento.  Por favor intente nuevamente.</div>";
        }
    }
    public function edit_medicamentos($med_codigo,$med_descripcion){
        $this->parametros = array($med_codigo,$med_descripcion);
        $this->sp = "med_medicamentos_edit";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="Medicamento modificado";
        }else{
            $this->mensaje="Medicamento no modificado";
        }
    }
    public function egreso_medicamentos($med_codigo,$med_stock){
        $this->parametros = array($med_codigo,$med_stock,$_SESSION['usua_codi']);
        $this->sp = "med_medicamentos_egreso";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="Medicamento disminuido";
        }else{
            $this->mensaje="Medicamento no disminuido";
        }
    }
    public function delete_medicamentos($med_codigo){
        $this->parametros = array($med_codigo);
        $this->sp = "med_medicamentos_delete";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="Medicamento eliminado";
        }else{
            $this->mensaje="No se eliminó el medicamento";
        }
    }
    public function get_medicamento_info($med_codigo){
        $this->parametros = array($med_codigo);
        $this->sp = "med_medicamentos_info";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Medicamento encontrado";
        }else{
            $this->mensaje="No se encontró el medicamento";
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
