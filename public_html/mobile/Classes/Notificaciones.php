<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class Notificaciones extends DB_Abstract_mobile
{
	private $noticodi;
	private $notiDetaEsta;
	private $fechaRegistro;
        private $fechaLectura;
	public $resultado=array();
	
	public function get_noticodi(){
		return $this->noticodi;
	}
	public function get_notiDetaEsta(){
		return $this->notiDetaEsta;
	}
	public function get_fechaRegistro(){
		return $this->fechaRegistro;
	}
        public function get_fechaLectura(){
		return $this->fechaLectura;
	}
	
	public function set_noticodi($value){
		$this->noticodi= $value;
	}
	public function set_notiDetaEsta($value){
		$this->notiDetaEsta= $value;
	}
	public function set_fechaRegistro($value){
		$this->fechaRegistro= $value;
	}
        public function set_fechaLectura($value){
		$this->fechaLectura= $value;
	}
		
	
	public function getNotificaciones($usuacodi,$tipousua)
	{
        $this->parametros = array($usuacodi,$tipousua);
        $this->sp = "noti_usua_view";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
                        $this->noticodi=$this->rows[0]['noti_codi'];
                        $this->notiDetaEsta=$this->rows[0]['noti_deta_esta'];
                        $this->fechaRegistro=$this->rows[0]['noti_deta_fech_regi'];
                        $this->fechaLectura=$this->rows[0]['noti_deta_fech_lect'];			
                        $this->resultado = array("noticodi"=>$this->noticodi,"notiDetaEsta"=>$this->notiDetaEsta,"fechaRegistro"=>$this->fechaRegistro,"fechaLectura"=>$this->fechaLectura);
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