<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
	</head> 
    <body class="hold-transition skin-blue sidebar-mini">
		<?php  
			 $titulo_pagina = "";
			if(isset($_POST['alum_codi']))
				$titulo_pagina = "Edición de Alumno ";
			else if(isset($_GET['alum_codi']))
				$titulo_pagina = "Edición de Alumno ";
			else
				$titulo_pagina = "Inscripcion";
		?>
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=101; include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1><?php echo $titulo_pagina; ?>
						<small>Formulario de datos del alumno</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-clipboard"></i></a></li>
						<li class="active"><?php echo $titulo_pagina; ?></li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $titulo_pagina; ?>
								</h3>
							</div>
							<div class="panel-body">
								<?php include("alumnos_add_script.php");?>
							</div>
						</div>
							
					</div><!-- Information -->
				</section>
				<?php include("template/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("template/rutas.php");?>
				<?php include("template/scripts.php");?>
			</form>
			<?php include("template/footer.php");?>
		</div>
		<!-- =============================== -->
		<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		
		<!-- InstanceBeginEditable name="EditRegion4" -->
		<script type="text/javascript" charset="utf-8">
			$("#alum_fech_naci").datepicker();
			$("#alum_resp_form_fech_vcto").datepicker();
		  $("#repr_fech_promoc").datepicker();
		  shortcut.add("Shift+I", function() {
			  $('#btn_inscribir').trigger("click");
		  });
		  shortcut.add("Shift+G", function() {
			  $('#btn_guardar').trigger("click");
		  },{'disable_in_input':true});
		  shortcut.add("Shift+F", function() {
			  $('#btn_repre').trigger("click");
		  },{'disable_in_input':true});
		</script>
	</body>
</html>
    
    
