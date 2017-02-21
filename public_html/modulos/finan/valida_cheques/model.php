<?php
session_start();
# Importar modelo de abstracción de base de datos
require_once('../../../core/db_abstract_model.php');

class valida_cheques extends DBAbstractModel{
    #propiedades
 
   
    #metodos
    /*
     * Consulta un usuario especifico
     * @param string Correo Electronico del usuario
     * @access public
     */

    /*
     * Consulta todos los usuarios.
     * @access public
     */
    public function get_all( $filtro = 'PV' )
	{   $this->parametros = array( $filtro );
        $this->sp = "str_consultaCheque_busq";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Cheques encontrados";
        }
		else
		{   $this->mensaje="Cheques no encontradas";
        }
    }
	public function get_menu_count_chequesPendienteToValidate(){
        $this->parametros = array();
        $this->sp = "str_consultaMenu_ChequesPendientesValidar";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Cheques por validar encontrados.";
        }else{
            $this->mensaje="Cheques por validar no encontrados.";
        }
        return $this->rows;
    }
	public function aprobar($data=array())
	{   foreach ($data as $campo=>$valor)
		{   $$campo = $valor;
        }
        $this->parametros = array( $cheq_codigo, $_SESSION['usua_codi'] );
        $this->sp = "str_consultaChequeaprobar";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="Cheques aprobado";
        }else
		{   $this->mensaje="No se ha podido actualizar el cheque";
        }
    }
	public function protestar( $data = array() )
	{   foreach ( $data as $campo => $valor )
		{   $$campo = $valor;
        }
        $this->parametros = array( $cheq_codigo, $cheq_observacion, $alerta, $_SESSION['usua_codi'] );
        $this->sp = "str_consultaChequeprotestar";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="Cheques protestado";
        }
		else
		{   $this->mensaje="No se ha podido protestar el cheque";
        }
    }
    /*
     * Permite ingresar un nuevo usuario.
     * @param array $user_data Inforamcion a ingresar.
     * @access public
     */
  

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