<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}

class AlumnosBloqueo extends DB_Abstract_mobile
{
	private $alum_tiene_deuda;
	public $resultado=array();
	
	public function set_alum_tiene_deuda($value){
		$this->alum_tiene_deuda = $value;
	}
	
        public function get_alum_tiene_deuda(){
		return $this->alum_tiene_deuda;
	}
	
	public function alumno_bloqueo($alumnocodi, $cursParaCodi)
	{
        $this->parametros = array($alumnocodi, $cursParaCodi);
        $this->sp = "alum_curs_para_tiene_deuda";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0)
		{
			 $this->alum_tiene_deuda=$this->rows[0]['alum_tiene_deuda'];
			$this->resultado = array("alum_tiene_deuda"=>$this->alum_tiene_deuda);
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