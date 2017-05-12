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
    case 'PeriodosDistribucion':
      $peri_dist_cab_codi = $_POST['peri_dist_cab_codi'];
      PeriodosDistribucion($peri_dist_cab_codi);
    break;

    case 'CursosParalelos':
      $peri_dist_cab_codi = $_POST['peri_dist_cab_codi'];
      CursosParalelos($peri_dist_cab_codi);
    break;
	
	case 'CursosParalelosExc':
      $peri_dist_cab_codi = $_POST['peri_dist_cab_codi'];
      CursosParalelosExc($peri_dist_cab_codi);
    break;

    case 'CursosParalelosAlumnos':
      $curs_para_codi = $_POST['curs_para_codi'];
      CursosParalelosAlumnos($curs_para_codi);
    break;
  }

  /*Función para llenar el select de Periodos Distribución*/
  function PeriodosDistribucion ($peri_dist_cab_codi)
  {
    require_once ('../framework/dbconf.php');
    $params = array ($peri_dist_cab_codi);
    $sql = "{call peri_dist_peri_libt_plus_view (?)}";
    $stmt = sqlsrv_query($conn, $sql, $params);

    if (sqlsrv_has_rows($stmt))
    {
      echo "<select  class=\"form-control\" id='sl_periodo_dist' style='width: 200px' onchange=\"var sl_periodo_dist = document.getElementById('sl_periodo_dist'); 
						       var sl_periodo_distText = sl_periodo_dist.options[sl_periodo_dist.selectedIndex].innerHTML;
							   ValidarOpciones(sl_periodo_distText);\">";
      while ($row = sqlsrv_fetch_array($stmt))
      {
        echo "<option value='".$row["peri_dist_codi"]."'>".$row['peri_dist_deta']."</option>";
      }
    }
    else
    {
      echo "<select  class=\"form-control\" id='sl_periodo_dist' style='width: 200px' disabled='disabled'
				onchange=\"var sl_periodo_dist = document.getElementById('sl_periodo_dist'); 
						  var sl_periodo_distText = sl_periodo_dist.options[sl_periodo_dist.selectedIndex].innerHTML;
					ValidarOpciones(sl_periodo_distText);\">";
      echo "<option value='0'>Parcial/Quimestre</option>";
    }
    echo "</select>";
  }

  /*Función para llenar el select de Cursos Paralelos*/
  function CursosParalelos ($peri_dist_cab_codi)
  {
    require_once ('../framework/dbconf.php');
    $params = array ($peri_dist_cab_codi);
    $sql = "{call curs_para_by_peri_view (?)}";
    $stmt = sqlsrv_query($conn, $sql, $params);

    if (sqlsrv_has_rows($stmt))
    {
      echo "<select  class='form-control' id='sl_paralelos' style='width: 200px' onChange='CargarCursosParalelosAlumnos(this.value);'>";
	  echo "<option value='0'>Curso/Paralelo</option>";
      while ($row = sqlsrv_fetch_array($stmt))
      {
        echo "<option value='".$row["curs_para_codi"]."'>".$row['curs_deta'].' '.$row['para_deta']."</option>";
      }
    }
    else
    {
      echo "<select class='form-control' id='sl_paralelos' style='width: 200px' disabled='disabled'>";
      echo "<option value='0'>Curso/Paralelo</option>";
    }
    echo "</select>";
  }	
  /*Función para llenar el select de Cursos Paralelos*/
  function CursosParalelosExc ($peri_dist_cab_codi)
  {
    require_once ('../framework/dbconf.php');
    $params = array ($peri_dist_cab_codi);
    $sql = "{call curs_para_by_peri_view (?)}";
    $stmt = sqlsrv_query($conn, $sql, $params);

    if (sqlsrv_has_rows($stmt))
    {
      echo "<select class='form-control' id='sl_paralelos' style='width: 200px' onChange='CargarCursosParalelosAlumnos(this.value);'>";
	  echo "<option value='0'>Curso/Paralelo</option>";
	  echo "<option value='0'>Todos</option>";
      while ($row = sqlsrv_fetch_array($stmt))
      {
        echo "<option value='".$row["curs_para_codi"]."'>".$row['curs_deta'].' '.$row['para_deta']."</option>";
      }
    }
    else
    {
      echo "<select class='form-control' id='sl_paralelos' style='width: 200px' disabled='disabled'>";
      echo "<option value='0'>Curso/Paralelo</option>";
    }
    echo "</select>";
  }
  /*Función para llenar el select de Alumnos*/
  function CursosParalelosAlumnos ($curs_para_codi)
  {
    require_once ('../framework/dbconf.php');
    $params = array ($curs_para_codi);
    $sql = "{call curs_para_alum_cons (?)}";
    $stmt = sqlsrv_query($conn, $sql, $params);

    if (sqlsrv_has_rows($stmt))
    {
      echo "<select class='form-control' id='sl_alumnos' style='width: 200px'>";
	  echo "<option value='-1'>TODOS</option>";
      while ($row = sqlsrv_fetch_array($stmt))
      {
        echo "<option value='".$row["codigo"]."'>".$row['nombres']."</option>";
      }
    }
    else
    {
      echo "<select class='form-control' id='sl_alumnos' style='width: 200px' disabled='disabled'>";
      echo "<option value='0'>Alumno</option>";
    }
    echo "</select>";
  }
?>
