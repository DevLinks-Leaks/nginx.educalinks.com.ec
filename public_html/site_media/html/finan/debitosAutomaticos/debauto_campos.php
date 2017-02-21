<li class="ui-state-default" id="li_campo_{name}__{num_campo}" name="li_campo_{name}__{num_campo}"
    style='list-style-type:none;'>
    <div id="div_campo_{name}__{num_campo}" name="div_campo_{name}__{num_campo}" class="container-fluid" style="width:100%; padding-left:25px;margin-top:10px;">
        <div class="row" style="width:100%;">
            <div class="checkbox col-xxs-1" style="float:left; padding-left:5px; margin-top:10px;text-align:right;">
                <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
            </div>
            <div class="col-sm-3" style="float:left; padding-left:5px;">
                <input type="text" style="font-size:small;" class="form-control" name="cabe_{name}__{num_campo}" id="cabe_{id}__{num_campo}" placeholder="Ingrese nombre del campo" value="{descripcion}" 
                        data-placement="top"
                        title='Nombre de la cabecera del campo.' onkeypress='return validate_save_button_followed(false);'  onchange='return validate_save_button_followed(false);' 
                        onmouseover='$(this).tooltip("show")' required='required' {cabe_readonly} />
            </div>
            <div id="div_camp_{id}__{num_campo}" name="div_camp_{id}__{num_campo}" class="input-group col-sm-2" style="float:left; padding-left:5px;"
                data-placement="top"
                title='Escriba un valor si desea que el campo tenga un valor constante. Caso contrario, déjelo en blanco.'
                onmouseover='$(this).tooltip("show")'>
                <span class="input-group-addon"><small>valor</small></span>
                <input type="text" style="font-size:small;" class="form-control" name="camp_{name}__{num_campo}" id="camp_{id}__{num_campo}" 
                       placeholder="por defecto" onkeypress="return validate_save_button_followed(false);"  
					   onchange="return validate_save_button_followed(false);" value='{text_predif}' >
            </div>
            <div id="div_nmax_{id}__{num_campo}" name="div_nmax_{id}__{num_campo}" class="input-group col-sm-1" style="float:left; padding-left:5px;padding-left:5px;"
                data-placement="top"
                title="Longitud m&aacute;xima del campo. Deje en blanco, para que la longitud sea el máximo posible."
                onmouseover='$(this).tooltip("show")'>
                <input type="number" style="font-size:small;" class="form-control" name="nmax_{name}__{num_campo}" id="nmax_{id}__{num_campo}"
					   onkeypress="validate_save_button_followed(false);"
					   onchange="return validate_save_button_followed(false);"
                       min="1" max="8000" placeholder="max" value='{num_caracteres}'>
            </div>
            <div class="col-xxs-1" style="float:left; padding-left:5px; margin-top:10px;text-align:right;">
                <label>
                    <input type="checkbox" name="izqi_{name}__{num_campo}" id="izqi_{id}__{num_campo}" onclick="return cambia_check(this);"
                           onchange='return validate_save_button_followed(false);' {val_izq}>
                </label>
            </div>
            <div id="div_caiz_{id}__{num_campo}" name="div_caiz_{id}__{num_campo}" class="input-group col-sm-2" style="float:left; padding-left:5px;"
                data-placement="top"
                title='Caracter con el que se llenará la longitud maxima al lado izquierdo.'
                onmouseover='$(this).tooltip("show")'>
                <span class="input-group-addon"><small>Izq.</small></span>
                <input type="text" style="font-size:small;" class="form-control" name="caiz_{name}__{num_campo}" id="caiz_{id}__{num_campo}" 
                         {text_izq_dis} placeholder="" value="{text_izq}"
                        onkeypress='return validate_save_button_followed(false);'  onchange='return validate_save_button_followed(false);' >
            </div>
            <div class="col-xxs-1" style="float:left; padding-left:5px; margin-top:10px;text-align:right;">
                <label>
                    <input type="checkbox" name="dere_{name}__{num_campo}" id="dere_{id}__{num_campo}" onclick="return cambia_check(this);"
                           onchange='return validate_save_button_followed(false);' {val_der}>
                </label>
            </div>
            <div id="div_cade_{id}__{num_campo}" name="div_cade_{id}__{num_campo}" class="input-group col-sm-2" style="float:left; padding-left:5px;"
                    data-placement="top"
                    title='Caracter con el que se llenará la longitud maxima al lado derecho.'
                    onmouseover='$(this).tooltip("show")'>
                <span class="input-group-addon">
                    <small>Der.</small></span>
                <input type="text" style="font-size:small;" class="form-control" name="cade_{name}__{num_campo}" id="cade_{id}__{num_campo}" 
                         {text_der_dis} placeholder="" value="{text_der}"
                        onkeypress='return validate_save_button_followed(false);'  onchange='return validate_save_button_followed(false);' >
            </div>
            <div id="div_quitar_{id}__{num_campo}"  name="div_quitar_{id}__{num_campo}" 
                    style='float:left; padding-left:5px;color:red;font-size:large;' 
                    class="col-sm-1" >
                <span  class="glyphicon glyphicon-remove-circle cursorlink" id="quitar_{id}__{num_campo}" name="quitar_{id}__{num_campo}"
                       onclick='return remove_column(this);'></span>
            </div>
        </div>
    </div>    
</li>