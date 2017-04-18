<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=0;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->Inicio<!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                      
<?php echo $_SESSION['usua_nomb'] + ' '+ $_SESSION['usua_apel'] + '(' + $_SESSION['usua_codi']   + ")"; ?>

<h3>VENTANA MODAL</h3>
                      <!-- Button trigger modal -->


<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Ver ventana
</button>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva Aula</h4>
      </div>
      <div class="modal-body">
       
        	<table>
        		<tr>
        			<td>nombre</td>
        			<td>apellido</td>
        			<td>email</td>
        		</tr>
                	<tr>
        			<td> d</td>
        			<td>d</td>
        			<td>d</td>
        		</tr>
        	</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<hr />
<h3>BOTONES</h3>
<a href="" class="btn btn-primary ">Aceptar</a>
<a href="" class="btn btn-info ">Editar</a>
<a href="" class="btn btn-default ">Borrar</a>

<hr />

<h3>BOTONES DENTRO DE TABLAS</h3>
<a href="" class="btn btn-primary btn-xs">Aceptar</a>
<a href="" class="btn btn-info btn-xs">Editar</a>
<a href="" class="btn btn-default btn-xs">Borrar</a>

<hr />

<h3>PESTAÑAS</h3>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" id="tab">
<li class="active"><a href="#tab1" role="tab" data-toggle="tab">tab 1</a></li>
  <li><a href="#tab2" role="tab" data-toggle="tab">tab 2</a></li>
  <li><a href="#tab3" role="tab" data-toggle="tab">tab 3</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane fade in active" id="tab1">CONTENT TAB 01</div>
  <div class="tab-pane fade" id="tab2">CONTENT TAB 02</div>
  <div class="tab-pane fade" id="tab3">CONTENT TAB 03</div>
</div>


<h3>CALENDARIO & HORA</h3>

<div class="container">
    <div class="row">
        <div class='col-sm-6'>
            <div class="form-group">
                <div class='input-group date' id='datetime'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon"><span class="icon-calendar icon"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class='col-sm-6'>
            <div class="form-group">
                <div class='input-group date' id='time'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon"><span class="icon-clock icon"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>
                      Opciones de menud
                      <a href="cursos_paralelo_main.php">curso</a> <!-- InstanceEndEditable -->
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
    
<!-- InstanceBeginEditable name="EditRegion4" -->EditRegion4<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>