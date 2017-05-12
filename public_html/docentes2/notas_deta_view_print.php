<?php
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
?>
<!DOCTYPE html>
<html>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Educalinks | <?php echo get_parametro($_SESSION['codi'], 4); ?></title> 
        <link rel="SHORTCUT ICON" href="http://108.179.196.99/educalinks/imagenes/logo_icon.png"/>
        <link href="../theme/css/main.css" rel="stylesheet" type="text/css"> 
    <link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css">
	  
	<style>
		@page {  size: A4 portrait;  }  
		@media all {
	.page-break	{ display: none; }
}

@media print {
	.page-break	{ display: block; page-break-before: always; }
}
	</style> 
</head>
<body>

<?php  
	$peri_dist_codi=$_GET['peri_dist_codi'];
	$curs_para_mate_codi =$_GET['curs_para_mate_codi'];
 
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_padr_view(?)}";
	$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
	
	$params = array($curs_para_mate_codi,$peri_dist_codi);
	$sql="{call curs_para_nota_peri_dist_view(?,?)}";
	$curs_para_nota_peri_dist_view = sqlsrv_query($conn, $sql, $params); 
	$row_curs_para_nota_peri_dist_view= sqlsrv_fetch_array($curs_para_nota_peri_dist_view);
	
	$CC_COLUM=$row_curs_para_nota_peri_dist_view['CC_COLUM'];
	 
	sqlsrv_next_result($curs_para_nota_peri_dist_view);
	sqlsrv_next_result($curs_para_nota_peri_dist_view); 
	  
	 
	$cc = 0;
	$CC_COLUM_index=0;
	
	
	$params = array($nota_perm_codi);
	$sql="{call nota_perm_info(?)}";
	$nota_perm_info = sqlsrv_query($conn, $sql, $params); 
	$row_nota_perm_info= sqlsrv_fetch_array($nota_perm_info);
	
	// validacion si el permiso esta activa
	$aa=$row_nota_perm_info['nota_peri_esta_resu'];
	
  
	$all='UNA';$peri_codi=0;
	
	if(isset($_GET['peri_codi'])){
		 $peri_codi=$_GET['peri_codi'];
		 $all='YES';
	}
	
	
	$params = array($peri_codi);
	$sql="{call curs_peri_view(?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params);  
	 
?>	



<?php  while (($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) or  ($all=='UNA'))  {  ?> 

 <?php 	
	if ($all=='UNA'){ 
		$all='OFF';
		if(isset($_GET['curs_para_codi'])){
		 	$curs_para_codi=$_GET['curs_para_codi'];
		}
		if(isset($_POST['curs_para_codi'])){
		 	$curs_para_codi=$_POST['curs_para_codi'];
		}
		 
	}else {
		$curs_para_codi=$row_curs_peri_view['curs_para_codi'];
	}
	

	$params = array($curs_para_codi);
	$sql="{call alum_curs_para_view(?)}";
	$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
	
	$params = array($curs_para_mate_codi);
	$sql="{call curs_para_mate_info(?)}";
	$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
	$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info)
?>
<page>
	<div  class="lista" >

	<div class="header_institution">
        <div class="institution">
          <div class="image">
            <img src="../imagenes/reportes/logo_libreta.png" width="90" height="107">
          </div>
          <div class="name">
                  <h4> <strong> UNIDAD EDUCATIVA <?= $_SESSION['cliente']; ?> </strong></h4>
                  <h4>INFORMACION DE APRENDIZAJE DEL SEGUNDO PARCIAL DEL PRIMER QUIMESTRE</h4>
                  <h5>Ano Lectivo <?= $_SESSION['peri_deta']; ?></h5>
          </div>
        </div>
        <div class="user_data">
          <div class="name">
                  <h4>Curso: <?= $row_curs_peri_info['curs_deta']; ?> </h4>
                  <h4>Paralelo: <?= $row_curs_peri_info['para_deta']; ?></h4>
          </div>
        </div>
    </div>


	<div class="full">
	  
<input id="CC_COLUM_index" value="<?= $CC_COLUM; ?>" type="hidden"  />

<table class="table_striped" >
        <thead>
        <tr>
          
           <th align="left">#</th> 
              <th align="left">Alumnos</th> 
             
              <? while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view))  { $cc +=1 ?>       
                
                <th class="left">
          <?= $row_peri_dist_padr_view['peri_dist_abre']; ?>
                    <input type="hidden" value="<?= $row_peri_dist_padr_view['peri_dist_codi']; ?>" id="peri_dist_codi_<?= $cc;?>"/>
                    <input type="hidden" value="<?= $row_peri_dist_padr_view['peri_dist_nota_tipo']; ?>" id="peri_dist_nota_tipo_<?= $cc;?>"/>
                    <?php  $peri_dist_nota_tipo[$cc]= $row_peri_dist_padr_view['peri_dist_nota_tipo'];?>  
                </th>    
              <?php  }$cc =0;?>      
                
            
        </tr>
                
        </thead>
        <tbody>
		
            <?php  while ($row_curs_para_nota_peri_dist_view= sqlsrv_fetch_array($curs_para_nota_peri_dist_view)) { $cc +=1; ?> 
            	<tr>
              
              <td class="center"><?= $cc;?></td>

              <td > <?= $row_curs_para_nota_peri_dist_view['alum_codi']; ?> -
                  	
                    <input type="hidden" value="<?= $row_curs_para_nota_peri_dist_view['alum_curs_para_mate_codi']; ?>" id="alum_curs_para_mate_codi_<?= $cc;?>" />
				  	<?= $row_curs_para_nota_peri_dist_view['alum_apel']; ?> 	<?= $row_curs_para_nota_peri_dist_view['alum_nomb']; ?>
                  </td>
				  	<? $CC_COLUM_index =0; while($CC_COLUM_index <= $CC_COLUM )  {?>       
                      <td align="right" >
                      		 
                        		<?= number_format($row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 8], 2, '.', ''); ?> 
                                <?php
									$prom_cc[$CC_COLUM_index] =  $prom_cc[$CC_COLUM_index] + 1;  
									$prom[$CC_COLUM_index] =  $prom[$CC_COLUM_index] + $row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 8]; ?> 
                      </td>
           			<?php $CC_COLUM_index+=1;} ?>    
              	</tr>
            <?php } ?>
            
            
           <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
             <? $CC_COLUM_index =0; while($CC_COLUM_index <= $CC_COLUM )  {?>       
              	<td align="right">&nbsp;
                 <strong>
             		<?= number_format(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]), 2, '.', ''); ?> 
               </strong>
                </td> 
            
              <?php $CC_COLUM_index+=1;}?>    
                
            </tr>
        </tbody>
</table><? if ($aa=='A') {?>
<div  style="width:95%; height:90; text-align:right">
<button class="btn btn-primary" onclick="curs_para_nota_peri_dist_save(<?=$peri_dist_codi;?>,<?=$curs_para_mate_codi;?>,<?=$nota_perm_codi;?>);">  Grabar 	</button>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button class="btn btn-primary" onclick="window.location='notas.php'">  Cancelar 	</button>
</div><? } ?>
<br />
<br />
<br />
<br />
<br />
<br />

<input id="cc" value="<?= $cc; ?>" type="hidden"  />
      
      
	</div>

	</div>
</page>
<div class="page-break"></div>
<? } ?>
</body>
</html>


              