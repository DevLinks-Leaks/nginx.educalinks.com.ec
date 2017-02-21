<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body role="document">
    <?php $active="ficha_datos";include("template/navbar.php");
	include("clases/Fichas.php");
    $fichas = new Fichas();?>
    <div class="container-fluid theme-showcase" role="main">
    <!-- =============================== -->
    	<div class="row">
            <div class="col-md-8 bottom_10">
                <div class="input-group">
                    <span class="input-group-addon" id="nombre_ficha_addon">Ficha:</span>
                    <select class="form-control" id="fic_codigo" name="fic_codigo" onChange="carga_preguntas('preguntas_div','ajax_script/fichas.php',this.value)">
                    	<option value="">Seleccione...</option>
                        <?php 
                        $fichas->get_all_fichas_selectFormat();
                        foreach($fichas->rows as $ficha){
						?>
                        <option value="<?=$ficha['fic_codigo'];?>"><?=$ficha['fic_nombre'];?></option>
                        <?php
						}
						?>
                    </select>
                </div>
            </div>
        </div>
        <div id="preguntas_div">
        	
        </div>
    </div><!-- /container -->
    <?php include("template/scripts.php");?>
    <script src="js/med_fichas.js"></script>
    <script type="text/javascript">  
        $(document).ready(function(){  
			
        });
    </script>
  </body>
</html>