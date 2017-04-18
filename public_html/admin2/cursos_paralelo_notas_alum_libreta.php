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
  @page {  size: A4 landscape;  }  
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
 
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_padr_libr_view(?)}";
	$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
	
	$peri_codi=Periodo_Distribucion_Peri_Codi($peri_dist_codi);
	 
	
	$params = array($alum_codi,$peri_dist_codi);
	$sql="{call alum_nota_peri_dist_view(?,?)}";
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
          <div class="image">
            <img src="<?= $_SESSION['ruta_foto_logo_libreta']; ?>" width="90" height="107">
          </div>
          <div class="name">
                  <h4> <strong> UNIDAD EDUCATIVA <?= para_sist(3); ?> </strong></h4>
                  <h4>INFORMACION DE APRENDIZAJE: <? echo $cab_row['nivel_1']."  ".$cab_row['nivel_2'];?></h4>
                  <h4><?php echo $row_curs_info['nive_deta'].' : '.$row_curs_info['curs_deta'].' - '.$row_curs_info['para_deta']; ?></h4>
                  <h5>Ano Lectivo <?= $_SESSION['peri_deta']; ?></h5>
          </div>
        </div>
      

        <div class="user_data">
          <div class="image">
            <img src="<?php echo $pp;?>"     border="0" style="border-color:#F0F0F0; width:auto; height:80px;"/>
          </div>
          <div class="name">
                  <h5>Estudiante:</h5>
                  <h4><?= $row_alum_info['alum_apel']; ?> <?= $row_alum_info['alum_nomb']; ?> - <?= $row_alum_info['alum_codi']; ?></h4>
          </div>
        </div>
      </div>            
    <div class="CSSTableGenerator full" >
      <table class="table_striped">
        <thead>
          <tr >


            <th colspan="3" align="left">ASIGNATURAS</th>
            <? while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view))  {?>       
            <th align="left">
              <?= $row_peri_dist_padr_view['peri_dist_abre']; ?>
            </th>    
            <?php  }?>
            <th align="left">CUALIT.</th> 
            <th align="left">RECOMENDACION.</th> 
            <th align="left">PLAN DE MEJORAMIENTO ACADEMICO</th> 
          </tr>
        </thead>
        <tbody>

          <?php  while ($row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view)) { $cc +=1; ?> 
          <tr>
            <td width="3%"  >  <?= $cc;?>  </td>
            <td width="3%"  ><? if ($row_alum_nota_peri_dist_view["mate_prom"] =='A') echo '*';?></td>
            <td width="24%" >
              <div  <? if ($row_alum_nota_peri_dist_view["mate_padr"] >0) echo 'style="text-indent:15px;"';?>  >
                <?= $row_alum_nota_peri_dist_view['mate_deta']; ?> 
                (<?= $row_alum_nota_peri_dist_view['alum_curs_para_mate_codi']; ?> )
              </div>
            </td>
            <? $CC_COLUM_index =0; while($CC_COLUM_index <= $CC_COLUM )  {?>       
            <td align="right" style="height:15px;"
            <?php 
				if(($row_alum_nota_peri_dist_view[$CC_COLUM_index + 10])<7)
				{
					echo " class='mala_nota'";
				}
		  	?>
            >
            	<? if ($row_alum_nota_peri_dist_view['mate_tipo'] <> 'Q' ) {?> 
             		<?=
					(number_format($row_alum_nota_peri_dist_view[$CC_COLUM_index + 10], 2, '.', '')==0)?'':number_format($row_alum_nota_peri_dist_view[$CC_COLUM_index + 10], 2, '.', '');
					echo ' - '.notas_prom_quali(10,'C',$row_alum_nota_peri_dist_view[$CC_COLUM_index + 10]); 
					 ?>                      
             	<? } ?>
             <? if ($row_alum_nota_peri_dist_view["mate_prom"] =='A'){ $prom_cc[$CC_COLUM_index] =  $prom_cc[$CC_COLUM_index] + 1; 
              $prom[$CC_COLUM_index] =  $prom[$CC_COLUM_index] + $row_alum_nota_peri_dist_view[$CC_COLUM_index + 10];
            }?>
          </td>
          <?php $CC_COLUM_index+=1;}?>  

          <td align="center"> <?= $row_alum_nota_peri_dist_view['nota_peri_cual_refe']; ?> </td>
          <td>  </td>
          <td>  </td>
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
          <div style="display:none;" >
           <strong>
              <?= (number_format(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]), 2, '.', '')==0)?'':number_format(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]), 2, '.', ''); ?> 
              <?php $prom_rend=$prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]; ?>
           </strong>
           </div>
           </td>    
           <?php $CC_COLUM_index+=1;}?>    
           <td  align="center"><strong>
             <?= notas_prom_quali(1,'C',$prom_rend); ?>
           </strong></td> 
           <td  align="left">	</td> 
           <td  align="left">	</td> 
         </tr>
         <tr>
          <td colspan="3" align="right" valign="middle"><strong>Faltas Totales</strong></td>
          <td align="right" colspan="<?= $CC_COLUM_index; ?> ">&nbsp;</td>
          <td align="center">
          <?
			//Faltas del estudiante
			$sql_falt="{call falt_alum_view(?,?,?,?)}";
			$params_falt = array($_SESSION['peri_codi'], $_GET['peri_dist_codi'], $_GET['curs_para_codi'], $_GET['alum_codi']);
			$stmt_falt = sqlsrv_query($conn, $sql_falt, $params_falt);
		
			if( $stmt_falt === false )
			{
				echo "Error in executing statement .\n";
				die( print_r( sqlsrv_errors(), true));
			}
			$faltas=sqlsrv_fetch_array($stmt_falt);
			echo $faltas['num_faltas'];
		  ?>
          </td>
          <td align="left">&nbsp;</td>
          <td align="left"></td>
        </tr>
      </tbody>
    </table>
  </div>
    
   
    
    <?php
	
		$params = array('C', $_SESSION['peri_codi']);
		$sql="{call nota_peri_cual_tipo_view(?,?)}";
		$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
		
	   
	?>
    
    

  <div class="CSSTableGenerator half" >


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
            <td   ><?= number_format($row_nota_peri_cual_tipo_view['nota_peri_cual_ini'], 2, '.', ''); ?> - <?= number_format($row_nota_peri_cual_tipo_view['nota_peri_cual_fin'], 2, '.', ''); ?></td>
            <td   ><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_refe']; ?></td>
          </tr>
          <? } ?>
        </tbody>
       </table>
        <?
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
		
		?>
        <table class="table_striped">
        	<tr>
                <td align="center" width="50%"><br /></td>
                <td align="center" width="50%"><br /></td>
            <tr>
                <td align="center" width="50%">__________________________________<br />Tutor(a)</td>
                <td align="center" width="50%">__________________________________<br /><? echo $representante["nombres"]; ?></td>
            </tr>
        </table>

    </div>
              
        
        
    <?php
	
		$params = array('Q', $_SESSION['peri_codi']);
		$sql="{call nota_peri_cual_tipo_view(?,?)}";
		$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
		
	   
	?>


 <div class="CSSTableGenerator half_end" >
  <table class="table_striped">
    <thead>
      <tr>
        <th colspan="2" align="center">EQUIVALENCIA CUALITATIVAS</th>
      </tr>
    </thead>
    <tbody>
      <?php  while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view)) { ?>
      <tr>
        <td  class="center"><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_refe']; ?> -</td>
        <td><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_deta']; ?></td>
        <? } ?>
      </tr>
    </tbody>
  </table>
</div>
      


</div>



</page>
</body>
</html>