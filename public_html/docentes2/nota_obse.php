﻿<?php
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
    <link href="../theme/jquery1_11/external/jquery/jquery_growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
	<script src="../framework/funciones.js"></script>
    <script src="js/notas.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js" type="text/javascript"></script>
    <script src="../theme/jquery1_11/external/jquery/jquery_growl/javascripts/jquery.growl.js" type="text/javascript"></script>
    
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
          <div class="image" style="margin-right: 5px;height: 75px; width:75px">
            <img src="<?= $_SESSION['ruta_foto_logo_libreta']; ?>">
          </div>
          <div class="name">
                  <h4 style="margin: 2px 0;"><strong> UNIDAD EDUCATIVA <?= para_sist(3); ?> </strong></h4>
                  <h4 style="margin: 2px 0;">INFORMACION DE LOS APRENDIZAJES: <? echo $cab_row['nivel_1']."  ".$cab_row['nivel_2'];?></h4>
                  <h4 style="margin: 2px 0;"><?php echo $row_curs_info['nive_deta'].' : '.$row_curs_info['curs_deta'].' - '.$row_curs_info['para_deta']; ?></h4>
                  <h5 style="margin: 2px 0;">Año Lectivo <?= $_SESSION['peri_deta']; ?></h5>
          </div>
        </div>
      

        <div class="user_data">
          <div class="image" style="height: 55px; width:55px">
            <img src="<?php echo $pp;?>" border="0" style="border-color:#F0F0F0; width:auto; height: 60px; width:60px"/>
          </div>
          <div class="name">
                  <h5 style="margin:0px 0px">Estudiante:</h5>
                  <h4 style="margin:0px 0px"><?= $row_alum_info['alum_apel']; ?> <?= $row_alum_info['alum_nomb']; ?> - <?= $row_alum_info['alum_codi']; ?></h4>
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
            <th style="text-align: center">CUALIT.</th> 
          </tr>
        </thead>
        <tbody>

          <?php  while ($row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view)) { $cc +=1; ?> 
          <tr>
            <td width="3%"  >  <?= $cc;?>  </td>
            <td width="3%"  ><? if ($row_alum_nota_peri_dist_view["mate_prom"] =='A') echo '*';?></td>
            <td width="34%" >
              <div  <? if ($row_alum_nota_peri_dist_view["mate_padr"] >0) echo 'style="text-indent:15px;"';?>  >
                <?= $row_alum_nota_peri_dist_view['mate_deta']; ?> 
              </div>
            </td>
            <? $CC_COLUM_index =0; while($CC_COLUM_index <= $CC_COLUM )  {?>       
            <td align="center"
            <?php 
				if(($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12])<7)
				{
					echo " class='mala_nota'";
				}
		  	?>
            >
            	<? if ($row_alum_nota_peri_dist_view['mate_tipo'] <> 'D' and $row_alum_nota_peri_dist_view['mate_tipo'] <> 'P') {?> 
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
     <? 
	if (para_sist(7))
	{
	?>
    <div style="border: 1px solid #999; height: 70px; margin-top: 5px;">
        <p style="padding: 5px 10px; margin: 0 0">
                Visite 
                <span style="font-weight: bolder; font-style:italic;">www.lamoderna.edu.ec</span> / 
                <span style="font-weight: bolder; font-style:italic;">moderna.educalinks.com.ec</span>
		</p>
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
  </div>  
     <?php
	
		$params = array('D', $_SESSION['peri_codi']);
		$sql="{call nota_peri_cual_tipo_view(?,?)}";
		$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
		
	   
	?>
  <div class="CSSTableGenerator half" >
  	 <table class="table_striped">
    <thead>
      <tr>
        <th colspan="2" align="center">EQUIVALENCIA CUALITATIVAS DE COMPORTAMIENTO</th>
      </tr>
    </thead>
    <tbody>
      <?php  while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view)) { ?>
      <tr>
        <td  class="center"><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_refe']; ?> </td>
        <td><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_deta']; ?></td>
        <? } ?>
      </tr>
    </tbody>
  </table>
  	
  </div>
  
 <div class="CSSTableGenerator half_end" >
   <?php
		$params = array('C', $_SESSION['peri_codi']);
		$sql="{call nota_peri_cual_tipo_view(?,?)}";
		$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
	?>
  <table   class="table_striped"   >
        <thead>
        <tr>
          <th colspan="3" align="center">EQUIVALENCIA CUALITATIVAS DEL APRENDIZAJE</td>
          </tr>
        </thead>
        <tbody>

          <?php  while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view)) { ?>
          <tr>
            <td ><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_deta']; ?></td>
            <td ><?= number_format($row_nota_peri_cual_tipo_view['nota_peri_cual_ini'], 2, '.', ''); ?> - 
			<?= number_format($row_nota_peri_cual_tipo_view['nota_peri_cual_fin'], 2, '.', ''); ?></td>
            <td   ><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_refe']; ?></td>
          </tr>
          <? } ?>
        </tbody>
       </table>
       
	<?php
	if ($row_curs_info['curs_orden']==11 or 
	$row_curs_info['curs_orden']==12 or 
	$row_curs_info['curs_orden']==13)
	{
		$params = array('P', $_SESSION['peri_codi']);
		$sql="{call nota_peri_cual_tipo_view(?,?)}";
		$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
    ?>
      <table class="table_striped" style="margin-top: 5px;">
            <thead>
            <tr>
              <th colspan="3" align="center">EQUIVALENCIA CUALITATIVAS DE PROYECTOS</td>
              </tr>
            </thead>
            <tbody>
              <?php  while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view)) { ?>
              <tr>
                <td width="10%"><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_refe']; ?></td>
                <td><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_deta']; ?></td>
              </tr>
              <? } ?>
            </tbody>
        </table>
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
        <div style="border: 1px solid #999; height: 100px; margin-top: 15px;">
            <textarea
            	id="txt_observacion" 
            	style="width: 100%; height: 100px; background-color:#FFFF99; resize: none;" 
                placeholder="Ingrese una observación"><?= $observaciones['nota_obse_deta']; ?></textarea>
        </div>
        <button 
        	class="icon-disk btn btn-primary"
            onClick="GuardarObs(<?= $_GET['peri_dist_codi']?>, <?= $row_alum_info['alum_codi']?>, document.getElementById('txt_observacion').value)"
            style="margin: 10px 0px;">
            Guardar
		</button>
        <button 
        	class="icon-arrow-left btn btn-primary"
            onClick="window.history.go(-1);"
            style="margin: 10px 0px;">
            Regresar
		</button>
</div>
</div>
</page>
</body>
</html>