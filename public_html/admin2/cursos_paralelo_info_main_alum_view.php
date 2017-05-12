<?php 

	session_start();	 
	require_once ('../framework/dbconf.php');
	require_once ('../framework/funciones.php');
	require_once ('script_cursos.php');
	
			
	if(isset($_GET['curs_para_codi'])){
		 $curs_para_codi=$_GET['curs_para_codi'];
	}
	if(isset($_POST['curs_para_codi'])){
		 $curs_para_codi=$_POST['curs_para_codi'];
	}
	
	
	if(isset($_POST['add_alum'])){
		if($_POST['add_alum']=='Y'){			
			alum_curs_para_add($_POST['curs_para_codi'],$_POST['alum_codi']);
		}
	}
	
	if(isset($_POST['del_alum'])){
		if($_POST['del_alum']=='Y'){
			curs_para_alum_del($_POST['alum_codi'],$_POST['curs_para_codi']);
		}
	}
	
	$params = array($curs_para_codi);
	$sql="{call alum_curs_para_view(?)}";
	$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
?>


<table class="table table-striped table-bordered">
<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
    <tr>
      <th>#</th>              
      <th>Nombres</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
    </tr>
</thead>
	<?php  
	while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) 
	{ 
		$cc +=1; 
	?> 
    <tr>
      <td class="center">
      <input type="checkbox" id="alumno_<?= $cc ?>" value="<?= $row_alum_curs_para_view["alum_curs_para_codi"] ?>"/>
	  	<?php echo $cc; ?>
      </td>
      <td>
          <table>
            <tr>   
            <?php
            $file_exi=$_SESSION['ruta_foto_alumno'].$row_alum_curs_para_view["alum_codi"].'.jpg';
            if (file_exists($file_exi)) 
            {
                $pp=$file_exi;
            } 
            else 
            {
                $pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
            }
        	?>
                <td>
                    <img 
                        src="<?php echo $pp; ?>" 
                        width="58" height="59"  
                        style="text-align:right; border:none; width:30px; height:30px;"/>
                </td>
                <td style='font-size:small;'>
                <a title='Editar información' data-placement='bottom' onmouseover='$(this).tooltip("show");' href="alumnos_add.php?alum_codi=<?= $row_alum_curs_para_view["alum_codi"]; ?>">
                    <?
                        echo $row_alum_curs_para_view["alum_codi"].' - ';
                        echo $row_alum_curs_para_view["alum_apel"]." ";
                        echo $row_alum_curs_para_view["alum_nomb"]; 
                        echo ($row_alum_curs_para_view["alum_curs_para_estado"]=="I"?" (**)":"");
                    ?>
                </a>
                </td>
              </tr>
          </table>
      </td>
      <td>
			<?
			/*Permiso para agregar/quitar materias a un estudiante*/
			if (permiso_activo(221))
			{
			?><a    class="btn btn-default" 
					<? if ($row_alum_curs_para_view["alum_curs_para_estado"]=="A")
						{ 
					?>
						onclick="alum_mate_view(<?php echo $row_alum_curs_para_view["curs_para_codi"]; ?>,
						<?php echo $row_alum_curs_para_view["alum_curs_para_codi"];?>,
						<?php echo $row_alum_curs_para_view["alum_codi"];?>)" 
						data-toggle="modal" 
						data-target="#ModalAlumMate"
					<?php
						}
					?>
						title="Agregar/Quitar materia" data-placement='left' onmouseover='$(this).tooltip("show");'>
						<span class="fa fa-book"></span></a>
			</li>
			<?
			}
			?>
	  </td> 
      <td>
			<?
			/*Permiso para cambiar a un estudiante de paralelo*/
			if (permiso_activo(222))
			{
			?>
				<a  class="btn btn-default" 
					<? 
						if ($row_alum_curs_para_view["alum_curs_para_estado"]=="A")
						{?>
						onclick="curs_para_cambiar_load(<?= $row_alum_curs_para_view["alum_curs_para_codi"]?>, <?= $row_alum_curs_para_view["alum_codi"]?>)" 
						data-toggle="modal" 
						data-target="#ModalCambioParalelo"
					<?	}
					?>
						title="Cambiar de paralelo" data-placement='top' onmouseover='$(this).tooltip("show");'>
						<span class="fa fa-cog"></span></a>
			<?
			}?>
      </td>
	  <!-- <td>  
        <div class="menu_options">
            <ul>
				<?
				/*Eliminar a un estudiante del curso paralelo*/
				if (permiso_activo(223))
				{
				?>
                <li>
                    <a  
                        class="option" 
                        onclick="vali_desmatri(<?php echo $row_alum_curs_para_view["curs_para_codi"];?>, 
                        <?php echo $row_alum_curs_para_view["alum_codi"]; ?>)"
                        title="Eliminar estudiante">
                            <span class="icon-close icon"></span>
                    </a>
                </li>
				<?
				}
				?>
            </ul>
        </div>
      </td> -->
    </tr>
<?php }?>
    <tr>
		<td colspan="4">(**) Alumno retirado</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
</table>
<input id="total_alumnos" type="hidden" value="<?= $cc ?>" />