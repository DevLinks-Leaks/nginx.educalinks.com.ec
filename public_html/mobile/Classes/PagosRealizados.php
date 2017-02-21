<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}

class PagosRealizados extends DB_Abstract_mobile
{
	private $totalPago;
	private $formaPago;
        private $codigoPago;
        
	public $resultado=array();
	
	public function set_totalPago($value){
		$this->totalPago = $value;
	}
	public function set_formaPago($value){
		$this->formaPago = $value;
	}
	public function set_codigoPago($value){
		$this->codigoPago = $value;
	}	        
        
	public function get_totalPago(){
		return $this->totalPago;
	}
	public function get_formaPago(){
		return $this->formaPago;
	}
	public function get_codigoPago(){
		return $this->codigoPago;
	}
        
        
        	
	public function getPagosRealizados($codigoPagos,$fechavenc_ini,$fechavenc_fin,$forma_pagos,$cod_titular,$id_titular,$cod_estudiante,$nombre_estudiante,$nombre_titular,$ptvo_venta,$sucursal,$ref_factura,$categoria_codigo ,$prod_codigo,$estado ,$tpago_ini,$tpago_fin,$usua_codi,$periodo,$grupoEconomico,$nivelEconomico ,$Curso ,$deuda)
	{
        $this->parametros = array($codigoPagos,$fechavenc_ini ,$fechavenc_fin,$forma_pagos,$cod_titular,$id_titular,$cod_estudiante,$nombre_estudiante,$nombre_titular,$ptvo_venta,$sucursal,$ref_factura,$categoria_codigo ,$prod_codigo,$estado ,$tpago_ini,$tpago_fin,$usua_codi,$periodo,$grupoEconomico,$nivelEconomico ,$Curso ,$deuda);
        $this->sp = "str_consultaPagosRealizados";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
			$this->totalPago=$this->rows[0]['totalPago'];
			$this->formaPago=$this->rows[0]['formaPago'];
			$this->codigoPago=$this->rows[0]['codigoPago'];
			$this->resultado = array("totalPago"=>$this->totalPago,"formaPago"=>$this->formaPago,"codigoPago"=>$this->codigoPago);
        }
		else{
            $this->mensaje="Error";
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