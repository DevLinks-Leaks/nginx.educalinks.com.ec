<?php
require_once('../../../core/db_abstract_model.php');
require_once('../../../includes/common/tcpdf/tcpdf.php');

require_once('../clientes/model.php');
require_once('../precios/model.php');
require_once('../items/model.php');

// 345.15
class Cobro extends DBAbstractModel{
    #propiedades
    public $codigo;
    public $codigoCliente;
    public $tipo_persona = 1;

    public $nombreTitular;
    public $direccionTitular;
    public $telefonoTitular;
    public $emailTitular;
    public $codigoPago = 0;
	public $tipoDocumento = 0;
	public $codigoDocumento = 0;
	public $estado;

    public function get_deudas()
	{   if($this->codigoCliente != '')
		{   $this->parametros = array($this->codigoCliente, $this->tipo_persona);
            $this->sp = "str_consultaDeudasPendientesEstudiante";
            $this->executeSPConsulta();    
        }
        if (count($this->rows)>0)
		{   $this->mensaje="Deudas encontradas";
        }
		else
		{   $this->mensaje="Deudas no encontradas";
        }
    }
	public function get_chequesprotestados()
	{   if($this->codigoCliente != '')
		{   $this->parametros = array($this->codigoCliente); 
            $this->sp = "str_consultaChequesProtestados";
            $this->executeSPConsulta();    
        }
        if (count($this->rows)>0)
		{   $this->mensaje="Deudas encontradas";
        }
		else
		{   $this->mensaje="Deudas no encontradas";
        }
    }
	public function get_deudasAnterioresVencidas($cabFact_codigo=0)
	{   $this->parametros = array($cabFact_codigo); 
		$this->sp = "str_consultaDeudasAnterioresVencidas";
		$this->executeSPConsulta();    
        if (count($this->rows)>0)
		{   $this->mensaje="Deudas encontradas";
        }
		else
		{   $this->mensaje="Deudas no encontradas";
        }
		array_pop($this->rows);
    }
	public function get_saldoafavor( $alum_codi = 0, $tipo_persona = 1 )
	{   $this->parametros = array( $alum_codi, $tipo_persona ); 
		$this->sp = "str_consultasaldoafavorcobro";
		$this->executeSPConsulta();    
        if (count($this->rows)>0)
		{   $this->mensaje="Deudas encontradas";
        }
		else
		{   $this->mensaje="Deudas no encontradas";
        }
		array_pop($this->rows);
    }
    public function get_cuentasBancariasSelectFormat()
	{   $this->parametros = array();
        $this->sp = "str_consultaGeneralCuentasBancarias";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{   $this->mensaje="No existen cuentas bancarias en la BD.";
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
            foreach($this->rows as $cuentaBancaria){
                array_push($bypass, array_values($cuentaBancaria));
            }

            $this->rows = $bypass;
            unset($bypass);
        }
    }
    public function setsaldo ($codigo, $valor, $usuario)
	{   $this->parametros = array($codigo, $valor, $usuario);
		$this->sp = "str_consultaSaldo_add";
		$this->executeSPAccion();
		if($this->filasAfectadas>0)
		{   $this->mensaje="Item agregado exitosamente";
		}
		else
		{   $this->mensaje="No se ha agregado el item";
		}
    }
	public function setPago($datosPago = '',$valor)
	{   $this->codigoPago = 0;
		$this->tipoDocumento = 0;
		$this->codigoDocumento = 0;
        
        if($datosPago!='')
		{   $this->parametros = array( $datosPago, $valor, $_SESSION['caja_codi'] );
            $this->sp = "str_ingresaPago";
            $this->executeSPConsulta();
			if (count($this->rows)>0)
			{   $this->mensaje="Pago registrado con exito";
				$this->codigoPago = $this->rows[0]['codigo_pago'];
			}
			else
			{   $this->mensaje="Error al registrar el pago";
			}
        }else
		{    $this->mensaje = "No se generó el pago porque no se ha definido el XML con los datos";
        }
        return $this->codigoPago;
    }
    public function get_deudaDetails($codigoDeuda)
	{   if($codigoDeuda != '')
		{   $this->parametros = array($codigoDeuda); 
            $this->sp = "str_consultaDetalleDeuda";
            $this->executeSPConsulta();    
        }
        if (count($this->rows)>0){
            $this->mensaje="Detalles encontrados";
        }
		else
		{   $this->mensaje="Detalles no encontrados";
        }
        return $this->rows;
    }
    public function get_pagosDeudaDetails($codigoDeuda)
	{   if($codigoDeuda != '')
		{   $this->parametros = array($codigoDeuda); 
            $this->sp = "str_consultaDetallePagosDeuda";
            $this->executeSPConsulta();    
        }
        if (count($this->rows)>0)
		{   $this->mensaje="Pagos de la deuda encontrados";
        }
		else
		{   $this->mensaje="Pagos de la deuda no encontrados";
        }
        return $this->rows;
    }

    public function get_documentosGenerados($codigoPago)
	{   if($codigoPago != '')
		{   $this->parametros = array($codigoPago); 
            $this->sp = "str_consultaDocumentosGenerados";
            $this->executeSPConsulta();   
            array_pop($this->rows); 
        }
        if (count($this->rows)>0)
		{   $this->mensaje="Facturas encontradas";
        }
		else
		{   $this->mensaje="Facturas no encontrados";
        }
        return $this->rows;   
    }


    public function get_deudasAfectadas($codigoPago)
	{   if($codigoPago != '')
		{   $this->parametros = array($codigoPago); 
            $this->sp = "str_consultaDeudasAfectadas";
            $this->executeSPConsulta();   
            array_pop($this->rows); 
        }
        if (count($this->rows)>0)
		{   $this->mensaje="Deudas Afectadas encontradas";
        }
		else
		{   $this->mensaje="Deudas Afectadas no encontradas";
        }
        return $this->rows;   
    }
    public function get_detallePagos($codigoPago)
	{   if($codigoPago != '')
		{   $this->parametros = array($_SESSION['peri_codi'], $codigoPago); 
            $this->sp = "str_consultaPagosRealizados";
            $this->executeSPConsulta();   
            array_pop($this->rows); 
        }
        if (count($this->rows)>0)
		{   $this->mensaje="Detalles de pagos encontrados";
        }
		else
		{   $this->mensaje="Detalles de pagos no encontrados";
        }
        return $this->rows;   
    }
    public function get_infoPago($codigoPago)
	{   if($codigoPago != '')
		{   $this->parametros = array($codigoPago); 
            $this->sp = "str_consultaInformacionPago";
            $this->executeSPConsulta();   
            array_pop($this->rows); 
        }
        if (count($this->rows)>0)
		{   $this->mensaje="Informacion del pago encontrada";
        }
		else
		{   $this->mensaje="Informacion del pago no encontrada";
        }
        return $this->rows;      
    }
	public function deuda_marcar_pagado_cero( $deud_codigo )
	{   $this->parametros = array($deud_codigo, $_SESSION['usua_codigo']);
        $this->sp = "str_deuda_marcar_pagado_cero";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Deuda marcada como pagada.";
        }
		else
		{   $this->mensaje="¡Error! No se pudo procesar la solicitud.";
        }
		return $this;
    }
	
    # Método constructor
    function __construct() {
        $this->codigo = 0;
        $this->codigoCliente = '';
        $this->nombreTitular = '';
        $this->direccionTitular = '';
        $this->telefonoTitular = '';
        $this->emailTitular = '';
        $this->codigoPago = 0;
        $this->estado = '';
    }

    # Método destructor del objeto
    function __destruct() {
        unset($this);
    }
}
?>