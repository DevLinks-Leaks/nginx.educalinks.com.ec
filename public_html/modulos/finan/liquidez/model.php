<?php
require_once('../../../core/db_abstract_model.php');

class Liquidez extends DBAbstractModel{
    #propiedades
    public $codigo;
    public $nombre;
    public $codigoCuenta;
    public $descripcion;
    public $cuentaPadre;
    public $tipo;
	public $estado;

    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaCuentaContable_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Cuenta contable encontrada";
        }else{
            $this->mensaje="Cuenta contable no encontrada";
        }
    }
	
	
	public function get_rept_liquidez(){
        $this->parametros = array();
        $this->sp = "str_reporteLiquidez";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Transacciones encontradas";
        }else{
            $this->mensaje="No existen transacciones realizadas";
        }
    }
	
	public function get_all($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaCuentaContable_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Cuentas contables encontrados";
        }else{
            $this->mensaje="Cuentas contables no encontrados";
        }
    }
	public function get_all_bancos(){
        $this->parametros = array();
        $this->sp = "str_consultaBanco_infotabla";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Cuentas contables encontrados";
        }else{
            $this->mensaje="Cuentas contables no encontrados";
        }
    }
		public function get_all_anosanteriores(){
        $this->parametros = array();
        $this->sp = "str_consultaPeriodosanteriores";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Cuentas contables encontrados";
        }else{
            $this->mensaje="Cuentas contables no encontrados";
        }
    }
		public function get_all_productos(){
        $this->parametros = array();
        $this->sp = "str_consultaItem_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Cuentas contables encontrados";
        }else{
            $this->mensaje="Cuentas contables no encontrados";
        }
    }
    public function get_grupos()
    {
        $this->parametros = array();
        $this->sp = "str_consultaGrupoCuentaContable";
        $this->executeSPConsulta();

        if (count($this->rows)>=0)
        {
            $grupo = array();
            foreach($this->rows as $grupos)
            {
                array_push($grupo, array_values($grupos));
            }
            // Agregar la opcion de ninguna categoria padre
            array_pop($grupo);
            array_push($grupo, array(0 => -1, 
                                   1 => 'NINGUNO',
                                   2 => ''));
            array_push($grupo, array());

            $this->rows = $grupo;
            unset($grupo);
            $this->mensaje="Grupos de cuentas contables encontrados";
        }
        else
        {
            $this->mensaje="Grupos de cuentas contables no encontrados";
        }
    }

    public function set($data=array()){
        if (array_key_exists('nombre',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($cuentaPadre, $codigoCuenta, $nombre, $descripcion, $tipo, $codigoUsuario);
            $this->sp = "str_consultaCuentaContable_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Cuenta contable agregada exitosamente";
            }else{
                $this->mensaje="No se ha agregado la cuenta contable";
            }
        }else{
            $this->mensaje="No se ha agregado la Cuenta contable - Falta el nombre de la misma";
        }
    }

    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($codigo, $cuentaPadre, $codigoCuenta, $nombre, $descripcion, $tipo);
        $this->sp = "str_consultaCuentaContable_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Cuenta contable actualizada exitosamente";
        }else{
            $this->mensaje="Cuenta contable no actualizada";
        }
    }
public function get_becasdescuentos(){
        $this->parametros = array();
        $this->sp = "str_reporteLiquidezbecas";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Transacciones encontradas";
        }else{
            $this->mensaje="No existen transacciones realizadas";
        }
    }
     public function delete($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($codigo);
        $this->sp = "str_consultaCuentaContable_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Cuenta contable eliminada exitosamente";
        }else{
            $this->mensaje="Cuenta contable no eliminada";
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