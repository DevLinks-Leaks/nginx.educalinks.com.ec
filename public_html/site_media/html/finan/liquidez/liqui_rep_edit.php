<!-- Modal Reporte-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog-900">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Visor de Reporte de Liquidez</h4>
      </div>
      <div class="modal-body" >
        <div id="modal-liquidezbody">
       
         ...
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
     
      </div>
    </div>
  </div>
</div>
<!-- Modal Reporte-->

<div id="genera_liquidez" class="form-medium" >
    <div class="form-group">
    	
    	{tabla_bancos}
	</div>
   
	<div class="form-group">
    
    	<label for="sumbancos">Suma Total de Bancos  </label>
        <div class="input-group">
        <span class="input-group-addon">$</span>
    	<input type="text" class="form-control" name="sumbancos" disabled="disabled" id="sumbancos" placeholder="0.00" required="required">
	</div>
    </div>
    <div class="form-group">
      	<label for="cheqgiradonocobrado">Cheques girados y no cobrados </label>
        <div class="input-group">
        <span class="input-group-addon">$</span>
    	<input type="text" class="form-control" name="cheqgiradonocobrado" id="cheqgiradonocobrado" placeholder="0.00" required="required">
	</div>
    </div>
     <div class="form-group">
       	<label for="depositosdia">Depositos del día</label>
        <div class="input-group">
        <span class="input-group-addon">$</span>
    	<input type="text" class="form-control" name="depositosdia" id="depositosdia" placeholder="0.00" required="required">
	</div>
    </div>
    <h2>Cuentas por Cobrar</h2>
    <hr/>
 
       <div class="form-group">
       <label for="becasdescuentos">Becas y Descuentos</label>
        <div class="input-group">
        <span class="input-group-addon">$</span>
    	<input type="text" class="form-control" name="becasdescuentos" onkeyup="SubtotalcuentasxCobrar()" id="becasdescuentos" placeholder="0.00" value="{becas}" required="required">
	</div>
    </div>
       <div class="form-group">
       	<label for="tarjetas">Tarjetas</label>
        <div class="input-group">
        <span class="input-group-addon">$</span>
    	<input type="text" class="form-control" name="tarjetas" id="tarjetas"onkeyup="SubtotalcuentasxCobrar()" placeholder="0.00" required="required">
	</div>
    </div>
      <div class="form-group">
    	<label for="chequesposfechado">Cheques pos Fechado</label>
        <div class="input-group">
        <span class="input-group-addon">$</span> 
    	<input type="text" class="form-control" name="chequesposfechado" onkeyup="SubtotalcuentasxCobrar()"id="chequesposfechado" placeholder="0.00" required="required">
	</div>
    </div>
     <div class="form-group">
     	<label for="subtotal">Sub Total</label>
        <div class="input-group">
        <span class="input-group-addon">$</span> 
    	<input type="text" class="form-control" name="subtotal"  disabled="disabled" id="subtotal" placeholder="0.00" required="required">
	</div>
    </div>
    <h2>Cuentas por Pagar</h2>
      <hr/>
        <div class="form-group">        
    	<label for="rol1quincena">Rol Neto Primera Quincena</label>
        <div class="input-group">
        <span class="input-group-addon">$</span> 
    	<input type="text" class="form-control" name="rol1quincena"  onkeyup="SumarCuentasxPagar()"  id="rol1quincena" placeholder="0.00" required="required">
	</div>
    </div>
     <div class="form-group"> 
      	<label for="Desc1quincena">Descuentos a Empleados Primera Quincena</label>
        <div class="input-group">
        <span class="input-group-addon">$</span>
    	<input type="text" class="form-control" name="Desc1quincena"  onkeyup="SumarCuentasxPagar()"  id="Desc1quincena" placeholder="0.00" required="required">
	</div>
    </div>
       <div class="form-group"> 
    	<label for="rolneto2quincena">Rol Neto Segunda Quincena</label>
        <div class="input-group">
        <span class="input-group-addon">$</span>  
    	<input type="text" class="form-control" name="rolneto2quincena"   onkeyup="SumarCuentasxPagar()"  id="rolneto2quincena" placeholder="0.00" required="required">
	</div>
    </div>
     <div class="form-group">   
    	<label for="Desc2quincena">Descuentos a Empleados Segunda Quincena</label>
        <div class="input-group">
        <span class="input-group-addon">$</span>  
    	<input type="text" class="form-control" name="Desc2quincena"  onkeyup="SumarCuentasxPagar()"  id="Desc2quincena" placeholder="0.00" required="required">
	</div>
    </div>
         <div class="form-group"> 
         	<label for="IESS">IESS 9.35% + 12.15 PATRONAL</label>
            <div class="input-group">
        <span class="input-group-addon">$</span>  
    	<input type="text" class="form-control" name="IESS"  onkeyup="SumarCuentasxPagar()"  id="IESS" placeholder="0.00" required="required">
	</div>
    </div>
        <div class="form-group">
      	<label for="SRI">S.R.I</label>
        <div class="input-group">
        <span class="input-group-addon">$</span>  
    	<input type="text" class="form-control" name="SRI"  onkeyup="SumarCuentasxPagar()"  id="SRI" placeholder="0.00" required="required">
	</div>
    </div>
     <div class="form-group">
     	<label for="bonificacion">Bonificacion</label>
        <div class="input-group">
        <span class="input-group-addon">$</span> 
    	<input type="text" class="form-control" name="bonificacion"  onkeyup="SumarCuentasxPagar()"  id="bonificacion" placeholder="0.00" required="required">
	</div>
    </div>
       <div class="form-group">
   	<label for="dividendoInversionista">Dividendo Inversionista</label>
      <div class="input-group">
        <span class="input-group-addon">$</span>  
    	<input type="text" class="form-control" name="dividendoInversionista"  onkeyup="SumarCuentasxPagar()"  id="dividendoInversionista" placeholder="0.00" required="required">
	</div>
    </div>
     <div class="form-group">
    <label for="prestamos">Prestamos</label>
    <div class="input-group">
        <span class="input-group-addon">$</span>
    	<input type="text" class="form-control" name="prestamos"  onkeyup="SumarCuentasxPagar()"  id="prestamos" placeholder="0.00" required="required">
	</div>
    </div>
    <div class="form-group">
    
    	<label for="liqui_proveedores">Proveedores</label>
        <div class="input-group">
        <span class="input-group-addon">$</span>
    	<input type="text" class="form-control" name="liqui_proveedores"  onkeyup="SumarCuentasxPagar()"  id="liqui_proveedores" placeholder="0.00" required="required">
	</div>
     </div>
     <div class="form-group">
     	<label for="sumacuentasxpagar">Cuentas por Pagar</label>
        <div class="input-group">
        <span class="input-group-addon">$</span>
    	<input type="text" class="form-control" name="sumacuentasxpagar"  disabled="disabled" id="sumacuentasxpagar" placeholder="0.00" required="required">
	</div>
  </div>
    <button type="button" style="float:right" class="btn btn-primary" aria-hidden="true" data-toggle="modal"  data-target="#modal_edit" 
	onclick=" crearhtml('modal-liquidezbody','{ruta_html_finan}/liquidez/controller.php','print_liquidez')">
	<span class="glyphicon glyphicon-print"></span>&nbsp;Imprimir</button>
</div>
