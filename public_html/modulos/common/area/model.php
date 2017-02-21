<?php
require_once('../../../core/db_abstract_model.php');

class Area extends DBAbstractModel{
    //put your code here
    protected $area_codi;
    public $area_nombre;
    public $area_estado;
	
	public function set( $area_nombre )
	{   $this->parametros = array( $area_codi );
        $this->query = "insert into tbl_area
						values ( ".$area_nombre.", getdate(), '".$_SESSION['usua_codi']."', '".$_SERVER['REMOTE_ADDR']."', 'A' );";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Área ingresada correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo ingresar el área";
        }
    }
	public function delete( $area_codi )
	{   $this->parametros = array( $area_codi );
        $this->query = "update tbl_area
						set area_estado = 'I'
						where area_codi = ".$area_codi.";";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Área inactivada correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo inactivar el área";
        }
    }
	public function get( $area_codi = -1 )
	{   $this->parametros = array(  );
        $this->query = "select area_codi, area_nombre
						  from tbl_area
						 where area_estado = 'A'
						   and ( ( tbl_area.area_codi != -1 and tbl_area.area_codi = ".$area_codi." ) or ( ".$area_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Área(s) encontrada(s)";
        }else
		{   $this->mensaje="¡Error! Área(s) no encontrada(s)";
        }
    }
	public function get_Area_SelectFormat( $area_codi = -1 )
    {   $this->parametros = array(  );
        $this->query = "select area_codi, area_nombre
						  from tbl_area
						 where area_estado = 'A'
						   and ( ( tbl_area.area_codi != -1 and tbl_area.area_codi = ".$area_codi." ) or ( ".$area_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="¡Error! No existen áreas ingresadas en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '0', 
                                   1 => '- Seleccione área -',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => '0', 
                                   1 => '- Seleccione área -',
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