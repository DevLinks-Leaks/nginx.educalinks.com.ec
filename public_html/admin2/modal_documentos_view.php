<?php

	if (isset($_POST["alum_codi"])){$alum_codi = $_POST["alum_codi"];}else{	$alum_codi = 0;}
	if (isset($_POST["alum_curs_para_codi"])){$alum_curs_para_codi = $_POST["alum_curs_para_codi"];}else{	$alum_curs_para_codi = 0;}
?>
<div class="col-md-12" style='font-size:small;'>
	<table class="table table-striped" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td width="85%" >
				<h4>Convenio de matrícula</h4>
			</td>
			<td >
				<a class="btn btn-info" onmouseover="$(this).tooltip('show');" title="El alumno debe estar registrado en un curso" <?=($alum_curs_para_codi==0 ? 'disabled': '')?> onclick="window.open('reportes_generales/contrato_<?= $_SESSION['directorio'] ?>_pdf.php?alum_curs_para_codi=<?=$alum_curs_para_codi?>','_blank')">
					<span class='fa fa-download'></span> Descargar
				</a>
			</td>
		</tr>
		<tr>
			<td width="85%" >
				<h4>Pagaré</h4>
			</td>
			<td >
				<a class="btn btn-info" onmouseover="$(this).tooltip('show');" title="El alumno debe estar registrado en un curso" <?=($alum_curs_para_codi==0 ? 'disabled': '')?> onclick="window.open('reportes_generales/pagare_<?= $_SESSION['directorio'] ?>_pdf.php?alum_curs_para_codi=<?=$alum_curs_para_codi?>','_blank')"><span class='fa fa-download'></span> Descargar</a>
			</td>
		</tr>
		<tr>
			<td width="85%" >
				<h4>Solicitud de matrícula </h4>
				<input type="hidden" id="alum_codi" value="" />
			</td>
			<td >
				<a class="btn btn-info" onmouseover="$(this).tooltip('show');" title="El alumno debe estar registrado en un curso" <?=($alum_curs_para_codi==0 ? 'disabled': '')?> onclick="window.open('reportes_generales/soli_matr_<?= $_SESSION['directorio'] ?>_pdf.php?alum_codi=<?=$alum_codi?>&peri_codi=<?=$_SESSION["peri_codi"]?>','_blank')"><span class='fa fa-download'></span> Descargar</a>
			</td>
		</tr>
		<tr>
			<td width="85%" >
				<h4>Ficha de datos</h4>
			</td>
			<td >
				<a class="btn btn-info" onclick="window.open('reportes_generales/ficha_estudiantil_pdf.php?alum_codi=<?=$alum_codi?>','_blank')"><span class='fa fa-download'></span> Descargar</a>
			</td>
		</tr>
		<tr>
			<td width="85%" >
				<h4>Ficha de matrícula </h4>
			</td>
			<td >
				<?php 
					if($_SESSION['directorio']=='liceopanamericano' or $_SESSION['directorio']=='liceopanamericanosur'){

				?>
				<a class="btn btn-info" onmouseover="$(this).tooltip('show');" title="El alumno debe estar registrado en un curso" <?=($alum_curs_para_codi==0 ? 'disabled': '')?> onclick="window.open('reportes_generales/ficha_matricula_<?= $_SESSION['directorio'] ?>_pdf.php?alum_curs_para_codi=<?=$alum_curs_para_codi?>','_blank')"><span class='fa fa-download'></span> Descargar</a>
				<?php 
				}else{
				?>
				<a class="btn btn-info" onmouseover="$(this).tooltip('show');" title="El alumno debe estar registrado en un curso" <?=($alum_curs_para_codi==0 ? 'disabled': '')?> onclick="window.open('reportes_generales/ficha_matricula_pdf.php?alum_curs_para_codi=<?=$alum_curs_para_codi?>','_blank')"><span class='fa fa-download'></span> Descargar</a>
				<?php
					}
				?>
			</td>
		</tr>
		<tr>
			<td width="85%" >
				<h4>Carta de compromiso </h4>
			</td>
			<td >
				<a class="btn btn-info" onmouseover="$(this).tooltip('show');" title="El alumno debe estar registrado en un curso" <?=($alum_curs_para_codi==0 ? 'disabled': '')?> onclick="window.open('reportes_generales/carta_compromiso_pdf.php?alum_curs_para_codi=<?=$alum_curs_para_codi?>','_blank')"><span class='fa fa-download'></span> Descargar</a>
			</td>
		</tr>
		<tr>
			<td width="85%" >
				<h4>Autorización de fotos </h4>
			</td>
			<td >
				<a class="btn btn-info" onmouseover="$(this).tooltip('show');" title="El alumno debe estar registrado en un curso" <?=($alum_curs_para_codi==0 ? 'disabled': '')?> onclick="window.open('reportes_generales/autorizacion_fotos_pdf.php?alum_curs_para_codi=<?=$alum_curs_para_codi?>','_blank')"><span class='fa fa-download'></span> Descargar</a>
			</td>
		</tr>
		<tr>
			<td width="85%" >
				<h4>Autorización de débito</h4> 
			</td>
			<td >
				<a class="btn btn-info" onmouseover="$(this).tooltip('show');" title="El alumno debe estar registrado en un curso" <?=($alum_curs_para_codi==0 ? 'disabled': '')?> onclick="window.open('reportes_generales/debito_pdf.php?alum_curs_para_codi=<?=$alum_curs_para_codi?>','_blank')"><span class='fa fa-download'></span> Descargar</a>
			</td>
			
		</tr>
		<tr>
			<td width="85%" >
				<h4>Compromiso de rendimiento académico <h4>
				<input type="hidden" id="alum_curs_para_codi" value="" />
			</td>
			<td >
				<a class="btn btn-info" onmouseover="$(this).tooltip('show');" title="El alumno debe estar registrado en un curso" <?=($alum_curs_para_codi==0 ? 'disabled': '')?> onclick="window.open('reportes_generales/compromiso_rendimiento_pdf.php?alum_curs_para_codi=<?=$alum_curs_para_codi?>','_blank')">
					<span class='fa fa-download'></span> Descargar
				</a>
			</td>
			
		</tr>
		<tr>
			<td width="85%" >
				<h4>Compromiso de comportamiento </h4>
				<input type="hidden" id="alum_curs_para_codi" value="" />
			</td>
			<td >
				<a class="btn btn-info" onmouseover="$(this).tooltip('show');" title="El alumno debe estar registrado en un curso" <?=($alum_curs_para_codi==0 ? 'disabled': '')?> onclick="window.open('reportes_generales/compromiso_comportamiento_pdf.php?alum_curs_para_codi=<?=$alum_curs_para_codi?>','_blank')">
					<span class='fa fa-download'></span> Descargar
				</a>
			</td>
			
		</tr>
	</table>
</div>