<!DOCTYPE html>
<html>
    <?php
    	session_start();   
    ?>
    <head>   
     <?php
		//Set no cachinh
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

        /*$domain=$_SERVER['HTTP_HOST'];
        $serverName = "certuslinks.com";         
        $Database= "Certuslinks_admin"; 
        $UID= "sa";$PWD= "R3dlink5";

        $connectionInfo = array("Database"=>$Database, "UID"=>$UID, "PWD"=>$PWD, "CharacterSet"=>"UTF-8");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        if( $conn === false){
            echo "Error in connection.\n";
            die( print_r( sqlsrv_errors(), true));
        }*/
		include("framework/dbconf_main.php");
		include("framework/funciones.php");
		
        $params = array($domain);
        $sql="{call dbo.clie_info_domain(?)}";
        $resu_login = sqlsrv_query($conn, $sql, $params);  
        $row = sqlsrv_fetch_array($resu_login);
        $_SESSION['host']=$row['clie_instancia_db'];
        $_SESSION['user']=$row['clie_user_db'];
        $_SESSION['pass']=$row['clie_pass_db'];
        $_SESSION['dbname']=$row['clie_base'];
		
		
		
		if(isset($_POST['ult_reg'])){$ult_reg=$_POST['ult_reg'];$ult_reg_inicial=$_POST['ult_reg'];}else{$ult_reg=0;$ult_reg_incial=0;}
		if(isset($_POST['pension'])){$pension=$_POST['pension'];}else{$pension=9;}
		if(isset($_POST['periodo'])){$periodo=$_POST['periodo'];}else{$periodo=10;}

	?>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Educalinks </title>
    <link rel="shortcut icon" href="../favicon.ico"> 
    

    <link href="theme/css/main.css" rel="stylesheet" type="text/css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="theme/js/select.js"></script>

    
</head>

    <body>
    <form id="frm_diners" action="" method="post" enctype="multipart/form-data">
		<label>Ultimo Registro<input id="ult_reg" name="ult_reg" type="text" value="<?php echo $ult_reg;?>"></label>
        <label>Deuda<select id="pension" name="pension">
        <option value="1" <?php if ($pension=='1'){echo "selected";}?>>Mayo</option>
        <option value="2" <?php if ($pension=='2'){echo "selected";}?>>Junio</option>
        <option value="3" <?php if ($pension=='3'){echo "selected";}?>>Julio</option>
        <option value="4" <?php if ($pension=='4'){echo "selected";}?>>Agosto</option>
        <option value="5" <?php if ($pension=='5'){echo "selected";}?>>Septiembre</option>
        <option value="6" <?php if ($pension=='6'){echo "selected";}?>>Octubre</option>
        <option value="7" <?php if ($pension=='7'){echo "selected";}?>>Noviembre</option>
        <option value="8" <?php if ($pension=='8'){echo "selected";}?>>Diciembre</option>
        <option value="9" <?php if ($pension=='9'){echo "selected";}?>>Enero</option>
        <option value="10" <?php if ($pension=='10'){echo "selected";}?>>Febrero</option>
        </select></label>
        <label>Periodo<select id="periodo" name="periodo">
        <option value="12">2016-2017</option>
        </select></label><?php echo $_SESSION['db']; ?>
        <button type="submit">Enviar</button>
    </form>
        <?php
		
		include ('framework/dbconf.php');
		
        $sql = "
		with CTE_DEUDA (codigoDeuda, descripcionDeuda, prontoPago)
	AS(
		 select deud_codigo as 'codigoDeuda',
				case deud_tipoDocumento
					when 'FAC' then  p.prod_nombre
					when 'ND' then 'N/D REF: '+convert(varchar, ( select notaDebito.cabeND_codigo
																	from cabeceraNotaDebito notaDebito
																   where deud_codigoDocumento = notaDebito.cabeND_codigo ) )
				end AS 'descripcionDeuda',
				case 
					when p.prod_prontopago=1 and DATEADD(day,det.detaAnioPeri_diasProntoPago,det.detaAnioPeri_fechaInicio)>=getdate()
					then df.detaFact_totalNeto*(select convert(decimal(18,2),para_sist_valu) 
											    from Parametros_Sistemas  
	  										   where para_sist_deta='Descuento Prontopago')/100
					when p.prod_prontopago=0 then '0.00'
				end AS 'prontoPago'
		   from deuda as d 
		   join Alumnos
			 on Alumnos.alum_codi = d.alum_codi
		   left join detalleFactura as df 
		     on df.cabeFact_codigo= d.deud_codigoDocumento 
		   left join producto as p 
		     on p.prod_codigo=df.prod_codigo
		   left join detalleAnioPeriodo as det 
		     on ( p.prod_codigo=det.prod_codigo and 
				  d.peri_codi = det.peri_codi )
		  where d.deud_estado <> 'E')
	  select distinct     case (select desc_aplicaprontopago 
								  from descuento 
								  join Descuentos_Alumnos
									on descuento.desc_codigo = Descuentos_Alumnos.desc_codigo 
								 where alum_codigo = a.alum_codi 
								   and Descuentos_Alumnos.desc_alum_estado = 'A')
						  when 1 then 
						  (SELECT deuda.deud_totalPendiente - sum(isnull(convert(decimal(18,2),prontopago),0))
	 						 FROM CTE_DEUDA 
							WHERE (codigoDeuda = deuda.deud_codigo))
						  when 0 then deuda.deud_totalPendiente
						  else 
						  (SELECT deuda.deud_totalPendiente - sum(isnull(convert(decimal(18,2),prontopago),0))
	 						 FROM CTE_DEUDA 
							WHERE (codigoDeuda = deuda.deud_codigo))
						  end as valorfactura,
						a.alum_codi,
						a.alum_resp_form_banc_tarj_nume 
				  
	  FROM Alumnos a
	  left join Alumnos_Cursos_Paralelos alum_cp
	    on (alum_cp.alum_codi = a.alum_codi 
	   and alum_cp.alum_curs_para_estado='A')
	  left join Cursos_Paralelo cp
	    on cp.curs_para_codi=alum_cp.curs_para_codi
	  left join Cursos c
	    on c.curs_codi=cp.curs_codi 
	  left join Paralelos p
	    on p.para_codi=cp.para_codi
      left join Alumnos_Alumno_Estado_Periodo aaep
	    on (aaep.alum_codi = a.alum_codi
	   and aaep.alum_alum_est_peri_estado='A')
      left join Alumno_Estado_periodo aep
	    on (aep.alum_est_peri_codi=aaep.alum_est_peri_codi
	   and aep.alum_est_peri_estado='A')
	  left join Alumno_Estado ae
	    on (aep.alum_est_codi = ae.alum_est_codi
	   and ae.alum_est_estado='A')
	  left join Periodos per
	    on (per.peri_codi = aep.peri_codi
	   and alum_cp.peri_codi=per.peri_codi)
	  left join deuda
	    on deuda.alum_codi = a.alum_codi
	  left join cabeceraFactura cf
	    on (deuda.deud_codigoDocumento = cf.cabeFact_codigo
		   and deuda.deud_tipoDocumento='FAC')
	  left join detalleFactura df
	    on cf.cabeFact_codigo = df.cabeFact_codigo
	  left join producto
	    on df.prod_codigo = producto.prod_codigo
	  left join detalleAnioPeriodo dap
	    on producto.prod_codigo = dap.prod_codigo
	  left join catalogo cat
	    on (cat.idcatalogo = convert(varchar (max), a.alum_resp_form_banc_tarj)
		    and cat.idpadre='23') --BANCO, 22 --TARJETA 23
	  left join representantes_alumnos ra
	    on ra.alum_codi = a.alum_codi
	  left join representantes repr
	    on ra.repr_codi = repr.repr_codi
	 WHERE a.alum_estado='A'
	   and c.curs_codi is not null
	   and ae.alum_est_abre='MAT' --NO RETIRADO, SOLO MATRICULADOS
	   and per.peri_codi='10' --PERIODO
	   and ra.repre_alum_fact='S'
	   and cat.idcatalogo=30
	   and producto.prod_codigo=".$pension." --PENSION MES DE ENERO
	   and cf.cabefact_estado='PC' --FACTURA PAGADA";
		$stmt = sqlsrv_query( $conn, $sql,array(),array('Scrollable' => 'buffered'));
		if( $stmt === false) {die( print_r( sqlsrv_errors(), true) );}
		
		$row_count = sqlsrv_num_rows( $stmt );
		echo "<br><br><br>";
		echo "1"."14".str_pad(date('m'),2,'0',STR_PAD_LEFT).str_pad(date('d'),2,'0',STR_PAD_LEFT).str_pad($row_count,4,'0',STR_PAD_LEFT).'0000368044'.'&nbsp;&nbsp;&nbsp;'.'LICEOPANAMERICANO'.'0000000'.'00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000';
		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$ult_reg=$ult_reg+1;
			$valor=$row['valorfactura'];//deuda pendiente
			$valor=str_replace(".","",(str_replace(",","",$valor)));
			if($valor>0)
			{	echo "<br />";
			    echo "200".str_pad($row['alum_resp_form_banc_tarj_nume'],14,'0',STR_PAD_LEFT)."14".str_pad(date('m'),2,'0',STR_PAD_LEFT).str_pad(date('d'),2,'0',STR_PAD_LEFT).str_pad($ult_reg,7,'0',STR_PAD_LEFT)."00"."000000".str_pad($valor,13,'0',STR_PAD_LEFT)."0000000000000".str_pad($valor,13,'0',STR_PAD_LEFT)."001"."0000000000000"."0"."00"."000"."0"."0"."000000000000000000000000000000"."00000000000000".str_pad($valor,14,'0',STR_PAD_LEFT)."00000000000000";
			}
		}
		
		sqlsrv_free_stmt( $stmt);
		?>
	</body>
</html>