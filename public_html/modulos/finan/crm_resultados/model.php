<?php
session_start();
require_once('../../../core/db_abstract_model.php');

class ResultadosCRM extends DBAbstractModel{
    #propiedades
    protected $crm_resu_codigo;
    public $crm_resu_descripcion;
    public $crm_resu_estado;
    public $deta_crm_resu_descripcion;
    protected $deta_crm_resu_codigo;

    public function get_all($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaResultadoCRM_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Residencias encontradas";
        }else{
            $this->mensaje="Residencias no encontradas";
        }
    } 
    public function get_all_deta($codigo=""){
        $this->parametros = array($codigo);
        $this->sp = "str_consultaResultadoCRM_detalles";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Detalles encontrados";
        }else{
            $this->mensaje="Detalles no encontrados";
        }
    } 
    public function asign($data=array()){
        if (array_key_exists('deta_crm_resu_descripcion',$data)&&($data['deta_crm_resu_descripcion']!="")){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($crm_resu_codigo,$deta_crm_resu_descripcion,$_SESSION['usua_codigo']);
            $this->sp = "str_consultaResultadoCRM_asign";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Detalle agregado exitosamente";
            }else{
                $this->mensaje="No se ha agregado el Detalle";
            }
        }
    }
    public function del_asign($deta_crm_resu_codigo){
        foreach($data as $campo=>$valor){
            $$campo=$valor;
        }
        $this->parametros = array($deta_crm_resu_codigo);
        $this->sp = "str_consultaResultadoCRM_asign_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Detalle agregado exitosamente";
        }else{
            $this->mensaje="No se ha agregado el Detalle";
        }
    }

    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaResultadoCRM_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Residencia encontrada";
        }else{
            $this->mensaje="Residencia no encontrada";
        }
    }

    public function set ($data=array()){
        if (array_key_exists('crm_resu_descripcion',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($crm_resu_descripcion, $_SESSION['usua_codigo']);
            $this->sp = "str_consultaResultadoCRM_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Residencia agregada exitosamente";
            }else{
                $this->mensaje="No se ha agregado la Residencia";
            }
        }else{
            $this->mensaje="No se ha agregado la residencia - Faltan campos importantes.";
        }
    }

    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($crm_resu_codigo, $crm_resu_descripcion, $crm_resu_estado);
        print_r($this->parametros);
        $this->sp = "str_consultaResultadoCRM_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Residencia actualizada exitosamente";
        }else{
            $this->mensaje="Residencia no actualizada";
        }
    }

    public function delete($codigo='') {
        $this->parametros = array($codigo);
        $this->sp = "str_consultaResultadoCRM_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Residencia eliminada exitosamente";
        }else{
            $this->mensaje="No se ha eliminada el Residencia";
        }
    }

    # Método constructor
    function __construct() {
        //$this->db_name = 'URBALINKS_FINAN';
    }

    # Método destructor del objeto
    function __destruct() {
        unset($this);
    }
}
?>