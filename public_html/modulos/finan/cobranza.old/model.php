<?php
session_start();
require_once('../../../core/db_abstract_model.php');

class Cobranzas extends DBAbstractModel{
    #propiedades
    protected $clie_codigo;
    public $clie_nombres;
    public $clie_correoElectronico;
    public $clie_direccion;
    public $clie_telefono;
    public $deud_totalInicial;
    public $deud_totalPendiente;
    public $deud_fechaVencimiento;
    public $crm_resul_codigo;
    public $crm_resul_descripcion;
    public $deta_crm_resul_codigo;
    public $deta_crm_resul_descripcion;
    public $acerca_fecha_seguimiento;

    public function get_all_deud_deta($codigo=""){
        $this->parametros = array($codigo);
        $this->sp = "str_consultaCobranza_deudas";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Deudas encontradas";
        }else{
            $this->mensaje="Deudas no encontradas";
        }
    }
    public function get_all_deud_deta_info($codigo=""){
        $this->parametros = array($codigo);
        $this->sp = "str_consultadeudas_info";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Deudas encontradas";
        }else{
            $this->mensaje="Deudas no encontradas";
        }
    }
    public function get_all_deb_cob($cod_estudiante, 		$nombre_estudiante,		$fechanac_ini, 		$fechanac_fin,
									$id_titular,			$nombre_repr,			$id_cliente,		$periodos,
									$curso,					$grupoEconomico,		$nivelEconomico,	$estado)
	{   $this->parametros = array(	$cod_estudiante, 		$nombre_estudiante,		$fechanac_ini, 		$fechanac_fin,
									$id_titular,			$nombre_repr,			$id_cliente,		$periodos,
									$curso,					$grupoEconomico,		$nivelEconomico,	$estado,
									$_SESSION['usua_codigo']);
        $this->sp = "str_consultaCobranza_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="Deudores encontrados";
        }
		else
		{   $this->mensaje="Deudores no encontrados";
        }
    } 
    public function get_all_resultados($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaResultadoCRM_busq";
        $this->executeSPConsulta();
        if (count($this->rows)<=0){
            $this->mensaje="No existen resultados en la BD.";
        }else{
            $resul = array();
            foreach($this->rows as $resultados){
                array_push($resul, array_values($resultados));
            }
            $this->rows = $resul;
            unset($resul);
        }
    }
    public function get_all_resul_deta($codigo=""){
        $this->parametros = array($codigo);
        $this->sp = "str_consultaDetaResultadoCRM_info_resu";
        $this->executeSPConsulta();
        if (count($this->rows)<=0){
            $this->mensaje="No existen resultados en la BD.";
        }else{
            $resul = array();
            foreach($this->rows as $resultados){
                array_push($resul, array_values($resultados));
            }
            $this->rows = $resul;
            unset($resul);
        }
    }
    public function get_acercamientos($codigo=""){
        $this->parametros = array($codigo);
        $this->sp = "str_consultaAcerca_info";
        $this->executeSPConsulta();
         if (count($this->rows)>0){
            $this->mensaje="Acercamientos encontrados";
        }else{
            $this->mensaje="Acercamientos no encontrados";
        }
    }
    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaCobranza_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Deudor encontrado";
        }else{
            $this->mensaje="Deudor no encontrado";
        }
    }

    public function set ($data=array()){
        if (array_key_exists('resi_tipo_nombre',$data) && array_key_exists('resi_tipo_descripcion',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($resi_tipo_nombre, $resi_tipo_descripcion, $_SESSION['usua_codigo']);
            $this->sp = "str_consultaResiTipo_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Residencia agregada exitosamente";
            }else{
                $this->mensaje="No se ha agregado la Residencia";
            }
        }else{
            $this->mensaje="No se ha agregado la residencia - Faltan campos importantes.";
        }
    }

    public function guarda_acerca($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($clie_codigo, $clie_telefono, $clie_correoElectronico, $clie_direccion, $combo_resultado ,$combo_detalle_resultado,$observacion_resultado,$acerca_fecha_seguimiento,$deud_totalPendiente,$_SESSION['usua_codigo']);
        //print_r($this->parametros);
        $this->sp = "str_consultaAcerca_add";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Acercamiento guardado exitosamente";
        }else{
            $this->mensaje="Acercamiento no guardado";
        }
        print_r($this->parametros);
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