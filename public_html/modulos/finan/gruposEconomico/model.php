<?php
require_once('../../../core/db_abstract_model.php');

class GrupoEconomico extends DBAbstractModel{
    #propiedades
    protected $codigo;
    public $nombre;
    public $descripcion;
	public $estado;

	public function get_all($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaGrupoEconomico_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Grupos Economico encontrados";
        }else{
            $this->mensaje="Grupos Economico no encontrados";
        }
    }
	public function getCategorias_selectFormat_with_all($busq="")
    {	$this->parametros = array($busq);
        $this->sp = "str_consultaGrupoEconomico_busq";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen grupos económicos en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione grupo -',
                                   3 => ''));
			array_push($rol, array(0 => 0, 
                                   1 => 'Todos',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione grupo -',
                                   3 => ''));
			array_push($rol, array(0 => 0, 
                                   1 => 'Todos',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
    public function getCategorias_selectFormat($busq=""){
        $busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaGrupoEconomico_busq";
        $this->executeSPConsulta();

        if (count($this->rows)<=0){
            $this->mensaje="No existen grupos económicos en la BD.";
        }else{
            $rol = array();
            foreach($this->rows as $gruposEconomico){
                array_push($rol, array_values($gruposEconomico));
            }

            $this->rows = $rol;
            unset($rol);
        }
    }

    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaGrupoEconomico_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Grupo Economico encontrado";
        }else{
            $this->mensaje="Grupo Economico no encontrado";
        }
    }

    public function set ($data=array()){
        if (array_key_exists('nombre',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($nombre, $descripcion, $codigoUsuario);
            $this->sp = "str_consultaGrupoEconomico_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Grupo Economico agregado exitosamente";
            }else{
                $this->mensaje="No se ha agregado el grupo economico";
            }
        }else{
            $this->mensaje="No se ha agregado el grupo economico - Faltan campos importantes.";
        }
    }

    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($codigo, $nombre, $descripcion);
        $this->sp = "str_consultaGrupoEconomico_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Grupo Economico actualizada exitosamente";
        }else{
            $this->mensaje="Grupo Economico no actualizada";
        }
    }

    public function delete($codigo='') {
        $this->parametros = array($codigo);
        $this->sp = "str_consultaGrupoEconomico_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Grupo Economico eliminado exitosamente";
        }else{
            $this->mensaje="No se ha eliminado el Grupo Economico";
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