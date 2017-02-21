<div id="frm_busquedaCliente" class="form-group" >
    
    <fieldset>
    <legend>Filtros</legend>
        <div id="filtrosBusqueda" class="form-inline">
            <div class="form-group"> 
            	<input type="text" class="form-control" name="numeroIdentificacion_busq" id="numeroIdentificacion_busq" placeholder="Código del Cliente" required="required" onkeyup="busca_clientes('numeroIdentificacion','resultadoBusqueda','{ruta_html_finan}/notaCredito/controller.php')" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control" name="nombre_busq" id="nombre_busq" placeholder="Nombres" required="required" onkeyup="busca_clientes('nombres','resultadoBusqueda','{ruta_html_finan}/notaCredito/controller.php')" />
            </div>
        </div>
    </fieldset>
    
    <fieldset>
    <legend>Resultados</legend>
    <div id="resultadoBusqueda">
		{tablaCliente}
	</div>
    </fieldset>
</div>