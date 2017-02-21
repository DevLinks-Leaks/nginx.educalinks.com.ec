<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class profesores extends DB_Abstract_mobile
{
	private $prof_codi;
	private $prof_nombre;
	private $Materia;
	public $resultado=array();
	
	public function get_prof_codi(){
		return $this->prof_codi;
	}
	public function get_prof_nombre(){
		return $this->prof_nombre;
	}
	public function get_Materia(){
		return $this->Materia;
	}
        
        public function set_prof_codi($value){
		$this->prof_codi= $value;
	}
	public function set_prof_nombre($value){
		$this->prof_nombre= $value;
	}
	public function set_Materia($value){
		$this->Materia= $value;
	}
		
	
	public function getListaProfesores($alumnocodi,$pericodi)
	{
        $this->parametros = array($alumnocodi,$pericodi);
        $this->sp = "alum_list_prof";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
			$this->prof_codi=$this->rows[0]['prof_codi'];
			$this->prof_nombre=$this->rows[0]['prof_nombre'];
			$this->Materia=$this->rows[0]['Materia'];
			$this->resultado = array("prof_codi"=>$this->prof_codi,"prof_nombre"=>$this->prof_nombre,"Materia"=>$this->Materia);
        }
		else{
            $this->mensaje="mensaje no encontrado";
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