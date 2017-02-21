<?php
if(!class_exists('DB_Abstract_mobile')){include 'db_abstract_mobile.php';}

class Etapas extends DB_Abstract_mobile
{
	private $peridistcodi;
	private $peridistdeta;
	private $peridistdetapadr;
	public $resultado=array();
	
	public function set_pericodi($value){
		$this->pericodi = $value;
	}
	public function set_distipo($value){
		$this->distipo = $value;
	}
	public function set_etapcodi($value){
		$this->etapcodi = $value;
	}	
	
	public function get_pericodi(){
		return $this->pericodi;
	}
	public function get_distipo(){
		return $this->distipo;
	}
	public function get_etapcodi(){
		return $this->etapcodi;
	}
	
	
	
	public function getEtapas($pericodi, $distipo,$etapcodi)
	{
        $this->parametros = array($pericodi, $distipo,$etapcodi);
        $this->sp = "peri_dist_peri_view_Lb_etapa";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0)
		{
			 $this->peridistcodi=$this->rows[0]['peri_dist_codi'];
			 $this->peridistdeta=$this->rows[0]['peri_dist_deta'];
                         $this->peridistdetapadr=$this->rows[0]['peri_dist_deta_padr'];
            $this->mensaje="Usuario autenticado";
			$this->resultado = array("exito"=>"OK","mensaje"=>$this->mensaje,"peridistcodi"=>$this->peridistcodi,"peridistdeta"=>$this->peridistdeta,"peridistdetapadr"=>$this->peridistdetapadr);
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