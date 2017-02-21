<?php
# Importar modelo de abstracción de base de datos
require_once('../../core/db_abstract_model.php');

class RolesUsuario extends DBAbstractModel{
    #propiedades
    public $rol_nombre;
    public $rol_descripcion;
    public $rol_estado;
    protected $rol_codigo;
    
    #metodos
    /*
     * Consulta un usuario especifico
     * @param string Correo Electronico del usuario
     * @access public
     */
    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaRolesUsuario_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="rol de usuario encontrado";
        }else{
            $this->mensaje="rol de usuario no encontrado";
        }
    }
    /*
     * Consulta todos los usuarios.
     * @access public
     */
    public function get_all($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaRolesUsuario_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Roles de usuarios encontrados";
        }else{
            $this->mensaje="Roles de usuarios no encontrados";
        }
    }
    /*
     * Permite ingresar un nuevo rol usuario.
     * @param array $rol_user_data Inforamcion a ingresar.
     * @access public
     */
    public function set ($data=array()){
        if (array_key_exists('rol_nombre',$data)){
			foreach($data as $campo=>$valor){
				$$campo=$valor;
			}
			$this->parametros = array($rol_nombre,$rol_descripcion);
			$this->sp = "str_consultaRolUsuario_add";
			$this->executeSPAccion();
			if($this->filasAfectadas>0){
				$this->mensaje="Rol de usuario agregado exitosamente";
			}else{
				$this->mensaje="No se ha agregado el rol de usuario";
            }
        }else{
            $this->mensaje="No se ha agregado el rol de usuario";
        }
    }
    /*
     * Permite actualizar la informacion de un usuario especifico.
     * @param array $rol_user_data Informacion a actualizar.
     * @acces public
     */
    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($rol_nombre,$rol_descripcion,$rol_estado,$rol_codigo);
        $this->sp = "str_consultaRolUsuario_upd";
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
        $this->sp = "str_consultaRolUsuario_del";
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