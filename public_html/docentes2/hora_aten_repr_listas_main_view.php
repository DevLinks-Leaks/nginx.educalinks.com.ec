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



<page>
	<div  class="lista" >
	<div class="header_institution">
        <div class="institution">
          <div class="image">
            <img src="<?=$_SESSION['ruta_foto_logo_web']?>" width="75" height="90">
          </div>
          <div class="name">
              <h4> <strong> UNIDAD EDUCATIVA <?= $_SESSION['cliente']; ?></strong></h4>
              <h4>LISTADO DE CITAS CON PADRES DE FAMILIA</h4>
              <h5>Año Lectivo <?= $_SESSION['peri_deta']; ?></h5>
          </div>
        </div>
    </div>


	<div class="full">

	<table class="table_striped">
	<thead>
		<tr>
			<th colspan="11" class="center">
				
				Listado de citas reservadas

			</th>
		</tr>
        <tr>
			<th></th>
			<th>Hora de cita</th>
			<th>Profesor</th>
            <th>Padre de familia</th>
            <th>Alumno</th>
            <th>Curso</th>
		</tr>
	</thead>
	        <tbody>
            <?
			
			if (isset($_GET['fecha']))
			{
				$fecha=substr($_GET['fecha'],6,4)."".substr($_GET['fecha'],3,2)."".substr($_GET['fecha'],0,2);
			}
			else
			{
				$fecha= date('Ymd');
			}
			$params = array($fecha, $_SESSION['prof_codi']);
			$sql="{call hora_aten_repr_view_prof(?,?)}";
			$hora_aten_repr_view = sqlsrv_query($conn, $sql, $params); 
			$bandera=false;
			$cont=0;
				while ($row_hora_aten_repr_view = sqlsrv_fetch_array($hora_aten_repr_view))
				{
					$cont++;
					$bandera=true;
					?>
					<tr>
                    	<td width="5%" class="center"><? echo $cont; ?></td>
						<td width="10%" class="left"><? echo $row_hora_aten_repr_view['hora_ini'].' - '.$row_hora_aten_repr_view['hora_fin']; ?></td>
						<td width="25%" class="left"><? echo $row_hora_aten_repr_view['prof_nomb']; ?></td>
                        <td width="25%" class="left"><? echo $row_hora_aten_repr_view['repr_nomb']; ?></td>
                        <td width="25%" class="left"><? echo $row_hora_aten_repr_view['alum_nomb']; ?></td>
                        <td width="10%" class="left"><? echo $row_hora_aten_repr_view['curs_deta']; ?></td>
					</tr>
					<? 
				}
				if ($bandera==false)
				{
				?>
                    <tr>
                        <td colspan="6">No hay citas reservadas.</td>
                    </tr>
                <?
				} 
				?>
                <tr>
                    <td width="5%" class="center">&nbsp;</td>
                    <td width="10%" class="left">&nbsp;</td>
                    <td width="25%" class="left">&nbsp;</td>
                    <td width="25%" class="left">&nbsp;</td>
                    <td width="25%" class="left">&nbsp;</td>
                    <td width="10%" class="left">&nbsp;</td>
				</tr>
	        </tbody>
	</table>
	</div>
</div>
</page>
<div class="page-break"></div>
</body>
</html>