<?php
require_once('../../../core/db_abstract_model.php');

class Cliente_xtn extends DBAbstractModel{
    #propiedades
    protected $codigo;
    public $tipoPersona;
    public $nombres;
    public $apellidos;
    public $tipoIdentificacion;
    public $numeroIdentificacion;
    public $direccion;
    public $telefono;
    public $email;
    public $estadoCivil;
    public $fechaNacimiento;
    public $estado;

	public function get_cliente_cl_ext_general( $cod_cliente, $nombre_cliente, $fechanac_ini, $fechanac_fin, $id_cliente, $estado )
	{   $this->parametros = array(	$cod_cliente, $nombre_cliente, $fechanac_ini, $fechanac_fin, $id_cliente, $estado );
        $this->sp = "str_consultaCliente_externo_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="Cliente(s) externo(s) encontrado(s)";
        }
		else
		{   $this->mensaje="Cliente(s) externo(s) no encontrado(s)";
        }
    }
	public function getDescuentos_cliente($codigo="", $estado='A', $tipo_persona='4' )
	{   $this->parametros = array($codigo, $estado, $tipo_persona );
        $this->sp = "str_consultaClienteDescto";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="Descuentos encontrados";
        }
		else
		{   $this->mensaje="Descuentos no encontrados";
        }
    }
	public function getDatosAdicionalesAlumno($alum_codi, $peri_codi, $tipo_persona = 4 )
	{   $this->parametros = array($alum_codi, $peri_codi, $tipo_persona);
        $this->sp = "str_consultadatosadicionalesCliente_info";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="¡Exito! Datos del estudiante encontrados.";
        }else{
            $this->mensaje="¡Exito! Datos del estudiante no encontrados.";
        }
    }
    public function getDescuento($codigoAlumno="", $codigoPeriodo="")
	{   $this->parametros = array($codigoAlumno, $codigoPeriodo);
        $this->sp = "str_consultaDescuentoAsignado";
        $this->executeSPConsulta();   
		
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Descuento(s) encontrado(s).";
        }
		else
		{   $this->mensaje="Descuento(s) no encontrado(s).";
        }
		return $this->rows;
    }

    public function get($codigo="", $tipo_persona="4"){
        if($codigo!=""){
            $this->parametros = array( $codigo, $tipo_persona );
            $this->sp = "str_consultaCliente_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Cliente encontrado";
        }else{
            $this->mensaje="Cliente no encontrado";
        }
    }
    public function getPorcentaje($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaDescuento_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Porcentaje encontrado";
        }else{
            $this->mensaje="Porcentaje no encontrado";
        }
    }

    public function set ($data=array()){
        if (array_key_exists('numeroIdentificacion',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($tipoPersona, $tipoIdentificacion, $numeroIdentificacion, $nombres, $apellidos, $direccion, $telefono, $email, $fechaNacimiento, $estadoCivil);
            $this->sp = "str_consultaCliente_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Cliente agregado exitosamente";
            }else{
                $this->mensaje="No se ha agregado el cliente";
            }
        }else{
            $this->mensaje="No se ha agregado el usuario - Falta el numero de identificacion";
        }
    }

    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($codigo, $tipoPersona, $tipoIdentificacion, $numeroIdentificacion, $nombres, $apellidos, $direccion, $telefono, $email, $fechaNacimiento, $estadoCivil);
        $this->sp = "str_consultaCliente_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Cliente actualizado exitosamente";
        }else{
            $this->mensaje="Cliente no actualizado";
        }
    }

    public function delete($codigo='') {
        $this->parametros = array($codigo);
        $this->sp = "str_consultaCliente_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Cliente eliminado exitosamente";
        }else{
            $this->mensaje="No se ha eliminado al cliente";
        }
    }


    public function getDscto_selectFormat($busq=""){
        $busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaDescuento_busq";
        $this->executeSPConsulta();

        if (count($this->rows)<=0){
            $this->mensaje="No existen descuentos en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione descuento -',
                                   3 => ''));
        }else{
            $rol = array();

            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione descuento -',
                                   3 => ''));
            foreach($this->rows as $dsctos){
                array_push($rol, array_values($dsctos));
            }

            $this->rows = $rol;
            unset($rol);
        }
    }
    public function asignarDscto($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
       
        $this->parametros = array(	$codigo, 		$codigo_descto, 		$porcentaje_descuento,
									$diasvalidez,	$_SESSION['usua_codigo'], $_SESSION['peri_codi'] );
        $this->sp = "str_consultaClienteDescto_add";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Descuento asignado exitosamente";
        }else{
            $this->mensaje="Descuento no asignado";
        }
    }
    public function getPeriodos_selectFormat(){
        $this->parametros = array();
        $this->sp = "str_consultaPeriodos";
        $this->executeSPConsulta();

        $temporal = array();
        if (count($this->rows)<=0){
            
            $this->mensaje="No existen periodos en la BD.";
            array_pop($temporal);
            array_push($temporal, array(0 => -1, 
                                   1 => 'Seleccione...',
                                   3 => ''));
        }else{
            array_pop($temporal);
            array_push($temporal, array(0 => -1, 
                                   1 => 'Seleccione...',
                                   3 => ''));
            foreach($this->rows as $periodos){
                array_push($temporal, array_values($periodos));
            }

            $this->rows = $temporal;
            unset($temporal);
        }
    }

    public function getCabeceraEstadoCuenta($codigoAlumno="", $codigoPeriodo="", $fechaInicio="", $fechaFin=""){
        if($codigoAlumno!=""){
            $this->parametros = array($codigoAlumno, ($codigoPeriodo==""? null : $codigoPeriodo ), ($fechaInicio==""? null : $fechaInicio), ($fechaFin==""? null : $fechaFin ));
            $this->sp = "str_consultaCabeceraEstadoCuenta_CE";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            $this->mensaje="Deudas Encontradas";
            array_pop($this->rows);
        }else{
            $this->mensaje="Deudas no encontradas";
        }
    }
 public function getCabeceraEstadoCuentatabla($codigoAlumno="", $codigoPeriodo="", $fechaInicio="", $fechaFin=""){
        if($codigoAlumno!=""){
            $this->parametros = array($codigoAlumno,$codigoPeriodo,$fechaInicio,$fechaFin );
            $this->sp = "str_consultaCabeceraEstadoCuentatabla_CE";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            $this->mensaje="Deudas Encontradas";
           
        }else{
            $this->mensaje="Deudas no encontradas";
        }
    }
    public function getDetalleEstadoCuenta($codigoDeuda=""){
        if($codigoDeuda!=""){
            $this->parametros = array($codigoDeuda);
            $this->sp = "str_consultaDetalleEstadoCuenta";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            $this->mensaje="Detalles de Pagos Encontradas";
            array_pop($this->rows);
        }else{
            $this->mensaje="Detalles no encontrados";
        }
    }

    public function getGrupoEconomicoAsignado($codigoEstudiante=""){
        if($codigoEstudiante!=""){
            $this->parametros = array($codigoEstudiante);
            $this->sp = "str_consultaGrupoEconomico_added";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            $this->mensaje="Registro encontrado";
            array_pop($this->rows);
        }else{
            $this->mensaje="Registro no encontrado";
        }
    }

    public function setGrupoEconomico($codigoEstudiante="", $codigoGrupoEconomico="") {
        if($codigoEstudiante!="" && $codigoGrupoEconomico!=""){
            $this->parametros = array($codigoEstudiante, $codigoGrupoEconomico);
            $this->sp = "str_consultaCliente_addGrupoEconomico";
            $this->executeSPAccion();
        }
        if($this->filasAfectadas>0){
            $this->mensaje="¡Exito! Grupo economico modificado.";
        }else{
            $this->mensaje="¡Error! Actualización no se pudo realizar.";
        }
		return $this;
    }
	public function delete_descuento( $codigo='' )
	{   $this->parametros = array( $codigo, $_SESSION['usua_codigo'] );
        $this->sp = "str_consultaDescuentoalumnos_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="Item eliminado exitosamente";
        }
		else
		{   $this->mensaje="No se ha eliminado el Item";
        }
    }
    public function deleteDeuda($codigoDeuda="") {
        if($codigoDeuda!=""){
            $this->parametros = array($codigoDeuda);
            $this->sp = "str_consultaDeuda_del";
            $this->executeSPAccion();
        }
        
        if($this->filasAfectadas>0){
            $this->mensaje="Deuda actualizada!";
        }else{
            $this->mensaje="Deuda no actualizada!";
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