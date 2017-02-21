<?php 
	session_start();	 
	include ('../framework/dbconf.php');?>  
<div class="main_lista">
	<div id="div_curso">
		<?php 
		$params = array ($_SESSION['peri_codi']);
        $sql="{call curs_para_view(?)}";
        $stmt = sqlsrv_query($conn, $sql, $params);
        if( $stmt === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));}
		$a=0;?>
        <label>Elija un curso:</label>
        <select id="curso" name="curso" onchange="MostrarListado(this.value);" style="width: 30%">
        <option value="0">Seleccione..</option>
        <?php while($curso_view= sqlsrv_fetch_array($stmt)){?>
        <option value="<?= $curso_view['curs_para_codi'];?>">
			<?= $curso_view['curs_deta'].' / Paralelo '.$curso_view['para_deta'];?>
        </option>
        <?php }?>
        </select>
    </div>
    
    <script type="text/javascript">
	function MostrarListado (curso)
	{
		var xmlhttp;

		if (window.XMLHttpRequest)
		{
			xmlhttp = new XMLHttpRequest ();
		}
		else
		{
			xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}

		xmlhttp.onreadystatechange = function ()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('div_curso_lista').innerHTML=xmlhttp.responseText;
			}
		}

		xmlhttp.open("GET", "cursos_paralelo_profe_listas_main_view.php?curs_para_codi="+curso, true);
		xmlhttp.send();
	}
	</script>
    
    <div id="div_curso_lista">
    
    </div>
</div>