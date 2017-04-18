<!-- Modal  MATERIA MODIFICACION-->
<input id="a_area_codi" name="a_area_codi" type="hidden" value="">
<div class="modal fade" id="area_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Área <label id="m_top_matemodal" ></label></h4>
      </div>
      <div class="modal-body">
      <div id="div_area_edi"> 
       	<table width="100%">
    		<tr>
                <td width="15%">
                	Nombre: 
    			</td>
                <td width="85%">
                	<input 
                    	id="a_area_deta" 
                        name="a_area_deta" 
                        type="text" 
                        value="" 
                        style="width: 100%; margin-top: 10px;">
    			</td>
    		</tr>
		</table>
      </div>
	  <div class="form_element">&nbsp;</div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary"  onClick="area_upd()">
        	Aceptar
        </button>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button type="button" class="btn btn-default" data-dismiss="modal">
        	Cerrar
		</button>
      </div>
    </div>
  </div>
</div>