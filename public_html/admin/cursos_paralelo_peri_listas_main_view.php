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
	$params1 = array($curso);
	$sql1="{call curs_e_view(?)}";
	$curs_view = sqlsrv_query($conn, $sql1, $params1);  
	 
?>	


<page>
	<div  class="lista">
	<div class="header_institution">
        <div class="institution">
          <div class="image">
            <img src="../imagenes/reportes/<?= $_SESSION['directorio'] ?>/logo_libreta.png" width="90" height="107">
          </div>
          <div class="name">
                  <h4> <strong> UNIDAD EDUCATIVA <?= para_sist(3); ?> </strong></h4>
                  <h4>INFORMACION DE CURSOS Y PARALELOS</h4>
                  <h5>Ano Lectivo <?= $_SESSION['peri_deta']; ?></h5>
          </div>
        </div>
    </div>


	<div class="full">

	<table class="table_striped">
	<thead>
		<tr>
			<th colspan="11" class="center">
				
				Listado de Cursos y Paralelos

			</th>
		</tr>
        <tr>
			<th>Curso</th>
			<th>Paralelo</th>
			<th>Dirigente</th>
            <th>Aula</th>
			<th>Alumnos</th>
		</tr>
	</thead>
	        <tbody>
            <?
			$params = array($_SESSION['peri_codi']);
			$sql="{call curs_peri_view_info(?)}";
			$curs_peri_view = sqlsrv_query($conn, $sql, $params); 
			$bandera=false;
			$cont=0;
				while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view))
				{
					$cont++;
					$bandera=true;
					?>
					<tr>
     					<td width="30%" class="left"><? echo $row_curs_peri_view['curso'] ?></td>
                    	<td width="10%" class="center"><? echo $row_curs_peri_view['paralelo'] ?></td>
						<td width="30%" class="left"><? echo $row_curs_peri_view['dirigente'] ?></td>
                        <td width="15%" class="left"><? echo $row_curs_peri_view['aula'] ?></td>
						<td width="15%" class="left"><? echo $row_curs_peri_view['alumnos'] ?></td>
					</tr>
					<? 
				}
				if ($bandera==false)
				{
				?>
                    <tr>
                        <td colspan="5">No hay profesores asignados.</td>
                    </tr>
                <?
				}
				?>
                <tr>
                    <td width="30%" class="center">&nbsp;</td>
                    <td width="10%" class="left">&nbsp;</td>
                    <td width="30%" class="left">&nbsp;</td>
                    <td width="15%" class="left">&nbsp;</td>
                    <td width="15%" class="left">&nbsp;</td>
				</tr>
	        </tbody>
			<t<tfoot>
				<tr>
					<td colspan="5">
						<?= print_usua_info(); ?>
					</td>
				</tr>
			</tfoot>
	</table>
	</div>
</div>
</page>
<div class="page-break"></div>
</body>
</html>