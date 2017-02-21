<?php
# Importar modelo de abstracción de base de datos
require_once('../../core/db_abstract_model.php');

class Usuario extends DBAbstractModel{
    #propiedades
    public $usua_nombres;
    public $usua_apellidos;
    public $usua_correoElectronico;
    protected $usua_codigo;
    public $usua_estado;
   
    #metodos
    /*
     * Consulta un usuario especifico
     * @param string Correo Electronico del usuario
     * @access public
     */
    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaUsuario_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Usuario encontrado";
        }else{
            $this->mensaje="Usuario no encontrado";
        }
    }
    /*
     * Consulta todos los usuarios.
     * @access public
     */
    public function get_all($busq="")
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaUsuario_busq";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Usuarios encontrados";
        }
		else
		{   $this->mensaje="Usuarios no encontrados";
        }
    }
	public function get_all_tbl($busq="")
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaUsuario_busq_tbl";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Usuarios encontrados";
        }
		else
		{   $this->mensaje="Usuarios no encontrados";
        }
    }
	public function get_all_roles($busq=""){
		$busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaRolesUsuario_busq";
        $this->executeSPConsulta();

        if (count($this->rows)<=0){
            $this->mensaje="No existen roles de usuario en la BD.";
        }else{
            $rol = array();
            foreach($this->rows as $roles){
                array_push($rol, array_values($roles));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
    /*
     * Permite ingresar un nuevo usuario.
     * @param array $user_data Inforamcion a ingresar.
     * @access public
     */
    public function set ($data=array()){
        if (array_key_exists('usua_codigo',$data)){
			foreach($data as $campo=>$valor){
				$$campo=$valor;
			}
			$this->parametros = array($usua_codigo,$usua_nombres,$usua_apellidos,$usua_fechaNacimiento,$usua_correoElectronico,$usua_codigoRol,$usua_clave);
			$this->sp = "str_consultaUsuario_add";
			$this->executeSPAccion();
			if($this->filasAfectadas>0){
				$this->mensaje="Usuario agregado exitosamente";
			}else{
				$this->mensaje="No se ha agregado el usuario";
            }
        }else{
            $this->mensaje="No se ha agregado el usuario";
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
        
        $this->parametros = array($usua_codigo,$usua_nombres,$usua_apellidos,$usua_fechaNacimiento,$usua_correoElectronico,$usua_codigoRol,$usua_clave,$usua_estado);
        $this->sp = "str_consultaUsuario_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Usuario modificado exitosamente";
        }else{
            $this->mensaje="No se ha actualizado al usuario";
        }
    }
    /*
     * Elimina un usuario especifico.
     * @param string $user_email Correo electronico del usuario a eliminar.
     * @access public
     */
    public function delete($codigo='') {
		$this->parametros = array($codigo);
        $this->sp = "str_consultaUsuario_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Usuario eliminado exitosamente";
        }else{
            $this->mensaje="No se ha eliminado al usuario";
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