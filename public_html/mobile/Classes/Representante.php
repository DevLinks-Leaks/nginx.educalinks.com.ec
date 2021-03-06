<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}

class Representante extends DB_Abstract_mobile
{
	private $nombre;
	private $apellido;
	private $usuario;
	private $clave;
	private $colegio;
	private $codigo;
	private $periodo;
        private $repr_app;
	public $resultado=array();
	
	public function set_usuario($value){
		$this->usuario = $value;
	}
	public function set_clave($value){
		$this->clave = $value;
	}
	public function set_colegio($value){
		$this->colegio = $value;
	}	
	public function set_codigo($value){
		$this->codigo = $value;
	}
	public function set_periodo($value){
		$this->periodo = $value;
	}
        public function set_nombre($value){
		$this->nombre = $value;
	}
	public function set_apellido($value){
		$this->apellido = $value;
	}
        public function set_repr_app($value){
		$this->repr_app = $value;
	}
        public function get_repr_app(){
		return $this->repr_app;
	}
	public function get_usuario(){
		return $this->usuario;
	}
	public function get_clave(){
		return $this->clave;
	}
	public function get_colegio(){
		return $this->colegio;
	}
	public function get_codigo(){
		return $this->codigo;
	}
	public function get_periodo(){
		return $this->periodo;
	}
        public function get_nombre(){
		return $this->nombre;
	}
	public function get_apellido(){
		return $this->apellido;
	}
	
	public function Login($username, $password,$tipo_usua)
	{
        $this->parametros = array($username,$password,$tipo_usua);
        $this->sp = "main_logi_ws";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0)
		{
			$this->codigo=$this->rows[0]['repr_codi'];
			$this->periodo=$this->rows[0]['peri_codi'];
                        $this->nombre=$this->rows[0]['repr_nomb'];
                        $this->apellido=$this->rows[0]['repr_apel'];
                        $this->repr_app=$this->rows[0]['repr_app'];
            $this->mensaje="Usuario autenticado";
			$this->resultado = array("exito"=>"OK","mensaje"=>$this->mensaje,"codigo"=>$this->codigo,"periodo"=>$this->periodo,"nombre"=>$this->nombre,"apellido"=>$this->apellido,"repr_app"=>$this->repr_app);
        }
		else
		{
            $this->mensaje="Usuario no autenticado";
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