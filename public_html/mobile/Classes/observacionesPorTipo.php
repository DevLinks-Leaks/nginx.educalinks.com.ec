<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}
class observacionesPorTipo extends DB_Abstract_mobile
{
	private $obse_codi;
	private $obse_deta;
        private $obse_fech;
	private $obse_tipo_deta;
        private $usua_deta;
	private $usua_tipo;
	public $resultado=array();
	
	public function set_obse_codi($value){
		$this->obse_codi = $value;
	}
	public function set_obse_deta($value){
		$this->obse_deta = $value;
	}
	public function set_obse_fech($value){
		$this->obse_fech = $value;
	}
        public function set_obse_tipo_deta($value){
		$this->obse_tipo_deta = $value;
	}
        public function set_usua_deta($value){
		$this->usua_deta = $value;
	}
        public function set_usua_tipo($value){
		$this->usua_tipo = $value;
	}
        
        
        
        public function get_obse_codi(){
		return $this->obse_codi;
	}
        public function get_obse_deta(){
		return $this->obse_deta;
	}
        public function get_obse_fech(){
		return $this->obse_fech;
	}
        public function get_obse_tipo_deta(){
		return $this->obse_tipo_deta;
	}
        public function get_usua_deta(){
		return $this->usua_deta;
	}
        public function get_usua_tipo(){
		return $this->usua_tipo;
	}
	
	
	public function getObservacionesPorTipo($pericodi,$alumnocodi,$tipo_observacion)
	{
        $this->parametros = array($pericodi,$alumnocodi,$tipo_observacion);
        $this->sp = "observacion_alum_info_por_tipo";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
			$this->obse_codi=$this->rows[0]['obse_codi'];
			$this->obse_deta=$this->rows[0]['obse_deta'];
			$this->obse_fech=$this->rows[0]['obse_fech'];
			$this->obse_tipo_deta=$this->rows[0]['obse_tipo_deta'];
                        $this->usua_deta=$this->rows[0]['usua_deta'];
			$this->usua_tipo=$this->rows[0]['usua_tipo'];
			$this->resultado = array("obse_codi"=>$this->obse_codi,"obse_deta"=>$this->obse_deta,"obse_fech"=>$this->obse_fech,"obse_tipo_deta"=>$this->obse_tipo_deta,"usua_deta"=>$this->usua_deta,"usua_tipo"=>$this->usua_tipo);
        }
		else{
            $this->mensaje="Clientes no encontrados";
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