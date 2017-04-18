	<select 
    	id="rol_codi_edi" 
        name="rol_codi_edi" 
        style="width: 50%; margin-top: 5px;">
	<? 
    session_start();	 
    include ('../framework/dbconf.php');
    if(isset($_POST['texto'])) {$texto=$_POST['texto'];		}else   {$texto='%';}
    if(isset($_POST['rol_codi'])){$rol_codi=$_POST['rol_codi'];}else{$rol_codi='0';}
    $params = array($texto);
    $sql="{call rol_busq(?)}";
    $rol_busq = sqlsrv_query($conn, $sql, $params);  
    while($row_rol_busq = sqlsrv_fetch_array($rol_busq))
	{
	?>
        <option 
        	value="<?= $row_rol_busq['rol_codi']?>" <?= ($rol_codi==$row_rol_busq['rol_codi'])?"selected='selected'":""; ?>>
			<?= $row_rol_busq['rol_deta'];?>
		</option>
	<? 
	}
	?>
	</select>