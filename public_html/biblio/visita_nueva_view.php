<?php 

	session_start();	 
	include ('../framework/dbconf.php');  


	 
?>

 
     
    <div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="panel panel-default">
    <div class="panel-heading"><h4>Nueva Visita</h4> </div>
  <div class="panel-body">
 

    <div class="row">
        <div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
            <div class="input-group">
                <span class="input-group-addon">Cod.:</span>
                <input type="text" class="form-control" id="usua_codi" name="usua_codi" placeholder="Usuario"  readonly>
            </div>
        </div>
        <div class="col-md-5 col-xs-12 col-sm-6 bottom_10">
            <div class="input-group">
                <span class="input-group-addon"  >Nombre:</span>
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
    <div class="panel-heading">Datos de Visita:</div>
  	<div class="panel-body">
    	<div class="row">
        	<div class="col-md-4 col-xs-12 col-sm-6 bottom_10">            	 
                <div class="input-group">
                	<span class="input-group-addon" >Fecha:</span>
               		<input name="visi_fech" type="text" class="form-control" id="visi_fech" placeholder="Inicio" value="<?=  date("d/m/Y"); ?>" >
            	</div>
           	</div>
            <div class="col-md-4 col-xs-12 col-sm-6 bottom_10">            	 
                <div class="input-group">
                	<span class="input-group-addon" >Tipo:</span>
               		 <?php 
                        $params = array();
                        $sql="{call lib_visi_tipo_view()}";
                        $lib_visi_tipo_view= sqlsrv_query($conn, $sql, $params);  
                        $cc = 0;

                    ?>
                    <select class="form-control"  id="visi_tipo_codi" >
                        <?php  while ($row_lib_visi_tipo_view = sqlsrv_fetch_array($lib_visi_tipo_view)) {?> 
                            <option  value="<?= $row_lib_visi_tipo_view['visi_tipo_codi']; ?>"   >
                                  <?= $row_lib_visi_tipo_view['visi_tipo_deta']; ?>
                            </option> 
                        <?php  } ?>
                    </select>
            	</div>
           	</div>
         
            <div class="col-md-12 col-xs-12 col-sm-12 bottom_10">&nbsp;</div>
        	<div class="col-md-12 col-xs-12 col-sm-12 bottom_10">
            	 <div class="input-group">
                	<span class="input-group-addon" >Observaccion:</span>
               		<textarea name="visi_obse" rows="3" class="form-control" id="visi_obse"></textarea>
            	</div>
        	</div>
    	</div>
      </div>
   </div>   
    
     <div class="panel panel-default" style="margin-top:10px;" >
          
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12 bottom_10 text-right">
                        <button class="btn btn-primary"  onclick="boton_visita();" >
                            <span class="glyphicon glyphicon-save"></span> Guardar Visita
                        </button>
                    </div>    	 
                </div>
            </div>   
        </div>    
    <!-- =============================== -->
</div><!-- /container -->        
 
 
 