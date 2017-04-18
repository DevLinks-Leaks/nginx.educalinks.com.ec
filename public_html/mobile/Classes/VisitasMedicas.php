<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class VisitasMedicas extends DB_Abstract_mobile
{
	private $enfe_descripcion;
	private $aten_fechaCreacion;
	private $aten_codigo;
	public $resultado=array();
	
	public function get_enfe_descripcion(){
		return $this->enfe_descripcion;
	}
	public function get_aten_fechaCreacion(){
		return $this->aten_fechaCreacion;
	}
	public function get_aten_codigo(){
		return $this->aten_codigo;
	}
	
	
	public function set_enfe_descripcion($value){
		$this->enfe_descripcion= $value;
	}
	public function set_aten_fechaCreacion($value){
		$this->aten_fechaCreacion= $value;
	}
	public function set_aten_codigo($value){
		$this->aten_codigo= $value;
	}
	
	
	public function getVisitasMedicas($alumnocodi)
	{
        $this->parametros = array($alumnocodi);
        $this->sp = "med_alum_atenciones";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
			$this->enfe_descripcion=$this->rows[0]['enfe_descripcion'];
			$this->aten_fechaCreacion=$this->rows[0]['aten_fechaCreacion'];
			$this->aten_codigo=$this->rows[0]['aten_codigo'];
			$this->resultado = array("enfe_descripcion"=>$this->enfe_descripcion,"aten_fechaCreacion"=>$this->aten_fechaCreacion,"aten_codigo"=>$this->aten_codigo);
        }
		else{
            $this->mensaje="visitas no encontradas";
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