<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class detalleVisitasMedicas extends DB_Abstract_mobile
{
	private $aten_deta_med_cantidad;
	private $med_descripcion;
	public $resultado=array();
	
	public function get_aten_deta_med_cantidad(){
		return $this->aten_deta_med_cantidad;
	}
	public function get_med_descripcion(){
		return $this->med_descripcion;
	}
	
	public function set_aten_deta_med_cantidad($value){
		$this->aten_deta_med_cantidad= $value;
	}
	public function set_med_descripcion($value){
		$this->med_descripcion= $value;
	}
	public function getDetalleVisitasMedicas($aten_codigo)
	{
        $this->parametros = array($aten_codigo);
        $this->sp = "med_atenciones_detalle_info";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
			$this->aten_deta_med_cantidad=$this->rows[0]['aten_deta_med_cantidad'];
			$this->med_descripcion=$this->rows[0]['med_descripcion'];
			$this->resultado = array("aten_deta_med_cantidad"=>$this->aten_deta_med_cantidad,"med_descripcion"=>$this->med_descripcion);
        }
		else{
            $this->mensaje="detalle no encontrado";
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