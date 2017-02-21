<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class NotiUpdate extends DB_Abstract_mobile
{
	private $usua_codi;
	private $usua_tipo_codi;
	public $resultado=array();
	
	public function set_usua_codi($value){
		$this->usua_codi = $value;
	}
	public function set_usua_tipo_codi($value){
		$this->usua_tipo_codi = $value;
	}

	public function get_usua_codi(){
		return $this->usua_codi;
	}
	public function get_usua_tipo_codi(){
		return $this->usua_tipo_codi;
	}
	
	
	public function updateNoti($usua_codi,$usua_tipo_codi)
	{
        $this->parametros = array($usua_codi,$usua_tipo_codi);
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