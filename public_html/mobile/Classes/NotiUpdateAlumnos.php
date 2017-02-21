<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}

class NotiUpdateAlumnos extends DB_Abstract_mobile
{
	private $alumcodi;
	private $usua_tipo_codi;
	public $resultado=array();
	
	public function set_alumcodi($value){
		$this->alumcodi = $value;
	}
	public function set_usua_tipo_codi($value){
		$this->usua_tipo_codi = $value;
	}

	public function get_alumcodi(){
		return $this->alumcodi;
	}
	public function get_usua_tipo_codi(){
		return $this->usua_tipo_codi;
	}
	
	
	public function updateNotiAlum($alumcodi,$usua_tipo_codi)
	{
        $this->parametros = array($alumcodi,$usua_tipo_codi);
        $this->sp = "noti_usua_update";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0)
		{
                    $this->mensaje="Usuario cambio estado";
                    $this->resultado = array("exito"=>"OK","mensaje"=>$this->mensaje);
                }
		else
		{
                    $this->mensaje="Usuario no cambio de estado";
                    $this->resultado = array("exito"=>"noOK","mensaje"=>$this->mensaje);
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