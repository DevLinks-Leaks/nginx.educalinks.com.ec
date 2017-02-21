<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class Notificacionesall extends DB_Abstract_mobile
{
	private $noti_deta_esta;
	private $noti_deta_fech_regi;
	private $noti_tipo_deta;
        private $noti_deta;
        private $noti_deta_codi;
	public $resultado=array();
	
	public function get_noti_deta_fech_regi(){
		return $this->noti_deta_fech_regi;
	}
	public function get_noti_tipo_deta(){
		return $this->noti_tipo_deta;
	}
	public function get_noti_deta(){
		return $this->noti_deta;
	}
        public function get_noti_deta_esta(){
		return $this->noti_deta_esta;
	}
        public function get_noti_deta_codi(){
		return $this->noti_deta_codi;
	}
        
	public function set_noti_deta_fech_regi($value){
		$this->noti_deta_fech_regi= $value;
	}
	public function set_noti_tipo_deta($value){
		$this->noti_tipo_deta= $value;
	}
	public function set_noti_deta($value){
		$this->noti_deta= $value;
	}
        public function set_noti_deta_esta($value){
		$this->noti_deta_esta= $value;
	}
        public function set_noti_deta_codi($value){
		$this->noti_deta_codi= $value;
	}
		
	
	public function getNotificacionesAll($usuacodi,$tipousua)
	{
        $this->parametros = array($usuacodi,$tipousua);
        $this->sp = "noti_usua_view_all_top";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
                        $this->noti_deta_fech_regi=$this->rows[0]['noti_deta_fech_regi'];
                        $this->noti_deta_esta=$this->rows[0]['noti_deta_esta'];
                        $this->noti_tipo_deta=$this->rows[0]['noti_tipo_deta'];
                        $this->noti_deta=$this->rows[0]['noti_deta'];		
                        $this->noti_deta_codi=$this->rows[0]['noti_deta_codi'];		
                        $this->resultado = array("noti_deta_codi"=>$this->noti_deta_codi,"noti_deta_fech_regi"=>$this->noti_deta_fech_regi,"noti_deta_esta"=>$this->noti_deta_esta,"noti_tipo_deta"=>$this->noti_tipo_deta,"noti_deta"=>$this->noti_deta);
        }
		else{
            $this->mensaje="Notificacion no encontrada";
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