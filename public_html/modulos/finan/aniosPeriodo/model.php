<?php
require_once('../../../core/db_abstract_model.php');

class AnioPeriodo extends DBAbstractModel{
    #propiedades
    public $anio;
    public $producto;
    public $fechaInicio;
    public $fechaFin;
    public $nombreProducto;
    public $estado;
	public $totalAlumnosGestionados;
	public $totalDeudasGeneradas;
	public $totalDeudasOmitidas;

	public function get_all_cursos($busq="")
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaCursosrpt_cons";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{   $this->mensaje="No existen categorias en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => ' - Todos -',
                                   3 => ''));
        }
		else
		{   $rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => ' - Todos -',
                                   3 => ''));
            foreach($this->rows as $categorias){
                array_push($rol, array_values($categorias));
            }

            $this->rows = $rol;
            unset($rol);
        }
    }
	public function getfacturacontifico( $busq="", $anio )
	{   $this->parametros = array( $busq, $anio );
        $this->sp = "str_consultaMigracioncontificodeuda";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Bancos encontrados";
        }
		else
		{   $this->mensaje="Bancos no encontradas";
        }
    }
	public function getdetallefactura($codigo="")
	{   if($codigo!="")
		{   $this->parametros = array($codigo);
            $this->sp = "str_consultaMigracioncontificodetfactura";
            $this->executeSPConsulta();
        }
		if (count($this->rows)>0)
		{   $this->mensaje="Detalles de periodo encontrados";
        }
		else
		{   $this->mensaje="Detalles de periodo no encontrados";
        }
    }
	public function getdetallepago($codigo="")
	{   if($codigo!="")
		{   $this->parametros = array($codigo);
            $this->sp = "str_consultaMigracioncontificodetpago";
            $this->executeSPConsulta();
        }
        if (count($this->rows)>=1)
		{   foreach($this->rows[0] as $propiedad=>$valor)
			{   $this->$propiedad=$valor;
            }
            $this->mensaje="Banco encontrado";
        }
		else
		{   $this->mensaje="Banco no encontrado";
        }
    }
	public function get_all_alumnos($busq="")
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaAlumnosrpt_cons";
        $this->executeSPConsulta(); 
		if (count($this->rows)<=0)
		{   $this->mensaje="No existen categorias en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => ' - Todos -',
                                   3 => ''));
        }
		else
		{   $rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => ' - Todos -',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{   array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	public function get_detalle()
	{   $this->parametros = array($this->anio);
        $this->sp = "str_consultaDetalleAnioPeriodo_busq";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Detalles de periodo encontrados";
        }
		else
		{   $this->mensaje="Detalles de periodo no encontrados";
        }
    }
	public function get_deudas_anuales($peri_codi)
	{   $this->parametros = array($peri_codi);
        $this->sp = "str_consultaDeudasPeriodoAnual";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Productos encontrados";
        }
		else
		{   $this->mensaje="Productos no encontrados";
        }
	}
	public function get_deudas_contifico($peri_codi)
	{   $this->parametros = array($peri_codi);
        $this->sp = "str_consultaDeudasContifico";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Productos encontrados";
        }
		else
		{   $this->mensaje="Productos no encontrados";
        }
	}
	public function get_deudas_contificoindividual($peri_codi,$mes)
	{   $this->parametros = array($peri_codi,$mes);
        $this->sp = "str_consultaDeudasContificoindividual";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
		{   $this->mensaje="Productos encontrados";
        }
		else
		{   $this->mensaje="Productos no encontrados";
        }
	}
	public function get_deudas_individualmigracion($codigo)
	{   $this->parametros = array($codigo);
        $this->sp = "str_consultaMigracioncontificodeudaindividual";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Productos encontrados";
        }
		else
		{   $this->mensaje="Productos no encontrados";
        }
	}
	public function upddeudacontifico( $codigo, $codigo_contifico, $estado )
	{   $this->parametros = array( $codigo, $codigo_contifico, $estado, $_SESSION['usua_codigo'] );
        $this->sp = "str_consultadeudacontifico_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="Banco modificado exitosamente";
        }
		else
		{   $this->mensaje="No se ha actualizado el banco";
        }
    }
    public function getCategorias_selectFormat($busq="")
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaCategoria_busq";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{   $this->mensaje="No existen categorias en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione categoría -',
                                   3 => ''));
        }else
		{   $rol = array();

            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione categoría -',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{   array_push($rol, array_values($categorias));
            }

            $this->rows = $rol;
            unset($rol);
        }
    }
    public function getProductos_selectFormat($busq="")
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaProducto_cons";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{   $this->mensaje="No existen productos en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione producto -',
                                   3 => ''));
        }
		else
		{   $rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione producto -',
                                   3 => ''));
            foreach($this->rows as $productos)
			{   array_push($rol, array_values($productos));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
    public function get($codigoProducto="", $anio="")
	{   if($codigoProducto!="" && $anio!=""){
            $this->parametros = array($anio, $codigoProducto);
            $this->sp = "str_consultaAnioPeriodo_info";
            $this->executeSPConsulta();
        }
        if (count($this->rows)>=1)
		{   foreach($this->rows[0] as $propiedad=>$valor)
			{   $this->$propiedad=$valor;
            }
            $this->mensaje="Anio Periodo encontrado";
        }
		else
		{   $this->mensaje="Anio Periodo no encontrado";
        }
    }
    public function set ($data=array())
	{   if (array_key_exists('anio',$data))
		{   foreach($data as $campo=>$valor)
			{   $$campo=$valor;
            }
            $this->parametros = array($anio, $producto, $fechaInicio, $diasProntopago, $fechaFin, $codigoUsuario, $_SESSION['USUA_TIPO_CODI']);
           	var_dump($data);
		    $this->sp = "str_consultaAnioPeriodo_add";
            $this->executeSPAccion();
            if($this->filasAfectadas>0){
                $this->mensaje="Registro agregado exitosamente";
            }else{
                $this->mensaje="No se ha agregado el registro ".$this->ErrorToString();
            }
        }else{
            $this->mensaje="No se ha agregado el registro - Faltan campos importantes.";
        }
    }
	public function set_deudas_lote ($data=array())
	{   if (array_key_exists('peri_codi',$data) && array_key_exists('codigoUsuario',$data))
		{   foreach($data as $campo=>$valor)
			{   $$campo=$valor;
            }
            $this->parametros = array($peri_codi, $codigoUsuario);
            $this->sp = "str_generaDeudasPeriodo";
            $this->executeSPConsulta();
			if (count($this->rows)>=1)
			{   foreach($this->rows[0] as $propiedad=>$valor)
				{   $this->$propiedad=$valor;
				}
				if($this->totalDeudasOmitidas == 0)
				{   $this->mensaje="Se han generado las deudas exitosamente. <br>Alumnos gestionados: ".$this->totalAlumnosGestionados." <br>Deudas Generadas: ".$this->totalDeudasGeneradas;
				}
				else
				{   $this->mensaje="No se generaron completamente las deudas. <br>Deudas omitidas: ".$this->totalDeudasOmitidas;
				}
			}
			else
			{   $this->mensaje="No se han generado las deudas".$this->ErrorToString();
			}
        }
		else
		{   $this->mensaje="No se han generado las deudas  - Faltan campos importantes.";
        }
    }
	public function set_deudas_lote_Alumnoind ($data=array())
	{   if (array_key_exists('peri_codi',$data) && array_key_exists('codigoUsuario',$data) &&
			array_key_exists('xml',$data) && array_key_exists('xml_textAlum', $data ) )
		{   foreach($data as $campo=>$valor)
			{   $$campo=$valor;
            }
            $this->parametros = array($xml, $peri_codi, $codigoUsuario, $xml_textAlum );
            $this->sp = "str_generaDeudasAlumnoPeriodo_ind";
            $this->executeSPConsulta();
			if (count($this->rows)>=1)
			{   foreach($this->rows[0] as $propiedad=>$valor)
				{   $this->$propiedad=$valor;
				}
				if($this->totalDeudasOmitidas == 0)
				{   $this->mensaje="Se han generado las deudas exitosamente.<br>Deudas Generadas:" .$this->totalDeudasGeneradas;
				}
				else
				{   $this->mensaje="No se generaron completamente las deudas. <br>Deudas omitidas: ".$this->totalDeudasOmitidas;
				}
			}
			else
			{   $this->mensaje="No se han generado las deudas".$this->ErrorToString();
			}
        }
		else
		{   $this->mensaje="No se han generado las deudas  - Faltan campos importantes. ".$this->ErrorToString();
        }
    }
	public function set_deudas_cursolote_ind ($data=array())
	{   if (array_key_exists('peri_codi',$data) && array_key_exists('codigoUsuario',$data) && array_key_exists('xml',$data)){
            foreach($data as $campo=>$valor)
			{   $$campo=$valor;
            }
            $this->parametros = array($xml, $peri_codi, $codigoUsuario,$cod_curso);
            $this->sp = "str_generaDeudasCursoPeriodo_ind";
            $this->executeSPConsulta();
			if (count($this->rows)>=1)
			{   foreach($this->rows[0] as $propiedad=>$valor)
				{   $this->$propiedad=$valor;
				}
				if($this->totalDeudasOmitidas == 0)
				{   $this->mensaje="Se han generado las deudas exitosamente. <br>Alumnos gestionados: ".$this->totalAlumnosGestionados." <br>Deudas Generadas: ".$this->totalDeudasGeneradas;
				}
				else
				{   $this->mensaje="No se generaron completamente las deudas. <br>Deudas omitidas: ".$this->totalDeudasOmitidas;
				}
			}
			else
			{   $this->mensaje="No se han generado las deudas".$this->ErrorToString();
			}
        }
		else
		{   $this->mensaje="No se han generado las deudas  - Faltan campos importantes.";
        }
    }
	public function set_deudas_lote_ind ($data=array())
	{   if (array_key_exists('peri_codi',$data) && array_key_exists('codigoUsuario',$data) && array_key_exists('xml',$data))
		{   foreach($data as $campo=>$valor)
			{   $$campo=$valor;
            }
            $this->parametros = array($xml, $peri_codi, $codigoUsuario);
            $this->sp = "str_generaDeudasPeriodo_ind";
            $this->executeSPConsulta();
			if (count($this->rows)>=1)
			{   foreach($this->rows[0] as $propiedad=>$valor)
				{   $this->$propiedad=$valor;
				}
				if($this->totalDeudasOmitidas == 0)
				{   $this->mensaje="Se han generado las deudas exitosamente. <br>Alumnos gestionados: ".$this->totalAlumnosGestionados." <br>Deudas Generadas: ".$this->totalDeudasGeneradas;
				}
				else
				{   $this->mensaje="No se generaron completamente las deudas. <br>Deudas omitidas: ".$this->totalDeudasOmitidas;
				}
			}
			else
			{   $this->mensaje="No se han generado las deudas".$this->ErrorToString();
			}
        }
		else
		{   $this->mensaje="No se han generado las deudas  - Faltan campos importantes.";
        }
    }
    public function edit($data=array())
	{   foreach ($data as $campo=>$valor)
		{   $$campo = $valor;
        }
        $this->parametros = array($anio, $producto, $fechaInicio, $diasProntopago, $fechaFin, $ckb_deudasPendientes, $_SESSION['usua_codigo'],$_SESSION['USUA_TIPO_CODI']);
        $this->sp = "str_consultaAnioPeriodo_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="Registro actualizada exitosamente";
        }
		else
		{   $this->mensaje="Registro no actualizado";
        }
    }
    public function delete($codigoProducto="", $anio="")
	{   $this->parametros = array($anio, $codigoProducto);
        $this->sp = "str_consultaAnioPeriodo_del";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="Registro eliminado exitosamente";
        }
		else
		{   $this->mensaje="No se ha eliminado el registro";
        }
    }
    public function setDeudasLote($codigoPeriodo="", $codigoUsuario="")
	{   if($codigoPeriodo!="" && $codigoUsuario!="")
		{   $this->parametros = array($codigoPeriodo, $codigoUsuario);
            $this->sp = "str_generaDeudasPeriodo";
            $this->executeSPConsulta();
        }
        if (count($this->rows)>=1)
		{   foreach($this->rows[0] as $propiedad=>$valor)
			{   $this->$propiedad=$valor;
            }
            $this->mensaje="Deudas generadas";
        }
		else
		{   $this->mensaje="Error al generar las deudas";
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