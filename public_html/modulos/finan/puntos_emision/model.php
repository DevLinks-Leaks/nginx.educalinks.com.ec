<?php
session_start();
# Importar modelo de abstracción de base de datos
require_once('../../../core/db_abstract_model.php');

class PtoEmision extends DBAbstractModel{
    #propiedades
    public $puntVent_prefijo;
    public $puntVent_codigoSucursal;
    public $puntVent_secuencia;
    protected $puntVent_codigo;
    public $puntVent_estado;
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
            $this->sp = "str_consultaPtoVenta_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Punto de Emisión encontrado";
        }else{
            $this->mensaje="Punto de Emisión no encontrado";
        }
    }
    /*
     * Consulta todos los usuarios.
     * @access public
     */
    public function get_all($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaPtoVenta_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Puntos de Emisión encontrados";
        }else{
            $this->mensaje="Punto de Emisión no encontrados";
        }
    }
    public function get_all_sucursales($busq=""){
        $busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaSucursal_busq";
        $this->executeSPConsulta();

        if (count($this->rows)<=0){
            $this->mensaje="No existen sucursales en la BD.";
        }else{
            $sucursal = array();
            foreach($this->rows as $sucursales){
                array_push($sucursal, array_values($sucursales));
            }
            $this->rows = $sucursal;
            unset($sucursal);
        }
    }
    public function get_all_users($busq=""){
        $busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaPtoVenta_user_all";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Usuarios encontrados";
        }else{
            $this->mensaje="Usuarios no encontrados";
        }
    }
    public function get_all_users_asigned($codigo=""){
        $this->parametros = array($codigo);
        $this->sp = "str_consultaPtoVenta_user_asigned";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Usuarios encontrados";
        }else{
            $this->mensaje="Usuarios no encontrados";
        }
    }
    /*
     * Permite ingresar un nuevo usuario.
     * @param array $user_data Inforamcion a ingresar.
     * @access public
     */
    public function set ($data=array()){
        if (array_key_exists('puntVent_prefijo',$data) && array_key_exists('puntVent_codigoSucursal',$data) && array_key_exists('puntVent_secuencia',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($puntVent_prefijo,$puntVent_codigoSucursal,$puntVent_secuencia,$puntVent_secuencianc,$puntVent_estado);
            $this->sp = "str_consultaPtoVenta_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Punto de Emisión agregado exitosamente";
            }else{
                $this->mensaje="No se ha agregado el Punto de Emisión";
            }
        }else{
            $this->mensaje="No se ha agregado el Punto de Emisión";
        }
    }
    public function asign_user ($data=array()){
        foreach($data as $campo=>$valor){
            $$campo=$valor;
        }
        $this->parametros = array($puntVent_codigo,$usua_codigo,$_SESSION['usua_codigo']);
        $this->sp = "str_consultaUsuario_asign";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Usuario agregado exitosamente";
        }else{
            $this->mensaje="No se ha agregado el Usuario";
        }
    }
    public function del_asign_user ($usuaPvta_codigo){
        foreach($data as $campo=>$valor){
            $$campo=$valor;
        }
        $this->parametros = array($usuaPvta_codigo);
        $this->sp = "str_consultaUsuario_asign_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Usuario agregado exitosamente";
        }else{
            $this->mensaje="No se ha agregado el Usuario";
        }
    }
    /*
     * Permite actualizar la informacion de un usuario especifico.
     * @param array $user_data Informacion a actualizar.
     * @acces public
     */
    public function edit($data=array()) {
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
			if (array_key_exists('puntVent_prefijo',$data) && array_key_exists('puntVent_secuencia',$data) && array_key_exists('puntVent_secuencianc',$data)){
				$this->codigoVal=0;
				foreach ($data as $campo=>$valor) {
					$$campo = $valor;
				}
				$this->parametros = array($puntVent_codigo, $puntVent_prefijo, $puntVent_codigoSucursal, 
											$puntVent_secuencia, $puntVent_secuencianc, $puntVent_estado, $ckb_docPendientes);
				$this->sp = "str_consultaPtoVenta_upd";
				$this->executeSPAccion();
				if($this->filasAfectadas>0){
					$this->mensaje="¡Exito! Punto de Emisión modificado exitosamente.";
				}else{
					$this->mensaje="¡Error! No se ha actualizado el Punto de Emisión.";
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
        $this->sp = "str_consultaPtoVenta_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Punto de emisión eliminado.";
        }else{
            $this->mensaje="¡Advertencia! No se ha eliminado el Punto de Emisión.";
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