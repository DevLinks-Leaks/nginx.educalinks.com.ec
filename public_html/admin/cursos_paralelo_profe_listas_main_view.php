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
	if (isset($_POST['curs_para_codi']))
		$curs_para_codi=$_POST['curs_para_codi'];
		
	if (isset($_GET['curs_para_codi']))
		$curs_para_codi=$_GET['curs_para_codi'];
		
	$params1 = array($curs_para_codi);
	$sql1="{call curs_para_info(?)}";
	$curs_view = sqlsrv_query($conn, $sql1, $params1);  
	$row_curs_view = sqlsrv_fetch_array($curs_view);
	 
?>	
<page>
	<div class="lista">
	<div class="header_institution">
        <div class="institution">
          <div class="image">
            <img src="<?= $_SESSION['ruta_foto_logo_web']; ?>">
          </div>
          <div class="name">
                  <h4> <strong>UNIDAD EDUCATIVA <?= para_sist(3); ?> </strong></h4>
                  <h4>INFORMACION DEL PERSONAL DOCENTE</h4>
                  <h5>Año Lectivo <?= $_SESSION['peri_deta']; ?></h5>
          </div>
        </div>
        <div class="user_data">
          <div class="name">
              <h4>Curso: <?= $row_curs_view['curs_deta']; ?> </h4>
              <h4>Paralelo:  <?= $row_curs_view['para_deta']; ?></h4>
          </div>
        </div>
    </div>
	<div class="full">
	<table class="table_striped">
	<thead>
        <tr>
            <th colspan="11" class="center">
                Listado de Profesores
            </th>
        </tr>
        <tr>
            <th></th>
            <th>Asignatura</th>
            <th>Profesor</th>
            <th>Agendas</th>
            <th>Materiales</th>
        </tr>
	</thead>
        <tbody>
        <?
        $params3 = array($curs_para_codi);
        $sql3="{call para_profe_mate_view(?)}";
        $para_profe_mate_view = sqlsrv_query($conn, $sql3, $params3); 
        $bandera=false;
        $cont=0;
            while ($row_para_profe_mate_view = sqlsrv_fetch_array($para_profe_mate_view))
            {
                $cont++;
                $bandera=true;
                ?>
                <tr>
                    <td width="5%" class="center"><? echo $cont ?></td>
                    <td width="40%" class="left"><? echo $row_para_profe_mate_view['mate_deta'] ?></td>
                    <td width="45%" class="left"><? echo $row_para_profe_mate_view['prof_deta'] ?></td>
                    <td width="5%" class="left"><? echo $row_para_profe_mate_view['agendas'] ?></td>
                    <td width="5%" class="left"><? echo $row_para_profe_mate_view['materiales'] ?></td>
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
        </tbody>
		<tfoot>
			<tr>
				<td></td>
				<td colspan="4">
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