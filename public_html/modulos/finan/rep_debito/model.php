<?php
session_start();
# Importar modelo de abstracción de base de datos
require_once('../../../core/db_abstract_model.php');

class Rep_debito extends DBAbstractModel
{   #propiedades
    public $banc_nombre;
   
    protected $banc_codigo;
	public $banc_estado;
	public $banc_fechcreacion;
	public $banc_usucreacion;
	
	public function get_all_deudores( 	$curs_codi=0, 		$niveEcon_codi=0, $peri_codi=0 )
	{	$this->parametros = array( $curs_codi, $niveEcon_codi, $peri_codi );
        $this->sp = "str_consultareptDebito_busq";
        $this->executeSPConsulta();
		if (count($this->rows)>0)
		{	//array_pop($permiso);
			foreach($this->rows[0] as $propiedad=>$valor)
			{	$this->$propiedad=$valor;
			}
			$this->mensaje="Datos obtenidos correctamente.";
		}
		else
		{	$this->mensaje="Error al obtener datos.";
		}
    }
	
	public function get_header_mediacion( )
	{	$this->parametros = array( );
        $this->sp = "str_consultareptDebito_headers";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen productos en la BD.";
        }
		else
		{	$producto = array();
            foreach($this->rows as $productos)
			{	array_push($producto, array_values($productos));
            }
			array_pop($producto);
            $this->rows = $producto;
            unset($producto);
        }
    }
    public function get_all_cajeros()
    {   $this->parametros = array();
        $this->sp = "str_consultacajeros";
        $this->executeSPConsulta();

         if (count($this->rows)<=0){
            $this->mensaje="No existen niveles economicos en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'Seleccione...',
                                   3 => ''));
			
        }else{
            $rol = array();

            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => 'Seleccione...',
                                   3 => ''));
			
            foreach($this->rows as $niveles_economicos){
                array_push($rol, array_values($niveles_economicos));
            }

            $this->rows = $rol;
            unset($rol);
        }
    }
    
	public function get_all_deudores_cierre_cuentas_por_cobrar($curs_codi=0, $niveEcon_codi=0, $peri_codi=0, $fechvenc_fin='', $xml_productos='')
	{	if ( $curs_codi == 0 || $curs_codi == '' )
			$curs_codi = -1;
		if ( $niveEcon_codi == 0 || $niveEcon_codi == '' )
			$niveEcon_codi = -1;
		if ( $peri_codi == 0 || $peri_codi == '' )
			$peri_codi = -1;
		
		$this->parametros = array($curs_codi, $niveEcon_codi, $peri_codi, $fechvenc_fin, $xml_productos);
        $this->sp = "str_consultarpt_cierre_cuentas_por_cobrar";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{	$this->mensaje="Error al obtener datos.";
        }
		else
		{	$producto = array();
            foreach($this->rows as $productos)
			{	array_push($producto, array_values($productos));
            }
            $this->rows = $producto;
            unset($producto);
        }
    }
	public function get_all_deudores_cierre_cuentas_por_cobrar_producto($curs_codi=0, $niveEcon_codi=0, $peri_codi=0, $fechvenc_fin='', $xml_productos='')
	{	if ( $curs_codi == 0 || $curs_codi == '' )
			$curs_codi = -1;
		if ( $niveEcon_codi == 0 || $niveEcon_codi == '' )
			$niveEcon_codi = -1;
		if ( $peri_codi == 0 || $peri_codi == '' )
			$peri_codi = -1;
		
		$this->parametros = array($curs_codi, $niveEcon_codi, $peri_codi, $fechvenc_fin, $xml_productos);
        $this->sp = "str_consultarpt_cierre_cuentas_por_cobrar_producto";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{	$this->mensaje="Error al obtener datos.";
        }
		else
		{	$producto = array();
            foreach($this->rows as $productos)
			{	array_push($producto, array_values($productos));
            }
            $this->rows = $producto;
            unset($producto);
        }
    }
	public function get_all_deudores_cierre_cuentas_por_cobrar_curso($curs_codi=0, $niveEcon_codi=0, $peri_codi=0, $fechvenc_fin='', $xml_productos='')
	{	if ( $curs_codi == 0 || $curs_codi == '' )
			$curs_codi = -1;
		if ( $niveEcon_codi == 0 || $niveEcon_codi == '' )
			$niveEcon_codi = -1;
		if ( $peri_codi == 0 || $peri_codi == '' )
			$peri_codi = -1;
		
		$this->parametros = array($curs_codi, $niveEcon_codi, $peri_codi, $fechvenc_fin, $xml_productos);
        $this->sp = "str_consultarpt_cierre_cuentas_por_cobrar_curso";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{	$this->mensaje="Error al obtener datos.";
        }
		else
		{	$producto = array();
            foreach($this->rows as $productos)
			{	array_push($producto, array_values($productos));
            }
            $this->rows = $producto;
            unset($producto);
        }
    }
	public function get_all_deudores_cierre_cuentas_por_cobrar_resumen($curs_codi=0, $niveEcon_codi=0, $peri_codi=0, $fechvenc_fin='', $xml_productos='')
	{	if ( $curs_codi == 0 || $curs_codi == '' )
			$curs_codi = -1;
		if ( $niveEcon_codi == 0 || $niveEcon_codi == '' )
			$niveEcon_codi = -1;
		if ( $peri_codi == 0 || $peri_codi == '' )
			$peri_codi = -1;
		
		$this->parametros = array($curs_codi, $niveEcon_codi, $peri_codi, $fechvenc_fin, $xml_productos);
        $this->sp = "str_consultarpt_cierre_cuentas_por_cobrar_resumen";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{	$this->mensaje="Error al obtener datos.";
        }
		else
		{	$producto = array();
            foreach($this->rows as $productos)
			{	array_push($producto, array_values($productos));
            }
            $this->rows = $producto;
            unset($producto);
        }
    }
	public function get_all_deudores_persona($curs_codi=-1, $niveEcon_codi=-1, $peri_codi=-1, $fechvenc_ini='', $fechvenc_fin='', $quienes='T')
	{	if ( $curs_codi == 0 || $curs_codi == '' )
			$curs_codi = -1;
		if ( $niveEcon_codi == 0 || $niveEcon_codi == '' )
			$niveEcon_codi = -1;
		if ( $peri_codi == 0 || $peri_codi == '' )
			$peri_codi = -1;
		
		$this->parametros = array($curs_codi, $niveEcon_codi, $peri_codi, $fechvenc_ini, $fechvenc_fin, $quienes);
        $this->sp = "str_consultarpt_deudorespersona";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{	$this->mensaje="Error al obtener datos.";
        }
		else
		{	$producto = array();
            foreach($this->rows as $productos)
			{	array_push($producto, array_values($productos));
            }
            $this->rows = $producto;
            unset($producto);
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