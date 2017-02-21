<?php
require_once('../../../core/db_abstract_model.php');

require_once('../../finan/clientes/model.php');
require_once('../../finan/facturas/model.php');
//require_once('../../finan/cobros/model.php');

class notaCredito extends DBAbstractModel{
	#propiedades
    public $codigo;
    public $numero;
    public $codigoAlumno;
    public $valor;

    public $nombreTitular;
    public $direccionTitular;
    public $telefonoTitular;
    public $emailTitular;
    public $codigoPago = 0;
	public $estado;
	
	public function get_notasCredito($estadoElectronico = '', $fechavenc_ini = '', $fechavenc_fin = '',
		$cod_titular = '', $id_titular = '', $cod_estudiante = '', $nombre_estudiante = '',
		$nombre_titular = '', $ptvo_venta = '', $sucursal = '', $ref_factura = '', $prod_codigo = '', 
		$estado = '', $tneto_ini = 0, $tneto_fin = 0, $periodo = 0, $grupoEconomico = 0, $nivelEconomico = 0, $curso = 0, $fechadeuda_ini = '', $fechadeuda_fin = '' ){
        $this->parametros = array($estadoElectronico, $fechavenc_ini, $fechavenc_fin,
									$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
									$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
									$estado, $tneto_ini, $tneto_fin, $periodo, $grupoEconomico, $nivelEconomico, $curso, $fechadeuda_ini, $fechadeuda_fin );
        $this->sp = "str_consultaNotascredito";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Notas de crédito encontradas.";
        }else{
            $this->mensaje="Notas de crédito no encontradas.";
        }

        return $this->rows;
    }
	public function get_notasCredito_excel($estadoElectronico = '', $fechavenc_ini = '', $fechavenc_fin = '',
		$cod_titular = '', $id_titular = '', $cod_estudiante = '', $nombre_estudiante = '',
		$nombre_titular = '', $ptvo_venta = '', $sucursal = '', $ref_factura = '', $prod_codigo = '', 
		$estado = '', $tneto_ini = 0, $tneto_fin = 0, $periodo = 0, $grupoEconomico = 0, $nivelEconomico = 0, $curso = 0, $fechadeuda_ini = '', $fechadeuda_fin = '' ){
        $this->parametros = array($estadoElectronico, $fechavenc_ini, $fechavenc_fin,
									$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
									$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
									$estado, $tneto_ini, $tneto_fin, $periodo, $grupoEconomico, $nivelEconomico, $curso, $fechadeuda_ini, $fechadeuda_fin );
        $this->sp = "str_consultaNotascredito_excel";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Notas de crédito encontradas.";
        }else{
            $this->mensaje="Notas de crédito no encontradas.";
        }

        return $this->rows;
    }
	
	public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
       
        $this->parametros = array($codigo, $tipoid, $numeroid, trim($repr_nomb), trim($repr_apel), trim($repr_domi), trim($repr_email), $repr_telf, $codigoAlumno, $ckb_docPendientes, $ckb_datosPersonales);
        $this->sp = "str_consultaDatosnotacredito_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Datos de nota de cr&eacute;dito guardados.";
        }else{
            $this->mensaje="¡Error! No se han actualizado los datos.";
        }
		return $this;
    }
	
	public function updNotaCreditoEstadoElec($estado,$claveAcceso,$numeroAutorizacion,$codigoNC,$ambiente,$tipoEmision) {
      
        $this->parametros = array($estado,$claveAcceso,$numeroAutorizacion,$codigoNC,$ambiente,$tipoEmision);
        $this->sp = "str_consultaNotacredito_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Datos de nota de cr&eacute;dito guardados.";
        }else{
            $this->mensaje="¡Error! No se han actualizado los datos.";
        }
    }
	public function set_estadoElectronico_estado($codigoFactura ,$estadoSRI = ''){
        $this->parametros = array($codigoFactura, $estadoSRI);
        $this->sp = "str_actualizaEstadoElectroniconotacreditoEstado";
        $this->executeSPAccion();
        if($this->codigo>0){
            $this->mensaje="Actualizado con exito el estado electrónico de la factura!";
        }else{
            $this->mensaje="Error al actualizar el estado electrónico de la factura";
        }
    }
	
	public function get_menu_count_notasCreditoPendienteToSRI(){
        $this->parametros = array();
        $this->sp = "str_consultaMenu_NotascreditoPendientesEnvioSRI";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Notas de crédito encontradas.";
        }else{
            $this->mensaje="Notas de crédito no encontradas.";
        }

        return $this->rows;
    }

    public function get_deudas(){
        if($this->codigoAlumno != ''){
            $this->parametros = array($this->codigoAlumno); 
            $this->sp = "str_consultaDeudasPendientesEstudiante";
            $this->executeSPConsulta();    
        }
        if (count($this->rows)>0){
            $this->mensaje="Deudas encontradas";
        }else{
            $this->mensaje="Deudas no encontradas";
        }
    }
	public function get_facturas_pagadas(){
		if($this->codigoAlumno != ''){
            $this->parametros = array($this->codigoAlumno); 
            $this->sp = "str_consultaFacturasPagadasEstudiante";
            $this->executeSPConsulta();    
        }
        if (count($this->rows)>0){
            $this->mensaje="Facturas encontradas";
        }else{
            $this->mensaje="Facturas no encontradas";
        }
	}
	
	public function getSingleNotaCredito($codigoFactura){
        if($codigoFactura!=""){
            $this->parametros = array($codigoFactura); 
            $this->sp = "str_consultaNotacreditoEspecifica";
            $this->executeSPConsulta();    

            if (count($this->rows)>0){
                array_pop($this->rows);
                $this->mensaje="Nota de cr&eacute;dito encontrada.";
            }else{
                $this->mensaje="Nota de cr&eacute;dito no encontrada.";
            }
        }else{
            $this->mensaje="Nota de cr&eacute;dito no buscada. Faltan datos.";
        }

        return $this->rows;   
    }
	
    public function setNotaCredito($datosNotaCredito = ''){
        $this->codigo = 0;
        $this->numero = 0;
        
        if($datosNotaCredito!=''){
            $this->parametros = array( $datosNotaCredito );
            $this->sp = "str_ingresaNotaCredito";
            $this->executeSPConsulta();
            if(count($this->rows)>0)
			{   $this->mensaje = "Nota de crédito registrada con éxito. ";
				$this->codigo = $this->rows[0]['codigo'];
                $this->numero = $this->rows[0]['numero'];
            }
			else
			{   $this->mensaje = "Error al registrar la nota de crédito: ".$this->ErrorToString();
            }
        }else{ 
            $this->mensaje = "No se generó la nota de crédito porque no se ha definido el XML con los datos";
        }
        return $this->codigo;
    }

    public function getSingleHeader($codigoNotaCredito){
        if($codigoNotaCredito != ''){
            $this->parametros = array($codigoNotaCredito);
            $this->sp = "str_consultaEspecificaNotaCredito";
            $this->executeSPConsulta();
            if(count($this->rows)>0){
                $this->mensaje="Registro de nota de crédito encontrada!";
            }else{
                $this->mensaje="Nota de crédito no encontrada.";
            }
        }else{
            $this->mensaje="No se procedió a la consulta por falta de datos.";
        }
        
        return $this->rows;   
    }
	
	public function getNotacreditoTrama($codigoNotaCredito){
        if($codigoNotaCredito != ''){
            $this->parametros = array($codigoNotaCredito);
            $this->sp = "str_consultaEspecificaNotaCreditotoXML";
            $this->executeSPConsulta();
            if(count($this->rows)>0){
                $this->mensaje="Detalles de la nota de crédito encontrados!";
            }else{
                $this->mensaje="Detalle no encontrado.";
            }
        }else{
            $this->mensaje="No se procedió a la consulta por falta de datos.";
        }
        
        return $this->rows;   
    }
    public function getDetails($codigoNotaCredito){
        if($codigoNotaCredito != ''){
            $this->parametros = array($codigoNotaCredito);
            $this->sp = "str_consultaEspecificaNotaCreditoDetalle";
            $this->executeSPConsulta();
            if(count($this->rows)>0){
                $this->mensaje="Detalles de la nota de crédito encontrados!";
            }else{
                $this->mensaje="Detalle no encontrado.";
            }
        }else{
            $this->mensaje="No se procedió a la consulta por falta de datos.";
        }
        
        return $this->rows;   
    }

}