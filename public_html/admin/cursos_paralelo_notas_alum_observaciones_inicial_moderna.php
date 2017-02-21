﻿<?php
	session_start();
    include ('../framework/dbconf.php');
    include ('../framework/funciones.php');
?>
<!DOCTYPE html>
<html style="-webkit-print-color-adjust:exact;">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Educalinks |  <?php echo para_sist(2); ?></title>
        <link rel="SHORTCUT ICON" href="../imagenes/logo_icon.png"/>
        <link href="../theme/css/main.css" rel="stylesheet" type="text/css" />
        <link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css" />
        <link href="../theme/jquery1_11/external/jquery/jquery_growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
      	<script src="../framework/funciones.js"></script>
        <script src="js/funciones_notas.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js" type="text/javascript"></script>
    	<script src="../theme/jquery1_11/external/jquery/jquery_growl/javascripts/jquery.growl.js" type="text/javascript"></script>
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
    
            
    //PARAMETROS
    $enlace_pagina_oficial = para_sist(58);
    $enlace_pagina_academico = para_sist(59);
    
	$curs_para_codi=$_GET['curs_para_codi'];
	$peri_dist_codi=$_GET['peri_dist_codi'];
	$alum_codi=$_GET['alum_codi'];

	//Quimestre y Parcial
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_peri_codi (?)}";
	$cab_view = sqlsrv_query($conn, $sql, $params);
	$cab_row=sqlsrv_fetch_array($cab_view);

	unset($prom);
	unset($prom_cc);
	$params = array($peri_dist_codi,'I'); //I: Inicial
	$sql="{call peri_dist_padr_libr_view_NEW(?,?)}";
	$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params);

	$peri_codi=Periodo_Distribucion_Peri_Codi($peri_dist_codi);

	$params = array($alum_codi,$peri_dist_codi,'I');//I: Inicial
	$sql="{call alum_nota_peri_dist_view_NEW(?,?,?)}";
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

	  $file_exi=$_SESSION['ruta_foto_alumno'].$alum_codi . '.jpg';
	  if (file_exists($file_exi)) {
		$pp=$file_exi;
	  } else {
		$pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
	  }
?>
<page>
<div class="libreta" style="clear:both;">
    <div class="header_institution">
        <div class="institution">
          <div class="image" style="margin-right: 5px;height: 75px; width: 75px">
            <img src="<?= $_SESSION['ruta_foto_logo_libreta'];?>">
          </div>
          <div class="name">
            <h4 style="margin: 2px 0;">
	            <strong>
                	<?= para_sist(3); ?>
				</strong>
            </h4>
            <h4 style="margin: 2px 0;">
            	INFORMACION DE APRENDIZAJES: <? echo $cab_row['nivel_1']."  ".$cab_row['nivel_2'];?>
			</h4>
            <h4 style="margin: 2px 0;">
				<?php
					echo $row_curs_info['nive_deta'].' : '.$row_curs_info['curs_deta'].' - '.$row_curs_info['para_deta'];
				?>
			</h4>
				<h5 style="margin: 2px 0;">
                	Año Lectivo <?= $_SESSION['peri_deta']; ?>
				</h5>
          </div>
        </div>

        <div class="user_data">
            <div class="image" style="height: 55px; width:55px">
            	<img src="<?php echo $pp;?>" border="0" style="border-color:#F0F0F0;" style="height: 55px; width:55px"/>
            </div>
        <div class="name">
        	<h5 style="margin: 0px 0px;">
            	Estudiante:
			</h5>
        	<h4 style="margin: 0px 0px;">
				<?=
					$row_alum_info['alum_apel']; ?> <?= $row_alum_info['alum_nomb']; ?> - <?= $row_alum_info['alum_codi'];
				?>
            </h4>
        </div>
    	</div>
    </div>
    <div class="CSSTableGenerator full">
      <table class="table_striped" width="50%">
        <thead>
          <tr>
            <th>ÁMBITOS</th>
            <? while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view))  {?>
            <th style="text-align: center">
              <?= $row_peri_dist_padr_view['peri_dist_abre']; ?>
            </th>
            <?php  }?>
          </tr>
        </thead>
        <tbody>

          <?php  while ($row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view)) { $cc +=1; ?>
          <tr>
            <td width="80%">
              <div  
			  	<? 
				$sangria=($row_alum_nota_peri_dist_view["nivel"]-1)*15;
				if ($row_alum_nota_peri_dist_view["nivel"]>1) 
					echo 'style="padding-left:'.$sangria.'px;"'; 
				else 
					echo 'style="font-size: 1.2em;font-weight: bolder;"'
				?>  
               >
               
                <?= $row_alum_nota_peri_dist_view['mate_deta']; ?>
              </div>
            </td>
            <? $CC_COLUM_index =0; while($CC_COLUM_index < $CC_COLUM )  {?>
            <td align="center">
				<?=
                 ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]==0 or $row_alum_nota_peri_dist_view["es_padre"])?
                 '':nota_peri_cual_cons($_SESSION['peri_codi'], 
				 						$row_alum_nota_peri_dist_view['nota_refe_cab_codi'], 
										$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]); 
                ?>
          </td>
          <?php $CC_COLUM_index+=1;}?>
        </tr>
        <?php 
		$nota_refe_cab_codi=$row_alum_nota_peri_dist_view["nota_refe_cab_codi"];
		}?>
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
    <div style="border: 1px solid #999; height: 25px; margin-top: 5px;">
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
    <div style="border: 1px solid #999; height: 80px; margin-top: 5px;">
    	<p style="padding: 5px 10px; margin: 0 0">
    		Visite
            <span style="font-weight: bolder; font-style:italic;"><?= $enlace_pagina_oficial; ?></span> / 
            <span style="font-weight: bolder; font-style:italic;"><?= $enlace_pagina_academico; ?></span>
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
  <div class="CSSTableGenerator half" >
  <?php

		$params = array($nota_refe_cab_codi);
		$sql="{call nota_peri_cual_tipo_view_NEW(?)}";
		$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
	?>
  <table class="table_striped">
        <thead>
        <tr>
          <th colspan="2" align="center">EQUIVALENCIA CUALITATIVAS DEL APRENDIZAJE</td>
          </tr>
        </thead>
        <tbody>
          <?php  while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view)) { ?>
          <tr>
            <td><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_deta']; ?></td>
            <td><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_refe']; ?></td>
          </tr>
          <? } ?>
        </tbody>
    </table>


    </div>
    <div class="CSSTableGenerator half_end" >
    <?php
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
<div class="page-break">&nbsp;</div>
</body>
</html>