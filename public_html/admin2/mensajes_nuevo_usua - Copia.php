<?php 

	include ('../framework/dbconf.php');
	session_start();
	
	if(isset($_POST['OP'])){
		 $OP=$_POST['OP'];
	}
?>	
<style>
.usua_style {
	background: #FFFFFF;font-size: 8px;
	vertical-align:middle;padding: 3px;	margin:2px; float:left;	
	border: 1px solid #bbbbbb;
	width:175px;height:30px;	
	     
    border-radius: 5px;    -moz-border-radius: 5px;   -webkit-border-radius: 5px;
	
}

</style>

 
<?php if ($OP=='A'){  ?>	  	  
	  
<?php 	  
 
	if(isset($_GET['curs_para_codi'])){
		 $curs_para_codi=$_GET['curs_para_codi'];
	}
	if(isset($_POST['curs_para_codi'])){
		 $curs_para_codi=$_POST['curs_para_codi'];
	}

	$params = array($curs_para_codi);
	$sql="{call alum_curs_para_view(?)}";
	$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);  
	
?>

<?php  while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) {
		$cc +=1; ?> 
      <div   id=""  class="usua_style"   >  
      <input  type="checkbox" value='<?= $row_alum_curs_para_view["alum_codi"]; ?>' id="ch_<?= $OP; ?>_<?php echo $cc; ?>" name="ch_<?= $OP; ?>_<?php echo $cc; ?>"   />
      
          <?php
              $file_exi=$_SESSION['ruta_foto_alumno'].$row_alum_curs_para_view["alum_codi"].'.jpg';
      
              if (file_exists($file_exi)) {
                  $pp=$file_exi;
              } else {
                  $pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
              }
          ?>
     <img src="<?php echo $pp; ?>" style="width:20px; height:20px;"  /><?php echo $row_alum_curs_para_view["alum_nomb"]; ?></div>
  <?php }?>
  
<?php }  ?>	

<?php if ($OP=='R'){  ?>	  	  
	  
<?php 	  
 	
	if(isset($_GET['curs_para_codi'])){
		 $curs_para_codi=$_GET['curs_para_codi'];
	}
	if(isset($_POST['curs_para_codi'])){
		 $curs_para_codi=$_POST['curs_para_codi'];
	}

	$params = array($curs_para_codi);
	$sql="{call repr_curs_para_view(?)}";
	$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);  
	
?>

<?php  while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) {
		$cc +=1; ?> 
      <div   id=""  class="usua_style" title="REPRESENTANTE: <?= strtoupper($row_alum_curs_para_view["repr_apel"]); ?> <?= strtoupper($row_alum_curs_para_view["repr_nomb"]); ?>  (<?= strtoupper($row_alum_curs_para_view["repr_parentesco"]); ?>)"   > 
      	<?php
              $file_exi=$_SESSION['ruta_foto_alumno'].$row_alum_curs_para_view["alum_codi"].'.jpg';
      
              if (file_exists($file_exi)) {
                  $pp=$file_exi;
              } else {
                  $pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
              }
          ?>
      
       		<table width="175" border="0" cellspacing="0" cellpadding="0"  >
                      <tr>
                        <td style="width:15px;"><input  type="checkbox" value='<?= $row_alum_curs_para_view["repr_codi"]; ?>' id="ch_<?= $OP; ?>_<?php echo $cc; ?>" name="ch_<?= $OP; ?>_<?php echo $cc; ?>"   /> </td>
                        <td style="width:20px;"><img src="<?php echo $pp; ?>" style="width:20px; height:20px;"  /></td>
                        <td style="width:115px;"><?php echo $row_alum_curs_para_view["alum_apel"]; ?> <?php echo $row_alum_curs_para_view["alum_nomb"]; ?></td>
                      </tr>
                    </table> 
      
      
          
     </div>
  <?php }?>
  
<?php }  ?>	



<?php if ($OP=='D'){  ?>	  	  
	  
<?php 	  
 
 
	$params = array();
	$sql="{call prof_view()}";
	$prof_view = sqlsrv_query($conn, $sql, $params);  
	
	
?>

	<?php  while ($row_prof_view = sqlsrv_fetch_array($prof_view)) { $cc +=1; ?> 
    	<?php if ($row_prof_view["prof_codi"] != $_SESSION['USUA_DE']){ ?>
          <div   id=""  class="usua_style"   >  
          <input  type="checkbox" value='<?php echo $row_prof_view["prof_codi"]; ?>' id="ch_<?= $OP; ?>_<?php echo $cc; ?>"   name="ch_<?= $OP; ?>_<?php echo $cc; ?>" />
          
              <?php
                  $file_exi=$_SESSION['ruta_foto_docente'] . $row_prof_view["prof_codi"] . '.jpg';
          
                  if (file_exists($file_exi)) {
                      $pp=$file_exi;
                  } else {
                      $pp=$_SESSION['ruta_foto_docente'].'0.jpg';
                  }
              ?>
         <img src="<?php echo $pp; ?>" style="width:20px; height:20px;"  /><?php echo $row_prof_view["prof_apel"]; ?> <?php echo $row_prof_view["prof_nomb"]; ?></div>
      <?php }?>
  	<?php }?>
<?php }  ?>	  	 






<?php if ($OP=='K'){  ?>	  	  
	  
<?php 	  
 
 
	$params = array();
	$sql="{call usua_view()}";
	$usua_view = sqlsrv_query($conn, $sql, $params);  
	
	
?>

	<?php  while ($row_usua_view = sqlsrv_fetch_array($usua_view)) { $cc +=1; ?>  	
	
		<?php if ($row_usua_view["usua_codi"] != $_SESSION['USUA_DE']){ ?>
            <div   id=""  class="usua_style"   >  
              <input  type="checkbox" value='<?= $row_usua_view["usua_codi"]; ?>' id="ch_<?= $OP; ?>_<?php echo $cc; ?>" name="ch_<?= $OP; ?>_<?php echo $cc; ?>"   />
              
                     <?php
                      $file_exi=$_SESSION['ruta_foto_admin']  . $row_usua_view["usua_codi"] . '.jpg';              
					   
                      if (file_exists($file_exi)) {
                          $pp=$file_exi;
                      } else {
                          $pp='../fotos/usua_0.jpg';
                      }
                  ?>
             	<img src="<?php echo $pp; ?>" style="width:20px; height:20px;"  /><?php echo $row_usua_view["usua_apel"]; ?> <?php echo $row_usua_view["usua_nomb"]; ?>
             
             </div>
 		 <?php }?>
   
   <?php }  ?>	 
		
      
  
<?php }  ?>	  	 
 <input name="mens_tipo"  type="hidden" id="mens_tipo" value='<?php echo $OP; ?>'    />
 <input name="mens_cc_usua"  type="hidden" id="mens_cc_usua" value='<?php echo $cc; ?>'    />



