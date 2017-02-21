<?php
	session_start();
    include ('../framework/dbconf.php');
    include ('../framework/funciones.php');
	include ('../framework/lenguaje.php');
?>
<!DOCTYPE html>
<html style="-webkit-print-color-adjust:exact;">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Educalinks |  <?php echo para_sist(2); ?></title> 
	<link rel="SHORTCUT ICON" href="../imagenes/logo_icon.png"/>
	<link href="../theme/css/main.css" rel="stylesheet" type="text/css" /> 
	<link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css" />
	<script src="../framework/funciones.js"></script>
<style>
	@page 
	{  
		size: A4 portrait;
		margin: 0.5cm;
	}  
		
	@media all 
	{
		.page-break	{ display: none; }
	}

	@media print 
	{
		.page-break	{  display: block; page-break-before: always; }
	}
</style> 
</head>
<body>
<?php 
	
	$curs_para_codi=$_GET['curs_para_codi'];
	$peri_dist_codi=$_GET['peri_dist_codi'];
	if(isset($_GET['orientacion']))
	{	$orientacion = $_GET['orientacion'];
	}else
	{	$orientacion="portrait";
	}
	if(isset($_GET['ver_mv']))
	{	$ver_mv = $_GET['ver_mv'];
	}else
	{	$ver_mv="true";
	}
	if(isset($_GET['ml']))
	{	$ml = $_GET['ml'];
	}else
	{	$ml="false";
	}
	//Quimestre y Parcial
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_peri_codi (?)}";
	$cab_view = sqlsrv_query($conn, $sql, $params);  
	$cab_row=sqlsrv_fetch_array($cab_view);
	
	$params_est = array($curs_para_codi);
	$sql_est="{call alum_curs_para_view(?)}";
	$alumnos_view = sqlsrv_query($conn, $sql_est, $params_est); 
	
	while ($alumno = sqlsrv_fetch_array($alumnos_view))
	{	if( $alumno['alum_curs_para_estado'] != 'I' )
		{
		unset($prom);
		unset($prom_cc);
		$params = array($peri_dist_codi,'C');
		$sql="{call peri_dist_padr_libr_view(?,?)}";
		$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
		
		$peri_codi=Periodo_Distribucion_Peri_Codi($peri_dist_codi);
		 
		$alum_codi=$alumno['alum_codi'];
		$params = array($alum_codi,$peri_dist_codi,'C');
		$sql="{call alum_nota_peri_dist_view(?,?,?)}";
		$alum_nota_peri_dist_view = sqlsrv_query($conn, $sql, $params); 
		$row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view);
		
		$CC_COLUM=$row_alum_nota_peri_dist_view['CC_COLUM'];
		 
		sqlsrv_next_result($alum_nota_peri_dist_view);
		sqlsrv_next_result($alum_nota_peri_dist_view); 
		 
	 
		$params = array($alum_codi);
		$sql="{call alum_info(?)}";
		$alum_info = sqlsrv_query($conn, $sql, $params);
		$row_alum_info = sqlsrv_fetch_array($alum_info);
		
		$params = array($curs_para_codi);
		$sql="{call curs_para_info(?)}";
		$curs_info = sqlsrv_query($conn, $sql, $params);
		$row_curs_info = sqlsrv_fetch_array($curs_info);
		
		//Nombre del representante
		//Consulta datos del representante
		$sql_rep="{call repr_info_vida(?,?)}";
		$params_rep = array($alum_codi, "R");
		$stmt_rep = sqlsrv_query($conn, $sql_rep, $params_rep);
	
		if( $stmt_rep === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		$representante=sqlsrv_fetch_array($stmt_rep);
		 
		 
		$cc = 0;
		$CC_COLUM_index=0;
		$mate_size = 100-(($CC_COLUM+2)*7);
		
		  $file_exi=$_SESSION['ruta_foto_alumno'].$alumno["alum_codi"] . '.jpg';
		  if (file_exists($file_exi)) {
			$pp=$file_exi;
		  } else {
			$pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
		  }
?>
<page>
	<div  class="libreta" >
		<div class="header_institution">
			<table width='100%'>
				<tr style='text-align:center;'>
					<td width='15%' style='vertical-align:top;'>
						<div class="image" style="height:40px; width:150px;">
							<img src="<?= $_SESSION['ruta_foto_logo_libreta']; ?>">
						</div>
					</td>
					<td width='70%' style='vertical-align:top;'>
						<h2 style="margin: 0px 0; width: 100%;font-style:italic;" >INFORME DE CALIFICACIONES DEL <? echo $cab_row['nivel_1'].", ".$cab_row['nivel_2'];?></h2>
						<h3 style="margin: 0px 0; font-style:italic;">Per&iacute;odo Lectivo: <?= $_SESSION['peri_deta']; ?></h3>
						<h3 style="margin: 0px 0; font-style:italic;">Jornada: <?= para_sist(35); ?></h3>
					</td>
					<td width='15%' style='vertical-align:top;'>
						<div class="image" style="height:40px; width:150px;">
							<?php if ($ml=="true") echo "<img src='".$_SESSION['ruta_foto_logo_minis_long']."'"; ?>
						</div>
					</td>
				</tr>
			</table>
			<table width='100%'>
				<tr style='text-align:left;'>
					<td>
						<div class="image" style="height: 55px; width:55px">
							<img src="<?php echo $pp;?>" border="0" style="border-color:#F0F0F0;" style="height: 55px; width:55px"/>
						</div>
					</td>
					<td>
						<div style="font-size:normal;font-style:italic;"><b>CURSO:</b> <?php echo $row_curs_info['curs_deta'].' - '.$row_curs_info['para_deta']; ?></div>
						<div style="font-size:normal;font-style:italic;"><b>ESTUDIANTE:</b> <?php echo $row_alum_info['alum_apel']; ?> <?= $row_alum_info['alum_nomb']; ?></div>
						<div style="font-size:normal;font-style:italic;"><b>NIVEL:</b> <?php echo $row_curs_info['nive_deta'];?></div>
					</td>
					<td>
						<div style="font-size:normal;font-style:italic;"><?php echo get_fecha_ciudad($_SESSION['current_language']); ?></div>
						<div style="font-size:normal;font-style:italic;"><b>CODIGO:</b> <?= $row_alum_info['alum_codi']; ?></div>
						<div style="font-size:normal;font-style:italic;"><?= ($row_alum_info["alum_tiene_discapacidad"]?'INCLUSIÓN':'')?></div>
					</td>
				</tr>
			</table>
		  </div>            
		<div class="CSSTableGenerator full" style="margin-bottom: 0px">
			<table class="table_striped">
				<thead>
					<tr>
						<th style="border: solid 1px black" width="<?= $mate_size; ?>%">ASIGNATURAS</th>
							<?php $cabecera = array();
								while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view)) 
								{   echo '<th style="text-align: center;border: solid 1px black;word-break: break-word;padding:0;font-size:0.8em" width="7%">'.$row_peri_dist_padr_view['peri_dist_abre'].'</th>';
									if( $row_peri_dist_padr_view['peri_dist_nota_tipo'] == 'VW' )
									{   $cabecera[] = str_replace( '%', "", $row_peri_dist_padr_view['peri_dist_abre'] );
									}else
									{	$cabecera[] = 100;
									}
								}
							?>
						<th style="text-align: center;border: solid 1px black;word-break: break-word;padding:0;font-size:0.8em" width="7%">EQUIVALENCIA CUALITATIVA</th> 
					</tr>
				</thead>
				<tbody>
					<?php  
					while ($row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view))
					{ 	
						$cc +=1;
						if (!($row_alum_nota_peri_dist_view["mate_padr"]>0 and $row_alum_nota_peri_dist_view["mate_tipo"]=='P'))
						{
					?> 
					<tr>
						<td width="<?= $mate_size; ?>%" style="border: solid 1px black">
							<div  <? if ($row_alum_nota_peri_dist_view["mate_padr"] >0) echo 'style="text-indent:15px;"';?>  >
							<? 
								if ($row_alum_nota_peri_dist_view["mate_padr"]>0)
								{
									echo ucwords(mb_strtolower($row_alum_nota_peri_dist_view['mate_deta'],'UTF-8'));
								}
								else
								{
									echo mb_strtoupper($row_alum_nota_peri_dist_view['mate_deta'],'UTF-8');
								} 
							?> 
							</div>
						</td>
						<? $CC_COLUM_index =0; while($CC_COLUM_index <= $CC_COLUM )  {?>       
						<td align="center" width="7%" style="border: solid 1px black">
							<? 
			            	$perc = (int)$cabecera[ $CC_COLUM_index ];
							$mayor_aceptable = ( ( 7 * $perc ) / 100 ); //EDUCALINKS PENDIENTE
							if ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]>0 and $row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]<>null)
			            	{
			            		switch ($row_alum_nota_peri_dist_view['mate_tipo'])
			            		{
			            			case "C":
			            				echo (truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12])==0)?'':truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
			            				if(($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]>0) and ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]<$mayor_aceptable))
			            				{
			            					echo "*";
			            				}
			            			break;
			            			
			            			case "D":
			            				echo notas_prom_quali($_SESSION['peri_codi'],'D',$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
			            			break;
			            			
			            			case "P":
			            				echo notas_prom_quali($_SESSION['peri_codi'],'P',$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
			            			break;
			            		}
			            	}
			             
						 if ($row_alum_nota_peri_dist_view["mate_prom"] =='A')
						 { 
						 	$prom_cc[$CC_COLUM_index] =  $prom_cc[$CC_COLUM_index] + 1; 
			              	$prom[$CC_COLUM_index] =  $prom[$CC_COLUM_index] + truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
			            }
						?>
						</td>
						<?php $CC_COLUM_index+=1;}?>  
						<td width="7%" align="center" style="border: solid 1px black"> 
							<?= $row_alum_nota_peri_dist_view['nota_peri_cual_refe']; ?>
						</td>
					</tr>
				<?php 
					}
					}
				?>
				</tbody>
			</table>
		<?
			//Faltas del estudiante
			$sql_falt="{call falt_grup_tipo_alum_view(?,?,?,?)}";
			$params_falt = array($_SESSION['peri_codi'], 
								 $_GET['peri_dist_codi'], 
								 $_GET['curs_para_codi'], 
								 $row_alum_info['alum_codi']);
			$stmt_falt = sqlsrv_query($conn, $sql_falt, $params_falt);
		
			if( $stmt_falt === false )
			{
				echo "Error in executing statement .\n";
				die( print_r( sqlsrv_errors(), true));
			}
			?>
			<table>
				<tr>
					<td style="vertical-align:middle" width='5px'>
						<span style="font-size:large;">*</span></td>
					<td><span style="font-style: italic">
							Calificaci&oacute;n menor al mínimo requerido</span>
					</td>
				</tr>
			</table>
			<?php if ($orientacion=='landscape') echo '<div class="CSSTableGenerator half" style="margin-top: 0px">'; ?>
			<div style="border: 1px solid #999; margin-top: 0px;">
				<strong><span style='font-size:1em;'>INASISTENCIAS:</span></strong>
				<?
				$c=0;
				$array1= array();
				while ($faltas=sqlsrv_fetch_array($stmt_falt))
				{
					$array1[]= '<td><span style="font-style: italic;font-size:x-small;"><b>'.$faltas['falt_tipo_deta'].': </b>'.$faltas['num_faltas']."</span> </td>";
					$c++;
				}
				if ($orientacion=='landscape')
				{	echo "<span style='font-size:x-small;'>".genera_tabla_por_columnas($array1, 2, 0)."</span>";
				}else
				{	echo "".genera_tabla_por_columnas($array1, 4, 0)."";
				}
				//Observaciones del estudiante
				$sql_obs="{call nota_obse_view(?,?)}";
				$params_obs = array($row_alum_info['alum_codi'], $_GET['peri_dist_codi']);
				$stmt_obs = sqlsrv_query($conn, $sql_obs, $params_obs);

				if( $stmt_obs === false )
				{
					echo "Error in executing statement .\n";
					die( print_r( sqlsrv_errors(), true));
				}
				$observaciones=sqlsrv_fetch_array($stmt_obs);
				?>
			</div>
			<div style="border: 1px solid #999; margin-top: 5px;">
				<strong><span style='font-size:1em;'>OBSERVACIONES:</span><br></strong>
				<? echo '<span style="font-style: italic;font-size:x-small;">'.$observaciones['nota_obse_deta'].'</span>'; ?>
			</div>
		<?
		if (para_sist(7))
		{
		?>
			<div style="border: 1px solid #999; margin-top: 5px;">
				<ul>
					<li>
						<strong>ESTUDIANTE</strong> 
						Usuario: 
						<?= $row_alum_info['alum_usua']; ?> 
						Contraseña: 
						<?= $row_alum_info['alum_pass']; ?>
					</li>
					<li>
						<strong>REPRESENTANTE</strong> 
						Usuario: 
						<?= $representante["usuario"]; ?> 
						Contraseña: 
						<?= $representante["clave"]; ?>
					</li>
				</ul>
			</div>
			<?
			}
			?>
			<div style="border: 1px solid #999; margin-top: 5px; padding: 2px;">
				<strong><span style='font-size:1em;'>EQUIVALENCIAS CUALITATIVAS DEL APRENDIZAJE:</span></strong>
				<?php
					$params = array('C', $_SESSION['peri_codi']);
					$sql="{call nota_peri_cual_tipo_view(?,?)}";
					$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
					$c=0;
					unset($array1);
					$array1= array();
					while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
					{	$array1[]='<td><span style="font-style: italic;font-size:xx-small;">'.truncar($row_nota_peri_cual_tipo_view['nota_peri_cual_ini']).' - '.truncar($row_nota_peri_cual_tipo_view['nota_peri_cual_fin']).' ('.$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].') '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'].'</span></td>';
						$c++;
					}
					if ($orientacion=='landscape')
					{	echo "<span style='font-size:x-small;'>".genera_tabla_por_columnas($array1, 2, 0)."</span>";
					}else
					{	echo "".genera_tabla_por_columnas($array1, 4, 0)."";
					}
				?>
			</div>
			<?php
				if ($orientacion=='landscape') 
					echo '
						</div>
						<div class="CSSTableGenerator half_end" style="margin-top: 0px">';
			?>
			<div style="border: 1px solid #999; margin-top: 5px; padding: 2px;text-align: left;">
				<strong><span style='font-size:1em;'>EQUIVALENCIAS CUALITATIVAS DE COMPORTAMIENTO:</span></strong><br/>
				<?php
					$params = array('D', $_SESSION['peri_codi']);
					$sql="{call nota_peri_cual_tipo_view(?,?)}";
					$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
					$c=0;
					unset($array1);
					$array1= array();
					while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
					{	$array1[] = '<td><span style="font-style: italic; margin-right:5px">('.$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].') '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'].'</span></td>';
						$c++;
					}
					if ($orientacion=='landscape')
					{	echo "<span style='font-size:xx-small;'>".genera_tabla_por_columnas($array1, 5, 0)."</span>";
					}else
					{	echo "<span style='font-size:x-small;'>".genera_tabla_por_columnas($array1, 4, 0)."</span>";
					}
				?>
			</div>
			<?
				if ($row_curs_info['curs_orden']==11 or 
					$row_curs_info['curs_orden']==12 or 
					$row_curs_info['curs_orden']==13)
				{
			?>
			<div style="border: 1px solid #999;margin-top: 5px; padding: 2px; text-align: justify;">
				<strong>EQUIVALENCIAS CUALITATIVAS DE PROYECTOS:</strong><br/>
				<?php
					$params = array('P', $_SESSION['peri_codi']);
					$sql="{call nota_peri_cual_tipo_view(?,?)}";
					$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
					
					while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
					{
						echo '<span style="font-style: italic; margin-right:10px">('.$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].')'.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'].'</span>';
					}
				?>
			</div>
			<?php
				}
			?>
			<div style="border: 0px solid #999; margin-top: 5px; padding: 2px;text-align: left;">
				<?php
				unset($array1);
				$array1[]=array();
				$array1[0]="<td align='center' width='50%' style='padding-top: 5px;font-weight: bold;'><div class='image' style='height:50px; width:100px;margin-top:0px;'><img src='".$_SESSION["ruta_foto_firma"]."' /></div>".para_sist(33).": ".para_sist(5)."</td>";
				$array1[1]="<td align='center' width='50%' style='padding-top: 55px;font-weight: bold;'>Tutor(a):</td>";
				echo "<span style='font-size:normal;'>".genera_tabla_por_columnas($array1, 3, 1)."</span>";
				?>
			</div>
			<?php
				if ($ver_mv=="true"){
			?>
			<div style="border: 0 solid #999; margin-top: 5px; padding: 2px;text-align: left;">
				<?php
				unset($array1);
				$array1[]=array();
				$array1[0]="<td align='center' width='30%' valign='top' style='font-weight: bold;font-style:italic;'>Misi&oacute;n</td>";
				$array1[1]="<td align='center' style='font-weight: normal;font-style:italic;'>
						Formar en base a valores éticos y morales en cada una de las áreas del conocimiento. 
						Integrando a niños, jóvenes con habilidades múltiples y necesidades educativas para alcanzar un verdadero desarrollo; 
						comprometidos con la mejora continua, buscando la excelencia institucional.
					</td>";
				$array1[2]="<td align='center' style='font-weight: bold;font-style:italic;'>Visi&oacute;n</td>";
				$array1[3]="<td align='center' style='font-weight: normal;font-style:italic;'>
								Ser una de las mejores unidades educativas de la ciudad de Guayaquil, 
								entregando a la sociedad jóvenes capaces de enfrentar los desafíos del mundo actual.
							</td>";
				$array1[4]="<td align='center' style='padding-top: 20px;font-weight: normal;font-style:italic;'><span style='font-weight:bold;'>Valores:</span> 
					Respeto,  Solidaridad,  Lealtad,  Honestidad,Responsabilidad: Puntualidad y  Constancia</td>";
				if ($orientacion=='landscape')
				{	echo "<span style='font-size:xx-small;'>".genera_tabla_por_columnas($array1, 1, 0)."</span>";
				}else
				{	echo "<span style='font-size:x-small;'>".genera_tabla_por_columnas($array1, 1, 0)."</span>";
				}
				?>
			</div>
			<?php }
			if ($orientacion=='landscape') echo '</div>'; 
			unset($array1);?>
		</div>
	</div>  
</page>
<div class="page-break">&nbsp;</div>
<?
	}
}
?>
</body>
</html>