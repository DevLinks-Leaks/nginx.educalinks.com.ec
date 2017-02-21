<?php
if(!class_exists('DB_Abstract_mobile_main')){include 'db_abstract_mobile_main.php';}

class Clientes extends DB_Abstract_mobile_main
{
	private $host_client;
	private $db_client;
	private $uid_client;
	private $pwd_client;
    private $client_nomb;
	private $client_codi;
	
	
	public function set_usuario($value){
		$this->uid_client = $value;
	}
	public function set_clave($value){
		$this->pwd_client = $value;
	}
	public function set_host($value){
		$this->host_client = $value;
	}
	public function set_dbname($value){
		$this->db_client = $value;
	}
        public function set_client_nomb($value){
		$this->client_nomb = $value;
	}
        public function set_client_codi($value){
		$this->client_codi = $value;
	}
        public function set_client_carpeta($value){
		$this->client_codi = $value;
	}
	public function get_usuario(){
		return $this->uid_client;
	}
	public function get_clave(){
		return $this->pwd_client;
	}
	public function get_host(){
		return $this->host_client;
	}
	public function get_dbname(){
		return $this->db_client;
	}
        public function get_client_nomb(){
		return $this->client_nomb;
	}
        public function get_client_codi(){
		return $this->client_codi;
	}
        public function get_client_carpeta(){
		return $this->client_codi;
	}
	
	public function getClients($opci_codi)
	{
        $this->parametros = array($opci_codi);
        $this->sp = "clie_all_opci";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
            $this->mensaje="Clientes encontrados";
                        $this->client_nomb=$this->rows[0]['clie_nomb'];
                        $this->client_codi=$this->rows[0]['clie_codi'];
                        $this->client_carpeta=$this->rows[0]['clie_carpeta'];
        }
		else{
            $this->mensaje="Clientes no encontrados";
        }
    }
	public function getClientInfo($clie_codi)
	{
        $this->parametros = array($clie_codi);
        $this->sp = "clie_info";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
            $this->mensaje="Cliente encontrado";
			$this->db_client=$this->rows[0]['clie_base'];
			$this->uid_client=$this->rows[0]['clie_user_db'];
			$this->pwd_client=$this->rows[0]['clie_pass_db'];
			$this->host_client=$this->rows[0]['clie_instancia_db'];
                        
        }
		else{
            $this->mensaje="Cliente no encontrado";
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