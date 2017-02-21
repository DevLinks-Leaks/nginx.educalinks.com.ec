<?php
session_start();
require_once('../../../core/db_abstract_model.php');

class CajaCierre extends DBAbstractModel{
    #propiedades
    protected $caja_cier_codigo;
    public $caja_cier_fecha;
    public $usua_codi;
    public $caja_cier_fechaApertura;
	public $caja_cier_fechaCierre;
	public $caja_cier_estado;
	public $caja_cier_recaudacion;

	public function get_all_cajas(){
        $this->parametros = array($_SESSION['usua_codigo']);
        $this->sp = "str_consultaCajaCierre_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Categorias encontrados";
        }else{
            $this->mensaje="Categorias no encontrados";
        }
    }
	public function get_caja_cierre_items($caja_cier_codigo=""){
        $this->parametros = array($caja_cier_codigo);
        $this->sp = "str_consultaCajaCierre_rep_items";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Transacciones encontradas";
        }else{
            $this->mensaje="No existen transacciones realizadas";
        }
    }
	public function get_caja_cierre_fp($caja_cier_codigo=""){
        $this->parametros = array($caja_cier_codigo);
        $this->sp = "str_consultaCajaCierre_rep_formaPago";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Transacciones encontradas";
        }else{
            $this->mensaje="No existen transacciones realizadas";
        }
    }
	public function get_caja_cierre_nc($caja_cier_codigo="", $alum_codi='%', $fecha_ini='%', $fecha_fin='%'){
		if ($alum_codi==0) $alum_codi='%';
		if ($fecha_ini==0) $fecha_ini='%';
		if ($fecha_fin==0) $fecha_fin='%';
        $this->parametros = array($caja_cier_codigo, $alum_codi, $fecha_ini, $fecha_fin);
        $this->sp = "str_consultaCajaCierre_rep_notaCredito";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Registro(s) encontrado(s)";
        }else{
            $this->mensaje="Registro(s) NO encontrado(s)";
        }
    }
    public function get_selectFormat($busq=""){
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
            // Agregar la opcion de ninguna categoria padre
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'NINGUNA',
                                   2 => 'SIN CATEGORIA PADRE',
                                   3 => ''));
            array_push($rol, array());

            $this->rows = $rol;
            unset($rol);
        }
    }

    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaCategoria_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Categoria encontrada";
        }else{
            $this->mensaje="Categoria no encontrada";
        }
    }

    public function set ($data=array()){
        if (array_key_exists('nombre',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($nombre, $descripcion, $categoriaPadre, $codigoUsuario);
            $this->sp = "str_consultaCategoria_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Categoria agregada exitosamente";
            }else{
                $this->mensaje="No se ha agregado la categoria";
            }
        }else{
            $this->mensaje="No se ha agregado la categoria - Falta el nombre de la misma";
        }
    }

    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($codigo, $nombre, $descripcion, $categoriaPadre);
        //print_r($this->parametros);
        $this->sp = "str_consultaCategoria_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Categoria actualizada exitosamente";
        }else{
            $this->mensaje="Categoria no actualizada";
        }
    }

    public function close($codigo='',$usua_cierre='') {
        $this->parametros = array($usua_cierre,$codigo);
        $this->sp = "str_consultaCajaCierre_close";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Caja cerrada exitosamente";
        }else{
            $this->mensaje="No se ha cerrado la caja";
        }
    }
	public function reopen($codigo='',$usua_cierre='') {
        $this->parametros = array($usua_cierre,$codigo);
        $this->sp = "str_consultaCajaCierre_reopen";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Caja reabierta exitosamente";
        }else{
            $this->mensaje="No se ha abierto la caja";
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