<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class Agenda extends DB_Abstract_mobile
{
	private $codigoAgenda;
	private $tituloAgenda;
	private $detalleAgenda;
	private $fechaIniAgenda;
	private $fechaFinAgenda;
	private $estadoAgenda;
	private $detalleMateria;
	private $nombreProfesor;
    private $profcodi;
	public $resultado=array();
	
	public function get_codigoAgenda(){
		return $this->codigoAgenda;
	}
	public function get_tituloAgenda(){
		return $this->tituloAgenda;
	}
	public function get_detalleAgenda(){
		return $this->detalleAgenda;
	}
	public function get_fechaIniAgenda(){
		return $this->fechaIniAgenda;
	}
	public function get_fechaFinAgenda(){
		return $this->fechaFinAgenda;
	}
	public function get_estadoAgenda(){
		return $this->estadoAgenda;
	}
	public function get_detalleMateria(){
		return $this->detalleMateria;
	}
	public function get_nombreProfesor(){
		return $this->nombreProfesor;
	}
        
    public function get_profcodi(){
		return $this->profcodi;
	}
	
	public function set_codigoAgenda($value){
		$this->codigoAgenda= $value;
	}
	public function set_tituloAgenda($value){
		$this->tituloAgenda= $value;
	}
	public function set_detalleAgenda($value){
		$this->detalleAgenda= $value;
	}
	public function set_fechaIniAgenda($value){
		$this->fechaIniAgenda= $value;
	}
	public function set_fechaFinAgenda($value){
		$this->fechaFinAgenda= $value;
	}
	public function set_estadoAgenda($value){
		$this->estadoAgenda= $value;
	}
	public function set_detalleMateria($value){
		$this->detalleMateria= $value;
	}
	public function set_nombreProfesor($value){
		$this->nombreProfesor= $value;
	}
    public function set_profcodi($value){
		$this->profcodi= $value;
	}
	

	
	
	public function getAgenda($alumnocodi,$pericodi)
	{
        $this->parametros = array($alumnocodi,$pericodi);
        $this->sp = "agen_curs_para_mate_view_all";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
			$this->codigoAgenda=$this->rows[0]['agen_codi'];
			$this->tituloAgenda=$this->rows[0]['agen_titu'];
			$this->detalleAgenda=$this->rows[0]['agen_deta'];
			$this->fechaIniAgenda=$this->rows[0]['agen_fech_ini'];
			$this->fechaFinAgenda=$this->rows[0]['agen_fech_fin'];
			$this->estadoAgenda=$this->rows[0]['agen_esta'];			
			$this->detalleMateria=$this->rows[0]['mate_deta'];
			$this->nombreProfesor=$this->rows[0]['prof_nomb'];
            $this->profcodi=$this->rows[0]['prof_codi'];
			$this->resultado = array("codigoAgenda"=>$this->codigoAgenda,"tituloAgenda"=>$this->tituloAgenda,"detalleAgenda"=>$this->detalleAgenda,"fechaIniAgenda"=>$this->fechaIniAgenda,"fechaFinAgenda"=>$this->fechaFinAgenda,"estadoAgenda"=>$this->estadoAgenda,"profcodi"=>$this->profcodi,"detalleMateria"=>$this->detalleMateria,"nombreProfesor"=>$this->nombreProfesor);
        }
		else{
            $this->mensaje="Agenda no encontrada";
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