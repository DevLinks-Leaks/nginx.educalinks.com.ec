<?php
require_once('../../../core/db_abstract_model.php');

class Periodo extends DBAbstractModel{
    #propiedades
    public $peri_codigo;
    public $peri_descripcion;
	public $peri_fechainicio;
	public $peri_fechafin;
	public $peri_estado;
	public $peri_estado_2;

	public function get_all()
	{   $this->parametros = array();
        $this->sp = "str_common_periodo_get_all";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="¡Exito! Periodos encontrados";
        }else{
            $this->mensaje="¡Error! Periodos no encontrados";
        }
		return $this;
    }
	public function get_all_selectFormat()
	{	$this->parametros = array();
        $this->sp = "str_common_periodo_get_all";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen categorias en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione período -',
                                   3 => '')
								);
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione período -',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	public function get_periodos_activos(){
        $this->parametros = array();
        $this->sp = "str_common_periodo_get_all_activos";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $tmp = array();
            foreach($this->rows as $periodos){
                array_push($tmp, array_values($periodos));
            }

            $this->rows = $tmp;
            unset($tmp);
        }else{
            $this->mensaje="¡Error! Periodos no encontrados";
        }
    }
	public function get_periodo_activo(){
		$this->parametros = array();
		$this->sp = "str_common_periodo_get_all_activo_single";
		$this->executeSPConsulta();
        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="¡Exito! Periodo encontrado";
        }else{
            $this->mensaje="¡Error! Periodo no encontrado";
        }
    }
    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_common_periodo_info_especifico";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="¡Exito! Periodo encontrado";
        }else{
            $this->mensaje="¡Error! Periodo no encontrado";
        }
    }
    public function set ($data=array()){
        if ( array_key_exists( 'descripcion', $data ) ){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array( $descripcion, $peri_ano, $peri_nota_max, $peri_tipo, $fechainicio, $fechafin, $usua_codigo );
            $this->sp = "str_common_periodo_set";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="¡Exito! Periodo agregado exitosamente";
            }else{
                $this->mensaje="¡Error! No se ha agregado el periodo";
            }
        }else{
            $this->mensaje="¡Error! No se ha agregado el periodo - Falta llenar descripción.";
        }
		return $this;
    }
    public function edit($data=array()) {
    if (array_key_exists('descripcion',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array( $codigo, $descripcion, $peri_ano, $peri_nota_max, $peri_tipo, $fechainicio, $fechafin, $usua_codigo );
            $this->sp = "str_common_periodo_upd";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="¡Exito! Periodo actualizado exitosamente";
            }else{
                $this->mensaje="¡Error! No se ha actualizado el periodo";
            }
        }else{
            $this->mensaje="¡Error! No se ha actualizado el periodo - Falta la descripción del mismo";
        }
		return $this;
    }
    public function delete($data=array()) {
    	foreach($data as $campo=>$valor){
    		$$campo=$valor;
    	}
        $this->parametros = array( $codigo );
        $this->sp = "str_common_periodo_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Periodo eliminado exitosamente";
        }else{
            $this->mensaje="No se ha eliminado el periodo";
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