<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class mensajeUpdate extends DB_Abstract_mobile
{
	private $mens_codi;
	public $resultado=array();
	
	public function get_mens_codi(){
		return $this->mens_de;
	}
        public function set_mens_codi($value){
		$this->mens_deta= $value;
	}
		
	
	public function mensajeLeido($mens_codi)
	{
        $this->parametros = array($mens_codi);
        $this->sp = "mens_read";
        
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