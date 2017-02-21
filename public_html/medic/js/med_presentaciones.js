/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function change_baja_inventario(url,pres_codigo,pres_baja_automatica){
    //document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="images/ajax-loader.gif"/></div>';
    var data = new FormData();
    data.append('option','cambia_baja_inventario');
    data.append('pres_codigo',pres_codigo);
    data.append('pres_baja_automatica',pres_baja_automatica);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
        }
    }
    xhr_tick_ok.send(data);
}

function edit_presentacion(div,url,pres_codigo,pres_descripcion){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('option','edit_presentacion');
    data.append('pres_codigo',pres_codigo);
    data.append('pres_descripcion',pres_descripcion);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
            var table= $('#table_presentaciones').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
            table.columns.adjust().draw();
        }
    }
    xhr_tick_ok.send(data);
}
function delete_presentacion(div,url,pres_codigo){
    if(confirm("¿Estás seguro de eliminar la presentación?")){
        document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
        var data = new FormData();
        data.append('option','delete_presentacion');
        data.append('pres_codigo',pres_codigo);
        var xhr_tick_ok = new XMLHttpRequest();
        xhr_tick_ok.open('POST', url , true);
        xhr_tick_ok.onreadystatechange=function(){
            if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
                document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
                var table= $('#table_presentaciones').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
                table.columns.adjust().draw();
            }
        }
        xhr_tick_ok.send(data);
    }
}


