<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/docentes.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php include ('head.php');?>
        <!-- InstanceEndEditable -->
	</head>
	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=2;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		
      <?php include ('menu.php');?>
			
			<div  id="mainPanel"  class="section_main">
            
				<?php include ('header.php');?>

				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
            <div class="title">
            	<h3><span class="icon-calendar icon"></span>Agenda</h3>
			</div>
            <div class="options">
                <ul>
                    <li>
                    <a
                    	id="bt_agen_add"
                        class="button_text"
                        data-toggle="modal"
                        data-target="#agen_nuev">
                    		<span class="icon-add icon"></span>Nueva  Agenda
                    </a>
                    </li>
                </ul>
            </div>
					<!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
						<script type="text/javascript" src="js/agenda.js">
                        </script>
                        <div id="para_main">
                        	<?php include ('agenda_main_view.php'); ?>
                        </div>
                    <!-- Modal -->
                        <div 
                        class="modal fade" 
                        id="agen_nuev" 
                        tabindex="-1" 
                        role="dialog" 
                        aria-labelledby="myModalLabel" 
                        aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button 
                                type="button" 
                                class="close" 
                                data-dismiss="modal">
                                    <span aria-hidden="true">
                                        &times;
                                    </span><span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Agendar Nueva Actividad</h4>
                          </div>
                          <div class="modal-body">
                          <div id="div_mate_edi"> 
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="25%">
                                        Fecha inicio
                                    </td>
                                    <td>
                                        <input 
                                            id="agen_fech_ini" 
                                            name="agen_fech_ini" 
                                            type="text" value="<?= date('d/m/Y');?>"
                                            style="width:30%; margin-top: 10px">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                        Fecha de Finalización
                                    </td>
                                    <td>
                                        <input 
                                            id="agen_fech_fin" 
                                            name="agen_fech_fin" 
                                            type="text" 
                                            value="<?= date('d/m/Y');?>"
                                            style="width:30%; margin-top: 10px">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                        Título
                                    </td>
                                    <td>
                                        <input 
                                            name="agen_titu" 
											maxlength="30"
                                            type="text" 
                                            id="agen_titu" 
                                            value=""
                                            style="width:100%; margin-top: 10px;">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                        Detalle
                                    </td>
                                    <td>&nbsp;
                                        
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="2">
                                        <textarea 
                                            name="agen_deta" 
                                            id="agen_deta" 
                                            cols="45" 
                                            rows="5"
                                            style="width:100%; margin-top: 10px; resize:none;"></textarea>
                                        <input 
                                            type="hidden" 
                                            id="curs_para_mate_codi" 
                                            name="curs_para_mate_codi" 
                                            value="<?= $_GET['curs_para_mate_prof_codi'];?>">
                                    </td>
                                  </tr>
                                </table>
                          </div>
                          <div class="form_element">&nbsp;</div>
                          </div>
                          <div class="modal-footer">
                             <button type="button" class="btn btn-primary"  data-dismiss="modal" onClick="agen_add('para_main','script_agen.php','<?= $_GET['curs_para_mate_prof_codi'];?>','<?= $_GET['curs_para_mate_codi'];?>') ">Aceptar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                           
                          </div>
                        </div>
                      </div>
                    </div>
                         
					<script src="../theme/jquery1_11/external/jquery/jquery.js"></script>
                    <script src="../theme/jquery1_11/jquery-ui.js"></script>
                    <script src="../theme/jquery1_11/external/jquery/jquery_growl/javascripts/jquery.growl.js" type="text/javascript"></script>
                    <script>
                        $("#agen_fech_ini").datepicker();
                        $("#agen_fech_fin").datepicker();
                    </script> 

							 <!-- InstanceEndEditable -->
                    </div>
				</div>
			</div>

	
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>

<script>

var myVar=setInterval(function () {myTimer()}, 120000);


</script>
<!-- InstanceEnd --></html>