<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class mensajeNuevo extends DB_Abstract_mobile
{
	private $mens_de;
	private $mens_de_tipo;
	private $mens_para;
        private $mens_para_tipo;
	private $mens_titu;
	private $mens_deta;
        private $mens_alum_codi;
	public $resultado=array();
	
	public function get_mens_de(){
		return $this->mens_de;
	}
	public function get_mens_de_tipo(){
		return $this->mens_de_tipo;
	}
	public function get_mens_para(){
		return $this->mens_para;
	}
        public function get_mens_para_tipo(){
		return $this->mens_para_tipo;
	}
        public function get_mens_titu(){
		return $this->mens_titu;
	}
        public function get_mens_deta(){
		return $this->mens_deta;
	}
        public function get_mens_alum_codi(){
		return $this->mens_alum_codi;
	}
        
        public function set_mens_de($value){
		$this->mens_de= $value;
	}
	public function set_mens_de_tipo($value){
		$this->mens_de_tipo= $value;
	}
	public function set_mens_para($value){
		$this->mens_para= $value;
	}
        public function set_mens_para_tipo($value){
		$this->mens_para_tipo= $value;
	}
        public function set_mens_titu($value){
		$this->mens_titu= $value;
	}
        public function set_mens_deta($value){
		$this->mens_deta= $value;
	}
        public function set_mens_alum_codi($value){
		$this->mens_alum_codi= $value;
	}
		
	
	public function addMessage($mens_de,$mens_de_tipo,$mens_para,$mens_para_tipo,$mens_titu,$mens_deta, $mens_alum_codi)
	{
        $this->parametros = array($mens_de,$mens_de_tipo,$mens_para,$mens_para_tipo,$mens_titu,$mens_deta, $mens_alum_codi);
        $this->sp = "mens_add";
        
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