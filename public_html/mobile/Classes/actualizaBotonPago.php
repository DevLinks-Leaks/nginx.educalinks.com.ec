<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}

class actualizaBotonPago extends DB_Abstract_mobile
{
	private $repr_nomb;
	private $repr_apel;
        private $repr_codi;
	private $pagos;
        
	public $resultado=array();
	
	public function set_repr_nomb($value){
		$this->repr_nomb = $value;
	}
	public function set_repr_apel($value){
		$this->repr_apel = $value;
	}
	public function set_repr_codi($value){
		$this->repr_codi = $value;
	}	        
        public function set_pagos($value){
		$this->pagos = $value;
	}
         
	public function get_repr_nomb(){
		return $this->repr_nomb;
	}
	public function get_repr_apel(){
		return $this->repr_apel;
	}
	public function get_repr_codi(){
		return $this->repr_codi;
	}
        public function get_pagos(){
		return $this->pagos;
	}
	
	public function getActualizaBotonPago($authorizationCode,$authorizationResult,$errorCode,$errorMessage,$cardNumber,$cardType,$purchaseOperationNumber,$purchaseAmount,$reserved11)
	{
        $this->parametros = array($authorizationCode,$authorizationResult,$errorCode,$errorMessage,$cardNumber,$cardType,$purchaseOperationNumber,$purchaseAmount,$reserved11);
        $this->sp = "str_actualiza_botonPago_deuda";
        $this->executeSPConsulta();
        if ($this->filasDevueltas=0){
             $this->mensaje="Error";
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