<?php
require_once('../../../core/db_abstract_model.php');

require_once('../clientes/model.php');
require_once('../precios/model.php');
require_once('../items/model.php');

// 345.15
class Descuentofacturas extends DBAbstractModel{
    #propiedades
    public $codigo;
    public $codigoCliente;
	public $tipo_persona;
    public $nombreTitular;
    public $direccionTitular;
    public $telefonoTitular;
    public $emailTitular;
    public $codigoPago = 0;
	public $estado;

    public function get_clientes($filtros=array()){
        if (array_key_exists('nombres',$filtros)){
            $this->parametros = array('nombres',$filtros['nombres']); 
        }else{
            $this->parametros = array('numeroIdentificacion',$filtros['numeroIdentificacion']); 
        }
        $this->sp = "str_consultaClienteParaCobro";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Clientes encontrados";
        }else{
            $this->mensaje="Clientes no encontrados";
        }
    }
	public function get_all( $busq = "" )
	{   $this->parametros = array( $busq );
        $this->sp = "str_consultaItem_busq";
        $this->executeSPConsulta();
		
        if (count($this->rows)>0)
		{   $this->mensaje="Items encontrados";
        }
		else
		{   $this->mensaje="Items no encontrados";
        }
    }
	public function get_all_deud_deta_info( $codigo = "" )
	{   $this->parametros = array( $codigo );
        $this->sp = "str_consultadeudas_info";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="Deudas encontradas";
        }
		else
		{   $this->mensaje="Deudas no encontradas";
        }
    }
	public function delete( $codigo = '' )
	{   $this->parametros = array( $codigo );
        $this->sp = "str_consultaFacturaDescto_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="Item eliminado exitosamente";
        }
		else
		{   $this->mensaje="No se ha eliminado el Item";
        }
    }
	
    public function get_deudas(){
        if($this->codigoCliente != ''){
            $this->parametros = array( $this->codigoCliente, $this->tipo_persona); 
            $this->sp = "str_consultaDeudasPendientesEstudiantedesc";
            $this->executeSPConsulta();    
        }
        if (count($this->rows)>0){
            $this->mensaje="Deudas encontradas";
        }else{
            $this->mensaje="Deudas no encontradas";
        }
    }
	public function get_deudasAnterioresVencidas($cabFact_codigo=0){        
		$this->parametros = array($cabFact_codigo); 
		$this->sp = "str_consultaDeudasAnterioresVencidas";
		$this->executeSPConsulta();    
        if (count($this->rows)>0){
            $this->mensaje="Deudas encontradas";
        }else{
            $this->mensaje="Deudas no encontradas";
        }
		array_pop($this->rows);
    }

    public function get_formaPagoSelectFormat($busq=''){
        $this->parametros = array($busq);
        $this->sp = "str_consultaFormaPago_busq";
        $this->executeSPConsulta();
        if (count($this->rows)<=0){
            $this->mensaje="No existen formas depago en la BD.";
            array_pop($bypass);
            array_push($bypass, array(0 => -1, 
                                   1 => 'SELECCIONE ..',
                                   3 => ''));
            $this->rows = $bypass;
            unset($bypass);
        }else{
            $bypass = array();
            array_pop($bypass);
            array_push($bypass, array(0 => -1, 
                                   1 => 'SELECCIONE ..',
                                   3 => ''));
            foreach($this->rows as $formasPago){
                array_push($bypass, array_values($formasPago));
            }

            $this->rows = $bypass;
            unset($bypass);
        }
    }
	  public function asignarDscto($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
       
        $this->parametros = array($codigodeuda, $valor_descuento, $porcentaje_descuento, $_SESSION['usua_codigo']);
        $this->sp = "str_consultaFacturaDescto_add";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Descuento asignado exitosamente";
        }else{
            $this->mensaje="Descuento no asignado";
        }
    }

	
	public function getDescuentos_factura($codigo=""){
        $this->parametros = array($codigo);
        $this->sp = "str_consultaFacturaDescto";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="descuentos encontrados";
        }else{
            $this->mensaje="Descuentos no encontrados";
        }
    }
    public function get_bancoSelectFormat(){
        $this->parametros = array();
        $this->sp = "str_consultaGeneralBancos";
        $this->executeSPConsulta();
        if (count($this->rows)<=0){
            $this->mensaje="No existen bancos en la BD.";
            array_pop($bypass);
            array_push($bypass, array(0 => -1, 
                                   1 => 'SELECCIONE ..',
                                   3 => ''));
            $this->rows = $bypass;
            unset($bypass);
        }else{
            $bypass = array();
            array_pop($bypass);
            array_push($bypass, array(0 => -1, 
                                   1 => 'SELECCIONE ..',
                                   3 => ''));
            foreach($this->rows as $banco){
                array_push($bypass, array_values($banco));
            }

            $this->rows = $bypass;
            unset($bypass);
        }
    }

    public function get_cuentasBancariasSelectFormat(){
        $this->parametros = array();
        $this->sp = "str_consultaGeneralCuentasBancarias";
        $this->executeSPConsulta();
        if (count($this->rows)<=0){
            $this->mensaje="No existen cuentas bancarias en la BD.";
            array_pop($bypass);
            array_push($bypass, array(0 => -1, 
                                      1 => 'SELECCIONE ..',
                                      3 => ''));
            $this->rows = $bypass;
            unset($bypass);
        }else{
            $bypass = array();
            array_pop($bypass);
            array_push($bypass, array(0 => -1, 
                                      1 => 'SELECCIONE ..',
                                      3 => ''));
            foreach($this->rows as $cuentaBancaria){
                array_push($bypass, array_values($cuentaBancaria));
            }

            $this->rows = $bypass;
            unset($bypass);
        }
    }

     public function get_tarjetasCreditoSelectFormat(){
        $this->parametros = array();
        $this->sp = "str_consultaGeneralTarjetasCredito";
        $this->executeSPConsulta();
        if (count($this->rows)<=0){
            $this->mensaje="No existen tarjetas de credito en la BD.";
            array_pop($bypass);
            array_push($bypass, array(0 => -1, 
                                   1 => 'SELECCIONE ..',
                                   3 => ''));
            $this->rows = $bypass;
            unset($bypass);
        }else{
            $bypass = array();
            array_pop($bypass);
            array_push($bypass, array(0 => -1, 
                                   1 => 'SELECCIONE ..',
                                   3 => ''));
            foreach($this->rows as $tajetaCredito){
                array_push($bypass, array_values($tajetaCredito));
            }

            $this->rows = $bypass;
            unset($bypass);
        }
    }

    public function setPago($datosPago = ''){
        $this->codigoPago = 0;
        
        if($datosPago!=''){
            $this->parametros = array(
                                    array($this->codigoPago, SQLSRV_PARAM_OUT),
                                    array($datosPago, SQLSRV_PARAM_IN)
                                    );
            $this->sp = "str_ingresaPago";
            $this->executeSPAccionOut();
            if($this->codigoPago > 0){
                $this->mensaje = "Pago registrado con exito";
            }else{
                $this->mensaje = "Error al registrar el pago";
            }
        }else{ 
            $this->mensaje = "No se generó el pago porque no se ha definido el XML con los datos";
        }
        return $this->codigoPago;
    }

    public function get_deudaDetails($codigoDeuda){
        if($codigoDeuda != ''){
            $this->parametros = array($codigoDeuda); 
            $this->sp = "str_consultaDetalleDeuda";
            $this->executeSPConsulta();    
        }
        if (count($this->rows)>0){
            $this->mensaje="Detalles encontrados";
        }else{
            $this->mensaje="Detalles no encontrados";
        }
        return $this->rows;
    }

    public function get_pagosDeudaDetails($codigoDeuda){
        if($codigoDeuda != ''){
            $this->parametros = array($codigoDeuda); 
            $this->sp = "str_consultaDetallePagosDeuda";
            $this->executeSPConsulta();    
        }
        if (count($this->rows)>0){
            $this->mensaje="Pagos de la deuda encontrados";
        }else{
            $this->mensaje="Pagos de la deuda no encontrados";
        }
        return $this->rows;
    }

    public function get_documentosGenerados($codigoPago){
        if($codigoPago != ''){
            $this->parametros = array($codigoPago); 
            $this->sp = "str_consultaDocumentosGenerados";
            $this->executeSPConsulta();   
            array_pop($this->rows); 
        }
        if (count($this->rows)>0){
            $this->mensaje="Facturas encontradas";
        }else{
            $this->mensaje="Facturas no encontrados";
        }
        return $this->rows;   
    }


    public function get_deudasAfectadas($codigoPago){
        if($codigoPago != ''){
            $this->parametros = array($codigoPago); 
            $this->sp = "str_consultaDeudasAfectadas";
            $this->executeSPConsulta();   
            //array_pop($this->rows); 
        }
        if (count($this->rows)>0){
            $this->mensaje="Deudas Afectadas encontradas";
        }else{
            $this->mensaje="Deudas Afectadas no encontradas";
        }
        return $this->rows;   
    }
    public function get_detallePagos($codigoPago){
        if($codigoPago != ''){
            $this->parametros = array($codigoPago); 
            $this->sp = "str_consultaPagosRealizados";
            $this->executeSPConsulta();   
            //array_pop($this->rows); 
        }
        if (count($this->rows)>0){
            $this->mensaje="Detalles de pagos encontrados";
        }else{
            $this->mensaje="Detalles de pagos no encontrados";
        }
        return $this->rows;   
    }
    public function get_infoPago($codigoPago){
        if($codigoPago != ''){
            $this->parametros = array($codigoPago); 
            $this->sp = "str_consultaInformacionPago";
            $this->executeSPConsulta();   
            array_pop($this->rows); 
        }
        if (count($this->rows)>0){
            $this->mensaje="Informacion del pago encontrada";
        }else{
            $this->mensaje="Informacion del pago no encontrada";
        }
        return $this->rows;      
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