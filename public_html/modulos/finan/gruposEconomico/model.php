<?php
require_once('../../../core/db_abstract_model.php');

class GrupoEconomico extends DBAbstractModel{
    #propiedades
    protected $codigo;
    public $nombre;
    public $descripcion;
	public $estado;
	public $rango_desde;
	public $rango_hasta;
	public $para_sist_valu;

	public function get_all($busq="")
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaGrupoEconomico_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Grupos Economico encontrados";
        }
		else
		{   $this->mensaje="¡Error! Grupos Economico no encontrados";
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
    public function getCategorias_selectFormat($busq="")
	{   $busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaGrupoEconomico_busq";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{   $this->mensaje="No existen grupos económicos en la BD.";
        }
		else
		{   $rol = array();
            foreach($this->rows as $gruposEconomico)
			{   array_push($rol, array_values($gruposEconomico));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
    public function get($codigo="")
	{   if($codigo!="")
		{   $this->parametros = array($codigo);
            $this->sp = "str_consultaGrupoEconomico_info";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>=1)
		{   foreach($this->rows[0] as $propiedad=>$valor)
			{   $this->$propiedad=$valor;
            }
            $this->mensaje="¡Exito! Grupo Economico encontrado";
        }
		else
		{   $this->mensaje="¡Error! Grupo Economico no encontrado";
        }
    }

    public function set ( $data = array() )
	{   if (array_key_exists( 'nombre', $data ) )
		{   foreach( $data as $campo=>$valor )
			{   $$campo=$valor;
            }
            $this->parametros = array( $nombre, $descripcion, $codigoUsuario, $rango_desde, $rango_hasta );
            $this->sp = "str_consultaGrupoEconomico_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0)
			{   $this->mensaje="¡Exito! Grupo Economico agregado exitosamente";
            }
			else
			{   $this->mensaje="¡Error! No se ha agregado el grupo economico";
            }
        }
		else
		{   $this->mensaje="¡Error! No se ha agregado el grupo economico - Faltan campos importantes.";
        }
    }
    public function edit($data=array())
	{   foreach ($data as $campo=>$valor)
		{   $$campo = $valor;
        }
        $this->parametros = array( $codigo, $nombre, $descripcion, $rango_desde, $rango_hasta );
        $this->sp = "str_consultaGrupoEconomico_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Grupo Economico actualizada exitosamente";
        }
		else
		{   $this->mensaje="¡Error! Grupo Economico no actualizada";
        }
    }

    public function delete($codigo='')
	{   $this->parametros = array($codigo);
        $this->sp = "str_consultaGrupoEconomico_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Grupo Economico eliminado exitosamente";
        }
		else
		{   $this->mensaje="¡Error! No se ha eliminado el Grupo Economico";
        }
    }
	public function get_grupEcon_config( )
	{   $this->parametros = array( );
		$this->sp = "str_consultaGrupoEconomico_config_info";
		$this->executeSPConsulta();
		
        if (count($this->rows)>=1)
		{   foreach($this->rows[0] as $propiedad=>$valor)
			{   $this->$propiedad=$valor;
            }
            $this->mensaje="¡Exito! Grupo Economico encontrado";
        }
		else
		{   $this->mensaje="¡Error! Grupo Economico no encontrado";
        }
    }
    public function set_grupEcon_config ( $config )
	{   $this->parametros = array( $config );
		$this->sp = "str_consultaGrupoEconomico_config_upd";
		$this->executeSPAccion();
		if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Configuración de grupo Economico modificada exitosamente";
		}
		else
		{   $this->mensaje="¡Error! No se han hechos cambios en la configuración";
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