<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}

class BotonPagoLista extends DB_Abstract_mobile
{
	private $numeroFactura;
	private $codigoDeuda;
        private $descripcionDeuda;
	private $periodo;
        private $totalInicial;
	private $totalNotaCredito;
        private $totalAbonado;
        private $fechaVencimiento;
	private $estado;
        private $totalPendiente;
        
	public $resultado=array();
	
	public function set_numeroFactura($value){
		$this->numeroFactura = $value;
	}
	public function set_codigoDeuda($value){
		$this->codigoDeuda = $value;
	}
	public function set_descripcionDeuda($value){
		$this->descripcionDeuda = $value;
	}	        
        public function set_periodo($value){
		$this->periodo = $value;
	}
         public function set_totalInicial($value){
		$this->totalInicial = $value;
	}
        public function set_totalNotaCredito($value){
		$this->totalNotaCredito = $value;
	}
        public function set_totalAbonado($value){
		$this->totalAbonado = $value;
	}
        public function set_fechaVencimiento($value){
		$this->fechaVencimiento = $value;
	}
        public function set_estado($value){
		$this->estado = $value;
	}
        public function set_totalPendiente($value){
		$this->totalPendiente = $value;
	}
	public function get_numeroFactura(){
		return $this->numeroFactura;
	}
	public function get_codigoDeuda(){
		return $this->codigoDeuda;
	}
	public function get_descripcionDeuda(){
		return $this->descripcionDeuda;
	}
        public function get_periodo(){
		return $this->periodo;
	}
         public function get_totalInicial(){
		return $this->totalInicial;
	}
        public function get_totalNotaCredito(){
		return $this->totalNotaCredito;
	}
        public function get_totalAbonado(){
		return $this->totalAbonado;
	}
        public function get_fechaVencimiento(){
		return $this->fechaVencimiento;
	}
        public function get_estado(){
		return $this->estado;
	}
        public function get_totalPendiente(){
		return $this->totalPendiente;
	}
	
	
	public function getBotonPagosLista($alumnocodi,$deud_estado)
	{
        $this->parametros = array($alumnocodi,$deud_estado);
        $this->sp = "str_consulta_botonPago_deudas_lista";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
			$this->numeroFactura=$this->rows[0]['numeroFactura'];
			$this->codigoDeuda=$this->rows[0]['codigoDeuda'];
			$this->descripcionDeuda=$this->rows[0]['descripcionDeuda'];
                        $this->totalInicial=$this->rows[0]['totalInicial'];
                         $this->totalNotaCredito=$this->rows[0]['totalNotaCredito'];
                         $this->totalAbonado=$this->rows[0]['totalAbonado'];
                         $this->fechaVencimiento=$this->rows[0]['fechaVencimiento'];
                         $this->estado=$this->rows[0]['estado'];
                         $this->totalPendiente=$this->rows[0]['totalPendiente'];
			$this->resultado = array("numeroFactura"=>$this->numeroFactura,"codigoDeuda"=>$this->codigoDeuda,"descripcionDeuda"=>$this->descripcionDeuda, "totalInicial"=>$this->totalInicial,"totalNotaCredito"=>$this->totalNotaCredito,"totalAbonado"=>$this->totalAbonado,"fechaVencimiento"=>$this->fechaVencimiento,"estado"=>$this->estado,"totalPendiente"=>$this->totalPendiente);
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