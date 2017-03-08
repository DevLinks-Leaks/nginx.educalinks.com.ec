<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}

class BotonPagoDeuda extends DB_Abstract_mobile
{
	private $deud_codigo;
	private $pon_code;
        private $prod_nombre;
	private $deud_totalPendiente;
        private $repr_nomb;
	private $repr_apel;
        private $repr_email;
        private $repr_telf;
	private $repr_domi;
        
	public $resultado=array();
	
	public function set_deud_codigo($value){
		$this->deud_codigo = $value;
	}
	public function set_pon_code($value){
		$this->pon_code = $value;
	}
	public function set_prod_nombre($value){
		$this->prod_nombre = $value;
	}	        
        public function set_deud_totalPendiente($value){
		$this->deud_totalPendiente = $value;
	}
         public function set_repr_nomb($value){
		$this->repr_nomb = $value;
	}
        public function set_repr_apel($value){
		$this->repr_apel = $value;
	}
        public function set_repr_email($value){
		$this->repr_email = $value;
	}
        public function set_repr_telf($value){
		$this->repr_telf = $value;
	}
        public function set_repr_domi($value){
		$this->repr_domi = $value;
	}
	public function get_deud_codigo(){
		return $this->deud_codigo;
	}
	public function get_pon_code(){
		return $this->pon_code;
	}
	public function get_prod_nombre(){
		return $this->prod_nombre;
	}
        public function get_deud_totalPendiente(){
		return $this->deud_totalPendiente;
	}
         public function get_repr_nomb(){
		return $this->repr_nomb;
	}
        public function get_repr_apel(){
		return $this->repr_apel;
	}
        public function get_repr_email(){
		return $this->repr_email;
	}
        public function get_repr_telf(){
		return $this->repr_telf;
	}
        public function get_repr_domi(){
		return $this->repr_domi;
	}
	
	public function getBotonPagoDeuda($alumnocodi,$reprcodi,$deudaCodigo)
	{
        $this->parametros = array($alumnocodi,$reprcodi,$deudaCodigo,1);
        $this->sp = "str_consulta_botonPago_deuda";
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