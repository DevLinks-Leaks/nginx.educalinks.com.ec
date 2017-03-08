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
            $this->repr_nomb=$this->rows[0]['repr_nomb'];
            $this->repr_apel=$this->rows[0]['repr_apel'];
            $this->repr_codi=$this->rows[0]['repr_codi'];
            $this->pagos=$this->rows[0]['pagos'];
            $this->resultado = array("repr_nomb"=>$this->repr_nomb,"repr_apel"=>$this->repr_apel,"repr_codi"=>$this->repr_codi, "pagos"=>$this->pagos);
        
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