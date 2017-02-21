<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}

class AlumnosBloqueo2 extends DB_Abstract_mobile
{
	private $tiene_deuda;
	public $resultado=array();
	
	public function set_tiene_deuda($value){
		$this->tiene_deuda = $value;
	}
	
        public function get_tiene_deuda(){
		return $this->tiene_deuda;
	}
	
	public function alumno_bloqueo2($alumnocodi, $pericodi)
	{
        $this->parametros = array($alumnocodi, $pericodi);
        $this->sp = "cali_repr_show";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0)
		{
			 $this->tiene_deuda=$this->rows[0]['tiene_deuda'];
			$this->resultado = array("tiene_deuda"=>$this->tiene_deuda);
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