<?php
session_start();
# Importar modelo de abstracción de base de datos
require_once('../../../core/db_abstract_model.php');

class saldoaFavor extends DBAbstractModel{
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
    public function get_all( $cuales )
	{   $this->parametros = array( $cuales );
        $this->sp = "str_consultaSaldo_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Carteras de saldos a favor encontradas";
        }
		else
		{   $this->mensaje="¡Error! Carteras de saldos a favor no encontradas";
        }
    }
	
	public function get_saf_historico( $cabeSaf_codigo  )
	{   $this->parametros = array( $cabeSaf_codigo  );
        $this->sp = "str_consultaSaldo_hist";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Historico de saldo a favor encontrado";
        }
		else
		{   $this->mensaje="¡Error! Historico de saldo a favor no encontrado";
        }
    }
	
    public function set( $valor, $alum_codi, $observacion, $concepto, $tipo_persona )
	{   if ( $valor == '' )
			$valor = 0;
		$this->parametros = array( $valor, $_SESSION['usua_codigo'], $alum_codi, $observacion, $concepto, NULL, $tipo_persona );
		//El procedimiento tiene otra variable, id_documento. que por aquí no se envía, así que se 'manda' como NULL.
		$this->sp = "str_consultaSaldo_add";
		$this->executeSPAccion();
		if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Saldo a favor agregado exitosamente";
		}
		else
		{   $this->mensaje="¡Error! No se ha agregado el saldo a favor";
		}
		echo $this->mensaje;
	}
    /*public function delete($codigo='')
	{   $this->parametros = array( $codigo );
        $this->sp = "str_consultaSaldo_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Saldo a favor eliminado exitosamente";
        }
		else
		{   $this->mensaje="¡Error! No se ha eliminado el Saldo a favor";
        }
    }*/
    public function saldo_marcar_como_devuelto($codigo='')
	{   $this->parametros = array($codigo);
        $this->sp = "str_consultaSaldo_devolver";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! ¡Saldo a favor marcado como devuelto!";
        }else{
            $this->mensaje="¡Error! No se completó la operación";
        }
    }
	public function set_saldoafavor_config( $saldo )
	{	$this->parametros = array( $saldo );
        $this->sp = "str_consultaSaldoadavor_config_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{	$this->mensaje="¡Exito! Su configuración ha sido cambiada.";
        }
		else
		{	$this->mensaje="¡Error! Ocurrió un problema con el cambio de la configuración";
        }
    }
	public function get_saldoafavor_config()
	{   $this->parametros = array();
        $this->sp = "str_consultaSaldoadavor_config_info";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
		{	foreach($this->rows[0] as $propiedad=>$valor)
			{	$this->$propiedad=$valor;
            }
        }
		else
		{	$this->mensaje="KO";
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