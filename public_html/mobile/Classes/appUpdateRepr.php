<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class appUpdateRepr extends DB_Abstract_mobile
{
	private $repr_codi;
        
	public $resultado=array();
	
	public function get_repr_codi(){
		return $this->repr_codi;
	}
        public function set_repr_codi($value){
		$this->repr_codi= $value;
	}
        
	
	public function verificarAppRepr($repr_codi)
	{
        $this->parametros = array($repr_codi);
        $this->sp = "repr_update_app";
        
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