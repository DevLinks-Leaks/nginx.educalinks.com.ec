<?php
require_once('../../../core/db_abstract_model.php');

class NivelEconomicoCursos extends DBAbstractModel{
    #propiedades
    public $codigo;
    public $curso;
    public $curs_deta;
    public $nivelEconomico;
	public $estado;

    public function get($codigo=""){
        if($codigo!=""){
            $this->parametros = array($codigo);
            $this->sp = "str_consultaNivelEconomicoCurso_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Registro encontrado";
        }else{
            $this->mensaje="Registro no encontrado";
        }
    }

	public function get_all($busq=""){
        $this->parametros = array($busq);
        $this->sp = "str_consultaNivelEconomicoCurso_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Registros encontrados";
        }else{
            $this->mensaje="Registros no encontrados";
        }
    }

    public function get_cursos()
    {
        $this->parametros = array();
        $this->sp = "str_consultaCursos_cons";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
        {
            $curso = array();
            foreach($this->rows as $cursos)
            {
                array_push($curso, array_values($cursos));
            }
            // Agregar la opcion de ninguna categoria padre
            array_pop($curso);
            array_push($curso, array());

            $this->rows = $curso;
            unset($curso);
            $this->mensaje="Cursos encontrados";
        }
        else
        {
            $this->mensaje="Cursos no encontrados";
        }
    }

    public function set($data=array()){
        foreach($data as $campo=>$valor){
            $$campo=$valor;
        }
        $this->parametros = array($curs_codi, $niveEcon_codigo, $codigoUsuario);
        $this->sp = "str_consultaNivelEconomicoCurso_add";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Registro agregado exitosamente";
        }else{
            $this->mensaje="No se ha agregado el registro";
        }
    }

    public function edit($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        //$this->parametros = array($codigo, $niveEcon_codigo, $ckb_deudasPendientes);
		$this->parametros = array($codigo, $niveEcon_codigo);
        $this->sp = "str_consultaNivelEconomicoCurso_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Registro agregado exitosamente";
        }else{
            $this->mensaje="No se ha agregado el registro";
        }
    }

     public function delete($data=array()) {
        foreach ($data as $campo=>$valor) {
            $$campo = $valor;
        }
        
        $this->parametros = array($codigo);
        $this->sp = "str_consultaNivelEconomicoCurso_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0){
            $this->mensaje="Registro eliminado exitosamente";
        }else{
            $this->mensaje="Registro no fue eliminado";
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