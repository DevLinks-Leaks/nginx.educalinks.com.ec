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
include_once('../../framework/db_abstract.php');
include_once('../framework/db_abstract.php');
class Atenciones extends DB_Abstract{
    //put your code here
    Public $alum_codi;
    Public $curs_para_codi;
    public $aten_codigo;
    
    public function get_all_mate_alum_selectFormat($alum_codi="",$curs_para_codi=""){
        $this->parametros = array($alum_codi,$curs_para_codi);        
        $this->sp = "alum_curs_peri_mate_view";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Materias encontradas";
        }else{
            $this->mensaje="Materias no encontradas";
        }
    }
    public function get_alumno_alergias($alum_codi=""){
        $this->parametros = array($alum_codi);
        $this->sp = "med_alum_alergic";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Restricciones de medicamentos o alergias encontradas: ";
            $this->cant_estudiante=count($this->rows);
        }else{
            $this->mensaje="No contiene restricciones de medicamentos o alergias.";
            $this->cant_estudiante=0;
        }
    }
    public function add_atencion_cabecera($alum_codi="",$mate_codi="",$curs_para_codi="",$prof_codi="",$efen_codi="",$observacion="",$efen_descripcion="",$usua_tipo=0){
        $this->parametros = array($alum_codi,$mate_codi,$curs_para_codi,$prof_codi,$efen_codi,$efen_descripcion,$observacion,$usua_tipo);        
        $this->sp = "med_atenciones_cabe_add";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Atención registrada con éxito";
            $this->aten_codigo=$this->rows[0]['aten_codigo'];
        }else{
            $this->mensaje="Ocurrió un problema al registrar la atención";
        }
    }
    public function add_atencion_cabecera_personal($usua_codi="",$enfe_codi="",$observacion="",$enfe_descripcion="",$usua_tipo=""){
        $this->parametros = array($usua_codi,$enfe_codi,$enfe_descripcion,$observacion,$usua_tipo);        
        $this->sp = "med_atenciones_cabe_add_personal";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Atención registrada con éxito";
            $this->aten_codigo=$this->rows[0]['aten_codigo'];
        }else{
            $this->mensaje="Ocurrió un problema al registrar la atención";
        }
    }
    public function get_today_atenciones(){
        $this->parametros = array();        
        $this->sp = "med_atenciones_today";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Se encontraron atenciones el día de hoy";
        }else{
            $this->mensaje="No se encontraron atenciones el día de hoy";
        }
    }
	public function get_all_atenciones(){
        $this->parametros = array();        
        $this->sp = "med_atenciones_all";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Se encontraron atenciones el día de hoy";
        }else{
            $this->mensaje="No se encontraron atenciones el día de hoy";
        }
    }
	public function get_atenciones_search( $txt_fini, $txt_ffin )
	{   $this->parametros = array( $txt_fini, $txt_ffin );        
        $this->sp = "med_atenciones_search";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Se encontraron atenciones";
        }else{
            $this->mensaje="No se encontraron atenciones";
        }
    }
    public function get_atenciones_info($aten_codigo=""){
        $this->parametros = array($aten_codigo);        
        $this->sp = "med_atenciones_info";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Información de la atención";
        }else{
            $this->mensaje="No se encontraron atenciones";
        }
    }
    public function get_detalle_atencion_info($aten_codigo=""){
        $this->parametros = array($aten_codigo);        
        $this->sp = "med_atenciones_detalle_info";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Se encontraron detalles de la atención";
        }else{
            $this->mensaje="No se encontraron detalles de la atencion";
        }
    }
    public function add_atencion_detalle($aten_codigo,$med_codigo,$med_cantidad,$usua_codigo){
        $this->parametros = array($aten_codigo,$med_codigo,$med_cantidad,$usua_codigo);        
        $this->sp = "med_atenciones_deta_add";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Detalle registrado con éxito";
        }else{
            $this->mensaje="Ocurrió un problema al registrar el detalle";
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
