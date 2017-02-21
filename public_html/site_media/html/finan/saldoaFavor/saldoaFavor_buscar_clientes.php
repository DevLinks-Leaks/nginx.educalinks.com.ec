<div id="frm_busquedaCliente" class="form-group" >
	<fieldset class="form-medium">
		<div class="form-group">
			<label for="exampleInputEmail1"><strong>Código de Alumno</strong></label>
			<input type="text" class="form-control" id="codalum" name="codalum" disabled="disabled" placeholder="Código">
		</div>
		<div class="form-group">
			<label for="exampleInputEmail1"><strong>Saldo a favor</strong></label>
			<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
				<a tabindex="0" data-toggle="popover" title="Monto del saldo a favor" data-content="<div style='font-size:x-small'>Ingrese aquí el monto con el que desea aperturar la cartera del cliente.</div>" data-placement='bottom'><span class='fa fa-info-circle'></span></a>
			</div>
			<div class="input-group">
				<span class="input-group-addon">$</span>
				<input type="text" class="form-control" id="valor" name="valor" placeholder="0.00">
			</div>
		</div>
	</fieldset>
    <legend>
		Búsqueda de Clientes
		<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
				<a tabindex="0" data-toggle="popover" data-placement='top' title="Clientes" data-content="<div style='font-size:x-small'>Ingrese el nombre o la cédula de identidad del alumno y luego selecciónelo, sombrenado su nombre.</div>" data-placement='bottom'><span class='fa fa-info-circle'></span></a>
			</div>
	</legend>
    <fieldset class="form-medium">
		<div id="filtrosBusqueda" class="form-inline">
			<div class="form-group">
				<select id="cmb_per_consulta_tipo_persona" name="cmb_per_consulta_tipo_persona" class='form-control input-sm'>
					<!--<option value='0'>Sin especificar</option>-->
					<option value='1'>Alumno</option>
					<!--<option value='2'>Representante</option>-->
					<!--<option value='3'>Empleado</option>-->
					<option value='4'>Cliente externo</option>
				</select>
			</div>
            <div class="form-group"> 
            	<input type="text" class="form-control input-sm" 
					name="numeroIdentificacion_busq" id="numeroIdentificacion_busq"
					placeholder="Código interno" required="required"
					onkeyup="js_saldoaFavor_busca_clientes('numeroIdentificacion','resultadoBusqueda','{ruta_html_finan}/saldoaFavor/controller.php')" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control input-sm"
					name="nombre_busq" id="nombre_busq" 
					placeholder="Nombres" required="required"
					onkeyup="js_saldoaFavor_busca_clientes('nombres','resultadoBusqueda','{ruta_html_finan}/saldoaFavor/controller.php')" />
            </div>
        </div>
		<div id="resultadoBusqueda" style='background-color:#e5e5e5;height:300px;overflow-y:scroll;'>
			{tablaCliente}
		</div>
    </fieldset>
</div>