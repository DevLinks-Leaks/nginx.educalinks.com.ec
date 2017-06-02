<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php include ('template/header.php');?>
        <?php $Menu=3;include("template/menu.php");?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Clases</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-book"></i></a></li>
                    <li class="active">Clases</li>
                </ol>
            </section>
            <section class="content" id="mainPanel">
                <div id="information">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <div class="col-lg-6 col-sm-6 input-group input-group-sm">
                                    <span id="span_balance_reason" name="span_balance_reason" class="input-group-addon">Ver</span>
                                    <select id="cmb_mostrarMat" name="cmb_mostrarMat" class="form-control" onChange="js_clases_get_clases_main();">
                                        <option value="">- Seleccione una materia -</option>
                                        <?php 
                                            $params_mate = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
                                            $sql_mate="{call prof_curs_para_mate_view(?,?)}";
                                            $stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
                                            while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate))
                                            {
                                                if ($row_curs_mate_view['curs_para_mate_agen']==1) 
                                                {
                                                    echo '<option value="'.$row_curs_mate_view['curs_para_mate_codi'].'"
                                                            data-curs_para_mate_prof_codi="'.$row_curs_mate_view['curs_para_mate_prof_codi'].'"
                                                            data-curs_para_codi="'.$row_curs_mate_view['curs_para_codi'].'"
                                                            >'.
                                                        $row_curs_mate_view["curs_deta"]." ".$row_curs_mate_view["para_deta"]." - ".$row_curs_mate_view["mate_deta"].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body" id='clases_main_body' name='clases_main_body'>
                        </div>
                    </div>
                </div>
            </section>
            <form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
                <?php include("template/rutas.php");?>
            </form>
        </div>
        <?php include("template/footer.php");?>
        <!-- =============================== -->
        <input name="mens_de"          type="hidden" id="mens_de"         value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
        <input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
        <?php include("template/scripts.php");?>
        <script src="js/upload.js"></script>
        <script type="text/javascript" charset="utf-8">
            $( document ).ready(function() {
            });
            function js_clases_select( value )
            {   var num_materias = document.getElementById( "hd_num_materias" ).value;
                var i = 0;
                for (i = 0; i < num_materias; i++ )
                {   document.getElementsByName( "mate_h_" + i )[0].style.display ='none';
                }
                document.getElementById( "mate_h_" + value ).style.display ='inline';
                //$.growl({ title: "Educalinks informa", message: "Materia seleccionada" });
            }
            function MostrarInfoAlumno (alum_curs_para_codi)
            {
                var xmlhttp;
        
                if (window.XMLHttpRequest)
                {
                    xmlhttp = new XMLHttpRequest ();
                }
                else
                {
                    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
                }
        
                xmlhttp.onreadystatechange = function ()
                {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    {
                        document.getElementById('alum_info_div').innerHTML=xmlhttp.responseText;
                    }
                }
        
                xmlhttp.open("GET", "info_alum.php?alum_curs_para_codi="+alum_curs_para_codi, true);
                xmlhttp.send();
            }
            function activa_subida()
            {
                document.getElementById('boton_subir').disabled=false;
                document.getElementById('archivo').disabled=false;
            }
            
            function carga_archivos(div,url,curs_para_mate_prof_codi)
            {
                document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
                var data = new FormData();
                data.append('curs_para_mate_prof_codi', curs_para_mate_prof_codi);
                data.append('opc', 'mater_view');
                    
                var xhr = new XMLHttpRequest();
                xhr.open('POST', url , true);
                xhr.onreadystatechange=function(){
                    if (xhr.readyState==4 && xhr.status==200){
                        document.getElementById(div).innerHTML=xhr.responseText;
                    } 
                }
                xhr.send(data);
            }
            function elimina_materiales(div,url,mater_codi,curs_para_mate_prof_codi)
            {   if( confirm( "¿Está seguro que desea eliminar éste material?" ) )
                {
                    document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
                    var data = new FormData();
                    data.append('mater_codi', mater_codi);
                    data.append('opc', 'mater_del');
                        
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', url , true);
                    xhr.onreadystatechange=function(){
                        if (xhr.readyState==4 && xhr.status==200){
                            document.getElementById(div).innerHTML=xhr.responseText;
                            carga_archivos('div_materiales','script_materiales.php',$("#curs_para_mate_prof_codi").val());
                        } 
                    }
                    xhr.send(data);
                }
            }
            function bloquea_subida(){
                document.getElementById('boton_subir').disabled=true;
                document.getElementById('archivo').disabled=true;
            }
            function subirArchivos() {
                if(document.getElementById("archivo").value!=""){
                    bloquea_subida();
                    $("#archivo").upload('subir_archivo.php',
                    {
                        mater_titu: $("#mater_titu").val(),
                        mater_deta: $("#mater_deta").val(),
                        curs_para_mate_prof_codi: $("#curs_para_mate_prof_codi").val()
                    },
                    function(respuesta) {
                        //Subida finalizada.
                        $("#barra_de_progreso").val(0);
                        if (respuesta === 1) {
                            activa_subida();
                            $.growl.notice({ title: "Informacion: ",message: "El archivo ha sido subido correctamente" });
                            console.log("pasa aqui");
                            //mostrarRespuesta('El archivo ha sido subido correctamente.', true);
                            $("#nombre_archivo, #archivo").val('');
                            carga_archivos('div_materiales','script_materiales.php',$("#curs_para_mate_prof_codi").val());
                        } else {
                            activa_subida();
                            if (respuesta === 0){
                            $.growl.error({ title: "Información: ",message: "El archivo NO se ha podido subir" });
                            }
                            else{
                            $.growl.warning({ title: "Información: ",message: "Archivos con extensión .exe no son permitidos" });
                            }
                            //mostrarRespuesta('El archivo NO se ha podido subir.', false);
                        }
                        //mostrarArchivos();
                    }, function(progreso, valor) {
                        //Barra de progreso.
                        $("#barra_de_progreso").val(valor);
                    });
                }else{
                    alert("Seleccione el archivo que desea subir primero.");
                }
            }
            function js_clases_get_clases_main()
            {   document.getElementById( 'clases_main_body' ).innerHTML='<div id="div_ini_wait" align="center" style="height:100%;"><br><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div>';
                var curs_para_mate_prof_codi = $('#cmb_mostrarMat').find(':selected').data('curs_para_mate_prof_codi');
                var curs_para_mate_codi = document.getElementById('cmb_mostrarMat').value;
                var curs_para_codi = $('#cmb_mostrarMat').find(':selected').data('curs_para_codi');
                
                if( curs_para_mate_codi != '' )
                {   var data = new FormData();
                    data.append('curs_para_mate_prof_codi', curs_para_mate_prof_codi );
                    data.append('curs_para_mate_codi', curs_para_mate_codi );
                    data.append('curs_para_codi', curs_para_codi );
                    
                    var xhr = new XMLHttpRequest();
                    xhr.open( 'POST', 'clases_main.php' , true);
                    xhr.onreadystatechange=function()
                    {   if (xhr.readyState === 4 && xhr.status === 200)
                        {   document.getElementById( 'clases_main_body' ).innerHTML = xhr.responseText;
                            $("#boton_subir").on('click', function() {
                                subirArchivos();
                            });
                        } 
                    };
                    xhr.send(data);
                }
                else
                {   document.getElementById( 'clases_main_body' ).innerHTML = "<span class='fa fa-alert'></span>Por favor, seleccione un curso para continuar.";
                }
            }
        </script>
    </body>
</html>

