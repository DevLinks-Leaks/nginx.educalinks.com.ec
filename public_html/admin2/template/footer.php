<!-- Modal Representante Edición -->
  <div class="modal fade" id="modal_representante_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div id="modal_representante_edit_content" class="modal-content">
        
      </div>
    </div>
  </div>
  <!-- FIN MODAL -->
  <!--Inicio modal cambiar de paralelo-->
<div class="modal fade" id="ModalCambioParalelo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="cambiar_paralelo_content" class="modal-content">
      
    </div>
  </div>
</div>
<!--Fin modal cambiar de paralelo
<div id='ss_menu'>
  <div> <i onclick="location.href = '../admin/index.php';" title='Módulo Académico' class="fa fa-graduation-cap"></i> </div>
  <div><?php //if($_SESSION['rol_finan']==1) //echo " <i onclick=\"location.href = '../../main_finan.php';\" title='Módulo Financiero' class='fa fa-dollar'></i> ";?></div>
  <div><?php //if($_SESSION['rol_biblio']==1)//echo " <i onclick=\"location.href = '../../biblio/index.php';\" title='Módulo Biblioteca' class='fa fa-book'></i> ";?></div>
  <div><?php //if($_SESSION['rol_medic']==1) //echo " <i onclick=\"location.href = '../../main_medic.php';\" title='Módulo Médico' class='fa fa-medkit'></i> ";?></div>
  <div class='menu'>
    <div class='share' id='ss_toggle' data-rot='180'>
      <div class='circle'></div>
      <div class='bar'></div>
    </div>
  </div>
</div>-->
<?php
if( !isset( $_SESSION['sidebar_status'] ) )
	$_SESSION['sidebar_status'] = 'sidebar-collapse';
?>
<input type='hidden' id='hd_status_bar' name='hd_status_bar' value='<?php echo $_SESSION['sidebar_status']; ?>'></input>
<footer class="main-footer" style='font-size:small;text-align:center;'>
	<strong>Desarrollado por <a href="http://www.redlinks.com.ec">Redlinks</a>. Copyright &copy; 2014-2017</strong> Todos los derechos reservados.<br>
	<div class="hidden-xs">
		Av. Raúl Gómez Lince (Av. Las Aguas) Mz 192 Solar 1 Oficina 3 1er Piso. Telf: 043726466. Email: <a href="mailto:info@redlinks.com.ec?Subject=Informacion" target="_blank">info@redlinks.com.ec</a>
	</div>
</footer>