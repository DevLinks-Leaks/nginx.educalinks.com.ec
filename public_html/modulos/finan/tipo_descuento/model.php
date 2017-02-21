<?php
session_start();
require_once('../../../core/db_abstract_model.php');

class DescuentosTipo extends DBAbstractModel{
    #propiedades
    protected $desc_codigo;
    public $desc_descripcion;
    public $desc_porcentaje;
    public $desc_estado;
    public $desc_usuarioCreacion;
    public $desc_fechaCreacion;

	public function get_all($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaDescuento_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Descuento encontrados";
        }else{
            $this->mensaje="Descuento no encontrados";
        }
    } 
	public function getDscto_selectFormat($busq=""){
        $busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaDescuento_busq";
        $this->executeSPConsulta();

        if (count($this->rows)<=0){
            $this->mensaje="No existen descuentos en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'Seleccione ..',
                                   3 => ''));
        }else{
            $rol = array();

            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'Seleccione ..',
                                   3 => ''));
            foreach($this->rows as $dsctos){
                array_push($rol, array_values($dsctos));
            }

            $this->rows = $rol;
            unset($rol);
        }
    }
    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaDescuento_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Descuento encontrado";
        }else{
            $this->mensaje="Descuento no encontrado";
        }
    }

    public function set ($data=array()){
        if (array_key_exists('desc_descripcion',$data) && array_key_exists('desc_porcentaje',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($desc_descripcion, $desc_porcentaje, $_SESSION['usua_codigo'],$prepago,$prontopago);
            $this->sp = "str_consultaDescuento_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Descuento agregado exitosamente";
            }else{
                $this->mensaje="No se ha agregado el Descuento";
            }
        }else{
            $this->mensaje="No se ha agregado el Descuento - Faltan campos importantes.";
        }
    }

    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        $this->parametros = array($desc_codigo,$desc_porcentaje,$desc_descripcion,$prepago,$prontopago);
        print_r($this->parametros);
        $this->sp = "str_consultaDescuento_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Descuento actualizado exitosamente";
        }else{
            $this->mensaje="Descuento no actualizado";
        }
    }

    public function delete($codigo='') {
        $this->parametros = array($codigo);
        $this->sp = "str_consultaDescuento_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Descuento eliminado exitosamente";
        }else{
            $this->mensaje="No se ha eliminado el Descuento";
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