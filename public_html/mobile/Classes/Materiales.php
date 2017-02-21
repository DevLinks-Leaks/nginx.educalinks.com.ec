<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}


class Materiales extends DB_Abstract_mobile
{
	private $mater_codi;
	private $mater_titu;
	private $mater_deta;
	private $mater_fech_regi;
	private $mater_file;
	public $resultado=array();
	
	public function get_mater_codi(){
		return $this->mater_codi;
	}
	public function get_mater_titu(){
		return $this->mater_titu;
	}
	public function get_mater_deta(){
		return $this->mater_deta;
	}
	public function get_mater_fech_regi(){
		return $this->mater_fech_regi;
	}
	public function get_mater_file(){
		return $this->mater_file;
	}

	
	public function set_mater_codi($value){
		$this->mater_codi= $value;
	}
	public function set_mater_titu($value){
		$this->mater_titu= $value;
	}
	public function set_mater_deta($value){
		$this->mater_deta= $value;
	}
	public function set_mater_fech_regi($value){
		$this->mater_fech_regi= $value;
	}
	public function set_mater_file($value){
		$this->mater_file= $value;
	}

	public function getMateriales($cursParaMateProfCodi)
	{
        $this->parametros = array($cursParaMateProfCodi);
        $this->sp = "curs_para_mate_mater_view";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
			$this->mater_codi=$this->rows[0]['mater_codi'];
			$this->mater_titu=$this->rows[0]['mater_titu'];
			$this->mater_deta=$this->rows[0]['mater_deta'];
			$this->mater_fech_regi=$this->rows[0]['mater_fech_regi'];
			$this->mater_file=$this->rows[0]['mater_file'];                     
			$this->resultado = array("mater_codi"=>$this->mater_codi,"mater_titu"=>$this->mater_titu,"mater_deta"=>$this->mater_deta, "mater_fech_regi"=>$this->mater_fech_regi,"mater_file"=>$this->mater_file);
        }
		else{
                        $this->mensaje="Materiales no encontrada";
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