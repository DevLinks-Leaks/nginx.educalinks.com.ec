<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?=$ficha['fic_cam_codigo'];?>" aria-expanded="true" aria-controls="<?=$ficha['fic_cam_codigo'];?>">
            	<?=$ficha['fic_cam_pregunta'];?>
            </a>
        </h4>
    </div>
    <div id="<?=$ficha['fic_cam_codigo'];?>" class="panel-collapse collapse <?= $i==1? 'in':'';?>" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
        	<?php 
				$respuestas->get_all_fichas_campos_respuestas($ficha['fic_cam_codigo']);
				switch($ficha['fic_cam_tipo']){
					case 'texto':
						echo "<div class='row'><div class='col-md-6'><input value='' placeholder='Ingrese su respuesta' class='form-control'></div></div>";
					break;
					case 'text_area':
						echo "<div class='row'><div class='col-md-6'><textarea placeholder='Ingrese su respuesta' class='form-control'></textarea></div></div>";
					break;
					case 'select':
						echo "<div class='row'><div class='col-md-6'><select class='form-control'>";
						foreach($respuestas->rows as $respuesta){
							echo "<option value='".$respuesta['fic_cam_resp_respuesta']."'>".$respuesta['fic_cam_resp_respuesta']."</option>";
						}
						echo "</select></div></div>";
					break;
					case 'check':	
						foreach($respuestas->rows as $respuesta){
							echo "<form class='form-inline'><div class='row'><div class='col-md-6'><div class='checkbox'><label>".$respuesta['fic_cam_resp_respuesta'];
							echo " <input type='checkbox' class='form-control' value='".$respuesta['fic_cam_resp_respuesta']."'></label></div></div></div></form>";
						}
					break;
					case 'select_text':
						echo "<div class='row'><div class='col-md-6'><select class='form-control'>";
						foreach($respuestas->rows as $respuesta){
							echo "<option value='".$respuesta['fic_cam_resp_respuesta']."'>".$respuesta['fic_cam_resp_respuesta']."</option>";
						}
						echo "<option value=''>Otro</option></select></div><div class='col-md-6'><input value='' placeholder='Ingrese otra opción' class='form-control'></div></div>";
					break;
					case 'check_text':
						echo "<div class='row'><div class='col-md-1'>";
						echo " <input type='checkbox' class='form-control'></div>";
						echo "<div class='col-md-3'>";
						echo " <input type='text' class='form-control' placeholder='Ingrese el detalle de su respuesta' value='' /></div></div>";
					break;
				}
			?>
        </div>
    </div>
</div>