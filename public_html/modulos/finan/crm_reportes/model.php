<?php
session_start();
require_once('../../../core/db_abstract_model.php');

class ResidenciaTipos extends DBAbstractModel{
    #propiedades
    protected $resi_tipo_codigo;
    public $resi_tipo_nombre;
    public $resi_tipo_descripcion;
    public $resi_tipo_estado;

	public function get_all($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaResiTipo_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Residencias encontradas";
        }else{
            $this->mensaje="Residencias no encontradas";
        }
    } 

    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaResiTipo_info";
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
        if (array_key_exists('resi_tipo_nombre',$data) && array_key_exists('resi_tipo_descripcion',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($resi_tipo_nombre, $resi_tipo_descripcion, $_SESSION['usua_codigo']);
            $this->sp = "str_consultaResiTipo_add";
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
        
        $this->parametros = array($resi_tipo_codigo, $resi_tipo_nombre, $resi_tipo_descripcion, $resi_tipo_estado);
        print_r($this->parametros);
        $this->sp = "str_consultaResiTipo_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Residencia actualizada exitosamente";
        }else{
            $this->mensaje="Residencia no actualizada";
        }
    }

    public function delete($codigo='') {
        $this->parametros = array($codigo);
        $this->sp = "str_consultaResiTipo_del";
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