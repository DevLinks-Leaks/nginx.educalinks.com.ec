<?php
require_once('../../../core/db_abstract_model.php');

class Cargo extends DBAbstractModel{
    //put your code here
    protected $dept_codi;
    public $dept_nombre;
    protected $area_codi;
    public $dept_estado;
	
	public function set( $cargo_nombre, $dept_codi )
	{   $this->parametros = array( $cargo_nombre, $dept_codi );
        $this->query = "insert into tbl_cargo
						values ( ".$dept_codi.", '".$cargo_nombre."', getdate(), '".$_SESSION['usua_codi']."', '".$_SERVER['REMOTE_ADDR']."', 'A' );";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Cargo ingresado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo ingresar el cargo";
        }
    }
	public function delete( $cargo_codi )
	{   $this->parametros = array( $cargo_codi );
        $this->query = "update tbl_cargo
						set cargo_estado = 'I'
						where cargo_codi = ".$cargo_codi.";";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Cargo inactivado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo inactivar el cargo";
        }
    }
	public function get( $cargo_codi = -1, $dept_codi = -1 )
	{   $this->parametros = array( );
        $this->query = "select cargo_codi, cargo_nombre
						  from tbl_cargo
						  join tbl_departamento
							on ( tbl_cargo.dept_codi = tbl_departamento.dept_codi and tbl_departamento.dept_estado = 'A' )
						  join tbl_area
							on ( tbl_departamento.area_codi = tbl_area.area_codi and tbl_area.area_estado = 'A' )
						 where dept_estado = 'A' 
						   and ( ( cargo_codi != -1 and cargo_codi = ".$cargo_codi." ) or ( ".$cargo_codi." = -1 ) )
						   and ( ( tbl_departamento.dept_codi != -1 and tbl_departamento.dept_codi = ".$dept_codi." ) or ( ".$dept_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Cargo(s) encontrado(s)";
        }else
		{   $this->mensaje="¡Error! Cargo(s) no encontrado(s)";
        }
    }
	public function get_Cargo_SelectFormat( $cargo_codi = -1, $dept_codi = -1 )
    {   $this->parametros = array( );
        $this->query = "select cargo_codi, cargo_nombre
						  from tbl_cargo
						  join tbl_departamento
							on ( tbl_cargo.dept_codi = tbl_departamento.dept_codi and tbl_departamento.dept_estado = 'A' )
						  join tbl_area
							on ( tbl_departamento.area_codi = tbl_area.area_codi and tbl_area.area_estado = 'A' )
						 where dept_estado = 'A' 
						   and ( ( cargo_codi != -1 and cargo_codi = ".$cargo_codi." ) or ( ".$cargo_codi." = -1 ) )
						   and ( ( tbl_departamento.dept_codi != -1 and tbl_departamento.dept_codi = ".$dept_codi." ) or ( ".$dept_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="¡Error! No existen cargos ingresados en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => '- Seleccione cargo -',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => '- Seleccione cargo -',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	# Método constructor
    function __construct()
	{   //$this->db_name = 'URBALINKS_FINAN';
    }
    # Método destructor del objeto
    function __destruct()
	{   unset($this);
    }
}
?>