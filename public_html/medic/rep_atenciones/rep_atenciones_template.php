<!DOCTYPE html>
<html lang="es">
    <?php include("../template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include("../template/navbar.php");?>
			<?php $active="cons_estudiantes";include("../template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Atención médica estudiantil
						<small>Ingreso de nuevo registro</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Atención médica estudiantil</li>
					</ol>
				</section>
				<section class="content" id="formulario">
					<?php include("rep_atenciones_main.php");?>
				</section>
				<?php include("../template/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("../template/rutas.php");?>
			</form>
			<?php include("../template/footer.php");?>
		</div>
		<!-- =============================== -->
		<?php include("../template/scripts.php");?>
		<script src="../js/med_fichas.js"></script>
		<script type="text/javascript">  
			$(document).ready(function(){  
				$("#txt_fecha_ini").datepicker();
				$("#txt_fecha_fin").datepicker();
				$("#boton_busqueda").click(function(){
					$("#desplegable_busqueda").slideToggle(200);
				});
				
				$('#table_atenciones').DataTable({
					dom: 'Bfrtip',
					buttons: [ 
						{ extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
						{ extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
						{ extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
						],
					"bPaginate": true,
					"bStateSave": false,
					"bAutoWidth": false,
					"bScrollAutoCss": true,
					"bProcessing": true,
					"bRetrieve": true,
					"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
					"sScrollXInner": "110%",
					"fnInitComplete": function() {
						this.css("visibility", "visible");
					},
					paging: true,
					lengthChange: true,
					searching: true,
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
				});
			});
			function obtener_fecha_subfuncion(cuanto)
			{   "use strict";
				var today = new Date();
				var dd = today.getDate() + cuanto;
				var mm = today.getMonth() + 1; //January is 0!

				var yyyy = today.getFullYear();
				if(dd<10){
					dd='0'+dd;
				}
				if(mm<10){
					mm='0'+mm;
				}
				today = dd+'/'+mm+'/'+yyyy;
				return today;
			}
			function obtener_fecha(cuando)
			{   "use strict";
				if(cuando=='ayer')
				{
					return obtener_fecha_subfuncion(-1);
				}
				if(cuando=='hoy')
				{
					return obtener_fecha_subfuncion(0);
				}
				if(cuando=='mañana')
				{
					return obtener_fecha_subfuncion(1);
				}
			}
			function check_fecha(){
				"use strict";
				var checked=document.getElementById('chk_fecha').checked;
				if(!checked)
				{
					document.getElementById('txt_fecha_ini').disabled = true;
					document.getElementById('txt_fecha_ini').value = '';
					document.getElementById('txt_fecha_fin').disabled = true;
					document.getElementById('txt_fecha_fin').value = '';
				}else
				{
					document.getElementById('txt_fecha_ini').disabled = false;
					document.getElementById('txt_fecha_fin').disabled = false;
					document.getElementById('txt_fecha_ini').value = obtener_fecha('ayer');
					document.getElementById('txt_fecha_fin').value = obtener_fecha('hoy');
				}
			}
			function carga_atenciones(  )
			{   document.getElementById('resultado').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
				var fechavenc_ini = document.getElementById("txt_fecha_ini").value;
				var fechavenc_fin = document.getElementById("txt_fecha_fin").value;
				var data = new FormData();
				data.append('option', 'pay_attention');
				data.append('fechavenc_ini', fechavenc_ini);
				data.append('fechavenc_fin', fechavenc_fin);
				/*var ckb_opc_adv = document.getElementById("ckb_opc_adv").checked;
				data.append('ckb_opc_adv', ckb_opc_adv);
				if(ckb_opc_adv)
				{   data.append('id_titular', document.getElementById("txt_id_titular").value);
					data.append('cod_estudiante', document.getElementById("txt_cod_cliente").value);
					data.append('nombre_estudiante', document.getElementById("txt_nom_cliente").value);
					data.append('nombre_titular', document.getElementById("txt_nom_titular").value);
					data.append('periodo', document.getElementById("periodos").value);
					data.append('grupoEconomico', document.getElementById("cmb_grupoEconomico").value);
					data.append('nivelEconomico', document.getElementById("cmb_nivelesEconomicos").value);
					data.append('cursos', document.getElementById("curso").value);
				}*/
				var xhr = new XMLHttpRequest();
				xhr.open('POST', '../ajax_script/atenciones.php' , true);
				xhr.onreadystatechange=function(){
					if (xhr.readyState==4 && xhr.status==200)
					{	document.getElementById('resultado').innerHTML=xhr.responseText;
						$('#table_atenciones').DataTable({
							dom: 'Bfrtip',
							buttons: [ 
								{ extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
								{ extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
								{ extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
								],
							"bPaginate": true,
							"bStateSave": false,
							"bAutoWidth": false,
							"bScrollAutoCss": true,
							"bProcessing": true,
							"bRetrieve": true,
							"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
							"sScrollXInner": "110%",
							"fnInitComplete": function() {
								this.css("visibility", "visible");
							},
							paging: true,
							lengthChange: true,
							searching: true,
							language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
						});
					}
				}
				xhr.send(data);
			}
		</script>
	</body>
</html>