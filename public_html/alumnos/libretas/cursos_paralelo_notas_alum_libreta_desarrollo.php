﻿<?php
	session_start();	 
	include ('../../framework/dbconf.php');
    include ('../../framework/funciones.php');
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
	if (!alum_tiene_deuda($_SESSION['alum_codi'],$_SESSION['curs_para_codi']) and !alum_tiene_deuda_vencida($_SESSION['alum_codi'],$_SESSION['peri_codi']))
	{		
	$alum_codi=$_SESSION['alum_codi'];
	$peri_dist_codi=$_GET['peri_dist_codi'];
	$curs_para_codi=$_SESSION['curs_para_codi'];
	//VALIDA PERMISO DE VISUALIZACIÓN
	$peri_etap_codi = 'U';
	$params = array($_SESSION['peri_codi'], $_SESSION['peri_dist_cab_tipo'],$peri_etap_codi);
	$sql="{call peri_dist_peri_view_Lb_etapa(?,?,?)}";
	$peri_dist_peri_view = sqlsrv_query($conn, $sql, $params);
	$nonegar = 0;
	while($row_peri_dist_peri_view = sqlsrv_fetch_array($peri_dist_peri_view))
	{ 	if($row_peri_dist_peri_view['peri_dist_codi'] == $peri_dist_codi)
		$nonegar++;
	}
	if($nonegar == 0)
	{	die ( "Resultado desconocido" );
	}
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
          <div class="image" style="margin-right: 5px;height: 75px; width:75px">
            <img src="<?= $_SESSION['ruta_foto_logo_libreta']; ?>">
          </div>
          <div class="name">
                  <h4 style="margin: 2px 0;"><strong> UNIDAD EDUCATIVA <?= para_sist(3); ?> </strong></h4>
                  <h4 style="margin: 2px 0;">INFORMACION DE LOS APRENDIZAJES: <? echo $cab_row['nivel_1']."  ".$cab_row['nivel_2'];?></h4>
                  <h4 style="margin: 2px 0;"><?php echo $row_curs_info['curs_deta'].' - '.$row_curs_info['para_deta']; ?></h4>
                  <h5 style="margin: 2px 0;">Año Lectivo <?= $_SESSION['peri_deta']; ?></h5>
          </div>
        </div>
      

        <div class="user_data">
          <div class="image" style="height: 55px; width:55px">
            <img src="<?php echo $pp;?>" border="0" style="border-color:#F0F0F0; width:auto; height: 60px; width:60px"/>
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
				Código:
			</h5>
			<h4 style="margin:0px 0px">
				<?= $row_alum_info['alum_codi']; ?>
			</h4>
          </div>
        </div>
      </div>            
    <div class="CSSTableGenerator full" >
      <table class="table_striped">
        <thead>
          <tr>
            <th colspan="3">ASIGNATURAS</th>
            <? while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view))  {?>       
            <th style="text-align: center">
              <?= $row_peri_dist_padr_view['peri_dist_abre']; ?>
            </th>    
            <?php  }?>
            <th style="text-align: center">EQUIVALENCIAS CUALITATIVAS</th> 
          </tr>
        </thead>
        <tbody>

          <?php  while ($row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view)) { $cc +=1; ?> 
          <tr>
            <td width="2%"  >  <?= $cc;?>  </td>
            <td width="3%"  ><? if ($row_alum_nota_peri_dist_view["mate_prom"] =='A') echo '*';?></td>
            <td width="25%" >
              <div  <? if ($row_alum_nota_peri_dist_view["mate_padr"] >0) echo 'style="text-indent:15px;"';?>  >
                <?= $row_alum_nota_peri_dist_view['mate_deta']; ?> 
              </div>
            </td>
            <? $CC_COLUM_index =0; while($CC_COLUM_index <= $CC_COLUM )  {?>       
            <td align="center" width="10%"
            <?php 
				if(($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12])<7)
				{
					echo " class='mala_nota'";
				}
		  	?>
            >
            	<? if ($row_alum_nota_peri_dist_view['mate_tipo'] <> 'D' and $row_alum_nota_peri_dist_view['mate_tipo'] <> 'P' ) {?> 
             		<?=
					(number_format($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12], 2, '.', '')==0)?'':number_format($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12], 2, '.', '');
					 ?>                      
             	<? } ?>
             <? if ($row_alum_nota_peri_dist_view["mate_prom"] =='A'){ $prom_cc[$CC_COLUM_index] =  $prom_cc[$CC_COLUM_index] + 1; 
              $prom[$CC_COLUM_index] =  $prom[$CC_COLUM_index] + $row_alum_nota_peri_dist_view[$CC_COLUM_index + 12];
            }?>
          </td>
          <?php $CC_COLUM_index+=1;}?>  
          <td width="10%" align="center"> <?= $row_alum_nota_peri_dist_view['nota_peri_cual_refe']; ?></td>
        </tr>
        <?php }?>


        <tr>
          <td colspan="3" align="center"><strong>PROMEDIOS RENDIMIENTO</strong></td>
          <? $CC_COLUM_index =0; while($CC_COLUM_index <= $CC_COLUM )  {?>       
          <td align="right" 
		  <?php 
		  	if(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index])<7)
			{
				echo " class='mala_nota'";
			}
		  ?>
          >
           <strong>
              <?= (number_format(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]), 2, '.', '')==0)?'':number_format(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]), 2, '.', ''); ?> 
              <?php $prom_rend=$prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]; ?>
           </strong></td>    
           <?php $CC_COLUM_index+=1;}?>    
           <td  align="center"><strong>
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
    <div style="border: 1px solid #999; height: 20px; margin-top: 5px;">
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
            	<strong>ALUMNO</strong> 
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
    	<strong>EQUIVALENCIAS CUALITATIVAS DEL APRENDIZAJE:</strong><br/>
		<?php
			$params = array('C', $_SESSION['peri_codi']);
			$sql="{call nota_peri_cual_tipo_view(?,?)}";
			$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
				
			while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
			{
				echo '<span style="font-style: italic; margin-left:20px">'.number_format($row_nota_peri_cual_tipo_view['nota_peri_cual_ini'],2,'.',',').' - '.number_format($row_nota_peri_cual_tipo_view['nota_peri_cual_fin'],2,'.',',').' ('.$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].')</span>'.' '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'];
			}
        ?>
	</div>
	<div style="border: 1px solid #999; margin-top: 5px; padding: 2px;text-align: justify;">
    	<strong>EQUIVALENCIAS CUALITATIVAS DE COMPORTAMIENTO:</strong>
		<?php
			$params = array('D', $_SESSION['peri_codi']);
			$sql="{call nota_peri_cual_tipo_view(?,?)}";
			$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
			
			while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
			{
				echo '<span style="font-style: italic; margin-left:20px">('.$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].')</span> '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'];
			}
        ?>
	</div>
  </div>
 <div class="CSSTableGenerator half_end" style="margin-top: 0px">
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
				echo '<span style="font-style: italic; margin-left:20px">('.$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].')</span> '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'];
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
	<div style="border: 1px solid #999; margin-top: 5px; padding: 2px">
		<strong>OBSERVACIONES: </strong>
		<? echo $observaciones['nota_obse_deta']; ?>
	</div>
</div>
</div>
<?
	}
	else
	{
		echo "<h1>Usted no puede ver sus notas porque mantiene deudas con la institución.<h1>";
	}
?>
</page>
</body>
</html>