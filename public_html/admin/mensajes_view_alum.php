 
 dd
<?php 

	 include ('../framework/dbconf.php');
	  session_start();
	  
	 $curs_para_codi=105;		
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
<style>
.alum_option
{
	background: #FFFFFF;
	font-size: 10px;
	vertical-align:middle;
	padding: 3px;
	margin:2px; 
	border: 1px solid #bbbbbb;
	width:350px;
	 
	float:left;
	height:35px;	
    
    border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
}

</style>

 
<?php  while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) {
		$cc +=1; ?> 
      <div   id=""  class="alum_option"  >  
          <?php
              $file_exi=$_SESSION['ruta_foto_alumno'] . $row_alum_curs_para_view["alum_codi"] . '.jpg';
      
              if (file_exists($file_exi)) {
                  $pp=$file_exi;
              } else {
                  $pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
              }
          ?> 
          <input type="checkbox" id="ch_alum_1"  />
           <?php echo $row_alum_curs_para_view["alum_nomb"]; ?>/div>
  <?php }?>