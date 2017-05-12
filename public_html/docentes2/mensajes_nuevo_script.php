 
<?php  

	session_start();
	include ('../framework/dbconf.php');  
	include ('../framework/funciones.php');  
	
	$peri_codi=1;		
	if(isset($_SESSION['peri_codi'])){
		 $peri_codi=$_SESSION['peri_codi'];
	}
 
	$params = array($peri_codi);
	$sql="{call curs_peri_view(?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params);  
	
	$para_sist_codi_admin=para_sist(17);
	$para_sist_codi_docen=para_sist(18);
	$para_sist_codi_alumm=para_sist(19);
	$para_sist_codi_repre=para_sist(20);				

 
?>

 
 
	 
 <script type="text/javascript" src="../framework/funciones.js"> </script>
        <div   style=" margin:5px;" >	
        	<select name="mens_usua_tipo"  id="mens_usua_tipo"  style="float:left; margin-right:10px"
            	 onChange="carga_usua();">
       
              
              <?php if($para_sist_codi_alumm=='A'){?> <option value="A" >Alumnos</option><?php } ?>
              <?php if($para_sist_codi_admin=='A'){?> <option value="K">Administrativos</option><?php } ?>
              <?php if($para_sist_codi_docen=='A'){?> <option value="D">Docentes</option><?php } ?>
              <?php if($para_sist_codi_repre=='A'){?> <option value="R">Representantes</option><?php } ?>
        	
        	</select>
            
         	<select name="mesn_curs_para_codi"   id="mesn_curs_para_codi"
            	 onChange="carga_usua();"  style="float:left; margin-left:10px; ">
             <?php  while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) {
		$cc +=1; ?>     
              <option value="<?= $row_curs_peri_view['curs_para_codi']; ?>"><?= $row_curs_peri_view['curs_deta']; ?> - (<?= $row_curs_peri_view['para_deta']; ?>)</option>
           <?php }  ?>	  
        	</select>
            <input type="checkbox" name="checkbox" id="checkbox"  style="float:right" onclick="select_todos_check(this)"/>  
         	<label for="checkbox" style="float:right">Todos&nbsp;</label>
            
        </div> 
      
        <div  id="usua_mens" style="border:thin; width:100%; height:100px;  overflow:scroll; overflow-x: hidden;margin:5px; margin-bottom:15px;float:left;"    >
      
        </div>
          <div  id="usua_mens" style="border:thin; width:100%; height:40px;margin-bottom:5px;float:left;"    >
      <input id="mens_titu" name="mens_titu" type="text" placeholder="Ingrese el Titulo..." value="" style="width:100%;"> 
        </div>
      
         <div   style=" float:left; width:100%; margin-bottom:20px;  "  >
     		<textarea cols="80" id="mens_deta" name="mens_deta" rows="8"placeholder="Escriba su mensaje Aqui..."  >
			
			</textarea>
        </div>
		
	 
		  