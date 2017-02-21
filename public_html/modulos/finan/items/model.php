<?php
require_once('../../../core/db_abstract_model.php');

class Item extends DBAbstractModel{
    #propiedades
    protected $codigo;
    public $nombre;
    public $descripcion;
    public $cuentaContable;
    public $categoria;
    public $aplicaIVA;
    public $aplicaICE;
	public $estado;

	public function get_all($busq="")
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaItem_busq";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Items encontrados";
        }
		else
		{   $this->mensaje="Items no encontrados";
        }
    }
    public function getProductos_selectFormat($categoria='')
	{   $this->rows = array();
        if($categoria != ''){
            $this->parametros = array($categoria);
            $this->sp = "str_consultaProducto_cons";
            $this->executeSPConsulta();    
        }
        if (count($this->rows)<0)
		{   $this->mensaje="Productos no encontrados";
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => '- Seleccione producto -',
                                   3 => ''));
        }
		else
		{   $rol = array();
            // Agregar la opcion de ninguna categoria padre
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => '- Seleccione producto -',
                                   3 => ''));
            foreach($this->rows as $productos){
                array_push($rol, array_values($productos));
            }
            $this->rows = $rol;
            unset($rol);   
        }
    }
	public function get_item_selectFormat($busq="")
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaItem_busq";
        $this->executeSPConsulta();
		if (count($this->rows)<=0)
		{	$this->mensaje="¡Error! No existen items en el sistema.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione producto -',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione producto -',
                                   3 => ''));
            foreach($this->rows as $item)
			{	array_push($rol, array_values($item));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
    public function getCategorias_selectFormat($busq="")
	{   $busq="";
        $this->parametros = array($busq);
        $this->sp = "str_consultaCategoria_busq";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{   $this->mensaje="No existen categorias en la BD.";
        }
		else
		{   $rol = array();
            foreach($this->rows as $categorias)
			{   array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
    public function get($codigo="")
	{   if($codigo!="")
		{   $this->parametros = array($codigo);
            $this->sp = "str_consultaItem_info";
            $this->executeSPConsulta();
			
        }
        if (count($this->rows)>=1)
		{   foreach($this->rows[0] as $propiedad=>$valor)
			{   $this->$propiedad=$valor;
            }
            $this->mensaje="Item encontrado";
        }
		else
		{   $this->mensaje="Item no encontrado";
        }
    }
    public function set ($data=array())
	{   if (array_key_exists('nombre',$data) && array_key_exists('categoria',$data) && array_key_exists('cuentaContable',$data))
		{   foreach($data as $campo=>$valor)
			{   $$campo=$valor;
            }
            $this->parametros = array($nombre, $descripcion, $categoria, $cuentaContable, $aplicaIVA, $aplicaICE, $precioGeneral, $codigoUsuario,$descuento,$liquidez,$prontopago);
            $this->sp = "str_consultaItem_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0)
			{   $this->mensaje="Item agregado exitosamente";
            }else
			{   $this->mensaje="No se ha agregado el item";
            }
        }
		else
		{   $this->mensaje="No se ha agregado el item - Faltan campos importantes.";
        }
    }
    public function edit($data=array())
	{   foreach ($data as $campo=>$valor)
		{   $$campo = $valor;
        }
        $this->parametros = array($codigo, $nombre, $descripcion, $categoria, $aplicaIVA, $aplicaICE, $precioGeneral, $cuentaContable,$descuento,$liquidez,$prontopago);
        $this->sp = "str_consultaItem_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Item actualizado exitosamente";
        }
		else
		{   $this->mensaje="¡Error! No se ha eliminado el item";
        }
		return $this;
    }
	public function delete($codigo='')
	{   $this->parametros = array($codigo);
        $this->sp = "str_consultaItem_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Precio eliminado exitosamente.";
        }
		else
		{   $this->mensaje="¡Error! No se ha eliminado el precio.";
        }
		return $this;
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