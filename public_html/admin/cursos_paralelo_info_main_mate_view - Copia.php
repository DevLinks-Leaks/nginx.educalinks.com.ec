<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('script_cursos.php'); 
 
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
			curs_para_mate_upd($_POST['curs_para_mate_codi'],$_POST['prof_codi'],$_POST['aula_codi']);
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
  
	$params = array($curs_para_codi);
	$sql="{call curs_peri_mate_view(?)}";
	$curs_peri_mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
	

?>
<table class=" table_striped ">
    <thead>
        <tr>
            <th>#</th>           
            <th>Materias</th>
            <!--<th>Aula</th>-->
            <th>Profesores(Aula)</th>
            <th>Opciones</th>
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
        <!--<td> 
			<?php
            /*
			if  ($row_curs_peri_mate_view["mate_hijo_cc"] == 0)
			{
				echo $row_curs_peri_mate_view["aula_deta"];
			}*/
			?>
        </td>-->
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
			/*if  ($row_curs_peri_mate_view["mate_hijo_cc"] == 0)
			{  
				if  ($row_curs_peri_mate_view["prof_codi"] <> '')
				{ 
			?> 
            	<img 
                	src="<?php echo $pp; ?>" 
                    width="58" 
                    height="59"  
                    style=" text-align:right; border:none; width:30px; height:30px;"/>
					<?php echo $row_curs_peri_mate_view["prof_nomb"]; ?> 
			<?php 
				}
			?>
            <?php 
			}*/
			$params = array($row_curs_peri_mate_view["curs_para_mate_codi"]);
			$sql="{call curs_para_mate_prof_view(?)}";
			$curs_para_mate_prof_view = sqlsrv_query($conn, $sql, $params);
			echo "<table>";
			while ($row_curs_para_mate_prof_view = sqlsrv_fetch_array($curs_para_mate_prof_view))
			{
				echo "<tr>";
				echo "<td>".$row_curs_para_mate_prof_view["prof_apel"]
				." ".$row_curs_para_mate_prof_view["prof_nomb"]
				."(".$row_curs_para_mate_prof_view["aula_deta"].")</td>"
				.'<td><a 
                        	class="option" 
                            data-toggle="modal" 
                            data-target="#ModalEditCurso" 
                            onclick="alum_curs_para_mate_upd('. $row_curs_peri_mate_view["curs_para_mate_codi"].',
							'.$row_curs_peri_mate_view["curs_para_codi"].')"
                            title="Editar profesor">
                        	<span class="icon-pencil2 icon"></span>
                        </a></td>'
				.'<td><a 
                        	class="option" 
                            onclick="curs_para_mate_del('.$row_curs_peri_mate_view["curs_para_mate_codi"].',
							'.$row_curs_peri_mate_view["curs_para_codi"].')"
                            title="Quitar profesor">
                    		<span class="icon-close icon"></span>
                    	</a></td>';
				echo "</tr>";
			}
			echo "</table>";
			?>
        </td>
        <td align="right">
            <div class="menu_options"  style="text-align:right;">
                <ul>
                	<?php if  ($row_curs_peri_mate_view["mate_hijo_cc"] == 0)
					{ 
					?> 
                	<li>
                    	<a 
                        	class="option" 
                            data-toggle="modal" 
                            data-target="#ModalEditCurso" 
                            onclick="alum_curs_para_mate_upd(<?php echo $row_curs_peri_mate_view["curs_para_mate_codi"]; ?>,
							<?php echo $row_curs_peri_mate_view["curs_para_codi"]; ?>)"
                            title="Agregar profesor">
                        	<span class="icon-add icon" title="Agregar profesor"></span>
                        </a>
                    </li>
                    <?
					}
					else
					{
					?>
                    <li>
                        <a 
                        	class="option" 
                            data-toggle="modal">
                        	<span>&nbsp;&nbsp;</span>
                        </a>
                    </li>
                    <?
					}
					?>
                    <li>
                    	<a 
                        	class="option" 
                            onclick="curs_para_mate_del(<?php echo $row_curs_peri_mate_view["curs_para_mate_codi"]; ?>,
							<?php echo $row_curs_peri_mate_view["curs_para_codi"];?>)"
                            title="Quitar materia">
                    		<span class="icon-remove icon"></span>
                    	</a>
                    </li>
                </ul>
            </div>
        </td> 
        <td>
            <button  
            	onclick="curs_para_mate_up_down(<?php echo $row_curs_peri_mate_view["curs_para_mate_codi"]; ?>,
				<?php echo $row_curs_peri_mate_view["curs_para_codi"]; ?>,'down');"
                title="Bajar">
                <i class="icon-arrow-down"></i>
            </button>
            <button 
            	onclick="curs_para_mate_up_down(<?php echo $row_curs_peri_mate_view["curs_para_mate_codi"]; ?>,
				<?php echo $row_curs_peri_mate_view["curs_para_codi"]; ?>,'up');"
                title="Subir">
                <i class="icon-arrow-up"></i>
            </button>
        </td>
    </tr>
<?php }?>
</tbody>
</table>
<input type="hidden" value="<?= $cc?>" id="num_materias" />