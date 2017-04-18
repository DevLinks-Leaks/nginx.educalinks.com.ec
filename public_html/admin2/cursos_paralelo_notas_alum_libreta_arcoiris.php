<?php
	session_start();	 
	include ('../framework/dbconf.php');
    include ('../framework/funciones.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Educalinks |  <?php echo para_sist(2); ?></title> 
    <link rel="SHORTCUT ICON" href="../imagenes/logo_icon.png"/>
	<link href="cursos_paralelo_notas_alum_libreta.css" rel="stylesheet" type="text/css">
    <link href="../theme/css/main.css" rel="stylesheet" type="text/css"> 
    <link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css">
	<script src="../framework/funciones.js"></script>

<style>
  	@page 
  	{  
  		size: A4 portrait;  
		margin: 0.5cm;
	}  
</style>
</head>
<body>
<?php
			
	$alum_codi=$_GET['alum_codi'];
	$peri_dist_codi=$_GET['peri_dist_codi'];
	$curs_para_codi=$_GET['curs_para_codi'];
	
	//Quimestre y Parcial
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_peri_codi (?)}";
	$cab_view = sqlsrv_query($conn, $sql, $params);  
	$cab_row=sqlsrv_fetch_array($cab_view);
 
	$params = array($peri_dist_codi, 'C');
	$sql="{call peri_dist_padr_libr_view(?,?)}";
	$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
	
	$peri_codi=Periodo_Distribucion_Peri_Codi($peri_dist_codi);
	 
	
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
	
?>
<?php
	  $file_exi = $_SESSION['ruta_foto_alumno'].$alum_codi.'.jpg';
	  if (file_exists($file_exi)) {
		$pp=$file_exi;
	  } else {
		$pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
	  }
?>
<page>
<div  class="libreta" >
      <div class="header_institution">
       <div class="institution">
		  <br/><br/>
          <div class="image" style="margin-right: 5px;height: 60px; width:120px">
			<br/><br/>
            <img src="<?= $_SESSION['ruta_foto_logo_libreta']; ?>">
          </div>
          <div class="name" style="padding-left: 10px">
			<div style="margin-right: 5px">
				<h1 style="margin: 0px 0; width: 100%;">BOLETÍN DE CALIFICACIONES</h1>
			</div>
			  <h3 style="margin: 0px 0;"><? echo $cab_row['nivel_1']."  ".$cab_row['nivel_2'];?></h3>
			  <h3 style="margin: 0px 0;"><?php echo $row_curs_info['curs_deta'].' - '.$row_curs_info['para_deta']; ?></h3>
			  <h3 style="margin: 0px 0;">Año Lectivo <?= $_SESSION['peri_deta']; ?></h3>
          </div>
        </div>
		<div class="user_data" style="margin-top: 5px">
			<div class="name">
				<span style="font-style: italic">
					Código: R8E-03 / Versión: 3 / Nov. 2015
				</span>
			</div>
		</div>
		<br /><br/>
        <div class="user_data">
          <div class="image" style="height: 55px; width:55px">
				<img src="<?php echo $pp;?>" border="0" style="border-color:#F0F0F0;" style="height: 55px; width:55px"/>
			</div>
          <div class="name">
            <h5 style="margin:0px 0px">
            	Estudiante:
			</h5>
        	<h4 style="margin:0px 0px">
				<?= 
					$row_alum_info['alum_apel']; ?> <?= $row_alum_info['alum_nomb'];
				?>
            </h4>
			<h5 style="margin:0px 0px">
				código: <?= $row_alum_info['alum_codi']; ?>
			</h5>
          </div>
        </div>
      </div>            
    <div class="CSSTableGenerator full" style="margin-bottom: 0px">
      <table class="table_striped">
        <thead>
          <tr>
            <th style="border: solid 1px black">ASIGNATURAS</th>
            <? $cabecera = array();
			while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view)) 
			{   echo '<th style="text-align: center;border: solid 1px black">'.$row_peri_dist_padr_view['peri_dist_abre'].'</th>';
				if( $row_peri_dist_padr_view['peri_dist_nota_tipo'] == 'VW' )
				{   $cabecera[] = str_replace( '%', "", $row_peri_dist_padr_view['peri_dist_abre'] );
				}else
				{	$cabecera[] = 100;
				}
            }?>
            <th style="text-align: center;border: solid 1px black">EQUIVALENCIA CUALITATIVA</th> 
          </tr>
        </thead>
        <tbody>

          <?php  while ($row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view)) { $cc +=1; ?> 
          <tr>
            <td width="25%" style="border: solid 1px black">
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
            <td align="center" width="10%" style="border: solid 1px black"
            <?php 
				$perc = (int)$cabecera[ $CC_COLUM_index ];
				$mayor_aceptable = ( ( 7 * $perc ) / 100 );
				if( ( $row_alum_nota_peri_dist_view[$CC_COLUM_index + 12] ) < $mayor_aceptable )
				{   echo " class='mala_nota_escuela_liceopanamericano'";
				}
		  	?>
            >
            <?
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
	            
            	 if ($row_alum_nota_peri_dist_view["mate_prom"] =='A'){ $prom_cc[$CC_COLUM_index] =  $prom_cc[$CC_COLUM_index] + 1; 
              $prom[$CC_COLUM_index] =  $prom[$CC_COLUM_index] + truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
            }?>
          </td>
          <?php $CC_COLUM_index+=1;}?>  
          <td width="10%" align="center" style="border: solid 1px black"> <?= $row_alum_nota_peri_dist_view['nota_peri_cual_refe']; ?></td>
        </tr>
        <?php }?>

        <tr>
          <td align="center" style="border: solid 1px black"><strong>PROMEDIO</strong></td>
          <? $CC_COLUM_index =0; while($CC_COLUM_index <= $CC_COLUM )  {?>       
          <td align="center" style="border: solid 1px black"
		  <?php 
		  	$perc = (int)$cabecera[ $CC_COLUM_index ];
			$mayor_aceptable = ( ( 7 * $perc ) / 100 );
			if( ( $row_alum_nota_peri_dist_view[$CC_COLUM_index + 12] ) < $mayor_aceptable )
			{   echo " class='mala_nota_escuela_liceopanamericano'";
			}
		?>
          >
           <strong>
              <?= (truncar(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]))==0)?'':truncar(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index])); ?> 
              <?php $prom_rend=$prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]; ?>
           </strong></td>    
           <?php $CC_COLUM_index+=1;}?>    
           <td  align="center" style="border: solid 1px black"><strong>
             <?= notas_prom_quali($_SESSION['peri_codi'],'C',$prom_rend); ?>
           </strong></td> 
         </tr>
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
    <div style="border: 1px solid #999; margin-top: 5px;">
    	<strong>INASISTENCIAS:</strong>
		<?
        while ($faltas=sqlsrv_fetch_array($stmt_falt))
        {
            echo '<span style="font-style: italic; margin-left:20px">'.$faltas['falt_tipo_deta'].':</span> '.$faltas['num_faltas'];
        }
        ?>
	</div>
	
  </div>  
  <div class="CSSTableGenerator half" style="margin-top: 0px">
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
	<div style="border: 1px solid #999; margin-top: 5px; padding: 2px; text-align: justify;">
    	<strong>EQUIVALENCIAS CUALITATIVAS DEL APRENDIZAJE:</strong>
		<?php
			$params = array('C', $_SESSION['peri_codi']);
			$sql="{call nota_peri_cual_tipo_view(?,?)}";
			$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
				
			while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
			{
				echo '<br/><span style="font-style: italic;">'.truncar($row_nota_peri_cual_tipo_view['nota_peri_cual_ini']).' - '.truncar($row_nota_peri_cual_tipo_view['nota_peri_cual_fin']).' ('.$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].') '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'].'</span>';
			}
        ?>
	</div>
	<div style="border: 1px solid #999; margin-top: 5px; padding: 2px;text-align: justify;">
    	<strong>EQUIVALENCIAS CUALITATIVAS DE COMPORTAMIENTO:</strong><br/>
		<?php
			$params = array('D', $_SESSION['peri_codi']);
			$sql="{call nota_peri_cual_tipo_view(?,?)}";
			$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
			
			while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
			{
				echo '<span style="font-style: italic; margin-right:5px">('.$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].') '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'].'</span>';
			}
        ?>
	</div>
	<table><tr><td style="vertical-align:middle" width='5px'><span style="font-size:large;">*</span></td><td><span style="font-style: italic">Calificaci&oacute;n menor al mínimo requerido</span></td></tr></table>
  </div>
 <div class="CSSTableGenerator half_end" style="margin-top: 0px">
	<?
		if ($row_curs_info['curs_orden']==11 or 
			$row_curs_info['curs_orden']==12 or 
			$row_curs_info['curs_orden']==13)
		{
	?>
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
	<?
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
	<div style="border: 1px solid #999; margin-top: 5px; padding: 2px;  height: 60px">
		<strong>OBSERVACIONES: </strong>
		<? echo $observaciones['nota_obse_deta']; ?>
	</div>
	<table width="100%">
		<tr>
			<td
				align="center" 
				width="50%" 
				style="padding-top: 40px">
				__________________________________<br />Tutor(a)
			</td>
			<td 
				align="center" 
				width="50%"
				style="padding-top: 40px">
				__________________________________<br />Representante
			</td>
		</tr>
	</table>
		
</div>
</div>
</page>
</body>
</html>