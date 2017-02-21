<?php
require_once('../../../core/db_abstract_model.php');

require_once('../clientes/model.php');
require_once('../facturas/model.php');
//require_once('../cobros/model.php');

class notaDebito extends DBAbstractModel{
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
	
	public function get_notasDebito($estadoElectronico = '', $fechavenc_ini = '', $fechavenc_fin = '',
		$cod_titular = '', $id_titular = '', $cod_estudiante = '', $nombre_estudiante = '',
		$nombre_titular = '', $ptvo_venta = '', $sucursal = '', $ref_factura = '', 
		$estado = '', $tneto_ini = 0, $tneto_fin = 0){
        $this->parametros = array($estadoElectronico, $fechavenc_ini, $fechavenc_fin,
									$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
									$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, 
									$estado, $tneto_ini, $tneto_fin);
        $this->sp = "str_consultaNotasDebito";
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
        $this->sp = "str_consultaDatosNotasDebito_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Datos de nota de d&eacute;bito guardados.";
        }else{
            $this->mensaje="¡Error! No se han actualizado los datos.";
        }
		return $this;
    }
	
	public function updNotaDebitoEstadoElec($estado,$claveAcceso,$numeroAutorizacion,$codigoND,$ambiente,$tipoEmision) {
      
        $this->parametros = array($estado,$claveAcceso,$numeroAutorizacion,$codigoND,$ambiente,$tipoEmision);
        $this->sp = "str_consultaNotadebito_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Datos de nota de d&eacute;bito guardados.";
        }else{
            $this->mensaje="¡Error! No se han actualizado los datos.";
        }
    }
	public function set_estadoElectronico_estado($codigoFactura ,$estadoSRI = ''){
        $this->parametros = array($codigoFactura, $estadoSRI);
        $this->sp = "str_actualizaEstadoElectroniconotadebitoEstado";
        $this->executeSPAccion();
        if($this->codigo>0){
            $this->mensaje="Actualizado con exito el estado electrónico de la factura!";
        }else{
            $this->mensaje="Error al actualizar el estado electrónico de la factura";
        }
    }
	
	public function get_menu_count_notasDebitoPendienteToSRI(){
        $this->parametros = array();
        $this->sp = "str_consultaMenu_NotasdebitoPendientesEnvioSRI";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Notas de débito encontradas.";
        }else{
            $this->mensaje="Notas de débito no encontradas.";
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
	
	public function getSingleNotaDebito($codigoFactura){
        if($codigoFactura!=""){
            $this->parametros = array($codigoFactura); 
            $this->sp = "str_consultaNotadebitoEspecifica";
            $this->executeSPConsulta();    

            if (count($this->rows)>0){
                array_pop($this->rows);
                $this->mensaje="Nota de d&eacute;bito encontrada.";
            }else{
                $this->mensaje="Nota de d&eacute;bito no encontrada.";
            }
        }else{
            $this->mensaje="Nota de d&eacute;bito no buscada. Faltan datos.";
        }

        return $this->rows;   
    }
	
    public function setNotaDebito($datosNotaDebito = ''){
        $this->codigo = 0;
        $this->numero = 0;
        
        if($datosNotaDebito!=''){
            $this->parametros = array(
                                    array($datosNotaDebito, SQLSRV_PARAM_IN),
                                    array($this->codigo, SQLSRV_PARAM_OUT),
                                    array($this->numero, SQLSRV_PARAM_OUT)
                                    );
            $this->sp = "str_ingresaNotaDebito";
            $this->executeSPAccionOut();
            if($this->codigo > 0){
                $this->mensaje = "Nota de débito registrada con éxito. ";
            }else{
                $this->mensaje = "Error al registrar la nota de débito: ".$this->ErrorToString();
            }
        }else{ 
            $this->mensaje = "No se generó la nota de débito porque no se ha definido el XML con los datos";
        }
        return $this->codigo;
    }

    public function getSingleHeader($codigoNotaDebito){
        if($codigoNotaDebito != ''){
            $this->parametros = array($codigoNotaDebito);
            $this->sp = "str_consultaEspecificaNotaDebito";
            $this->executeSPConsulta();
            if(count($this->rows)>0){
                $this->mensaje="Registro de nota de débito encontrada!";
            }else{
                $this->mensaje="Nota de débito no encontrada.";
            }
        }else{
            $this->mensaje="No se procedió a la consulta por falta de datos.";
        }
        
        return $this->rows;   
    }
	
	public function getNotadebitoTrama($codigoNotaDebito){
        if($codigoNotaDebito != ''){
            $this->parametros = array($codigoNotaDebito);
            $this->sp = "str_consultaEspecificaNotaDebitotoXML";
            $this->executeSPConsulta();
            if(count($this->rows)>0){
                $this->mensaje="Detalles de la nota de débito encontrados!";
            }else{
                $this->mensaje="Detalle no encontrado.";
            }
        }else{
            $this->mensaje="No se procedió a la consulta por falta de datos.";
        }
        
        return $this->rows;   
    }
    public function getDetails($codigoNotaDebito){
        if($codigoNotaDebito != ''){
            $this->parametros = array($codigoNotaDebito);
            $this->sp = "str_consultaEspecificaNotaDebitoDetalle";
            $this->executeSPConsulta();
            if(count($this->rows)>0){
                $this->mensaje="Detalles de la nota de débito encontrados!";
            }else{
                $this->mensaje="Detalle no encontrado.";
            }
        }else{
            $this->mensaje="No se procedió a la consulta por falta de datos.";
        }
        return $this->rows;   
    }

}