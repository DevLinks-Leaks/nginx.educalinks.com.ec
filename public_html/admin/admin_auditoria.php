<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	<script type="text/javascript" language="javascript" src="../theme/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" language="javascript" src="../theme/js/datatable.js"></script>
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=405;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
		<form name="auditoria" target="_blank" method="post" action="audi_listas_main_view.php" onSubmit="return Validar()">
          <div class="title">
          	<h3>
            	<span class="icon-briefcase icon"></span>Auditoría
            </h3>
          </div>
          <div class="options">
              <ul>
              	<li style="margin:10px 5px 10px 0;">
                <label>Desde:
					<input id="audi_fec_ini" name="audi_fec_ini" type="text" value="<?= date("Y-m-d");?>"/>
                  </label>
                </li>
                <li style="margin:10px 5px 10px 0;">
                  <label>Hasta:
                  	<input id="audi_fec_fin" name="audi_fec_fin" type="text" value="<?= date("Y-m-d");?>"/>
                  </label>
                </li>
                <li>
                  <a id="bt_mate_add" class="button_text"  onClick="document.auditoria.onsubmit();" >
                    <span class="icon-print"></span>Imprimir historial
                  </a>
                </li>
              </ul>
          </div>
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <div id="auditoria_main" >
                             <?php include ('admin_auditoria_script.php'); ?>
                        </div>
        </form>
        <script type="text/javascript">
		function Validar ()
		{
			if (ValidaAcciones() && ValidaUsuarios())
			{
				document.auditoria.submit();
				return true;
			}
			else
			{
				return false;
			}
		}
			
		function ValidaAcciones ()
		{
			if (IsChk('acciones'))
			{
				//ok, hay al menos 1 elemento checkeado envía el form!
				return true;
			} 
			else 
			{
			//ni siquiera uno chequeado no envía el form
				alert ('¡Seleccione una acción!');
				return false;
			}
		}
		
		function ValidaUsuarios ()
		{
			if (IsChk('usuarios'))
			{
				//ok, hay al menos 1 elemento checkeado envía el form!
				return true;
			} 
			else 
			{
			//ni siquiera uno chequeado no envía el form
				alert ('¡Seleccione un usuario!');
				return false;
			}
		}
		
		function IsChk(chkName)
		{
			var found = false;
			var chk = document.getElementsByName(chkName+'[]');
			for (var i=0 ; i < chk.length ; i++)
			{
				found = chk[i].checked ? true : found;
			}
				return found;
		}
		
		function seleccionar_todos_acciones()
		{
			var chk = document.getElementsByName('acciones[]');
			
			
				for (var i=0 ; i < chk.length ; i++)
				{
					chk[i].checked=1;
				}
		} 
		
		function deseleccionar_todos_acciones()
		{
			var chk = document.getElementsByName('acciones[]');
			
			
				for (var i=0 ; i < chk.length ; i++)
				{
					chk[i].checked=0;
				}
		} 
		
		function seleccionar_todos_usuarios()
		{
			var chk = document.getElementsByName('usuarios[]');
			for (var i=0 ; i < chk.length ; i++)
			{
				chk[i].checked=1;
			}
				
		} 
		
		function deseleccionar_todos_usuarios()
		{
			var chk = document.getElementsByName('usuarios[]');
			for (var i=0 ; i < chk.length ; i++)
			{
				chk[i].checked=0;
			}
				
		}
		
		$("#audi_fec_ini").datepicker
		(
			{ 
				dateFormat: 'yy-mm-dd',
				onSelect: function(date)
				{
					this.value=date;
				}
			}
		);
		
		$("#audi_fec_fin").datepicker({ dateFormat: 'yy-mm-dd' });
		</script>
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

       <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>