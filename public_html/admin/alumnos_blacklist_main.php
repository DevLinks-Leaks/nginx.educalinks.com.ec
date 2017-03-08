<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>

<!-- Nuevos Css Js -->

<!-- Fin -->
</head> 
<body class="general admin"> 
    <!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=106;    ?><!-- InstanceEndEditable -->
    <div class="pageContainer"> 

        <?php include ('menu.php');?>

        <div id="mainPanel" class="section_main">

         <?php include ('header.php');?>

         <div class="main sectionBorder">
           <div id="information">

              <div class="titleBar">
                  <!-- InstanceBeginEditable name="Titulo Top" --><div class="title"><h3><span class="icon-users icon"></span>Blacklist</h3></div>
              </div>

              <!-- InstanceBeginEditable name="information" -->
              
              <div id="blacklist_main" >
               <?php include ('alumnos_blacklist_main_lista.php'); ?>
           </div>

    <div class="modal fade" id="BlacklistEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Editar Motivo Blacklist</h4>
        </div>
        <div id="modal_main_blacklist" class="modal-body">
            
        </div>
        <div class="modal-footer">
            <button id="btn_blacklist_save" type="button" class="btn btn-success" data-loading-text="Grabando..." onClick="load_ajax_edit_alum_bl('blacklist_main','script_alumnos_blacklist.php','opc=upd&bl_codi='+document.getElementById('bl_codi').value+'&bl_moti_bloq_deta='+document.getElementById('cmb_motivos').options[document.getElementById('cmb_motivos').selectedIndex].value,true);" >Grabar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
</div>         
<!-- InstanceEndEditable -->
</div>
</div>
</div>


</div>


<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />

<!-- Modal SELECCION DE PERIODO -->
<div class="modal fade" id="ModalPeriodoActivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">SELECCION DE PERIODO ACTIVO</h4>
    </div>
    <div class="modal-body">

        <table>
            <tr>
                <td>PERIODOS</td>                        

            </tr>

            <? 	
            $params = array();
            $sql="{call peri_view()}";
            $peri_view = sqlsrv_query($conn, $sql, $params);  
            ?>

            <? while($row_peri_view = sqlsrv_fetch_array($peri_view)){ ?>
            <tr>    
              <td height="50"><button type="button" class="btn btn-primary" style="width:100%;" onClick="periodo_cambio(<?= $row_peri_view["peri_codi"]; ?>);">ACTIVAR PERIODO LECTIVO <?= $row_peri_view["peri_deta"]; ?></button></td>
          </tr>
          <?php  } ?>




      </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

</div>
</div>
</div>
</div>

<!-- InstanceBeginEditable name="EditRegion4" -->
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
       $('#alum_table').datatable({
      pageSize: 30,
      sort: [true,true, true, true, false],
      filters: [false,false, false, false, false],
      filterText: 'Buscar... '
    }) ;
   } );

</script>
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>