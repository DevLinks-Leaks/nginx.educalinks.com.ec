<?php
session_start();
# Importar modelo de abstracción de base de datos
require_once('../../../core/db_abstract_model.php');

class Contabilidad extends DBAbstractModel{
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
	public function get($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaMigracioncontifico";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Bancos encontrados";
        }else{
            $this->mensaje="Bancos no encontradas";
        }
    }
	public function getproducto($codigo){
        $this->parametros = array($codigo);
        $this->sp = "str_consultaItem_infocontifico";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Bancos encontrados";
        }else{
            $this->mensaje="Bancos no encontradas";
        }
    }
	public function get_menu_count_deudasPendienteToCONTIFICO(){
        $this->parametros = array();
        $this->sp = "str_consultaMenu_deudasPendientesCONTIFICO";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Deudas pendientes encontradas.";
        }else{
            $this->mensaje="Deudas pendientes no encontradas.";
        }
		
        return $this->rows;
    }
	public function get_menu_count_pagosPendienteToCONTIFICO(){
        $this->parametros = array();
        $this->sp = "str_consultaMenu_pagosPendientesCONTIFICO";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Pagos pendientes encontradas.";
        }else{
            $this->mensaje="Pagos pendientes no encontradas.";
        }
		
        return $this->rows;
    }
	public function get_allcontifico($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaCategoria_busqcontifico";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Categorias encontrados";
        }else{
            $this->mensaje="Categorias no encontrados";
        }
    }
		public function get_deudas_individualmigracion($codigo){
		$this->parametros = array($codigo);
        $this->sp = "str_consultaMigracioncontificopagoindividual";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Productos encontrados";
        }else{
            $this->mensaje="Productos no encontrados";
        }
	}
	public function getfacturacontifico( $anio, $mes )
	{   $this->parametros = array( $anio, $mes );
        $this->sp = "str_consultaMigracioncontificopago";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="DNA's encontrados";
        }else{
            $this->mensaje="DNA's no encontradas";
        }
    }
		public function get_deudas_contifico($peri_codi){
		$this->parametros = array($peri_codi);
        $this->sp = "str_consultaDeudasContifico";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Productos encontrados";
        }else{
            $this->mensaje="Productos no encontrados";
        }
	}
		public function get_allproductos($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaItem_busqcontifico";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Categorias encontrados";
        }else{
            $this->mensaje="Categorias no encontrados";
        }
    }
  	public function getcaja($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaMigracioncontificocaja";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje=1;
        }else{
            $this->mensaje=0;
        }
    }
	public function upddeudacontifico( $codigo, $codigo_contifico, $estado )
	{   $this->parametros = array($codigo, $codigo_contifico, $estado, $_SESSION['usua_codigo'] );
        $this->sp = "str_consultapagocontifico_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Banco modificado exitosamente";
        }else{
            $this->mensaje="No se ha actualizado el banco";
        }
    }
	public function updfacturacontifico( $codigo )
	{   $this->parametros = array($codigo, $_SESSION['usua_codigo'] );
        $this->sp = "str_consultafacturacontifico_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Banco modificado exitosamente";
        }else{
            $this->mensaje="No se ha actualizado el banco";
        }
    }
 	public function fechas(){
        $this->parametros = array();
        $this->sp = "str_consultaMigracionyear";
        $this->executeSPConsulta();
        if (count($this->rows)<=0){
            $this->mensaje="No existen formas depago en la BD.";
            array_pop($bypass);
            array_push($bypass, array(0 => -1, 
                                   1 => '- Seleccione año -',
                                   3 => ''));
            $this->rows = $bypass;
            unset($bypass);
        }else{
            $bypass = array();
            array_pop($bypass);
            array_push($bypass, array(0 => -1, 
                                   1 => '- Seleccione año -',
                                   3 => ''));
            foreach($this->rows as $formasPago){
                array_push($bypass, array_values($formasPago));
            }

            $this->rows = $bypass;
            unset($bypass);
        }
    }
	    public function getdetallefactura($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaMigracioncontificodetfactura";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Banco encontrado";
        }else{
            $this->mensaje="Banco no encontrado";
        }
    }
	public function getdetallepago($codigo="",$codigodeuda){
        if($codigo!=""){
            $this->parametros = array($codigo,$codigodeuda);
            $this->sp = "str_consultaMigracioncontificodetpago";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Banco encontrado";
        }else{
            $this->mensaje="Banco no encontrado";
        }
    }
	public function getdetallepagolote($codigo="",$anio){
        if($codigo!=""){
            $this->parametros = array($codigo,$anio);
            $this->sp = "str_consultaMigracioncontificodetpagolote";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Banco encontrado";
        }else{
            $this->mensaje="Banco no encontrado";
        }
    }
	public function get_deudas_contificoindividual( $peri_codi, $mes )
	{   $this->parametros = array( $peri_codi, $mes );
        $this->sp = "str_consultapagoContificoindividual";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Productos encontrados";
        }else{
            $this->mensaje="Productos no encontrados";
        }
	}
	public function get_paidDNAs_contificoindividual( $peri_codi, $mes )
	{   $this->parametros = array( $peri_codi, $mes );
        $this->sp = "str_consultaPaid_DNAs_Contificoindividual";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Productos encontrados";
        }else{
            $this->mensaje="Productos no encontrados";
        }
	}
    /*
     * Consulta todos los usuarios.
     * @access public
     */
    public function get_all($busq="")
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaPagosContifico";
        $this->executeSPConsulta();
		
        if (count($this->rows)>0)
		{   $this->mensaje="Bancos encontrados";
        }
		else
		{   $this->mensaje="Bancos no encontradas";
        }
    }
    public function get_all_paid_dnas($busq="")
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaPaid_DNAs_Contifico";
        $this->executeSPConsulta();
		
        if (count($this->rows)>0){
            $this->mensaje="Bancos encontrados";
        }else{
            $this->mensaje="Bancos no encontradas";
        }
    }
    /*
     * Permite ingresar un nuevo usuario.
     * @param array $user_data Inforamcion a ingresar.
     * @access public
     */
    public function set ($data=array()){
        if (array_key_exists('banc_nombre',$data) ){
			foreach($data as $campo=>$valor){
				$$campo=$valor;
			}
			$this->parametros = array($banc_nombre,$_SESSION['usua_codigo']);
			$this->sp = "str_consultaBanco_add";
			$this->executeSPAccion();
			if($this->filasAfectadas>0){
				$this->mensaje="Banco agregado exitosamente";
			}else{
				$this->mensaje="No se ha agregado el Banco";
            }
        }else{
            $this->mensaje="No se ha agregado el Banco";
        }
    }
    /*
     * Permite actualizar la informacion de un usuario especifico.
     * @param array $user_data Informacion a actualizar.
     * @acces public
     */
    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($banc_codigo,$banc_nombre);
        $this->sp = "str_consultaBanco_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Banco modificado exitosamente";
        }else{
            $this->mensaje="No se ha actualizado el banco";
        }
    }
	public function updproducto($codigo,$codigo_contifico) {
        
        
        $this->parametros = array($codigo,$codigo_contifico);
        $this->sp = "str_consultaItem_updcontifico";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Banco modificado exitosamente";
        }else{
            $this->mensaje="No se ha actualizado el banco";
        }
    }
	  public function savecontifico($codigo,$codigocontifico) {
        
        
        $this->parametros = array($codigo,$codigocontifico);
        $this->sp = "str_consultaCategoria_updcontifico";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Categoria modificado exitosamente";
        }else{
            $this->mensaje="No se ha actualizado el Categoria";
        }
    }
	  public function updcaja($codigo) {
    
        
        $this->parametros = array($codigo);
        $this->sp = "str_consultaMigracioncontificocajaupd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Banco modificado exitosamente";
        }else{
            $this->mensaje="No se ha actualizado el banco";
        }
    }
    /*
     * Elimina un usuario especifico.
     * @param string $user_email Correo electronico del usuario a eliminar.
     * @access public
     */
    public function delete($codigo='') {
		$this->parametros = array($codigo);
        $this->sp = "str_consultaBanco_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Banco eliminado exitosamente";
        }else{
            $this->mensaje="No se ha eliminado el Banco";
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