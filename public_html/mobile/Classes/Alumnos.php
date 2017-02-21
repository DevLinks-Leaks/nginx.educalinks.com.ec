<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}
class Alumnos extends DB_Abstract_mobile
{
	private $codigoAlumno;
	private $nombreAlumno;
	private $apellidoAlumno;
        private $periodo;
        private $distipo;
        private $cursCodi;
        private $alumCursCodi;
        private $curso;
        private $paralelo;
        private $repr_app;
	public $resultado=array();
	
	public function set_codigoAlumno($value){
		$this->codigoAlumno = $value;
	}
	public function set_nombreAlumno($value){
		$this->nombreAlumno = $value;
	}
	public function set_apellidoAlumno($value){
		$this->codigoAlumno = $value;
	}	        
        public function set_periodo($value){
		$this->periodo = $value;
	}
         public function set_distipo($value){
		$this->distipo = $value;
	}
        public function set_cursCodi($value){
		$this->cursCodi = $value;
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
        public function set_repr_app($value){
		$this->repr_app = $value;
	}
        public function get_repr_app(){
		return $this->repr_app;
	}
        
	public function get_codigoAlumno(){
		return $this->codigoAlumno;
	}
	public function get_nombreAlumno(){
		return $this->nombreAlumno;
	}
	public function get_apellidoAlumno(){
		return $this->apellidoAlumno;
	}
        public function get_periodo(){
		return $this->periodo;
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
	
	
	public function getAlumnosRepr($reprcodi,$pericodi)
	{
        $this->parametros = array($reprcodi,$pericodi);
        $this->sp = "repr_alum_info_princ_usua";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
			$this->codigoAlumno=$this->rows[0]['alum_codi'];
			$this->nombreAlumno=$this->rows[0]['alum_nomb'];
			$this->apellidoAlumno=$this->rows[0]['alum_apel'];
                        $this->periodo=$this->rows[0]['peri_codi'];
                        $this->alumCursCodi=$this->rows[0]['alum_curs_para_codi'];
                         $this->curso=$this->rows[0]['curs_deta'];
                         $this->paralelo=$this->rows[0]['para_deta'];
                         $this->distipo=$this->rows[0]['peri_dist_cab_tipo'];
                         $this->cursCodi=$this->rows[0]['curs_para_codi'];
                         $this->repr_app=$this->rows[0]['repr_app'];
			$this->resultado = array("codigoAlum"=>$this->codigoAlumno,"nombreAlumno"=>$this->nombreAlumno,"apellidoAlumno"=>$this->apellidoAlumno, "periodo"=>$this->periodo,"alumCursCodi"=>$this->alumCursCodi,"cursCodi"=>$this->cursCodi,"curso"=>$this->curso,"paralelo"=>$this->paralelo,"distipo"=>$this->distipo,"repr_app"=>$this->repr_app);
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