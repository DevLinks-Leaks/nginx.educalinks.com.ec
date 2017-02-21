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
        $this->sp = "str_consultaCajaCierre_hist";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Cajas encontradas";
        }else{
            $this->mensaje="Cajas no encontradas";
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