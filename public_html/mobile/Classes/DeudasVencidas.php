<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}

class DeudasVencidas extends DB_Abstract_mobile
{
	private $descripcionDeuda;
        private $deud_totalPendiente;
        private $deud_codigo;
	public $resultado=array();
	
	public function set_descripcionDeuda($value){
		$this->descripcionDeuda = $value;
	}
        public function set_deud_totalPendiente($value){
		$this->deud_totalPendiente = $value;
	}
        public function set_deud_codigo($value){
		$this->deud_codigo = $value;
	}
        public function get_deud_codigo(){
		return $this->deud_codigo;
	}
	public function get_descripcionDeuda(){
		return $this->descripcionDeuda;
	}
        public function get_deud_totalPendiente(){
		return $this->deud_totalPendiente;
	}
	
	public function deudasPendVencidas($deudaCodigo)
	{
        $this->parametros = array($deudaCodigo);
        $this->sp = "str_consultaDeudasAnterioresVencidas";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0)
		{
                        $this->descripcionDeuda=$this->rows[0]['descripcionDeuda'];
                        $this->codigoDeuda=$this->rows[0]['deud_codigo'];
                        $this->deud_TotalPendiente=$this->rows[0]['deud_TotalPendiente'];
			$this->resultado = array("descripcionDeuda"=>$this->descripcionDeuda,"deud_totalPendiente"=>$this->deud_totalPendiente);
        }
		else
		{
            $this->mensaje="KO";
			$this->resultado = array("exito"=>"KO","mensaje"=>$this->mensaje);
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