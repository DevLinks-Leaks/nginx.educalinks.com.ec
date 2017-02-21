<?php
require_once('../../../core/db_abstract_model.php');

class Elemento_protex extends DBAbstractModel{
    //put your code here
    protected $ele_protex_codi;
	public $ele_protex_nombre;
	public $ele_protex_estado;

	protected $ele_protex_tipo_codi;
	public $ele_protex_tipo_nombre;
	public $ele_protex_tipo_estado;
	
	public function set_tipo( $nombre )
	{   $this->parametros = array( $nombre );
        $this->query = "insert into tbl_elemento_proteccion_tipo
						values ( '".$nombre."', 'A' );";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Tipo de elemento ingresado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo ingresar el tipo de elemento";
        }
    }
	public function set_subtipo( $nombre, $tipo_codi )
	{   $this->parametros = array( $nombre, $tipo_codi );
        $this->query = "insert into tbl_elemento_proteccion
						values ( ".$tipo_codi.", '".$nombre."', 'A' );";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Elemento ingresado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo ingresar el elemento";
        }
    }
	public function delete_tipo( $tipo_codi )
	{   $this->parametros = array( $tipo_codi );
        $this->query = "update tbl_elemento_proteccion_tipo
						set ele_protex_tipo_estado = 'I'
						where ele_protex_tipo_codi = ".$tipo_codi.";";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Tipo de elemento inactivado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo inactivar el tipo de elemento";
        }
    }
	public function delete_subtipo( $subtipo_codi )
	{   $this->parametros = array( $subtipo_codi );
        $this->query = "update tbl_elemento_proteccion
						set ele_protex_estado = 'I'
						where ele_protex_codi = ".$subtipo_codi.";";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Elemento inactivado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo inactivar el elemento";
        }
    }
	public function get_tipo( $tipo_codi = -1 )
	{   $this->parametros = array(  );
        $this->query = "select ele_protex_tipo_codi, ele_protex_tipo_nombre
						  from tbl_elemento_proteccion_tipo
						 where ele_protex_tipo_estado = 'A' 
						   and ( ( ele_protex_tipo_codi != -1 and ele_protex_tipo_codi = ".$tipo_codi." ) or ( ".$tipo_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Tipo de elemento(s) encontrado(s)";
        }else
		{   $this->mensaje="¡Error! Tipo de elemento(s) no encontrado(s)";
        }
    }
	public function get_subtipo( $subtipo_codi = -1, $tipo_codi = -1 )
	{   $this->parametros = array(  );
        $this->query = "select ele_protex_codi, ele_protex_nombre
						  from tbl_elemento_proteccion
						  join tbl_elemento_proteccion_tipo
							on ( tbl_elemento_proteccion.ele_protex_tipo_codi = tbl_elemento_proteccion_tipo.ele_protex_tipo_codi and tbl_elemento_proteccion_tipo.ele_protex_tipo_estado = 'A' )
						 where ele_protex_estado = 'A' 
						   and ( ( ele_protex_codi != -1 and ele_protex_codi = ".$subtipo_codi." ) or ( ".$subtipo_codi." = -1 ) )
						   and ( ( tbl_elemento_proteccion_tipo.ele_protex_tipo_codi != -1 and tbl_elemento_proteccion_tipo.ele_protex_tipo_codi = ".$tipo_codi." ) or ( ".$tipo_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Elemento(s) encontrado(s)";
        }else
		{   $this->mensaje="¡Error! Elemento(s) no encontrado(s)";
        }
    }
	public function get_tipo_SelectFormat( $tipo_codi = -1 )
    {   $this->parametros = array(  );
        $this->query = "select ele_protex_tipo_codi, ele_protex_tipo_nombre
						  from tbl_elemento_proteccion_tipo
						 where ele_protex_tipo_estado = 'A' 
						   and ( ( ele_protex_tipo_codi != -1 and ele_protex_tipo_codi = ".$tipo_codi." ) or ( ".$tipo_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="¡Error! No existen departamentos ingresados en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '0', 
                                   1 => '- Seleccione categoría -',
                                   3 => ''));
        }
		else
		{	$rol = array(  );
            array_pop( $rol );
            array_push( $rol, array(0 => '0', 
                                   1 => '- Seleccione categoría -',
                                   3 => '' ) );
            foreach($this->rows as $categorias)
			{	array_push( $rol, array_values( $categorias ) );
            }
            $this->rows = $rol;
            unset( $rol );
        }
    }
	public function get_subtipo_SelectFormat( $subtipo_codi = -1, $tipo_codi = -1 )
    {   $this->parametros = array(  );
        $this->query = "select ele_protex_codi, ele_protex_nombre
						  from tbl_elemento_proteccion
						  join tbl_elemento_proteccion_tipo
							on ( tbl_elemento_proteccion.ele_protex_tipo_codi = tbl_elemento_proteccion_tipo.ele_protex_tipo_codi and tbl_elemento_proteccion_tipo.ele_protex_tipo_estado = 'A' )
						 where ele_protex_estado = 'A' 
						   and ( ( ele_protex_codi != -1 and ele_protex_codi = ".$subtipo_codi." ) or ( ".$subtipo_codi." = -1 ) )
						   and ( ( tbl_elemento_proteccion_tipo.ele_protex_tipo_codi != -1 and tbl_elemento_proteccion_tipo.ele_protex_tipo_codi = ".$tipo_codi." ) or ( ".$tipo_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="¡Error! No existen elementos ingresados en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '0', 
                                   1 => '- Seleccione elemento -',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => '0', 
                                   1 => '- Seleccione elemento -',
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