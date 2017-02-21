<?php
require_once('../../../core/db_abstract_model.php');

class NivelEconomico extends DBAbstractModel{
    #propiedades
    public $codigo;
    public $nombre;
    public $descripcion;
	public $estado;
	public $grupoeconomico;

    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaNivelEconomico_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Nivel económico contable encontrado";
        }else{
            $this->mensaje="Nivel económico no encontrado";
        }
    }
	public function getGrupoEconomico_SelectFormat($busq=""){
        $busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaGrupoEconomico_busq";
        $this->executeSPConsulta();

        if (count($this->rows)<=0){
            $this->mensaje="No existen grupos económicos en la BD.";
        }else{
            $rol = array();
            foreach($this->rows as $categorias){
                array_push($rol, array_values($categorias));
            }

            $this->rows = $rol;
            unset($rol);
        }
    }
	public function get_all($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaNivelEconomico_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Niveles económicos encontrados";
        }else{
            $this->mensaje="Niveles económicos no encontrados";
        }
    }

    public function get_niveles_economicos()
    {
        $this->parametros = array();
        $this->sp = "str_consultaNivelEconomico_cons";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
        {
            $nivel = array();

            array_push($nivel, array(0 => '-1', 
                                   1 => 'Seleccione...',
                                   3 => ''));

            foreach($this->rows as $niveles)
            {
                array_push($nivel, array_values($niveles));
            }
            // Agregar la opcion de ninguna categoria padre
            array_pop($nivel);
            array_push($nivel, array());

            $this->rows = $nivel;
            unset($nivel);
            $this->mensaje="Cursos encontrados";
        }
        else
        {
            $this->mensaje="Cursos no encontrados";
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => 'Seleccione...',
                                   3 => ''));
        }
    }


    public function set($data=array()){
        if (array_key_exists('nombre',$data)){
            foreach($data as $campo=>$valor){
                $$campo=$valor;
            }
            $this->parametros = array($nombre, $descripcion, $grupoeco, $codigoUsuario);
            $this->sp = "str_consultaNivelEconomico_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Nivel Económico agregado exitosamente";
            }else{
                $this->mensaje="No se ha agregado el Nivel Económico";
            }
        }else{
            $this->mensaje="No se ha agregado el Nivel Económico - Falta el nombre del mismo";
        }
    }

    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($codigo, $nombre, $grupoeco, $descripcion);
        $this->sp = "str_consultaNivelEconomico_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Nivel económico actualizado exitosamente";
        }else{
            $this->mensaje="Nivel económico no actualizado";
        }
    }

     public function delete($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($codigo);
        $this->sp = "str_consultaNivelEconomico_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Nivel económico eliminado exitosamente";
        }else{
            $this->mensaje="Nivel económico no eliminado";
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