<?php
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
?>
<!DOCTYPE html>
<html>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Educalinks | <?php echo para_sist(2); ?></title> 
        <link rel="SHORTCUT ICON" href="../imagenes/logo_icon.png"/>
        <link href="../theme/css/main.css" rel="stylesheet" type="text/css"> 
    <link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css">
	  
	<style>
		@page {    }  
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
	$curs_para_codi =$_GET['curs_para_codi'];
  
 
  	$params = array($peri_dist_codi);
	$sql="{call peri_dist_padr_view(?)}";
	$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
	
	

	$params = array($curs_para_codi);
	$sql="{call curs_para_info(?)}";
	$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
	$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
	
 
	
	$params = array($curs_para_codi);
	$sql="{call alum_curs_para_view(?)}";
	$alum_curs_para_view = sqlsrv_query($conn, $sql, $params); 
	$row_alum_curs_para_view = sqlsrv_fetch_array($row_alum_curs_para_view); 
	
	
	$CC_FILAS_index=0;		
	$CC_COLUM_index=0;		
	$CC_COLUM=0;
	
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_padr_view(?)}";
	$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
	
	//Quimestre y Parcial
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_peri_codi (?)}";
	$cab_view = sqlsrv_query($conn, $sql, $params);  
	$cab_row=sqlsrv_fetch_array($cab_view);
	
	//Datos del profesor
	$params = array($curs_para_mate_codi);
	$sql="{call prof_curs_para_mate_cons (?)}";
	$dat_profesor = sqlsrv_query($conn, $sql, $params);  
	$prof_row=sqlsrv_fetch_array($dat_profesor);
	 

 
	$cc = 0;
	while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view))  { 		        
		$CC_COLUM +=1;       
        $Array_peri_dist_abre[$CC_COLUM]=$row_peri_dist_padr_view['peri_dist_abre'];  
        $Array_peri_dist_nota_tipo[$CC_COLUM]= $row_peri_dist_padr_view['peri_dist_nota_tipo'];  
		 
		
    } 
	
	 
 
	
?>
<page>
	<div  class="lista" >

	<div class="header_institution">
        <div class="institution">
          <div class="image">
            <img src="../imagenes/reportes/<?= $_SESSION['directorio']; ?>/logo_libreta.png" width="90" height="107">
          </div>
          <div class="name">
                  <h4> <strong> UNIDAD EDUCATIVA <?= para_sist(3); ?> </strong></h4>
                  <h4>INFORMACION DE APRENDIZAJE <? echo $cab_row['nivel_1']."  ".$cab_row['nivel_2']; ?></h4>
                  <h5>Ano Lectivo <?= $_SESSION['peri_deta']; ?></h5>
          </div>
        </div>
        <div class="user_data">
          <div class="name">
                  <h4>Curso: <?= $row_curs_peri_info['curs_deta']; ?> </h4>
                  <h4>Paralelo:<?= $row_curs_peri_info['para_deta']; ?></h4>
                  
          </div>
        </div>
    </div>


	<div class="full">
	  
<input id="CC_COLUM_index" value="<?= $CC_COLUM; ?>" type="hidden"  />

<table class="table_striped" >
        <thead>
        <tr>
          <th align="left">#</th>
          <th align="left">Alumnos  </th>
           <?php  
					  	$params = array($curs_para_codi);
						$sql="{call curs_peri_mate_view(?)}";
						$curs_peri_mate_view = sqlsrv_query($conn, $sql, $params); 
					 	
					  
					  //ini  LOOP  MATERIAS
					  while ($row_curs_peri_mate_view = sqlsrv_fetch_array($curs_peri_mate_view)) {  ?> 
                 				<th class="left" colspan="<?= $CC_COLUM; ?>"><?= $row_curs_peri_mate_view['mate_deta']; ?></th>
			  	
                      <?php } //FIN  LOOP 2?> 
          
        </tr>
        <tr>
          
           <th align="left">&nbsp;</th> 
              <th align="left">&nbsp;</th> 
             
               
             <?php  
				$params = array($curs_para_codi);
				$sql="{call curs_peri_mate_view(?)}";
				$curs_peri_mate_view = sqlsrv_query($conn, $sql, $params);  
			  
			  //ini  LOOP  2 distribucion notas en MATERIAS
			  while ($row_curs_peri_mate_view = sqlsrv_fetch_array($curs_peri_mate_view)) {  
			  			$cc =1;?> 
						
						<? while($cc <= $CC_COLUM)  {  ?>               
						<th class="left">
                        	
							<?= $Array_peri_dist_abre[$cc]; ?> 
						</th>    
					<?php $cc +=1; }?>  
						
		
			  <?php } //FIN  LOOP 2?>      
                
  			   
                
                 
                
            
        </tr>
                
        </thead>
        <tbody>
		
            <?php  /* LOOP 1 ALUMNOS */ $CC_FILAS_index=0;	
			 while ($row_alum_curs_para_view= sqlsrv_fetch_array($alum_curs_para_view)) { $CC_FILAS_index+=1; ?> 
            	<tr>
              
              <td class="center"><?= $CC_FILAS_index;?></td>

              <td width="300" > 
			  		<?= $row_alum_curs_para_view['alum_codi']; ?> -              
				  	<?= $row_alum_curs_para_view['alum_apel']; ?> 	<?= $row_alum_curs_para_view['alum_nomb']; ?>                    
				</td>
                 <?php  
				$params = array($curs_para_codi);
				$sql="{call curs_peri_mate_view(?)}";
				$curs_peri_mate_view = sqlsrv_query($conn, $sql, $params); 
				 	
			  $CC_COLUM_index=0;
			  //ini  LOOP 2 DIST   MATERIAS
			  while ($row_curs_peri_mate_view = sqlsrv_fetch_array($curs_peri_mate_view)) {  $cc =0;?> 
					
                    	
			   	<?php  
                   // LOOP 3 NOTAS EN MATERIA DE ALUMNO 
				   
				   $curs_para_mate_codi=$row_curs_peri_mate_view['curs_para_mate_codi'];
				   $alum_codi=$row_alum_curs_para_view['alum_codi'];
				   
                  $params = array($curs_para_mate_codi,$peri_dist_codi,$alum_codi);
                  $sql="{call curs_para_nota_peri_dist_alum_view(?,?,?)}";
                  $curs_para_nota_peri_dist_alum_view = sqlsrv_query($conn, $sql, $params); 
                  
                  sqlsrv_next_result($curs_para_nota_peri_dist_alum_view);  
               
                   $row_curs_para_nota_peri_dist_alum_view= sqlsrv_fetch_array($curs_para_nota_peri_dist_alum_view);
        
                  $cc=1;
				  
               	?> 
				<? while($cc <= $CC_COLUM)  { $CC_COLUM_index +=1; ?>               
					<td>	
							<?php 
								$valor=$row_curs_para_nota_peri_dist_alum_view[$cc+3];
								$prom_cc[$CC_COLUM_index] =  $prom_cc[$CC_COLUM_index] + 1; 
								$prom[$CC_COLUM_index] =  $prom[$CC_COLUM_index] + $valor; 
							?> 
                          	<? if ($cc == $CC_COLUM) echo '<strong>'?>  
                           		<?= number_format($valor, 2, '.', ''); ?> 
						   	<? if ($cc == $CC_COLUM) echo '</strong>'?>
                          
					</td>
				<? $cc +=1;}
				//FIN DE LOOP DE NOTAS DE MATERIA
				?> 
             
				  
            
						
		
		 
              <?php } //FIN  LOOP 2 ?>     
       	  </tr>
            <?php }//FIN  LOOP 1 ?>
            
            
           <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
         <? $cc =1; while($cc <= $CC_COLUM_index )  {?>       
              	<td align="right">
                 <strong>
             		<?= number_format(($prom[$cc]/$prom_cc[$cc]), 2, '.', ''); ?> 
					 
               </strong>
                </td> 
                <?php $cc+=1;} ?>
            </tr>
        </tbody>
</table>


      
      

	</div>

	</div>
</page>
<div class="page-break"></div>

</body>
</html>


              