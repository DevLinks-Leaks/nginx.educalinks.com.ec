<?php
require_once('../../../core/db_abstract_model.php');

require_once('../clientes/model.php');
require_once('../precios/model.php');
require_once('../items/model.php');

// 345.15
class Factura extends DBAbstractModel{
    #propiedades
    public $numero;
    public $codigo;
    public $codigoCliente;
    public $nombreTitular;
    public $direccionTitular;
    public $telefonoTitular;
    public $emailTitular;
	public $estado;
	
	public function get_metodo_descuento_alumno()
	{   $this->parametros = array(  );
		$this->query = "select para_sist_valu from Parametros_sistemas where para_sist_codi = 509;";
		$this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{    $this->mensaje="Método encontrado.";
        }
		else
		{    $this->mensaje="Método no encontrado.";
        }
		return $this->rows[0]['para_sist_valu'];
	}
	public function get_facturas($estadoElectronico = '', $fechaemision_ini = '', $fechaemision_fin = '',
		$cod_titular = '', $id_titular = '', $cod_estudiante = '', $nombre_estudiante = '',
		$nombre_titular = '', $ptvo_venta = '', $sucursal = '', $ref_factura = '', $prod_codigo = '', 
		$estado = '', $tneto_ini = 0, $tneto_fin = 0, $periodo = 0, $grupoEconomico = 0, $nivelEconomico = 0, $curso = 0, $fechadeuda_ini = '', $fechadeuda_fin = '',
		$fechaAut_ini = '', $fechaAut_fin = '', $convenioPago = 0 ){
        $this->parametros = array($estadoElectronico, $fechaemision_ini, $fechaemision_fin,
									$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
									$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
									$estado, $tneto_ini, $tneto_fin, $periodo, $grupoEconomico, $nivelEconomico, $curso, $fechadeuda_ini, $fechadeuda_fin,
									$fechaAut_ini, $fechaAut_fin, $convenioPago );
        $this->sp = "str_consultaFacturas";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="Facturas encontradas.";
        }else
		{   $this->mensaje="Facturas no encontradas.";
        }
        return $this->rows;
    }
	public function get_facturas_to_excel($estadoElectronico = '', $fechaemision_ini = '', $fechaemision_fin = '',
		$cod_titular = '', $id_titular = '', $cod_estudiante = '', $nombre_estudiante = '',
		$nombre_titular = '', $ptvo_venta = '', $sucursal = '', $ref_factura = '', $prod_codigo = '', 
		$estado = '', $tneto_ini = 0, $tneto_fin = 0, $periodo = 0, $grupoEconomico = 0, $nivelEconomico = 0, $curso = 0, $fechadeuda_ini = '', $fechadeuda_fin = '',
		$fechaAut_ini = '', $fechaAut_fin = '', $convenioPago = 0 ){
        $this->parametros = array($estadoElectronico, $fechaemision_ini, $fechaemision_fin,
									$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
									$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
									$estado, $tneto_ini, $tneto_fin, $periodo, $grupoEconomico, $nivelEconomico, $curso, $fechadeuda_ini, $fechadeuda_fin,
									$fechaAut_ini, $fechaAut_fin, $convenioPago );
        $this->sp = "str_consultaFacturas_excel";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Facturas encontradas.";
        }else{
            $this->mensaje="Facturas no encontradas.";
        }
        return $this->rows;
    }
	public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
       
        $this->parametros = array($codigo, $tipoid, $numeroid, trim($repr_nomb), trim($repr_apel), trim($repr_domi), trim($repr_email), $repr_telf, $codigoAlumno, $ckb_docPendientes, $ckb_datosPersonales);
        $this->sp = "str_consultaDatosfactura_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Datos de factura guardados.";
        }else{
            $this->mensaje="¡Error! No se han actualizado los datos.";
        }
		return $this;
    }
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
    public function get_infoFacturacionCliente(){
        if($this->codigoCliente != ''){
            $this->parametros = array($this->codigoCliente); 
            $this->sp = "str_consultaDatosFacturaCliente";
            $this->executeSPConsulta();    
        }

        if (count($this->rows)>0){
            $this->mensaje="Datos encontrados";
        }else{
            $this->mensaje="Datos no encontrados";
        }
    }
    public function get_infoAdicionalAlumno($peri_codi )
	{   $this->parametros = array($this->codigoCliente, $peri_codi );
		$this->sp = "str_consultaDatosAdicionalesCliente_info";
		$this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="Datos encontrados";
        }
		else
		{   $this->mensaje="Datos no encontrados";
        }
    }
    public function get_etapasSelectFormat(){
        $this->parametros = array($this->codigoCliente);
        $this->sp = "str_consultaEtapasAsignadasAClientes";
        $this->executeSPConsulta();
        if (count($this->rows)<=0){
            $this->mensaje="No existen etapas asignadas en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'SELECCIONE ETAPA ..',
                                   3 => ''));
        }else{
            $rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'SELECCIONE ETAPA ..',
                                   3 => ''));
            foreach($this->rows as $etapas){
                array_push($rol, array_values($etapas));
            }

            $this->rows = $rol;
            unset($rol);
        }
    }
    public function get_manzanasSelectFormat($codigoEtapa){
        $this->parametros = array($this->codigoCliente, $codigoEtapa);
        $this->sp = "str_consultaManzanasAsignadasAClientes";
        $this->executeSPConsulta();

        if (count($this->rows)<=0){
            $this->mensaje="No existen manzanas asignadas en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'SELECCIONE MANZANA ..',
                                   3 => ''));
        }else{
            $rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'SELECCIONE MANZANA ..',
                                   3 => ''));
            foreach($this->rows as $manzanas){
                array_push($rol, array_values($manzanas));
            }

            $this->rows = $rol;
            unset($rol);
        }
    }
    public function get_villasSelectFormat($codigoEtapa, $codigoManzana){
        $this->parametros = array($this->codigoCliente, $codigoEtapa, $codigoManzana);
        $this->sp = "str_consultaVillasAsignadasAClientes";
        $this->executeSPConsulta();

        if (count($this->rows)<=0){
            $this->mensaje="No existen villas asignadas en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'SELECCIONE VILLA ..',
                                   3 => ''));
        }else{
            $rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'SELECCIONE VILLA ..',
                                   3 => ''));
            foreach($this->rows as $villas){
                array_push($rol, array_values($villas));
            }

            $this->rows = $rol;
            unset($rol);
        }
    }
    public function getPrefijos($codigoUsuario = ''){
        if($codigoUsuario != ''){
            $this->parametros = array($codigoUsuario);
            $this->sp = "str_consultaPrefijos";
            $this->executeSPConsulta();
            if(count($this->rows)>0){
                $this->mensaje="Prefijos encontrados!";
            }else{
                $this->mensaje="Prefijos no encontrados - Usuario no está asignado a un punto de emision";
            }
        }else{
            $this->mensaje="No se proveyó un nombre de usuario correcto";
        }
        
        return $this->rows;
    }
    public function set($datosFactura = ''){
        $this->codigo = 0;
        $this->numero = 0;
        $this->parametros = array(
                                array($datosFactura, SQLSRV_PARAM_IN), 
                                array($this->codigo, SQLSRV_PARAM_OUT)
                                );
        $this->sp = "str_ingresaFactura";
        $this->executeSPAccion();
        if($this->codigo>0){
            $this->mensaje="Factura generada con exito!";
        }else{
            $this->mensaje="Error al generar la factura";
        }
    }
    public function getSingleHeader($codigoFactura){
        if($codigoFactura != ''){
            $this->parametros = array($codigoFactura);
            $this->sp = "str_consultaEspecificaFactura";
            $this->executeSPConsulta();
            if(count($this->rows)>0){
                $this->mensaje="Registro de factura encontrada!";
            }else{
                $this->mensaje="Factura no encontrada.";
            }
        }else{
            $this->mensaje="No se procedió a la consulta por falta de datos.";
        }
        
        return $this->rows;   
    }
    public function getDetails($codigoFactura){
        if($codigoFactura != ''){
            $this->parametros = array($codigoFactura);
            $this->sp = "str_consultaEspecificaFacturaDetalle";
            $this->executeSPConsulta();
            if(count($this->rows)>0){
                $this->mensaje="Detalles de factura encontrados!";
            }else{
                $this->mensaje="Detalle no encontrado.";
            }
        }else{
            $this->mensaje="No se procedió a la consulta por falta de datos.";
        }
        
        return $this->rows;   
    }
    public function get_porcentajeIVA(){
        $this->parametros = array(); 
        $this->sp = "str_consultaPorcentajeActualIVA";
        $this->executeSPConsulta();    

        if (count($this->rows)>0){
            foreach ($this->rows[0] as $campo => $valor) {
                $this->$campo = $valor;
            }
            $this->mensaje="Porcentaje del IVA encontrado.";
        }else{
            $this->mensaje="Porcentaje del IVA no encontrado.";
        }

        return $this->rows[0]['porcentajeIVA'];
    }
    public function get_facturaToFormatXML( $codigoFactura ){
        $this->parametros = array($codigoFactura); 
        $this->sp = "str_consultaFacturaToFormatXML";
        $this->executeSPConsulta();    

        if (count($this->rows)>0){
            array_pop($this->rows);
            $this->mensaje="Factura encontrada.";
        }else{
            $this->mensaje="Factura no encontrada.";
        }

        return $this->rows;
    }
	public function get_facturaToFormatXML_pagos( $codigoFactura )
	{   $this->parametros = array($codigoFactura); 
        $this->sp = "str_consultaFacturaToFormatXML_pagos";
        $this->executeSPConsulta();    

        if (count($this->rows)>0){
            array_pop($this->rows);
            $this->mensaje="Datos encontrados.";
        }else{
            $this->mensaje="Datos no encontrados.";
        }

        return $this->rows;
    }
    public function get_facturaToFormatXMLandUpdateValues( $codigoFactura, $puntVent_codigo ){
        $this->parametros = array($codigoFactura, $puntVent_codigo); 
        $this->sp = "str_consultaFacturaToFormatXMLandUpdateValues";
        $this->executeSPConsulta();    

        if (count($this->rows)>0){
            array_pop($this->rows);
            $this->mensaje="Factura encontrada.";
        }else{
            $this->mensaje="Factura no encontrada.";
        }

        return $this->rows;
    }
    public function set_estadoElectronico($codigoFactura ,$estadoSRI = '', $numeroAutorizacion = null, $claveAcceso = null, $tipoEmision = null, $ambiente = null){
        $this->parametros = array($codigoFactura, $estadoSRI, $numeroAutorizacion, $claveAcceso, $tipoEmision, $ambiente);
        $this->sp = "str_actualizaEstadoElectronicoFactura";
        $this->executeSPAccion();
        if($this->codigo>0){
            $this->mensaje="Actualizado con exito el estado electrónico de la factura!";
        }else{
            $this->mensaje="Error al actualizar el estado electrónico de la factura";
        }
    }
	public function set_estadoElectronico_estado($codigoFactura ,$estadoSRI = ''){
        $this->parametros = array($codigoFactura, $estadoSRI);
        $this->sp = "str_actualizaEstadoElectronicoFacturaEstado";
        $this->executeSPAccion();
        if($this->codigo>0){
            $this->mensaje="Actualizado con exito el estado electrónico de la factura!";
        }else{
            $this->mensaje="Error al actualizar el estado electrónico de la factura";
        }
    }
	public function get_query_bancos($tipo='BANCO',$pension=9,$periodo=10){
		$this->parametros = array($tipo, $pension, $periodo);
        $this->sp = "str_consultaQueryBancos";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Facturas encontradas.";
        }else{
            $this->mensaje="Facturas no encontradas.";
        }
        return $this->rows;
    }
	public function get_menu_count_facturasPendienteToSRI()
	{   $this->parametros = array();
        $this->sp = "str_consultaMenu_FacturasPendientesSRI";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Facturas pendientes encontradas.";
        }else{
            $this->mensaje="Facturas pendientes no encontradas.";
        }
        return $this->rows;
    }
	public function get_menu_count_facturasPendienteConvenioPago()
	{   $this->parametros = array();
        $this->sp = "str_consultaMenu_FacturasPendientesConvenioPago";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Facturas pendientes encontradas.";
        }else{
            $this->mensaje="Facturas pendientes no encontradas.";
        }
        return $this->rows;
    }
	public function getSingleDeuda($codigoDeuda){
        if($codigoDeuda!=""){
            $this->parametros = array($codigoDeuda); 
            $this->sp = "str_consultaDeudaEspecifica";
            $this->executeSPConsulta();    

            if (count($this->rows)>0){
                array_pop($this->rows);
                $this->mensaje="Factura encontrada.";
            }else{
                $this->mensaje="Factura no encontrada.";
            }
        }else{
            $this->mensaje="Factura no buscada. Faltan datos.";
        }

        return $this->rows;   
    }
	public function getSingleFactura( $codigoFactura, $tipo_persona = '1' ){
        if($codigoFactura!=""){
            $this->parametros = array( $codigoFactura, $tipo_persona ); 
            $this->sp = "str_consultaFacturaEspecifica";
            $this->executeSPConsulta();    

            if (count($this->rows)>0){
                array_pop($this->rows);
                $this->mensaje="Factura encontrada.";
            }else{
                $this->mensaje="Factura no encontrada.";
            }
        }else{
            $this->mensaje="Factura no buscada. Faltan datos.";
        }

        return $this->rows;   
    }
    public function getSingle($codigoFactura){
        if($codigoFactura!=""){
            $this->parametros = array($codigoFactura); 
            $this->sp = "str_consultaFacturaEspecifica";
            $this->executeSPConsulta();    

            if (count($this->rows)>0){
                array_pop($this->rows);
                $this->mensaje="Factura encontrada.";
            }else{
                $this->mensaje="Factura no encontrada.";
            }
        }else{
            $this->mensaje="Factura no buscada. Faltan datos.";
        }
        return $this->rows;   
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