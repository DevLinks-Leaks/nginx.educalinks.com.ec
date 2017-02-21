<?php
require_once('../../../core/db_abstract_model.php');

class Precio extends DBAbstractModel{
    #propiedades
    public $producto;
    public $secuencia;
    public $fechaInicio;
    public $fechaFin;
    public $factorEconomico;
    public $valor;
	public $estado;
	public $codigoPrecio;

	public function get_all(){
        $this->rows = array();
        if($this->producto != ''){
            $this->parametros = array($this->producto);
            $this->sp = "str_consultaPrecio_busq";
            $this->executeSPConsulta();    
        }
        if (count($this->rows)>0){
            $this->mensaje="Precios encontrados";
        }else{
            $this->mensaje="Precios no encontrados";
        }
    }
    public function getGrupoEconomico_selectFormat(){
        $this->rows = array();
        $this->parametros = array();
        $this->sp = "str_consultaGrupoEconomico_cons";
        $this->executeSPConsulta();    
        if (count($this->rows)<0){
            $this->mensaje="Grupos economicos no encontrados";
            array_pop($rol);
            array_push($rol, array(0 => '-1', 
                                   1 => 'Seleccione...',
                                   3 => ''));
        }else{
            $rol = array();

            array_pop($rol);
            array_push($rol, array(0 => '-1', 
                                   1 => 'Seleccione...',
                                   3 => ''));
            foreach($this->rows as $productos){
                array_push($rol, array_values($productos));
            }

            $this->rows = $rol;
            unset($rol);   
        }
    }

    public function set ($data=array()){
		$this->codigoPrecio=0;
        if (array_key_exists('precio',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($codigoProducto, $codigoGrupoEconomico, $codigoNivelEconomico, $precio, $codigoUsuario,$cuentacontable,
									array($this->codigoPrecio, SQLSRV_PARAM_OUT));
            
            $this->sp = "str_consultaPrecio_add";
            $this->executeSPAccion();
            if($this->codigoPrecio>0){
                $this->mensaje="¡Exito! Precio agregado exitosamente.";
            }else{
                $this->mensaje="¡Error! No se ha agregado el precio.";
            }
        }else{
            $this->mensaje="¡Error! No se ha agregado el precio - Faltan campos importantes.";
        }
		return $this;
    }

    public function setLoteCategoria ($data=array()){
        if (array_key_exists('codigoCategoria',$data) && array_key_exists('codigoGrupoEconomico',$data) && array_key_exists('precio',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($codigoCategoria, $codigoGrupoEconomico, $codigoNivelEconomico, $precio, $codigoUsuario, $cuentacontable);
            //var_dump($this->parametros);
            $this->sp = "str_consultaPrecio_addLoteCategorico";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Precios agregados exitosamente";
            }else{
                $this->mensaje="No se han agregado los precios";
            }
        }else{
            $this->mensaje="No se han agregado los precios - Faltan campos importantes.";
        }
    }
	
	public function setLoteCategoriagrupoecon ($data=array()){
		$this->codigoPrecio=0;
        if (array_key_exists('codigoCategoria',$data) ){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($codigoCategoria, $codigoNivelEconomico,  $precio, $codigoUsuario, $cuentacontable,
									array($this->codigoPrecio, SQLSRV_PARAM_OUT));
           // var_dump($this->parametros);
            $this->sp = "str_consultaPrecio_addLotegrupoEcon";
            $this->executeSPAccion();
            if($this->codigoPrecio>0){
                $this->mensaje="Precios agregados exitosamente";
            }else{
                $this->mensaje="No se han agregado los precios";
            }
        }else{
            $this->mensaje="No se han agregado los precios - Faltan campos importantes.";
        }
		return $this;
    }
	
	public function setLoteCategorianivelecon ($data=array()){
		$this->codigoPrecio=0;
        if (array_key_exists('codigoCategoria',$data) ){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($codigoCategoria, $codigoGrupoEconomico,  $precio, $codigoUsuario, $cuentacontable,
									array($this->codigoPrecio, SQLSRV_PARAM_OUT));
            //$this->parametros = array('6','8','114','admin','1.1.1');
            $this->sp = "str_consultaPrecio_addLotenivelEcon";
            $this->executeSPAccion();
			
            if($this->codigoPrecio>0){
                $this->mensaje="Precios agregados exitosamente";
            }else{
                $this->mensaje="No se han agregado los precios";
            }
        }else{
            $this->mensaje="No se han agregado los precios - Faltan campos importantes.";
        }
		return $this;
    }
	
	public function setLoteCategorianivelgrupo ($data=array()){
		$this->codigoPrecio=0;
        if (array_key_exists('codigoCategoria',$data) ){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($codigoCategoria,   $precio, $codigoUsuario, $cuentacontable,
									array($this->codigoPrecio, SQLSRV_PARAM_OUT));
            
            $this->sp = "str_consultaPrecio_addLotenivelGrupo";
            $this->executeSPAccion();
			
            if($this->codigoPrecio>0){
                $this->mensaje="Precios agregados exitosamente";
            }else{
                $this->mensaje="No se han agregado los precios";
            }
        }else{
            $this->mensaje="No se han agregado los precios - Faltan campos importantes.";
        }
		return $this;
    }
	
    public function getSinglePrice($codigoProducto="", $codigoGrupoEconomico="", $codigoNivelEconomico=""){
        $this->parametros = array($codigoProducto, $codigoGrupoEconomico, $codigoNivelEconomico);
		
        $this->sp = "str_consultaPrecio_especifico";
        $this->executeSPConsulta();

        if (count($this->rows)<=0){
            $this->mensaje="No existen precios en la BD.";
            $this->valor = -1;
        }else{
            array_pop($this->rows);
            $this->valor = $this->rows[0]['precio'];
        }
        return $this->rows[0]['precio'];
    }
	public function delete($codigo='') {
        $this->parametros = array($codigo);
        $this->sp = "str_consultaPrecio_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Precio eliminado exitosamente.";
        }else{
            $this->mensaje="¡Error! No se ha eliminado el precio.";
        }
		return $this;
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