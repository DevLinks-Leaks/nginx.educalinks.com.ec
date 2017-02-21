<?php
session_start();
# Importar modelo de abstracción de base de datos
require_once('../../../core/db_abstract_model.php');

class tarjCredito extends DBAbstractModel{
    #propiedades
    public $tarjCred_nombre;

    public $tarjCred_bancod;
    protected $tarjCred_codigo;

    #metodos
    /*
     * Consulta un usuario especifico
     * @param string Correo Electronico del usuario
     * @access public
     */
    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultatarjetaCredito_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Tarjeta de Crédito encontrada";
        }else{
            $this->mensaje="Tarjeta de Crédito no encontrada";
        }
    }
	public function get_tarjetasfromCatologoSelectFormat( $all = 0 )
	{   $this->query = "select idcatalogo, descripcion from catalogo where idpadre=(select idcatalogo from catalogo where descripcion ='TARJETA DE CREDITO')";
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{   $this->mensaje="No existen bancos en la BD.";
            array_pop($bypass);
            array_push($bypass, array(0 => '', 
                                   1 => '- Seleccione tarjeta -',
                                   3 => ''));
				if ( $all == 1 )
					array_push($bypass, array(0 => '-1', 
										   1 => '- Todos -',
										   3 => ''));
            $this->rows = $bypass;
            unset($bypass);
        }
		else
		{   $bypass = array();
            array_pop($bypass);
            array_push($bypass, array(0 => '',
                                   1 => '- Seleccione tarjeta -',
                                   3 => ''));
				if ( $all == 1 )
					array_push($bypass, array(0 => '-1', 
										   1 => '- Todos -',
										   3 => ''));
            foreach($this->rows as $banco)
			{   array_push($bypass, array_values($banco));
            }

            $this->rows = $bypass;
            unset($bypass);
        }
		//var_dump($this);
    }
	public function get_tarjetasCreditoSelectFormat(){
		$this->parametros = array();
        $this->sp = "str_consultaGeneralTarjetasCredito";
        $this->executeSPConsulta();
        if (count($this->rows)<=0){
            $this->mensaje="No existen tarjetas de credito en la BD.";
            array_pop($bypass);
            array_push($bypass, array(0 => '', 
                                   1 => 'Seleccione...',
                                   3 => ''));
            $this->rows = $bypass;
            unset($bypass);
        }else{
            $bypass = array();
            array_pop($bypass);
            array_push($bypass, array(0 => '', 
                                   1 => 'Seleccione...',
                                   3 => ''));
            foreach($this->rows as $tajetaCredito){
                array_push($bypass, array_values($tajetaCredito));
            }

            $this->rows = $bypass;
            unset($bypass);
        }
    }
    public function get_all($busq="")
	{
        $this->parametros = array($busq);
        $this->sp = "str_consultarjetaCredito_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="Tarjetas de Crédito encontradas";
        }
		else
		{   $this->mensaje="Tarjetas de Crédito no encontradas";
        }
    }
    public function get_all_bancos($busq="")
	{   $busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaBanco_busq";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{   $this->mensaje="No existen bancos en la BD.";
        }
		else
		{   $banco = array();
            foreach($this->rows as $bancos)
			{   array_push($banco, array_values($bancos));
            }
            $this->rows = $banco;
            unset($banco);
        }
    }
    public function get_all_users($busq="")
	{
        $busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaPtoVenta_user_all";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="Usuarios encontrados";
        }
		else
		{   $this->mensaje="Usuarios no encontrados";
        }
    }
    public function get_all_users_asigned($codigo="")
	{
        $this->parametros = array($codigo);
        $this->sp = "str_consultaPtoVenta_user_asigned";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="Usuarios encontrados";
        }
		else
		{   $this->mensaje="Usuarios no encontrados";
        }
    }
    /*
     * Permite ingresar un nuevo usuario.
     * @param array $user_data Inforamcion a ingresar.
     * @access public
     */
    public function set ($data=array())
	{   if (array_key_exists('tarjCred_nombre',$data))
		{   foreach($data as $campo=>$valor)
			{   $$campo=$valor;
            }
            $this->parametros = array( $tarjCred_nombre, $_SESSION['usua_codigo'], $tarjCred_bancod, $es_internacional );
            $this->sp = "str_consultatarjetaCredito_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0)
			{   $this->mensaje="Tarjeta de Crédito agregado exitosamente";
            }
			else
			{   $this->mensaje="No se ha agregado la Tarjeta de Crédito";
            }
        }
		else
		{   $this->mensaje="No se ha agregado la Tarjeta de Crédito";
        }
    }
    public function asign_user ($data=array())
	{
        foreach($data as $campo=>$valor)
		{   $$campo=$valor;
        }
        $this->parametros = array($puntVent_codigo,$usua_codigo,$_SESSION['usua_codigo']);
        $this->sp = "str_consultaUsuario_asign";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="Usuario agregado exitosamente";
        }
		else
		{   $this->mensaje="No se ha agregado el Usuario";
        }
    }
    public function del_asign_user ($usuaPvta_codigo)
	{   foreach($data as $campo=>$valor)
		{   $$campo=$valor;
        }
        $this->parametros = array($usuaPvta_codigo);
        $this->sp = "str_consultaUsuario_asign_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="Usuario agregado exitosamente";
        }
		else
		{   $this->mensaje="No se ha agregado el Usuario";
        }
    }
    /*
     * Permite actualizar la informacion de un usuario especifico.
     * @param array $user_data Informacion a actualizar.
     * @acces public
     */
    public function edit($data=array())
	{
        foreach ($data as $campo=>$valor)
		{   $$campo = $valor;
        }
        
        $this->parametros = array( $tarjCred_bancod, $tarjCred_codigo, $tarjCred_nombre, $es_internacional );
        $this->sp = "str_consultatarjetaCredito_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="Tarjeta de Crédito modificado exitosamente";
        }else
		{   $this->mensaje="No se ha actualizado el Tarjeta de Crédito";
        }
    }
    /*
     * Elimina un usuario especifico.
     * @param string $user_email Correo electronico del usuario a eliminar.
     * @access public
     */
    public function delete($codigo='')
	{   $this->parametros = array($codigo);
        $this->sp = "str_consultatarjetaCredito_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="Tarjeta de Crédito eliminada exitosamente";
        }
		else
		{   $this->mensaje="No se ha eliminado la Tarjeta de Crédito";
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