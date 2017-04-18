<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}
class tipoObservacion extends DB_Abstract_mobile
{
	private $obse_tipo_codi;
	private $nombreAlumno;
	public $resultado=array();
	
	public function set_obse_tipo_codi($value){
		$this->obse_tipo_codi = $value;
	}
	public function set_obse_tipo_deta($value){
		$this->obse_tipo_deta = $value;
	}
	
        public function get_obse_tipo_codi(){
		return $this->obse_tipo_codi;
	}
        
	public function get_obse_tipo_deta(){
		return $this->obse_tipo_deta;
	}
	
	
	public function getTipoObservaciones()
	{
        $this->parametros = array();
        $this->sp = "tipo_observacion_view";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
			$this->obse_tipo_codi=$this->rows[0]['obse_tipo_codi'];
			$this->obse_tipo_deta=$this->rows[0]['obse_tipo_deta'];
			
			$this->resultado = array("obse_tipo_codi"=>$this->obse_tipo_codi,"obse_tipo_deta"=>$this->obse_tipo_deta);
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