/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function edit_medicamento(div,url,med_codigo,med_descripcion){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('option','edit_medicamento');
    data.append('med_codigo',med_codigo);
    data.append('med_descripcion',med_descripcion);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
            var table= $('#table_medicinas').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
            table.columns.adjust().draw();
        }
    }
    xhr_tick_ok.send(data);
}
function egreso_medicamento(div,url,med_codigo,med_stock){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('option','egreso_medicamento');
    data.append('med_codigo',med_codigo);
    data.append('med_stock',med_stock);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
            var table= $('#table_medicinas').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
            table.columns.adjust().draw();
        }
    }
    xhr_tick_ok.send(data);
}
function delete_medicamento(div,url,med_codigo){
    if(confirm("¿Estás seguro de eliminar el medicamento?")){
        document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
        var data = new FormData();
        data.append('option','delete_medicamento');
        data.append('med_codigo',med_codigo);
        var xhr_tick_ok = new XMLHttpRequest();
        xhr_tick_ok.open('POST', url , true);
        xhr_tick_ok.onreadystatechange=function(){
            if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
                document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
                var table= $('#table_medicinas').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
                table.columns.adjust().draw();
            }
        }
        xhr_tick_ok.send(data);
    }
}


