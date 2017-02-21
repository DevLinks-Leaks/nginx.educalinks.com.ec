<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Presentaciones
 *
 * @author Gustavo
 */
session_start();
include_once('../../framework/db_abstract.php');
include_once('../framework/db_abstract.php');
class Presentaciones extends DB_Abstract{
    Protected $pres_codigo;
    Public $pres_descripcion;
    Public $pres_estado;
    Public $pres_baja_automatica;
    
    public function get_all_presentaciones(){
        $this->parametros = array();
        $this->sp = "med_presentaciones_all";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Presentaciones encontrados";
        }else{
            $this->mensaje="Presentaciones no encontrados";
        }
    }
    public function edit_presentaciones_baja_automatica($pres_codigo,$pres_baja_automatica){
        $this->parametros = array($pres_codigo,$pres_baja_automatica);
        $this->sp = "med_presentaciones_edit_baja_auto";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="Presentación modificada";
        }else{
            $this->mensaje="Presentación no modificada";
        }
    }
    public function edit_presentaciones($pres_codigo,$pres_descripcion,$pres_baja_automatica){
        $this->parametros = array($pres_codigo,$pres_descripcion,$pres_baja_automatica);
        $this->sp = "med_presentaciones_edit";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="Presentación modificada";
        }else{
            $this->mensaje="Presentación no modificada";
        }
    }
    public function delete_presentaciones($pres_codigo){
        $this->parametros = array($pres_codigo);
        $this->sp = "med_presentaciones_delete";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="Presentación eliminada";
        }else{
            $this->mensaje="No se eliminó la presentación";
        }
    }
    public function add_presentacion($pres_descripcion,$pres_baja_automatica){
        $this->parametros = array($pres_descripcion,$pres_baja_automatica);
        $this->sp = "med_presentaciones_add";
        $this->executeSPAccion();
        if (count($this->filasAfectadas)>0){
            $this->mensaje="<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Se ingresó correctamente la presentación.</div>";
        }else{
            $this->mensaje="<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Ocurrió un problema al guardar la presentación.  Por favor intente nuevamente.</div>";
        }
    }
    # Método constructor
    function __construct() {
        $this->peri_codi = $_SESSION['peri_codi'];
        $this->pres_codigo="";
        $this->pres_descripcion="";
        $this->pres_estado="";
        $this->pres_baja_automatica="";
    }
    # Método destructor del objeto
    function __destruct() {
        unset($this);
    }
}
