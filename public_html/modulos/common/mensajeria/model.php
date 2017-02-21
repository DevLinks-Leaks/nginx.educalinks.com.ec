<?php
require_once('../../../core/db_abstract_model.php');

class Mensaje extends DBAbstractModel{
	
	public function get_menu_count_smsPendienteLeer($usuario, $tipo_usuario){
        $this->parametros = array($usuario, $tipo_usuario);
        $this->sp = "str_consultaMenu_smsPendienteLeer";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Mensajes pendientes encontrados.";
        }else{
            $this->mensaje="Mensajes pendientes no encontrados.";
        }
		
        return $this->rows;
    }
	public function get_menu_count_smsTrash($usuario, $tipo_usuario){
        $this->parametros = array($usuario, $tipo_usuario);
        $this->sp = "str_consultaMenu_smsTrash";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Mensajes eliminados encontrados.";
        }else{
            $this->mensaje="Mensajes eliminados no encontrados.";
        }
		
        return $this->rows;
    }
	public function get_menu_count_smsIn($usuario, $tipo_usuario){
        $this->parametros = array($usuario, $tipo_usuario);
        $this->sp = "str_consultaMenu_smsIn";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Mensajes de entrada encontrados.";
        }else{
            $this->mensaje="Mensajes de entrada no encontrados.";
        }
		
        return $this->rows;
    }
	public function get_menu_detail_smsPendienteLeer($usuario, $tipo_usuario){
        $this->parametros = array($usuario, $tipo_usuario);
        $this->sp = "str_consultaMenu_smsPendienteLeer_detail";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Mensajes pendientes encontrados.";
        }else{
            $this->mensaje="Mensajes pendientes no encontrados.";
        }
		
        return $this->rows;
    }
	public function get_smsInbox($usuario, $tipo_usuario){
        $this->parametros = array($usuario, $tipo_usuario);
        $this->sp = "str_mensajes_smsInbox_detail";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Mensajes pendientes encontrados.";
        }else{
            $this->mensaje="Mensajes pendientes no encontrados.";
        }
		
        return $this->rows;
    }
	public function get_smsSentbox($usuario, $tipo_usuario){
        $this->parametros = array($usuario, $tipo_usuario);
        $this->sp = "str_mensajes_smsSentbox_detail";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Mensajes enviados encontrados.";
        }else{
            $this->mensaje="Mensajes enviados no encontrados.";
        }
		
        return $this->rows;
    }
	public function get_smsDraftbox($usuario, $tipo_usuario){
        $this->parametros = array($usuario, $tipo_usuario);
        $this->sp = "str_mensajes_smsDraftbox_detail";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Borradores encontrados.";
        }else{
            $this->mensaje="Borradores no encontrados.";
        }
		
        return $this->rows;
    }
	public function get_smsTrashbox($usuario, $tipo_usuario){
        $this->parametros = array($usuario, $tipo_usuario);
        $this->sp = "str_mensajes_smsTrashbox_detail";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Mensajes pendientes encontrados.";
        }else{
            $this->mensaje="Mensajes pendientes no encontrados.";
        }
		
        return $this->rows;
    }
	public function set_favorite($mens_codi){
        $this->parametros = array($mens_codi);
		$this->sp = "str_mensajes_favorite_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="¡Advertencia! Favorito chequeado.";
        }else{
            $this->mensaje="Error! No se pudo guardar.";
        }
		return $this;
    }
	public function get_mensaje_para_leer($mens_codi=""){
        $this->parametros = array($mens_codi);
        $this->sp = "str_mensajes_leer_mensaje";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Mensaje encontrado.";
        }else{
            $this->mensaje="Mensaje no encontrado.";
        }
        return $this->rows;
    }
	public function get_all($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaItem_busq";
        $this->executeSPConsulta();
		
        if (count($this->rows)>0){
            $this->mensaje="Items encontrados";
        }else{
            $this->mensaje="Items no encontrados";
        }
    }
	public function get_item_selectFormat($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaItem_busq";
        $this->executeSPConsulta();
		if (count($this->rows)<=0)
		{	$this->mensaje="¡Error! No existen items en el sistema.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'Seleccione ..',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'Seleccione...',
                                   3 => ''));
            foreach($this->rows as $item)
			{	array_push($rol, array_values($item));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
    public function getCategorias_selectFormat($busq=""){
        $busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaCategoria_busq";
        $this->executeSPConsulta();

        if (count($this->rows)<=0){
            $this->mensaje="No existen categorias en la BD.";
        }else{
            $rol = array();
            foreach($this->rows as $categorias){
                array_push($rol, array_values($categorias));
            }

            $this->rows = $rol;
            unset($rol);
        }
    }

    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaItem_info";
            $this->executeSPConsulta();
			
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Item encontrado";
        }else{
            $this->mensaje="Item no encontrado";
        }
    }

    public function set ($data=array()){
        if (array_key_exists('nombre',$data) && array_key_exists('categoria',$data) && array_key_exists('cuentaContable',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($nombre, $descripcion, $categoria, $cuentaContable, $aplicaIVA, $aplicaICE, $precioGeneral, $codigoUsuario,$descuento,$liquidez,$prontopago);
            $this->sp = "str_consultaItem_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Item agregado exitosamente";
            }else{
                $this->mensaje="No se ha agregado el item";
            }
        }else{
            $this->mensaje="No se ha agregado el item - Faltan campos importantes.";
        }
    }

    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($codigo, $nombre, $descripcion, $categoria, $aplicaIVA, $aplicaICE, $precioGeneral, $cuentaContable,$descuento,$liquidez,$prontopago);
        print_r($this->parametros);
        $this->sp = "str_consultaItem_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Item actualizada exitosamente";
        }else{
            $this->mensaje="Item no actualizada";
        }
    }

    public function delete($codigo='') {
        $this->parametros = array($codigo);
        $this->sp = "str_consultaItem_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Item eliminado exitosamente";
        }else{
            $this->mensaje="No se ha eliminado el Item";
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