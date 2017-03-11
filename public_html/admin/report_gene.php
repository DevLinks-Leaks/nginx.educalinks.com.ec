<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>

<!-- Nuevos Css Js -->

<!-- Fin -->
</head> 
<body class="general admin"> 
    <!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=606;    ?><!-- InstanceEndEditable -->
    <div class="pageContainer"> 

        <?php include ('menu.php');?>

        <div id="mainPanel" class="section_main">

         <?php include ('header.php');?>

         <div class="main sectionBorder">
           <div id="information">

              <div class="titleBar">
                  <!-- InstanceBeginEditable name="Titulo Top" -->
                  <script type="text/javascript" src="js/select_reportes_generales.js?<?=$rand?>"></script>
                  <div class="title" style="width:25%; float:left;">
                      <h3><span class="icon-print icon"></span>Reportes Generales</h3>
                  </div>
                  <div style="width:100%; float:left;">
                      <div class="options" style="width:75%; float:none;"> 
                          <ul>
                           <li>
                              <a class="button_text">
                                 <select onchange="CargarPeriodosDistribucion(this.value);CargarCursosParalelos(this.value);CargarCursosParalelosAlumnos(0);"
                                 style="width: 200px">
                                 <?
                                 $peri_codi=$_SESSION['peri_codi'];
                                 $params = array($peri_codi);
                                 $sql="{call peri_dist_cab_view(?)}";
                                 $peri_dist_cab_view = sqlsrv_query($conn, $sql, $params);
                                 ?>
                                 <option value="0">Elija</option>
                                 <?php
                                 while ($row_peri_dist_cab_view = sqlsrv_fetch_array($peri_dist_cab_view))
                                 {
                                    ?>
                                    <option value="<?= $row_peri_dist_cab_view['peri_dist_cab_codi']; ?>">
                                       <?= $row_peri_dist_cab_view['peri_dist_cab_deta']; ?>
                                   </option>
                                   <?
                               }
                               ?>
                           </select>
                       </a>
                   </li>
                   <li>
                    <a class="button_text">
                      <div id="div_sl_periodo_dist">
                         <select
                         id="sl_periodo_dist"
                         disabled="disabled"
                         style="width: 200px">
                         <option value="0">Parcial/Quimestre</option>
                     </select>
                 </div>
             </a>
         </li>
         <li>
            <a class="button_text">
                <div id="div_sl_paralelos">
                  <select
                  disabled="disabled"
                  style="width: 200px"
                  id="sl_paralelos">
                  <option value="0">Curso/Paralelo</option>
              </select>
          </div>
      </a>
  </li>
  <li>
      <a class="button_text">
         <div id="div_sl_alumno">
            <select
            id="sl_alumnos"
            name="sl_alumnos"
            disabled="disabled"
            style="width: 200px">
            <option value="0">Alumno</option>
        </select>
    </div>
</a>
</li>
</ul>
</div>
</div>
<!-- InstanceEndEditable -->
</div>

        <!-- InstanceBeginEditable name="information" -->
        <div class="alumnos_main_lista" style="float:none; width:100%;">
            <table class="table_striped" id="alum_table">
               <thead>
                  <tr>
                    <th width="90%" class="sort"><span class="icon-sort icon"></span>Reporte </th>
                    <th width="10%" class="sort"><span class="icon-cog icon"></span>Opciones</th>
                </tr>
            </thead>
            <tbody>
               <tr>
                  <td><h3>Certificado de Matr&iacute;cula</h3></td>
                  <td>
                    <h1>
                       <a href="JavaScript:getURLCertMatriculaPDF();" >
                           <span class="icon-file-pdf icon"></span>
                       </a>
                   </h1>
               </td>
           </tr>
           <tr>
              <td><h3>Certificado de Conducta</h3></td>
              <td>
                <h1>
                   <a href="JavaScript:getURLCertComportamientoPDF();"> 
                       <span class="icon-file-pdf icon"></span>
                   </a>
               </h1>
           </td>
        </tr>
        <tr>
          <td><h3>Certificado de Asistencia</h3></td>
          <td>
            <h1>
               <a href="JavaScript:getURLCertAsistenciaPDF();" >
                   <span class="icon-file-pdf icon"></span>
               </a>
           </h1>
        </td>
        </tr>
        <tr>
          <td><h3>Certificado de Promoci&oacute;n</h3></td>
          <td>
            <h1>
               <a href="JavaScript:getURLCertPromocionPDF('<?= $_SESSION['directorio']; ?>','<?= $_SESSION['peri_codi']; ?>');">
                   <span class="icon-file-pdf icon"></span>
               </a>
               <h1>
               </td>
           </tr>
           <tr>
              <td><h3>Listado de alumnos con notas pendientes de ingreso</h3></td>
              <td>
                <h1>
                   <a href="JavaScript:getURLNotasPendientesIngresoPDF();">
                       <span class="icon-file-pdf icon"></span>
                   </a>
                   <h1>
                   </td>
               </tr>
               <?php 
               if($_SESSION['directorio']=='delfos' or $_SESSION['directorio']=='delfosvesp'){
                  ?>
                  <tr>
                    <td><h3>Informe Cualitativo Final de Educación Inicial</h3></td>
                    <td>
                        <h1>
                          <a href="JavaScript:getURLInformeCualitativoFinal();">
                              <span class="icon-file-pdf icon"></span>
                          </a>
                          <h1>
                          </td>
                      </tr>
                      <?php 
                  }
                  ?>
                  <tr>
                    <td><h3>Ficha de Matricula</h3></td>
                    <td>
                        <h1>
                          <a href="JavaScript:getURLFichaMatricula('<?=$_SESSION['directorio'];?>');">
                              <span class="icon-file-pdf icon"></span>
                          </a>
                          <h1>
                          </td>
                      </tr>
                  <tr>
                    <td><h3>Libro de Calificaciones</h3></td>
                    <td>
                      <h1>
                         <a href="JavaScript:getURLLibroCalificacionesPDF();">
                             <span class="icon-file-pdf icon"></span>
                         </a>
                         <h1>
                         </td>
                     </tr>
                  </tbody>
              </table>
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

</body>
<!-- InstanceEnd --></html>