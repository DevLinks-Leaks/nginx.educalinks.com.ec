<?php
require_once('../../../core/db_abstract_model.php');

class Departamento extends DBAbstractModel{
    //put your code here
    protected $dept_codi;
    public $dept_nombre;
    protected $area_codi;
    public $dept_estado;
	
	public function set( $dept_nombre, $area_codi )
	{   $this->parametros = array( $dept_nombre, $area_codi );
        $this->query = "insert into tbl_departamento
						values ( ".$area_codi.", '".$dept_nombre."', getdate(), '".$_SESSION['usua_codi']."', '".$_SERVER['REMOTE_ADDR']."', 'A' );";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Departamento ingresado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo ingresar el departamento";
        }
    }
	public function delete( $dept_codi )
	{   $this->parametros = array( $dept_codi );
        $this->query = "update tbl_departamento
						set dept_estado = 'I'
						where dept_codi = ".$dept_codi.";";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Departamento inactivado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo inactivar el departamento";
        }
    }
	public function get( $dept_codi = -1, $area_codi = -1 )
	{   $this->parametros = array(  );
        $this->query = "select dept_codi, dept_nombre
						  from tbl_departamento
						  join tbl_area
							on ( tbl_departamento.area_codi = tbl_area.area_codi and tbl_area.area_estado = 'A' )
						 where dept_estado = 'A' 
						   and ( ( dept_codi != -1 and dept_codi = ".$dept_codi." ) or ( ".$dept_codi." = -1 ) )
						   and ( ( tbl_area.area_codi != -1 and tbl_area.area_codi = ".$area_codi." ) or ( ".$area_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Departamento(s) encontrado(s)";
        }else
		{   $this->mensaje="¡Error! Departamento(s) no encontrado(s)";
        }
    }
	public function get_Dept_SelectFormat( $dept_codi = -1, $area_codi = -1 )
    {   $this->parametros = array(  );
        $this->query = "select dept_codi, dept_nombre
						  from tbl_departamento
						  join tbl_area
							on ( tbl_departamento.area_codi = tbl_area.area_codi and tbl_area.area_estado = 'A' )
						 where dept_estado = 'A' 
						   and ( ( dept_codi != -1 and dept_codi = ".$dept_codi." ) or ( ".$dept_codi." = -1 ) )
						   and ( ( tbl_area.area_codi != -1 and tbl_area.area_codi = ".$area_codi." ) or ( ".$area_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="¡Error! No existen departamentos ingresados en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '0', 
                                   1 => '- Seleccione dept -',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => '0', 
                                   1 => '- Seleccione dept -',
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