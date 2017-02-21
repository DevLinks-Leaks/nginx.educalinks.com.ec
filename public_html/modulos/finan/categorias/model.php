<?php
require_once('../../../core/db_abstract_model.php');

class Categoria extends DBAbstractModel{
    #propiedades
    protected $codigo;
    public $nombre;
    public $descripcion;
    public $categoriaPadre;
	public $estado;
	public $tipoMatricula;

	public function get_all( $busq="" )
	{   $this->parametros = array( $busq );
        $this->sp = "str_consultaCategoria_busq";
        $this->executeSPConsulta(  );
        if ( count( $this->rows ) >0 )
		{   $this->mensaje="¡Exito! Categorias encontrados";
        }
		else
		{   $this->mensaje="¡Error! Categorias no encontrados";
        }
    }
	public function get_allcontifico( $busq="" )
	{   $this->parametros = array( $busq );
        $this->sp = "str_consultaCategoria_busqcontifico";
        $this->executeSPConsulta(  );
        if ( count( $this->rows ) >0 )
		{   $this->mensaje="¡Exito! Categorias encontrados";
        }
		else
		{   $this->mensaje="¡Error! Categorias no encontrados";
        }
    }
    public function get_selectFormat( $busq="" )
	{   $busq="";
        $this->parametros = array( $busq );
        $this->sp = "str_consultaCategoria_busq";
        $this->executeSPConsulta(  );
        if ( count( $this->rows )<=0 )
		{   $this->mensaje="No existen categorias en la BD.";
        }else
		{   $rol = array(  );
            foreach( $this->rows as $categorias )
			{   array_push( $rol, array_values( $categorias ) );
            }
            // Agregar la opcion de ninguna categoria padre
            array_pop( $rol );
            array_push( $rol, array(0 => -1, 
                                   1 => '- Sin categoría padre -',
                                   2 => 'SIN CATEGORIA PADRE',
                                   3 => ''));
            array_push( $rol, array(  ) );

            $this->rows = $rol;
            unset( $rol );
        }
    }
	public function get_selectFormat_all($busq=""){
        $busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaCategoria_busq";
        $this->executeSPConsulta();

        if (count($this->rows)<=0){
            $this->mensaje="¡Error! No existen categorias en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '-1', 
                                   1 => '- Seleccione categoría -',
                                   3 => ''));
        }else{
            $rol = array();

            array_pop($rol);
            array_push($rol, array(0 => '-1', 
                                   1 => '- Seleccione categoría -',
                                   3 => ''));
            foreach($this->rows as $categorias){
                array_push($rol, array_values($categorias));
            }

            $this->rows = $rol;
            unset($rol);
        }
    }
    public function get($codigo="")
	{   if( $codigo!="" )
		{   $this->parametros = array( $codigo );
            $this->sp = "str_consultaCategoria_info";
            $this->executeSPConsulta();
        }
        if ( count( $this->rows ) >= 1 )
		{   foreach( $this->rows[0] as $propiedad=>$valor )
			{   $this->$propiedad=$valor;
            }
            $this->mensaje="¡Exito! Categoria encontrada";
        }
		else
		{   $this->mensaje="¡Error! Categoria no encontrada";
        }
    }
    public function set ( $data=array(  ) )
	{   if (array_key_exists( 'nombre', $data ) )
		{   foreach($data as $campo=>$valor)
			{   $$campo=$valor;
            }
            $this->parametros = array( $nombre, $descripcion, $categoriaPadre, $codigoUsuario, $tipoMatricula );
            $this->sp = "str_consultaCategoria_add";
            $this->executeSPAccion( );
            if( $this->filasAfectadas>0 )
			{   $this->mensaje="¡Exito! Categoria agregada exitosamente";
            }
			else
			{   $this->mensaje="¡Error! No se ha agregado la categoria";
            }
        }
		else
		{   $this->mensaje="¡Error! No se ha agregado la categoria - Falta el nombre de la misma";
        }
		return $this;
    }
    public function edit( $data=array(  ) )
	{   foreach ( $data as $campo=>$valor )
		{   $$campo = $valor;
        }
        $this->parametros = array( $codigo, $nombre, $descripcion, $categoriaPadre, $tipoMatricula );
        $this->sp = "str_consultaCategoria_upd";
        $this->executeSPAccion(  );
        if( $this->filasAfectadas>0 )
		{   $this->mensaje="¡Exito! Categoria actualizada exitosamente";
        }
		else
		{   $this->mensaje="¡Error! Categoria no actualizada";
        }
		return $this;
    }

    public function delete( $codigo='' )
	{   $this->parametros = array( $codigo );
        $this->sp = "str_consultaCategoria_del";
        $this->executeSPAccion( );
        if( $this->filasAfectadas>0 )
		{   $this->mensaje="¡Exito! Categoria eliminada exitosamente";
        }
		else
		{   $this->mensaje="¡Error! No se ha eliminado la categoria";
        }
		return $this;
    }

    # Método constructor
    function __construct(  ) {
        //$this->db_name = 'URBALINKS_FINAN';
    }

    # Método destructor del objeto
    function __destruct(  ) {
        unset($this);
    }
}
?>