 
 
     
    <div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="panel panel-default">
    <div class="panel-heading">Buscar usuario:  </div>
  <div class="panel-body">
 

    <div class="row">
        <div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
            <div class="input-group">
                <span class="input-group-addon" id="alum_codi_addon">Cod.:</span>
                <input type="text" class="form-control" id="usua_codi" name="usua_codi" placeholder="Usuario"  readonly>
            </div>
        </div>
        <div class="col-md-5 col-xs-12 col-sm-6 bottom_10">
            <div class="input-group">
                <span class="input-group-addon" id="alum_nombre_addon">Nombre:</span>
                <input type="text" class="form-control" id="usua_nomb" name="usua_nomb" placeholder="Nombre de Usuario"  readonly>
            </div>
        </div>
        <div class="col-md-2 col-xs-12 col-sm-6 bottom_10">
            <div class="input-group">
                
                <input type="text" class="form-control" id="usua_tipo_deta" name="usua_tipo_deta" placeholder="Tipo de Usuarios. Ej: Alumno"   readonly>
                <input name="usua_tipo_codi" type="hidden" class="form-control" id="usua_tipo_codi"   >
            </div>
        </div>
        <div class="col-md-1 col-xs-12 col-sm-6 bottom_10">
            <button class="btn btn-info" data-toggle="modal" data-target="#modal_usuarios"><span class="glyphicon glyphicon-search"></span> Buscar</button>
        </div>
    </div>
      </div>
</div>



   <div class="panel panel-default">
    <div class="panel-heading">Buscar Libro:</div>
  	<div class="panel-body">
    	<div class="row">
        	<div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
            	<div class="input-group">
                	<span class="input-group-addon" id="alum_curso_addon">Cod. Ejemplar:</span>
                    <input type="text" class="form-control" id="libr_ejem_codi" name="libr_ejem_codi" placeholder="Codigo de Ejemplar"   readonly>
               	
            	</div>
        	</div>
            <div class="col-md-7 col-xs-12 col-sm-6 bottom_10">
                <div class="input-group">
                    <span class="input-group-addon" id="alum_curso_addon">Titulo de Libro:</span>
                    <input type="text" class="form-control" id="libr_titu" name="libr_titu" placeholder="titulo de Libro"   readonly>
              </div>
       	  </div>
        <div class="col-md-2 col-xs-12 col-sm-6 bottom_10">
            <button class="btn btn-info" data-toggle="modal" data-target="#modal_ejemplares"><span class="glyphicon glyphicon-search"></span> Buscar</button>
        </div>
    	</div>
      </div>
   </div>   
   
    <div class="panel panel-default">
    <div class="panel-heading">Datos de Prestamo:</div>
  	<div class="panel-body">
    	<div class="row">
        	<div class="col-md-4 col-xs-12 col-sm-6 bottom_10">            	 
                <div class="input-group">
                	<span class="input-group-addon" >Prestamo:</span>
               		<input name="pres_fech_inic" type="text" class="form-control" id="pres_fech_inic" placeholder="Inicio">
            	</div>
           	</div>
         
            <div class="col-md-12 col-xs-12 col-sm-12 bottom_10">&nbsp;</div>
        	<div class="col-md-12 col-xs-12 col-sm-12 bottom_10">
            	 <div class="input-group">
                	<span class="input-group-addon" >Observaccion:</span>
               		<textarea name="pres_obse_inic" rows="3" class="form-control" id="pres_obse_inic"></textarea>
            	</div>
        	</div>
    	</div>
      </div>
   </div>   
    
     <div class="panel panel-default" style="margin-top:10px;" >
          
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12 bottom_10 text-right">
                        <button class="btn btn-primary"  onclick="boton_prestar();" >
                            <span class="glyphicon glyphicon-save"></span> Guardar Prestamo
                        </button>
                    </div>    	 
                </div>
            </div>   
        </div>    
    <!-- =============================== -->
</div><!-- /container -->        
 
 
 