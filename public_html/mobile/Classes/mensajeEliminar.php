<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class mensajeEliminar extends DB_Abstract_mobile
{
	private $mens_codi;
	public $resultado=array();
	
	public function get_mens_codi(){
		return $this->mens_de;
	}
        public function set_mens_codi($value){
		$this->mens_deta= $value;
	}
		
	
	public function eraseMessage($mens_codi)
	{
        $this->parametros = array($mens_codi);
        $this->sp = "mens_del";
        
        if (!$this->executeSPConsulta()) {
            $this->resultado = array("exito"=>"OK");
        }
        else{
            $this->resultado = array("NOexito"=>"nooooo");
            }
                /*if ($this->filasDevueltas>0)
		{
                    $this->mensaje="Mensaje Enviado";
                    $this->resultado = array("exito"=>"OK","mensaje"=>$this->mensaje);
                }
		else
		{
                    $this->mensaje="Mensaje no enviado";
                    $this->resultado = array("exito"=>"noOK","mensaje"=>$this->mensaje);
                }*/
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