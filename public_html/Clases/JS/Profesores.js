/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function carga_modal_busq(div,url,modal,alum_codi,alum_nomb,alum_curso){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('option','busq_profesores_load');
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
            var table =$('#table_cons_estudiantes').DataTable({select: true,lengthChange: false,searching: true,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
            table.columns.adjust().draw();
            $('#table_cons_estudiantes tbody').on( 'click', 'tr', function () {
                var idx = table.row(this).index();
                document.getElementById(alum_codi).value=table.cell( idx, 1).data();
                document.getElementById(alum_nomb).value=document.getElementById('nombre_'+table.cell( idx, 1).data()).innerHTML;
                document.getElementById(alum_curso).value=document.getElementById('curso_'+table.cell( idx, 1).data()).innerHTML;
                $('#' + modal).modal('hide');
            });
        }
    }
    xhr_tick_ok.send(data);
}
function carga_modal_busq_profesores(div,url,modal,alum_codi,alum_nomb,alum_telf,alum_domi,usua_tipo){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('option','busq_profesores_load');
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
            var table =$('#table_cons_estudiantes').DataTable({select: true,lengthChange: false,searching: true,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
            table.columns.adjust().draw();
            $('#table_cons_estudiantes tbody').on( 'click', 'tr', function () {
                var idx = table.row(this).index();
                document.getElementById(alum_codi).value=table.cell( idx, 1).data();
                document.getElementById(alum_nomb).value=document.getElementById('nombre_'+table.cell( idx, 1).data()).innerHTML;
                document.getElementById(alum_telf).value=document.getElementById('prof_telf'+table.cell( idx, 1).data()).value;
                document.getElementById(alum_domi).value=document.getElementById('prof_domi'+table.cell( idx, 1).data()).value;
                document.getElementById(usua_tipo).value=document.getElementById('usua_tipo'+table.cell( idx, 1).data()).value;
                $('#'+modal).modal('hide');
            });
        }
    }
    xhr_tick_ok.send(data);
}
