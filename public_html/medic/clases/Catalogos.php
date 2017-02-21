<?php
session_start();
include_once('../../framework/db_abstract.php');
include_once('../framework/db_abstract.php');
class Catalogos extends DB_Abstract{
    //put your code here
    protected $idcatalogo;
    public $descripcion;
    protected $idpadre;
    public $cata_estado;
	
	public function set_idpadre($value){
		$this->idpadre = $value;
	}
	public function get_idpadre(){
		return $this->idpadre;
	}
	
	public function get_all_estados_civiles(){
        $this->parametros = array($this->idpadre);
        $this->sp = "cata_hijo_view";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Estados encontrados";
        }else{
            $this->mensaje="Estados no encontrados";
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