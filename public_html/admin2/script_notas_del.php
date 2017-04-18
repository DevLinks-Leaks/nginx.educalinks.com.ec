<?php			
	include_once ('script_cursos.php');
	
	if (isset($_POST['del_notas']))
	{
		if ($_POST['del_notas']=='Y')
		{
			notas_elim_peri_dist($_POST['curs_para_codi'], 
								 $_POST['peri_dist_codi'], 
								 $_POST['clie_codi'], 
								 $_POST['clave']);
		}
	}
	
	if (isset($_POST['del_notas_all']))
	{
		if ($_POST['del_notas_all']=='Y')
		{
			notas_elim_peri_dist_all($_POST['peri_dist_codi'], 
								 $_POST['clie_codi'], 
								 $_POST['clave']);
		}
	}					 
	
?>