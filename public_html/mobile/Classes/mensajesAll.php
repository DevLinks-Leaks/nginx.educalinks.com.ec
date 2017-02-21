<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class mensajesAll extends DB_Abstract_mobile
{
	private $mens_nomb;
	private $mens_usua_tipo_deta;
	private $mens_titu;
	private $mens_deta;
	private $mens_fech_envi;
	private $mens_fech_lect;
        private $mens_de;
        private $mens_codi;
        private $mens_para;
        private $mens_de_nomb;
	public $resultado=array();
	
	public function get_mens_nomb(){
		return $this->mens_nomb;
	}
	public function get_mens_usua_tipo_deta(){
		return $this->mens_usua_tipo_deta;
	}
	public function get_mens_titu(){
		return $this->mens_titu;
	}
	public function get_mens_deta(){
		return $this->mens_deta;
	}
	public function get_mens_fech_envi(){
		return $this->mens_fech_envi;
	}
	public function get_mens_fech_lect(){
		return $this->mens_fech_lect;
	}
        public function get_mens_de(){
		return $this->mens_de;
	}
        public function get_mens_codi(){
		return $this->mens_codi;
	}
        
        public function get_mens_para(){
		return $this->mens_para;
	}
        public function get_mens_de_nomb(){
		return $this->mens_de_nomb;
	}
        
        public function set_mens_codi($value){
		$this->mens_codi= $value;
	}
	public function set_mens_de($value){
		$this->mens_de= $value;
	}
	public function set_mens_nomb($value){
		$this->mens_nomb= $value;
	}
	public function set_mens_usua_tipo_deta($value){
		$this->mens_usua_tipo_deta= $value;
	}
	public function set_mens_titu($value){
		$this->mens_titu= $value;
	}
	public function set_mens_deta($value){
		$this->mens_deta= $value;
	}
	public function set_mens_fech_envi($value){
		$this->mens_fech_envi= $value;
	}
	public function set_mens_fech_lect($value){
		$this->mens_fech_lect= $value;
	}
        public function set_mens_para($value){
		$this->mens_para= $value;
	}
        public function set_mens_de_nomb($value){
		$this->mens_de_nomb= $value;
	}

	
	
	public function getMensajes($op,$reprcodi,$tipoMens,$rowCount)
	{
        $this->parametros = array($op,$reprcodi,$tipoMens,$rowCount);
        $this->sp = "mens_view_op";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
			$this->mens_nomb=$this->rows[0]['mens_nomb'];
			$this->mens_usua_tipo_deta=$this->rows[0]['mens_usua_tipo_deta'];
			$this->mens_titu=$this->rows[0]['mens_titu'];
			$this->mens_deta=$this->rows[0]['mens_deta'];
			$this->mens_fech_envi=$this->rows[0]['mens_fech_envi'];
			$this->mens_fech_lect=$this->rows[0]['mens_fech_lect'];
                        $this->mens_de=$this->rows[0]['mens_de'];
                        $this->mens_codi=$this->rows[0]['mens_codi'];
                        $this->mens_para=$this->rows[0]['mens_para'];
                        $this->mens_de_nomb=$this->rows[0]['mens_de_nomb'];
			$this->resultado = array("mens_nomb"=>$this->mens_nomb,"mens_de_nomb"=>$this->mens_de_nomb,"mens_de"=>$this->mens_de,"mens_para"=>$this->mens_para, "mens_usua_tipo_deta"=>$this->mens_usua_tipo_deta,"mens_titu"=>$this->mens_titu,"mens_deta"=>$this->mens_deta,"mens_fech_envi"=>$this->mens_fech_envi,"mens_fech_lect"=>$this->mens_fech_lect,"mens_codi"=>$this->mens_codi);
        }
		else{
            $this->mensaje="mensaje no encontrado";
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