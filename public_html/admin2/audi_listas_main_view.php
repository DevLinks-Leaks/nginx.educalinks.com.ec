<?php
	session_start();	 
	include ('../framework/dbconf.php');
	require_once ('../framework/funciones.php');
?>
<!DOCTYPE html>
<html>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Educalinks |  <?php echo para_sist(2); ?></title> 
        <link rel="SHORTCUT ICON" href="../imagenes/logo_icon.png"/>
        <link href="../theme/css/main.css" rel="stylesheet" type="text/css"> 
    	<link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css">
	  
	<style>
		@page 
		{  
			size: A4 portrait;  
		}  
		@media all 
		{
			.page-break	
			{ 
				display: none; 
			}
		}
	
		@media print 
		{
			.page-break	
			{ 
				display: block; 
				page-break-before: always; 
			}
		}
	</style> 
</head>
<body>

<?php 
		$usuarios=$_POST["usuarios"];
		$count = count($usuarios);
			for ($i = 0; $i < $count; $i++) 
			{
	 
?>	


<page>
	<div  class="lista" >
	<div class="header_institution">
        <div class="institution">
          <div class="image">
            <img src="<?= $_SESSION['ruta_foto_logo_libreta']; ?>" width="90" height="107">
          </div>
          <div class="name">
                  <h4> <strong> UNIDAD EDUCATIVA <?php echo para_sist(3); ?> </strong></h4>
                  <h4>HISTORIAL DESDE <?= date($_POST['audi_fec_ini']).' HASTA '.date($_POST['audi_fec_fin']); ?></h4>
                  <h5>Año Lectivo <?= $_SESSION['peri_deta']; ?></h5>
          </div>
        </div>
         <div class="user_data">
          <div class="name">
                  <h4>Usuario:  <?= strtoupper($usuarios[$i]); ?></h4>
          </div>
        </div>
    </div>


	<div class="full">
	<table class="table_striped">
	<thead>
		<tr>
			<th colspan="4" class="center">
				Historial
			</th>
		</tr>
        <tr>
			<th>Fecha</th>
			<th>Hora</th>
			<th>Acción</th>
            <th>Detalle</th>
		</tr>
	</thead>
	        <tbody>
            <?php
								$acciones=$_POST["acciones"];
								$count2 = count($acciones);
								$bandera=false;
								
								$xml_acciones="";
								$xml_acciones="<Acciones>";
								for ($j = 0; $j < $count2; $j++) 
								{
									$xml_acciones.='<Accion codigo="'.$acciones[$j].'" />';
								}
								$xml_acciones.="</Acciones>";
								
								$params = array($usuarios[$i],$xml_acciones, $_POST['audi_fec_ini'], $_POST['audi_fec_fin']);
								$sql="{call audi_view(?,?,?,?)}";
								$res = sqlsrv_query($conn, $sql, $params); 
								while ($row = sqlsrv_fetch_array($res))
								{
									$bandera=true;
			?>
                            <tr>
                                <td width="8%" class="left"><? echo $row['audi_fecha']; ?></td>
                                <td width="8%" class="center"><? echo $row['audi_hora']; ?></td>
                                <td width="25%" class="left"><? echo $row['audi_tipo_deta']; ?></td>
                                <td width="59%" class="left"><? echo $row['audi_deta']; ?></td>
                            </tr>
                            
            <?php
								}
							if ($bandera==false)
							{
			?>
            				<tr>
                                <td width="8%" colspan="4">No registra acciones realizadas.</td>
                            </tr>
			<?php
                            }			
            ?>
	        </tbody>
	</table>
	</div>
</div>
</page>
<div class="page-break"></div>
<?php 
			}
?>
</body>
</html>