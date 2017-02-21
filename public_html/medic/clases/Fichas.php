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
class Fichas extends DB_Abstract{
    //put your code here
    public $codigo;
    public $nombre;
    public $estado;
	public $fechaCreacion;
	public $usuaCreacion;
	public $codigo_pregunta;
    
    public function get_all_fichas_selectFormat(){
        $this->parametros = array();        
        $this->sp = "med_fichas_all";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Fichas encontradas";
        }else{
            $this->mensaje="Fichas no encontradas";
        }
    }
	public function get_all_fichas_campos($fic_codigo=""){
        $this->parametros = array($fic_codigo);        
        $this->sp = "med_fichas_campos_all";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Preguntas encontradas";
        }else{
            $this->mensaje="Preguntas no encontradas";
        }
    }
	public function get_all_fichas_campos_respuestas($fic_cam_codigo=""){
        $this->parametros = array($fic_cam_codigo);        
        $this->sp = "med_fichas_campos_respuestas_all";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Respuestas encontradas";
        }else{
            $this->mensaje="Respuestas no encontradas";
        }
    }
    public function add_ficha($fic_nombre="",$usua_codi=""){
        $this->parametros = array($fic_nombre,$usua_codi);      
        $this->sp = "med_fichas_add";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Ficha registrada con éxito";
            $this->codigo=$this->rows[0]['fic_codigo'];
        }else{
            $this->mensaje="Ocurrió un problema al registrar la ficha";
        }
    }
	public function add_ficha_campo($fic_codigo="",$fic_cam_pregunta="",$fic_cam_tipo="",$usua_codi=""){
        $this->parametros = array($fic_codigo,$fic_cam_pregunta,$fic_cam_tipo,$usua_codi);      
        $this->sp = "med_fichas_campos_add";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Pregunta registrada con éxito";
            $this->codigo_pregunta=$this->rows[0]['fic_cam_codigo'];
        }else{
            $this->mensaje="Ocurrió un problema al registrar la pregunta";
        }
    }
	public function fichas_campos_respuesta_add($fic_cam_codigo="",$fic_cam_resp_respuesta="",$usua_codi=""){
        $this->parametros = array($fic_cam_codigo,$fic_cam_resp_respuesta,$usua_codi);      
        $this->sp = "med_fichas_campos_respuestas_add";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Pregunta registrada con éxito";
            $this->codigo_pregunta=$this->rows[0]['fic_cam_codigo'];
        }else{
            $this->mensaje="Ocurrió un problema al registrar la pregunta";
        }
    }
	public function fichas_campos_respuesta_del($fic_cam_resp_codigo=""){
        $this->parametros = array($fic_cam_resp_codigo);      
        $this->sp = "med_fichas_campos_respuestas_del";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Respuesta eliminada con éxito";
        }else{
            $this->mensaje="Ocurrió un problema al eliminar la respuesta";
        }
    }
	public function del_ficha_campo($fic_cam_codigo=""){
        $this->parametros = array($fic_cam_codigo);      
        $this->sp = "med_fichas_campos_del";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Pregunta eliminada con éxito";
        }else{
            $this->mensaje="Ocurrió un problema al eliminar la pregunta";
        }
    }
	public function edi_ficha_campo($fic_cam_codigo="",$fic_cam_pregunta="",$fic_cam_tipo=""){
        $this->parametros = array($fic_cam_codigo,$fic_cam_pregunta,$fic_cam_tipo);      
        $this->sp = "med_fichas_campos_edit";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Pregunta editada con éxito";
        }else{
            $this->mensaje="Ocurrió un problema al editada la pregunta";
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
