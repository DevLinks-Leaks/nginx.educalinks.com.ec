<?php
require_once('../../../core/db_abstract_model.php');

class descuentoalumnos extends DBAbstractModel{
    #propiedades
    protected $codigo;
    public $nombre;
    public $descripcion;
    public $cuentaContable;
    public $categoria;
    public $aplicaIVA;
    public $aplicaICE;
	public $estado;

	public function get_all($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaDescuentoalumnos_busq";
        $this->executeSPConsulta();
		
        if (count($this->rows)>0){
            $this->mensaje="Items encontrados";
        }else{
            $this->mensaje="Items no encontrados";
        }
    }

    public function getCategorias_selectFormat($busq=""){
        $busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaCategoria_busq";
        $this->executeSPConsulta();

        if (count($this->rows)<=0){
            $this->mensaje="No existen categorias en la BD.";
        }else{
            $rol = array();
            foreach($this->rows as $categorias){
                array_push($rol, array_values($categorias));
            }

            $this->rows = $rol;
            unset($rol);
        }
    }

    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaItem_info";
            $this->executeSPConsulta();
			
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Item encontrado";
        }else{
            $this->mensaje="Item no encontrado";
        }
    }

    public function set ($data=array()){
        if (array_key_exists('nombre',$data) && array_key_exists('categoria',$data) && array_key_exists('cuentaContable',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($nombre, $descripcion, $categoria, $cuentaContable, $aplicaIVA, $aplicaICE, $precioGeneral, $codigoUsuario,$descuento,$liquidez,$prontopago);
            $this->sp = "str_consultaItem_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Item agregado exitosamente";
            }else{
                $this->mensaje="No se ha agregado el item";
            }
        }else{
            $this->mensaje="No se ha agregado el item - Faltan campos importantes.";
        }
    }

    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($codigo, $nombre, $descripcion, $categoria, $aplicaIVA, $aplicaICE, $precioGeneral, $cuentaContable,$descuento,$liquidez,$prontopago);
        print_r($this->parametros);
        $this->sp = "str_consultaItem_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Item actualizada exitosamente";
        }else{
            $this->mensaje="Item no actualizada";
        }
    }

    public function delete($codigo='') {
        $this->parametros = array($codigo);
        $this->sp = "str_consultaDescuentoalumnos_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Item eliminado exitosamente";
        }else{
            $this->mensaje="No se ha eliminado el Item";
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