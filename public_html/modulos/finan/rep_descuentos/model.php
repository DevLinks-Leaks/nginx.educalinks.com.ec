<?php
session_start();
# Importar modelo de abstracción de base de datos
require_once('../../../core/db_abstract_model.php');

class Rep_descuentos extends DBAbstractModel{
    #propiedades
    public $banc_nombre;
   
    protected $banc_codigo;
	public $banc_estado;
	public $banc_fechcreacion;
	public $banc_usucreacion;
   
    #metodos
    /*
     * Consulta un usuario especifico
     * @param string Correo Electronico del usuario
     * @access public
     */
    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaBanco_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Banco encontrado";
        }else{
            $this->mensaje="Banco no encontrado";
        }
    }
    /*
     * Consulta todos los usuarios.
     * @access public
     */
    public function get_all($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaBanco_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Bancos encontrados";
        }else{
            $this->mensaje="Bancos no encontradas";
        }
    }
	public function get_reportedescuentos($periodo=0, $curso=0, $tipo_descuento=0){
        $this->parametros = array($periodo, $curso, $tipo_descuento);
        $this->sp = "str_consultarpt_descuentosClientes";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Bancos encontrados";
        }else{
            $this->mensaje="Bancos no encontradas";
        }
    }
    /*
     * Permite ingresar un nuevo usuario.
     * @param array $user_data Inforamcion a ingresar.
     * @access public
     */
    public function set ($data=array()){
        if (array_key_exists('banc_nombre',$data) ){
			foreach($data as $campo=>$valor){
				$$campo=$valor;
			}
			$this->parametros = array($banc_nombre,$_SESSION['usua_codigo']);
			$this->sp = "str_consultaBanco_add";
			$this->executeSPAccion();
			if($this->filasAfectadas>0){
				$this->mensaje="Banco agregado exitosamente";
			}else{
				$this->mensaje="No se ha agregado el Banco";
            }
        }else{
            $this->mensaje="No se ha agregado el Banco";
        }
    }
    /*
     * Permite actualizar la informacion de un usuario especifico.
     * @param array $user_data Informacion a actualizar.
     * @acces public
     */
    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($banc_codigo,$banc_nombre);
        $this->sp = "str_consultaBanco_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Banco modificado exitosamente";
        }else{
            $this->mensaje="No se ha actualizado el banco";
        }
    }
    /*
     * Elimina un usuario especifico.
     * @param string $user_email Correo electronico del usuario a eliminar.
     * @access public
     */
    public function delete($codigo='') {
		$this->parametros = array($codigo);
        $this->sp = "str_consultaBanco_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Banco eliminado exitosamente";
        }else{
            $this->mensaje="No se ha eliminado el Banco";
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