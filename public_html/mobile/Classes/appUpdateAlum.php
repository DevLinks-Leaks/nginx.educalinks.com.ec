<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class appUpdateAlum extends DB_Abstract_mobile
{
	private $alum_codi;
        
	public $resultado=array();
	
	public function get_alum_codi(){
		return $this->alum_codi;
	}
        public function set_alum_codi($value){
		$this->alum_codi= $value;
	}
        
	
	public function verificarAppAlum($alum_codi)
	{
        $this->parametros = array($alum_codi);
        $this->sp = "alum_update_app";
        
        if (!$this->executeSPConsulta()) {
            $this->resultado = array("exito"=>"OK");
        }
        else{
            $this->resultado = array("NOexito"=>"nooooo");
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