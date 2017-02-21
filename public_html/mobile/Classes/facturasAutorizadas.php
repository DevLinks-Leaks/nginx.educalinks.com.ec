<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}

class facturasAutorizadas extends DB_Abstract_mobile
{
	private $codigoFactura;
	private $totalNetoFactura;
	private $codigoAlumno;
	private $nombresAlumno;
	private $fechaEmision;
	private $estadoElectronico;
        private $prefijoSucursal;
	private $prefijoPuntoVenta;
	private $numeroFactura;
	public $resultado=array();
	
	public function set_codigoFactura($value){
		$this->codigoFactura = $value;
	}
	public function set_totalNetoFactura($value){
		$this->totalNetoFactura = $value;
	}
	public function set_codigoAlumno($value){
		$this->codigoAlumno = $value;
	}	
	public function set_nombresAlumno($value){
		$this->nombresAlumno = $value;
	}
	public function set_fechaEmision($value){
		$this->fechaEmision = $value;
	}
        public function set_estadoElectronico($value){
		$this->estadoElectronico = $value;
	}         
        public function set_prefijoSucursal($value){
		$this->prefijoSucursal = $value;
	}
	public function set_prefijoPuntoVenta($value){
		$this->prefijoPuntoVenta = $value;
	}
        public function set_numeroFactura($value){
		$this->numeroFactura = $value;
	}
                
	public function get_codigoFactura(){
		return $this->codigoFactura;
	}
	public function get_totalNetoFactura(){
		return $this->totalNetoFactura;
	}
	public function get_nombresAlumno(){
		return $this->nombresAlumno;
	}
	public function get_codigoAlumno(){
		return $this->codigoAlumno;
	}
	public function get_fechaEmisiono(){
		return $this->fechaEmision;
	}
	public function get_estadoElectronico(){
		return $this->estadoElectronico;
	}
	public function get_prefijoSucursal(){
		return $this->prefijoSucursal;
	}
	public function get_prefijoPuntoVenta(){
		return $this->prefijoPuntoVenta;
	}
	public function get_numeroFactura(){
		return $this->numeroFactura;
	}
	
	public function Facturas($estadoElectronico, $fechaemision_ini,$fechaemision_fin, $cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante, $nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo)
	{
        $this->parametros = array($estadoElectronico, $fechaemision_ini,$fechaemision_fin, $cod_titular, $id_titular , $cod_estudiante, $nombre_estudiante, $nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo);
        $this->sp = "str_consultaFacturas";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0)
		{
			$this->codigoFactura=$this->rows[0]['codigoFactura'];
			$this->totalNetoFactura=$this->rows[0]['totalNetoFactura'];
                        $this->nombresAlumno=$this->rows[0]['nombresAlumno'];
                        $this->codigoAlumno=$this->rows[0]['codigoAlumno'];
                        $this->fechaEmision=$this->rows[0]['fechaEmision'];
                        $this->estadoElectronico=$this->rows[0]['estadoElectronico'];
                        $this->prefijoSucursal=$this->rows[0]['prefijoSucursal'];
                        $this->prefijoPuntoVenta=$this->rows[0]['prefijoPuntoVenta'];
                        $this->numeroFactura=$this->rows[0]['numeroFactura'];
            $this->mensaje="Facturas";
			$this->resultado = array("exito"=>"OK","mensaje"=>$this->mensaje,"codigoFactura"=>$this->codigoFactura,"totalNetoFactura"=>$this->totalNetoFactura,"nombresAlumno"=>$this->nombresAlumno,"codigoAlumno"=>$this->codigoAlumno ,"fechaEmision"=>$this->fechaEmision, "estadoElectronico"=>$this->estadoElectronico, "prefijoSucursal"=>$this->prefijoSucursal, "prefijoPuntoVenta"=>$this->prefijoPuntoVenta, "numeroFactura"=>$this->numeroFactura);
        }
		else
		{
            $this->mensaje="No Facturas";
			$this->resultado = array("exito"=>"KO","mensaje"=>$this->mensaje);
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