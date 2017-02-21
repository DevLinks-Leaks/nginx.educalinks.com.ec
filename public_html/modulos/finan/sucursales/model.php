<?php
# Importar modelo de abstracción de base de datos
require_once('../../../core/db_abstract_model.php');

class Sucursal extends DBAbstractModel{
    #propiedades
    public $sucu_descripcion;
    public $sucu_direccion;
    public $sucu_prefijo;
    protected $sucu_codigo;
	public $sucu_estado;
	public $codigoVal;
   
    #metodos
    /*
     * Consulta un usuario especifico
     * @param string Correo Electronico del usuario
     * @access public
     */
    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaSucursal_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Sucursal encontrada";
        }else{
            $this->mensaje="Sucursal no encontrada";
        }
    }
    /*
     * Consulta todos los usuarios.
     * @access public
     */
    public function get_all($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaSucursal_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Sucursales encontradas";
        }else{
            $this->mensaje="Sucursales no encontradas";
        }
    }
    /*
     * Permite ingresar un nuevo usuario.
     * @param array $user_data Inforamcion a ingresar.
     * @access public
     */
    public function set ($data=array())
	{   if (isset($data['busq'])) 
			unset($data['busq']) ;
		
		$oneEmpty = false;
		foreach( $data as $val )
		{	if(strlen($val)==0)
			{	$oneEmpty = true;
			}
		}
		if($oneEmpty == false)
		{
			if (array_key_exists('sucu_descripcion',$data) && array_key_exists('sucu_prefijo',$data) && array_key_exists('sucu_direccion',$data)){
				foreach($data as $campo=>$valor){
					$$campo=$valor;
				}
				$this->parametros = array($sucu_descripcion,$sucu_direccion,$sucu_prefijo,$sucu_estado);
				$this->sp = "str_consultaSucursal_add";
				$this->executeSPAccion();
				if($this->filasAfectadas>0){
					$this->mensaje="¡Exito! Sucursal agregada exitosamente";
				}else{
					$this->mensaje="¡Error! No se ha agregado la sucursal";
				}
			}else{
				$this->mensaje="¡Error! No se ha agregado la sucursal";
			}
		}
		else
		{
			$this->mensaje="¡Error! Faltan campos importantes.";
		}
		return $this;
    }
    /*
     * Permite actualizar la informacion de un usuario especifico.
     * @param array $user_data Informacion a actualizar.
     * @acces public
     */
    public function edit($data=array()){
		if (isset($data['busq'])) 
			unset($data['busq']) ;
		
		$oneEmpty = false;
		foreach( $data as $val )
		{	if(strlen($val)==0)
			{	$oneEmpty = true;
			}
		}
		if($oneEmpty == false)
		{
			if (array_key_exists('sucu_descripcion',$data) && array_key_exists('sucu_direccion',$data) && array_key_exists('sucu_prefijo',$data)){
				$this->codigoVal=0;
				foreach ($data as $campo=>$valor) {
					$$campo = $valor;
				}
				$this->parametros = array($sucu_codigo,$sucu_descripcion,$sucu_direccion,$sucu_prefijo,$sucu_estado, $ckb_docPendientes);
				$this->sp = "str_consultaSucursal_upd";
				$this->executeSPAccion();
				if($this->filasAfectadas>0){
					$this->mensaje="¡Exito! Sucursal modificada exitosamente.";
				}else{
					$this->mensaje="¡Error! No se ha actualizado la sucursal.";
				}
			}else{
				$this->mensaje="¡Error! Faltan campos importantes.";
			}
		}
		else
		{
			$this->mensaje="¡Error! Faltan campos importantes.";
		}
		return $this;
    }
    /*
     * Elimina un usuario especifico.
     * @param string $user_email Correo electronico del usuario a eliminar.
     * @access public
     */
    public function delete($codigo='') {
		$this->parametros = array($codigo);
        $this->sp = "str_consultaSucursal_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Sucursal eliminada exitosamente.";
        }else{
            $this->mensaje="¡Error! No se ha eliminado la sucursal.";
        }
		return $this;
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