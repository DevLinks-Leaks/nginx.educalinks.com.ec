<?php 

	session_start();	 
	include_once ('../framework/dbconf.php');
	include_once ('../framework/funciones.php');
	include_once ('script_cursos.php'); 
 
	if(isset($_GET['curs_para_codi'])){
		 $curs_para_codi=$_GET['curs_para_codi'];
	}
	if(isset($_POST['curs_para_codi'])){
		 $curs_para_codi=$_POST['curs_para_codi'];
	}
	
	if(isset($_POST['add_mate'])){
		if($_POST['add_mate']=='Y'){
			curs_para_mate_add($_POST['curs_para_codi'],$_POST['mate_codi']);
		}
	}
	
	if(isset($_POST['del_mate'])){
		if($_POST['del_mate']=='Y'){
			curs_para_mate_del($_POST['curs_para_mate_codi']);
			 
		}
	}
	 
	if(isset($_POST['edit_curs'])){
		if($_POST['edit_curs']=='Y'){				
			curs_para_mate_upd($_POST['curs_para_mate_codi'],$_POST['curs_para_mate_prof_codi'],$_POST['prof_codi'],$_POST['aula_codi']);
		}
	}
	
	if(isset($_POST['edit_cupo'])){
		if($_POST['edit_cupo']=='Y'){
			curs_para_cupo_edit($_POST['curs_para_codi'],$_POST['curs_para_cupo']);
		}
	}
	
	if(isset($_POST['mate_up'])){
		if($_POST['mate_up']=='Y'){				
			curs_para_mate_up($_POST['curs_para_mate_codi']);
		}
	}
	if(isset($_POST['mate_down'])){
		if($_POST['mate_down']=='Y'){				
			curs_para_mate_down($_POST['curs_para_mate_codi']);
		}
	}
	if(isset($_POST['copy_curs'])){
		if($_POST['copy_curs']=='Y'){				
			copy_curs_mate($_POST['curs_para_codi_orig'], $_POST['curs_para_codi']);
		}
	}
	
	if(isset($_POST['add_model'])){
		if($_POST['add_model']=='Y'){				
			curs_para_mate_mode_upd($_POST['curs_para_mate_codi'], $_POST['nota_refe_cabe_codi']);
		}
	}
	
	if(isset($_POST['add_tutor'])){
		if($_POST['add_tutor']=='Y'){				
			curs_para_mate_tutor_add($_POST['curs_para_mate_prof_codi']);
		}
	}
	
	if(isset($_POST['add_agenda'])){
		if($_POST['add_agenda']=='Y'){				
			curs_para_mate_agen($_POST['curs_para_mate_codi'], $_POST['tiene_agenda']);
		}
	}
	
	if(isset($_POST['add_promoc'])){
		if($_POST['add_promoc']=='Y'){				
			curs_para_mate_promoc($_POST['curs_para_mate_codi'], $_POST['mostrar_materia']);
		}
	}
	
	if(isset($_POST['del_prof'])){
		if($_POST['del_prof']=='Y'){
			curs_para_mate_prof_del($_POST['curs_para_mate_prof_codi']);
		}
	}
  
	$params = array($curs_para_codi);
	$sql="{call curs_peri_mate_list(?)}";
	$curs_peri_mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
	

?>
<table class="table table-striped table-bordered" style="margin-bottom: 200px">
    <thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
        <tr>
            <th>#</th>           
            <th style='width:30%;'>Materias</th>
            <th>Áreas</th>
            <th>Profesores(Aula)</th>
            <th>Opcion</th>
            <th>Clases</th>
			<th></th>
        </tr>
    </thead>
<tbody>
<?php  
while ($row_curs_peri_mate_view = sqlsrv_fetch_array($curs_peri_mate_view)) 
{ 
	$cc +=1; 
?> 
    <tr>
        <td class="center">
			<?= $cc; ?>&nbsp;
		</td>
        <td class="left">              		
          <div  <? if ($row_curs_peri_mate_view["mate_padr"] >0) echo 'style="text-indent:15px;"';?>>
            <?php echo $row_curs_peri_mate_view["mate_codi"]."-".$row_curs_peri_mate_view["mate_deta"]; ?>
          </div>
        </td>
        <td class="center">              		
          <div>
            <?php echo $row_curs_peri_mate_view["area_deta"]; ?>
          </div>
        </td>
        <?php
            $file_exi=$_SESSION['ruta_foto_docente'] . $row_curs_peri_mate_view["prof_codi"] . '.jpg';
        
            if (file_exists($file_exi)) {
                $pp=$file_exi;
            } else {
                $pp=$_SESSION['ruta_foto_docente'].'0.jpg';
            }
        ?>
        <td align="left">
			<?php 
			$params = array($row_curs_peri_mate_view["curs_para_mate_codi"]);
			$sql="{call curs_para_mate_prof_view(?)}";
			$curs_para_mate_prof_view = sqlsrv_query($conn, $sql, $params);
			while ($row_curs_para_mate_prof_view = sqlsrv_fetch_array($curs_para_mate_prof_view))
			{ ?>
			<div class="row">
				<div class="col-sm-12">
					<div class="btn-group">
						<button 
								class='btn btn-default btn-sm' 
								title='<?= $row_curs_para_mate_prof_view["prof_apel"]." ".$row_curs_para_mate_prof_view["prof_nomb"]?>'
								onclick='Asignar_Profesor(<?= $row_curs_para_mate_prof_view["curs_para_mate_prof_codi"] ?>)'>
								<?= ($row_curs_para_mate_prof_view["es_tutor"]==1?'<b>':'') ?>
							<?= substr($row_curs_para_mate_prof_view["prof_apel"],0,6) ?>(<?= $row_curs_para_mate_prof_view["aula_deta"] ?>) <?= ($row_curs_para_mate_prof_view["es_tutor"]==1?'</b>':'') ?>"
						</button>
						<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
							 data-placement='right' title='Ver opciones' onmouseover='$(this).tooltip("show");'>
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<?  /*Permiso para cambiar de profesor*/
								if (permiso_activo(218))
								{ ?>
								<li>
									<a class="option" data-toggle="modal" data-target="#ModalEditCurso" 
									onclick="alum_curs_para_mate_upd(<?= $row_curs_peri_mate_view["curs_para_mate_codi"]?>,
									<?= $row_curs_para_mate_prof_view["curs_para_mate_prof_codi"]?>,
									<?= $row_curs_para_mate_prof_view["aula_codi"] ?>,
									<?= $row_curs_para_mate_prof_view["prof_codi"] ?>)"
									title="Editar profesor"><span class="fa fa-edit btn_opc_lista_editar" style='margin-right:3px;'></span> Cambiar Profesor</a>
								</li> <?
								}
								/*Permiso para quitar al profesor asignado*/
								if (permiso_activo(219))
								{ ?>
								<li>
									<a class="option" onclick="curs_para_mate_prof_del(<?= $row_curs_para_mate_prof_view["curs_para_mate_prof_codi"] ?>,
									<?= $row_curs_peri_mate_view["curs_para_codi"] ?>)"
									title="Quitar profesor"> <span class="fa fa-trash btn_opc_lista_eliminar" style='margin-right:3px;'></span> Quitar Profesor </a>
								</li>
								<? } ?>
						<?php if (permiso_activo(215)){?>
							<li class="divider"></li>
							<li><a class="option" title="Asignar como tutor" onclick='curs_para_mate_prof_tutor (
													<?= $row_curs_para_mate_prof_view["curs_para_mate_prof_codi"] ?>,
													<?= $curs_para_codi ?>)'>
										<input name='tutor'  
											type='radio' <?= ($row_curs_para_mate_prof_view["es_tutor"]==1?'checked':'') ?> style='margin-right:3px;'> Tutor</a></li>
						<?php }?>
						</ul>
					</div>
				</div>
			</div>
			<?
			}
			?>
        </td>
        <td align="center">
			<div class="btn-group" data-placement='left' title='Ver opciones' onmouseover='$(this).tooltip("show");'>
				<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" >
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<? 
				if ($row_curs_peri_mate_view["mate_hijo_cc"] == 0)
				{   /*Permiso para agregar un profesor*/
					if (permiso_activo(216))
					{ ?> 
					<li><a  class="option" 
							data-toggle="modal" 
							data-target="#ModalEditCurso" 
							onclick="alum_curs_para_mate_upd(<?= $row_curs_peri_mate_view["curs_para_mate_codi"]; ?>,0,
							0,0)"
							title="Agregar profesor">
							<span class="fa fa-plus" title="Agregar profesor"></span> Agregar Profesor</a>
					</li>
				<?  }
				}
				/*Permiso para eliminar la materia del curso paralelo*/
				if (permiso_activo(217))
				{ ?><li><a class="option" 
							onclick="curs_para_mate_del(<?= $row_curs_peri_mate_view["curs_para_mate_codi"]; ?>,
							<?= $row_curs_peri_mate_view["curs_para_codi"];?>)"
							title="Eliminar materia">
							<span class="fa fa-remove"></span> Eliminar Materia</a>
					</li> <?
				}
				/*Permiso para asignar un modelo de calificación a la materia*/
				if (permiso_activo(220))
				{ ?><li><a  class="option" 
							data-toggle="modal" 
							data-target="#ModalAsignarModelo" 
							onclick="curs_para_mate_mode_upd(<?= $row_curs_peri_mate_view["curs_para_mate_codi"]; ?>, <?= $row_curs_peri_mate_view["nota_refe_cab_cod"]; ?>)"
							title="Asignar modelo calificación">
							<span class="fa fa-cog" title="Asignar modelo calificación"></span> Modelo de Calif.</a>
					</li><?
				} ?>
				</ul>
			</div>
        </td> 
		<td>
			<input 
				class="option" data-placement='left' onmouseover='$(this).tooltip("show");'
				style="margin-right: 3px"
				onclick="curs_para_mate_agend_add(this, <?= $curs_para_codi ?>, <?= $row_curs_peri_mate_view["curs_para_mate_codi"] ?>);"
				title="Mostrar en agenda" 
				type="checkbox" <? echo ($row_curs_peri_mate_view["curs_para_mate_agen"]==0?"":"checked")?>/>
			<input 
				class="option" data-placement='right' onmouseover='$(this).tooltip("show");'
				style="margin-right: 3px"
				onclick="curs_para_mate_promoc_add(this, <?= $curs_para_codi ?>, <?= $row_curs_peri_mate_view["curs_para_mate_codi"] ?>);"
				title="Mostrar en promoción" 
				type="checkbox" <? echo ($row_curs_peri_mate_view["curs_para_mate_promoc"]==0?"":"checked")?>/>
		</td>
        <td>
			<div class="btn-group-vertical">
				<button data-placement='top' title='Subir posición' onmouseover='$(this).tooltip("show");'
					type='button' class='btn btn-default btn-sm'
					onclick="curs_para_mate_up_down(<?php echo $row_curs_peri_mate_view["curs_para_mate_codi"]; ?>,
					<?php echo $row_curs_peri_mate_view["curs_para_codi"]; ?>,'up');"
					title="Subir">
					<i class="fa fa-chevron-up"></i>
				</button>
				<button data-placement='bottom' title='Bajar posición' onmouseover='$(this).tooltip("show");'
					type='button' class='btn btn-default btn-sm'
					onclick="curs_para_mate_up_down(<?php echo $row_curs_peri_mate_view["curs_para_mate_codi"]; ?>,
					<?php echo $row_curs_peri_mate_view["curs_para_codi"]; ?>,'down');"
					title="Bajar">
					<i class="fa fa-chevron-down"></i>
				</button>
			</div>
        </td>
    </tr>
<?php }?>
</tbody>
</table>
<input type="hidden" value="<?= $cc?>" id="num_materias" />