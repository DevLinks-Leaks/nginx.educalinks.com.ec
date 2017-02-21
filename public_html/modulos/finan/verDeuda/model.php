<?php
require_once('../../../core/db_abstract_model.php');

class Pagos extends DBAbstractModel{
    #propiedades
    public $numero;
    public $codigo;
    public $codigoCliente;
    public $nombreTitular;
    public $direccionTitular;
    public $telefonoTitular;
    public $emailTitular;
	public $estado;
	
	public function get_PagosRealizados($codigo_pago=0, $fechavenc_ini = '', $fechavenc_fin = '', $forma_pago = '',
		$cod_titular = '', $id_titular = '', $cod_estudiante = '', $nombre_estudiante = '',
		$nombre_titular = '', $ptvo_venta = '', $sucursal = '', $num_factura = '', $prod_codigo = '', 
		$estado = '', $tpago_ini = 0, $tpago_fin = 0)
	{
		$this->parametros = array($codigo_pago, $fechavenc_ini, $fechavenc_fin, $forma_pago,
		$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
		$nombre_titular, $ptvo_venta, $sucursal, $num_factura, $prod_codigo, 
		$estado, $tpago_ini, $tpago_fin); 
        $this->sp = "str_consultaPagosRealizados";
        $this->executeSPConsulta();

        if (count($this->rows)>1)
		{   $this->mensaje="Pagos realizados encontradas.";
        }else
		{   $this->mensaje="Pagos realizados no encontradas.";
        }
        return $this->rows;
    }
	public function get_formaPagoSelectFormat($busq='')
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaFormaPago_busq";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{   $this->mensaje="No existen formas depago en la BD.";
            array_pop($bypass);
            array_push($bypass, array(0 => '', 
                                   1 => 'Seleccione...',
                                   3 => ''));
            $this->rows = $bypass;
            unset($bypass);
        }
		else
		{   $bypass = array();
            array_pop($bypass);
            array_push($bypass, array(0 => '', 
                                   1 => 'Seleccione...',
                                   3 => ''));
            foreach($this->rows as $formasPago)
			{   array_push($bypass, array_values($formasPago));
            }
            $this->rows = $bypass;
            unset($bypass);
        }
    }
	public function revertir_factura( $codigo ){
        $this->parametros = array( $codigo );
		$this->sp = "str_factura_revertirPago";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   if ( $this->rows[0]['Estado'] == 'OK' )
				$this->mensaje="¡Exito! Pago eliminado. Deuda reviertida a Estado: 'Por cobrar'.";
			else
				$this->mensaje="¡Error! <b>No se pudo eliminar el pago.</b><br>Puede que la factura haya sido autorizada. Los pagos de facturas autorizadas no se pueden revertir.";
        }
		else
		{   $this->mensaje="¡Error! <b>No se pudo eliminar el pago.</b><br>Puede que la factura haya sido autorizada. Los pagos de facturas autorizadas no se pueden revertir.";
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