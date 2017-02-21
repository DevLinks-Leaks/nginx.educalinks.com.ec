<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}

class Alumnoslogin extends DB_Abstract_mobile
{
	private $nombre;
	private $apellido;
	private $usuario;
	private $clave;
	private $colegio;
	private $codigo;
	private $periodo;
        private $distipo;
        private $cursCodi;
        private $alumCursCodi;
        private $alum_app;
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
        public function set_alumCursCodi($value){
		$this->alumCursCodi = $value;
	}
        public function set_curso($value){
		$this->apellido = $value;
	}
        public function set_paralelo($value){
		$this->apellido = $value;
	}
        public function set_distipo($value){
		$this->distipo = $value;
	}
        public function set_cursCodi($value){
		$this->cursCodi = $value;
	}
        public function set_alum_app($value){
		$this->alum_app = $value;
	}
        public function get_alum_app(){
		return $this->alum_app;
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
        public function get_alumCursCodi(){
		return $this->alumCursCodi;
	}
        public function get_curso(){
		return $this->apellido;
	}
        public function get_paralelo(){
		return $this->apellido;
	}
        public function get_distipo(){
		return $this->distipo;
	}
        public function get_cursCodi(){
		return $this->cursCodi;
	}
	
	
	public function Login($username, $password,$tipo_usua)
	{
        $this->parametros = array($username,$password,$tipo_usua);
        $this->sp = "main_login_app";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0)
		{
			 $this->codigo=$this->rows[0]['alum_codi'];
			 $this->periodo=$this->rows[0]['peri_codi'];
                         $this->nombre=$this->rows[0]['alum_nomb'];
                         $this->apellido=$this->rows[0]['alum_apel'];
                         $this->alumCursCodi=$this->rows[0]['alum_curs_para_codi'];
                         $this->curso=$this->rows[0]['curs_deta'];
                         $this->paralelo=$this->rows[0]['para_deta'];
                         $this->distipo=$this->rows[0]['peri_dist_cab_tipo'];
                         $this->cursCodi=$this->rows[0]['curs_para_codi'];
                         $this->alum_app=$this->rows[0]['alum_app'];

            $this->mensaje="Usuario autenticado";
			$this->resultado = array("exito"=>"OK","mensaje"=>$this->mensaje,"codigo"=>$this->codigo,"periodo"=>$this->periodo,"nombre"=>$this->nombre,"apellido"=>$this->apellido,"alumCursCodi"=>$this->alumCursCodi,"cursCodi"=>$this->cursCodi,"curso"=>$this->curso,"paralelo"=>$this->paralelo,"distipo"=>$this->distipo,"alum_app"=>$this->alum_app);
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