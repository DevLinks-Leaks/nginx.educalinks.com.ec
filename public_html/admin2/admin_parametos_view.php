<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
?>
<div class="alumnos_add_script">
    <div class="picture" style="float:left; width:25%;">   
        <div style="float:none; width:100%; position:relative;">
            <div class="selector">
				<?php
                if($_FILES['logo_foto']['error'] == UPLOAD_ERR_OK ){
                    $nombre = $_SESSION['ruta_foto_logo_web'];
                    $temporal = $_FILES['logo_foto']['tmp_name'];
                    $tamano= ($_FILES['logo_foto']['size'] / 1000)."Kb";
                    $full_name=$nombre;
                    move_uploaded_file($temporal,$full_name);
                }
                else{
                    echo $_FILES['logo_foto']['error']."."; //Si no se cargo mostramos el error
                }
                $file_exi=$_SESSION['ruta_foto_logo_web'];
            
                if (file_exists($file_exi)) {
                    $pp=$file_exi;
                } else {
                    $pp=$_SESSION['ruta_foto_logo_web'];
                }
                ?>
                <div id="div_foto" >
                    <h3>Logo Colegio</h3>
                    <img src="<?php echo $pp;?>" width="150" height="200" class="img-thumbnail"/>
                </div>
                <input type="file" name="logo_foto" id="logo_foto" onBlur='LimitAttach(this,7);' />
            </div>
        </div>
        <div style="float:none; width:100%; position:relative;">
            <div class="selector">
				<?php
                if($_FILES['logo_minis']['error'] == UPLOAD_ERR_OK ){
                    $nombre = $_SESSION['ruta_foto_logo_minis'];
                    $temporal = $_FILES['logo_minis']['tmp_name'];
                    $tamano= ($_FILES['logo_minis']['size'] / 1000)."Kb";
                    $full_name=$nombre;
                    move_uploaded_file($temporal,$full_name);
                }
                else{
                    echo $_FILES['logo_minis']['error']."."; //Si no se cargo mostramos el error
                }
                $file_exi=$_SESSION['ruta_foto_logo_minis'];
            
                if (file_exists($file_exi)) {
                    $pp=$file_exi;
                } else {
                    $pp=$_SESSION['ruta_foto_logo_minis'];
                }
                ?>
                <div id="div_foto" >
                	<h3>Logo Ministerio</h3>
                    <img src="<?php echo $pp;?>" width="150" height="200" />
                </div>
                <input type="file" name="logo_minis" id="logo_minis" onBlur='LimitAttach(this,7);' />
            </div>
        </div>
        <div style="float:none; width:100%; position:relative;">
            <div class="selector">
				<?php
                if($_FILES['logo_minis_long']['error'] == UPLOAD_ERR_OK ){
                    $nombre = $_SESSION['ruta_foto_logo_minis_long'];
                    $temporal = $_FILES['logo_minis_long']['tmp_name'];
                    $tamano= ($_FILES['logo_minis_long']['size'] / 1000)."Kb";
                    $full_name=$nombre;
                    move_uploaded_file($temporal,$full_name);
                }
                else{
                    echo $_FILES['logo_minis_long']['error']."."; //Si no se cargo mostramos el error
                }
                $file_exi=$_SESSION['ruta_foto_logo_minis_long'];
            
                if (file_exists($file_exi)) {
                    $pp=$file_exi;
                } else {
                    $pp=$_SESSION['ruta_foto_logo_minis_long'];
                }
                ?>
                <div id="div_foto" >
                	<h3>Logo Ministerio Largo</h3>
                    <img src="<?php echo $pp;?>" width="150" height="200" />
                </div>
                <input type="file" name="logo_minis_long" id="logo_minis_long" onBlur='LimitAttach(this,7);' />
            </div>
        </div>
        <div style="float:none; width:100%; position:relative;">
            <div class="selector">
				<?php
                if($_FILES['logo_distr']['error'] == UPLOAD_ERR_OK ){
                    $nombre = $_SESSION['ruta_foto_logo_distr'];
                    $temporal = $_FILES['logo_distr']['tmp_name'];
                    $tamano= ($_FILES['logo_distr']['size'] / 1000)."Kb";
                    $full_name=$nombre;
                    move_uploaded_file($temporal,$full_name);
                }
                else{
                    echo $_FILES['logo_distr']['error']."."; //Si no se cargo mostramos el error
                }
                $file_exi=$_SESSION['ruta_foto_logo_distr'];
            
                if (file_exists($file_exi)) {
                    $pp=$file_exi;
                } else {
                    $pp=$_SESSION['ruta_foto_logo_distr'];
                }
                ?>
                <div id="div_foto" >
                	<h3>Logo Distrito</h3>
                    <img src="<?php echo $pp;?>" width="150" height="200" />
                </div>
                <input type="file" name="logo_distr" id="logo_distr" onBlur='LimitAttach(this,7);' />
            </div>
        </div>
        <div style="float:none; width:100%; position:relative;">
            <div class="selector">
				<?php
                if($_FILES['logo_subse']['error'] == UPLOAD_ERR_OK ){
                    $nombre = $_SESSION['ruta_foto_logo_subse'];
                    $temporal = $_FILES['logo_subse']['tmp_name'];
                    $tamano= ($_FILES['logo_subse']['size'] / 1000)."Kb";
                    $full_name=$nombre;
                    move_uploaded_file($temporal,$full_name);
                }
                else{
                    echo $_FILES['logo_subse']['error']."."; //Si no se cargo mostramos el error
                }
                $file_exi=$_SESSION['ruta_foto_logo_subse'];
            
                if (file_exists($file_exi)) {
                    $pp=$file_exi;
                } else {
                    $pp=$_SESSION['ruta_foto_logo_subse'];
                }
                ?>
                <div id="div_foto" >
                    <h3>Logo Subsecretar&iacute;a</h3>
                    <img src="<?php echo $pp;?>" width="150" height="200" />
                </div>
                <input type="file" name="logo_subse" id="logo_subse" onBlur='LimitAttach(this,7);' />
            </div>
        </div>
		<div style="float:none; width:100%; position:relative;">
            <div class="selector">
				<?php
                if($_FILES['escudo_ecua']['error'] == UPLOAD_ERR_OK ){
                    $nombre = $_SESSION['ruta_foto_escudo_ecuador'];
                    $temporal = $_FILES['escudo_ecua']['tmp_name'];
                    $tamano= ($_FILES['escudo_ecua']['size'] / 1000)."Kb";
                    $full_name=$nombre;
                    move_uploaded_file($temporal,$full_name);
                }
                else{
                    echo $_FILES['escudo_ecua']['error']."."; //Si no se cargo mostramos el error
                }
                $file_exi=$_SESSION['ruta_foto_escudo_ecuador'];
            
                if (file_exists($file_exi)) {
                    $pp=$file_exi;
                } else {
                    $pp=$_SESSION['ruta_foto_escudo_ecuador'];
                }
                ?>
                <div id="div_foto" >
                    <h3>Escudo del Ecuador</h3>
                    <img src="<?php echo $pp;?>" width="150" height="200" />
                </div>
                <input type="file" name="escudo_ecua" id="escudo_ecua" onBlur='LimitAttach(this,7);' />
            </div>
        </div>
    </div>
    <div class="data" style="float:right; width:75%;">
    	<div style="float:none; width:100%; position:relative;">
            <h3>Logo Reportes</h3>
            <table width="100%" class="table_simple">
            	<tr>
                 	<td>&nbsp;</td>
                	<td>&nbsp;</td>
               	</tr>
               	<tr>
                	<td > 
                   		<label for="textfield">Pie de Paginas:</label>
                   		<input type="text" name="textfield" id="textfield" />
                 	</td>
                	<td>
                    	<label for="textfield2">Pie de Paginas:</label>
                 		<input type="text" name="textfield2" id="textfield2" /></td>
               	</tr>
        	</table>
    	</div>
    </div>
</div>

