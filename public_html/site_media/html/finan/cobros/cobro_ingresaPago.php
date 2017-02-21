<div id="frm_ingresoPago" class="form-group" >
    <div class="alert {tipo_mensaje}" data-resultado="{resultado}" id="mensajeResultado" >
       <p>{mensaje}</p>
       <br/>
       <p>Los documentos generados son: </p>
       <div> {listBills} </div>
	</div>
   	<input type='hidden' id='fc_generada' name='fc_generada' value='{codigoFC}'/>
	<input type='hidden' id='codigopago' name='codigopago' value='{codigopago}'/>
    <div id='div_detalle_sri'>
		{detalle_sri} 
    </div>
</div>