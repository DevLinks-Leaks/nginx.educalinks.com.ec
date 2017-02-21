<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class Clases extends DB_Abstract_mobile
{
	private $alumCursParaMateCodi;
	private $cursParaMateCodi;
	private $materiaCodi;
	private $materiaDetalle;
	private $profNombre;
	private $profApellido;
        private $curs_para_mate_prof_codi;
        private $mater_count;
	public $resultado=array();
	
	public function get_alum_curs_para_mate_codi(){
		return $this->alum_curs_para_mate_codi;
	}
	public function get_curs_para_mate_codi(){
		return $this->curs_para_mate_codi;
	}
	public function get_mate_codi(){
		return $this->mate_codi;
	}
	public function get_mate_deta(){
		return $this->mate_deta;
	}
	public function get_prof_nomb(){
		return $this->prof_nomb;
	}
	public function get_prof_apel(){
		return $this->prof_apel;
	}
        public function get_curs_para_mate_prof_codi(){
		return $this->curs_para_mate_prof_codi;
	}
        public function get_mater_count(){
		return $this->mater_count;
	}
	
	public function set_alum_curs_para_mate_codi($value){
		$this->alum_curs_para_mate_codi= $value;
	}
	public function set_curs_para_mate_codi($value){
		$this->curs_para_mate_codi= $value;
	}
	public function set_mate_codi($value){
		$this->mate_codi= $value;
	}
	public function set_mate_deta($value){
		$this->mate_deta= $value;
	}
	public function set_prof_nomb($value){
		$this->prof_nomb= $value;
	}
	public function set_prof_apel($value){
		$this->prof_apel= $value;
	}
        public function set_curs_para_mate_prof_codi($value){
		$this->curs_para_mate_prof_codi= $value;
	}
        public function set_mater_count($value){
		$this->mater_count= $value;
	}

	public function getMaterias($alumCursParaCodi)
	{
        $this->parametros = array($alumCursParaCodi);
        $this->sp = "alum_curs_mate_app";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
			$this->alum_curs_para_mate_codi=$this->rows[0]['alum_curs_para_mate_codi'];
			$this->curs_para_mate_codi=$this->rows[0]['curs_para_mate_codi'];
			$this->mate_codi=$this->rows[0]['mate_codi'];
			$this->mate_deta=$this->rows[0]['mate_deta'];
			$this->prof_nomb=$this->rows[0]['prof_nomb'];
			$this->prof_apel=$this->rows[0]['prof_apel'];
                        $this->curs_para_mate_prof_codi=$this->rows[0]['curs_para_mate_prof_codi'];  
                        $this->mater_count=$this->rows[0]['mater_count'];                      
			$this->resultado = array("alumCursParaMateCodi"=>$this->alum_curs_para_mate_codi,"cursParaMateCodi"=>$this->curs_para_mate_codi,"cursParaMateProfCodi"=>$this->curs_para_mate_prof_codi, "materiaCodi"=>$this->mate_codi,"materiaDetalle"=>$this->mate_deta,"profNombre"=>$this->prof_nomb,"profApellido"=>$this->prof_apel,"mater_count"=>$this->mater_count);
        }
		else{
                        $this->mensaje="Clases no encontrada";
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