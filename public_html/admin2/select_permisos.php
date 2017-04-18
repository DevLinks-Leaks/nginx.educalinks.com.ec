<?php
  /*¿Hicieron un post?*/
  if (isset($_POST['select']))
  {
    $select = $_POST['select'];
  }
  else
    exit("Error");

  /*Pregunto cuál select van a llenar*/
  switch ($select)
  {
    case 'UnidadesGeneral':
      $peri_dist_cab_codi = $_POST['peri_dist_cab_codi'];
	  $nivel = $_POST['nivel'];
      UnidadesGeneral($peri_dist_cab_codi, $nivel);
    breaK;
	
	case 'UnidadesIndividual':
      $peri_dist_cab_codi = $_POST['peri_dist_cab_codi'];
	  $nivel = $_POST['nivel'];
      UnidadesIndividual($peri_dist_cab_codi, $nivel);
    breaK;
	
	case 'UnidadesReporte':
      $peri_dist_cab_codi = $_POST['peri_dist_cab_codi'];
	  $nivel = $_POST['nivel'];
      UnidadesReporte($peri_dist_cab_codi, $nivel);
    breaK;
	
	case 'CursosGeneral':
      $peri_dist_cab_codi = $_POST['peri_dist_cab_codi'];
      CursosGeneral($peri_dist_cab_codi);
    breaK;
	
	case 'CursosIndividual':
      $peri_dist_cab_codi = $_POST['peri_dist_cab_codi'];
      CursosIndividual($peri_dist_cab_codi);
    breaK;
	
	case 'ProfesoresGeneral':
      $peri_dist_cab_codi = $_POST['peri_dist_cab_codi'];
      ProfesoresGeneral($peri_dist_cab_codi);
    breaK;
	
	case 'ProfesoresIndividual':
      $curs_para_codi = $_POST['curs_para_codi'];
      ProfesoresIndividual($curs_para_codi);
    breaK;
  }

  /*Función para llenar el select de Periodos Distribución*/
  function UnidadesGeneral ($peri_dist_cab_codi, $nivel)
  {
    require_once ('../framework/dbconf.php');
    $params = array ($peri_dist_cab_codi, $nivel);
    $sql = "{call peri_dist_peri_nive_view_perm_NEW (?,?)}";
    $stmt = sqlsrv_query($conn, $sql, $params);

    if (sqlsrv_has_rows($stmt))
	{		
		echo '<select id="pg_peri_dist_codi" style="width:75%; margin-top:10px;">';
		while($row = sqlsrv_fetch_array($stmt))
		{	
			echo '<option value="'.$row["peri_dist_codi"].'">'.$row["peri_dist_padr_deta"].'-'.$row["peri_dist_deta"].'</option>';
		}
	}
	else
	{
		echo '<select id="pg_peri_dist_codi" style="width:75%; margin-top:10px;" disabled="disabled">';
		echo '<option value="-1">Seleccione</option>';
	}
    echo "</select>";
  }
  
  /*Función para llenar el select de Periodos Distribución*/
  function UnidadesIndividual ($peri_dist_cab_codi, $nivel)
  {
    require_once ('../framework/dbconf.php');
    $params = array ($peri_dist_cab_codi, $nivel);
    $sql = "{call peri_dist_peri_nive_view_perm_NEW (?,?)}";
    $stmt = sqlsrv_query($conn, $sql, $params);

    if (sqlsrv_has_rows($stmt))
	{		
		echo '<select id="pi_peri_dist_codi" style="width:75%; margin-top:10px;">';
		while($row = sqlsrv_fetch_array($stmt))
		{	
			echo '<option value="'.$row["peri_dist_codi"].'">'.$row["peri_dist_padr_deta"].'-'.$row["peri_dist_deta"].'</option>';
		}
	}
	else
	{
		echo '<select id="pi_peri_dist_codi" style="width:75%; margin-top:10px;" disabled="disabled">';
		echo '<option value="-1">Seleccione</option>';
	}
    echo "</select>";
  }
  
  /*Función para llenar el select de Periodos Distribución*/
  function UnidadesReporte ($peri_dist_cab_codi, $nivel)
  {
    require_once ('../framework/dbconf.php');
    $params = array ($peri_dist_cab_codi, $nivel);
    $sql = "{call peri_dist_peri_nive_view_perm_NEW (?,?)}";
    $stmt = sqlsrv_query($conn, $sql, $params);

    if (sqlsrv_has_rows($stmt))
	{		
?>
	<select id="repo_peri_dist_codi" style="width:250px; margin-top:10px;" onchange="load_ajax_get('curs_para_main_repo_deta','cursos_notas_permisos_main_view_repo.php?peri_dist_codi=' + this.value + '&peri_dist_cab_codi='+document.getElementById('sl_repo_peri_dist_cab').value)">
<?
		echo '<option value="-1">Seleccione</option>';
		while($row = sqlsrv_fetch_array($stmt))
		{	
			echo '<option value="'.$row["peri_dist_codi"].'">'.$row["peri_dist_deta"].'</option>';
		}
	}
	else
	{
		echo '<select id="repo_peri_dist_codi" style="width:250px; margin-top:10px;" disabled="disabled">';
		echo '<option value="-1">Seleccione</option>';
	}
    echo "</select>";
  }
  
  /*Función para llenar el select de Cursos*/
  function CursosGeneral ($peri_dist_cab_codi)
  {
    require_once ('../framework/dbconf.php');
    $params = array ($peri_dist_cab_codi);
    $sql = "{call curs_para_peri_dist_cab (?)}";
    $stmt = sqlsrv_query($conn, $sql, $params);
	
	echo '<input 
	type="radio" 
	name="radio_op" 
	id="radio_op3" 
	value="3"
	style="margin-left: 15px; margin-right:10px; margin-top:10px;">';	
    if (sqlsrv_has_rows($stmt))
	{		
		echo '<select id="pg_curs_para_codi" style="width:75%; margin-top:10px;">';
		while($row = sqlsrv_fetch_array($stmt))
		{	
			echo '<option value="'.$row["curs_para_codi"].'">'.$row["curs_deta"].' ('.$row["para_deta"].')</option>';
		}
	}
	else
	{
		echo '<select id="pg_curs_para_codi" style="width:75%; margin-top:10px;" disabled="disabled">';
		echo '<option value="-1">Seleccione</option>';
	}
    echo "</select>";
  }
  
  /*Función para llenar el select de Cursos*/
  function CursosIndividual ($peri_dist_cab_codi)
  {
    require_once ('../framework/dbconf.php');
    $params = array ($peri_dist_cab_codi);
    $sql = "{call curs_para_peri_dist_cab (?)}";
    $stmt = sqlsrv_query($conn, $sql, $params);
	
    if (sqlsrv_has_rows($stmt))
	{	
?>	
		<select id='pi_curs_para_codi' style='width:75%; margin-top:10px;' onchange='CargarProfesoresIndividual(this.value,"div_profesor_materia_ind")'>
<?
		echo '<option value="-1">Seleccione</option>';
		while($row = sqlsrv_fetch_array($stmt))
		{	
			echo '<option value="'.$row["curs_para_codi"].'">'.$row["curs_deta"].' ('.$row["para_deta"].')</option>';
		}
	}
	else
	{
		echo '<select id="pi_curs_para_codi" style="width:75%; margin-top:10px;" disabled="disabled">';
		echo '<option value="-1">Seleccione</option>';
	}
    echo "</select>";
  }
  
  /*Función para llenar el select de Profesores*/
  function ProfesoresGeneral ($peri_dist_cab_codi)
  {
    require_once ('../framework/dbconf.php');
    $params = array ($peri_dist_cab_codi);
    $sql = "{call curs_para_mate_prof_dist_view (?)}";
    $stmt = sqlsrv_query($conn, $sql, $params);
	
	echo '<input 
	type="radio" 
	name="radio_op" 
	id="radio_op4" 
	value="4"
	style="margin-left: 15px; margin-right:10px; margin-top:10px;">';	
    if (sqlsrv_has_rows($stmt))
	{		
		echo '<select id="pg_prof_codi" style="width:75%; margin-top:10px;">';
		while($row = sqlsrv_fetch_array($stmt))
		{	
			echo '<option value="'.$row["prof_codi"].'">'.$row["prof_apel"].' '.$row["prof_nomb"].'</option>';
		}
	}
	else
	{
		echo '<select id="pg_prof_codi" style="width:75%; margin-top:10px;" disabled="disabled">';
		echo '<option value="-1">Seleccione</option>';
	}
    echo "</select>";
  }
  
  /*Función para llenar el select de Profesores*/
  function ProfesoresIndividual ($curs_para_codi)
  {
    require_once ('../framework/dbconf.php');
    $params = array ($curs_para_codi);
    $sql = "{call curs_para_mate_prof_full_view (?)}";
    $stmt = sqlsrv_query($conn, $sql, $params);
	
    if (sqlsrv_has_rows($stmt))
	{		
		echo '<select id="pi_profesor_materia" style="width:75%; margin-top:10px;">';
		while($row = sqlsrv_fetch_array($stmt))
		{	
			echo '<option value="'.$row["curs_para_mate_prof_codi"].'">'.$row["prof_apel"].' '.$row["prof_nomb"].' ('.$row["mate_deta"].')</option>';
		}
	}
	else
	{
		echo '<select id="pi_profesor_materia" style="width:75%; margin-top:10px;" disabled="disabled">';
		echo '<option value="-1">Seleccione</option>';
	}
    echo "</select>";
  }
  
?>
