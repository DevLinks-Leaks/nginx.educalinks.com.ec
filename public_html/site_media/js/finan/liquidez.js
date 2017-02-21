	     $(document).ready(function() {
			 actualiza_badge_gest_fact();
		      $('#liquidez_table').DataTable();
				$('#rol1quincena').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#prestamos').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#sumbancos').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#cheqgiradonocobrado').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#depositosdia').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#becasdescuentos').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#tarjetas').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#inversiones').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#chequesposfechado').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#IESS').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#SRI').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#bonificacion').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#dividendoInversionista').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#liqui_proveedores').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#liqui_roles').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#Desc2quincena').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#Desc1quincena').maskMoney({thousands:'', decimal:'.', allowZero:false});
				$('#rolneto2quincena').maskMoney({thousands:'', decimal:'.', allowZero:false});
			
		    });
// Consulta filtrada
function busca(busq,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('busq', busq);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		document.getElementById(div).innerHTML=xhr.responseText;
		$('#cuentaContable_table').datatable({
		    /*pageSize: 10,
		    sort: [false,true,true,true,false],
			filters: [false,true,true,'select',false],
		    filterText: 'Buscar... '*/
		});
		} 
	}
	xhr.send(data);
}
// Carga el formulario para ingresar un nuevo registro
function carga_add(div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'agregar');	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}
function add(div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'set');
	var cmb_grupo = document.getElementById('grupo_cuentaContable_add');
	data.append('cuentaPadre',cmb_grupo.options[cmb_grupo.selectedIndex].value);
	data.append('codigoCuenta', document.getElementById('codigoCuenta_add').value);
	data.append('nombre', document.getElementById('nombre_add').value);
	data.append('descripcion', document.getElementById('descripcion_add').value);
	data.append('tipo', document.getElementById('tipo_add').value);
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			busca("",div,url);
		} 
	}
	xhr.send(data);
}
function edit(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'modificar');
	data.append('codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}
function save_edited(codigo,div,url){
	if(confirm("¿Está seguro que desea editar la información de la cuenta contable?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'edit');
		data.append('codigo', document.getElementById('codigo_mod').value);
		var cmb_grupo = document.getElementById('codigoGrupo_mod');
		data.append('cuentaPadre',cmb_grupo.options[cmb_grupo.selectedIndex].value);
		data.append('codigoCuenta', document.getElementById('codigoCuenta_mod').value);
		data.append('nombre', document.getElementById('nombre_mod').value);
		data.append('descripcion', document.getElementById('descripcion_mod').value);
		data.append('tipo', document.getElementById('tipo_mod').value);
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				busca("",div,url)
			} 
		}
		xhr.send(data);
	}
}

function carga_reports_liquidez(div,url,evento){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'printvisor');

	url2=url+'?event='+evento;
	
	//+'&codigo='+codigo;
	data.append('url',url2);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	
	xhr.send(data);
}

function crearhtml(div,url,evento){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var sumabancos = document.getElementById('sumbancos').value;
	var saldo = 0;
	var chequesgirados = document.getElementById('cheqgiradonocobrado').value;
	var depositodia = document.getElementById('depositosdia').value;
	var rol1quincena = document.getElementById('rol1quincena').value;
	var Desc1quincena = document.getElementById('Desc1quincena').value;
	var rolneto2quincena = document.getElementById('rolneto2quincena').value;
	var Desc2quincena = document.getElementById('Desc2quincena').value;
	var IESS = document.getElementById('IESS').value;
	var SRI = document.getElementById('SRI').value;
	var bonificacion = document.getElementById('bonificacion').value;
	var dividendoInversionista = document.getElementById('dividendoInversionista').value;
	var prestamos = document.getElementById('prestamos').value;
	var liqui_proveedores = document.getElementById('liqui_proveedores').value;
	var sumacuentasxpagar = document.getElementById('sumacuentasxpagar').value;
	var becasdescuentos = document.getElementById('becasdescuentos').value;
	var tarjetas = document.getElementById('tarjetas').value;
	var chequesposfechado = document.getElementById('chequesposfechado').value;
	var becasdescuentos = document.getElementById('becasdescuentos').value;
	var tarjetas = document.getElementById('tarjetas').value;
	var chequesposfechado = document.getElementById('chequesposfechado').value;
	var subtotal = document.getElementById('subtotal').value;
	var liquidezactual=0;
	var i=0;
	var bancovalores={};
	bancovalores['valor']={};
	bancovalores['nombre']={};
	var colTotal=0;
	var cuentasxcobraractual=0;
		$('#tablabancos  tbody tr').each(function(){
		var celda = $(this).children().eq(1);
		var celda0 = $(this).children().eq(0);
		var valor =  $(celda).find("input").val();
		var name =$(celda).find("input").val();
		if((valor != "") && (valor != null)) {
		bancovalores['valor'][i]=valor;
		bancovalores['nombre'][i]=$(celda0).text();}
		else{
		
		bancovalores['valor'][i]=0;	
		bancovalores['nombre'][i]=$(celda0).text();
			}
		i=i+1;
		
	});
	
	
	if((chequesgirados != "") && (chequesgirados != null)) saldo  -=parseFloat(chequesgirados);
	if((depositodia != "") && (depositodia != null)) saldo +=parseFloat(depositodia);
	if((sumabancos != "") && (sumabancos != null)) saldo  +=parseFloat(sumabancos);
	
	
	var saldobancos=saldo.toFixed(2);
	
//	
//	var curso = document.getElementById('curso').value;f
	var data = new FormData();
	data.append('event', 'crearhtml');
	data.append('sumabancos', sumabancos);
	data.append('saldobancos', saldobancos);
	data.append('depositodia', depositodia);
	data.append('chequesgirados', chequesgirados);
	data.append('sumabancos', sumabancos);
	data.append('depositodia', depositodia);
	data.append('rol1quincena', rol1quincena);
	data.append('Desc1quincena', Desc1quincena);
	data.append('rolneto2quincena', rolneto2quincena);
	data.append('Desc2quincena', Desc2quincena);
	data.append('IESS', IESS);
	data.append('SRI', SRI);
	data.append('bonificacion', bonificacion);
	data.append('dividendoInversionista', dividendoInversionista);
	data.append('prestamos', prestamos);
	data.append('bonificacion', bonificacion);
	data.append('liqui_proveedores', liqui_proveedores);
	data.append('sumacuentasxpagar', sumacuentasxpagar);
	data.append('becasdescuentos', becasdescuentos);
	data.append('tarjetas', tarjetas);
	data.append('chequesposfechado', chequesposfechado);
	data.append('subtotal', subtotal);
	data.append('bancovalores', JSON.stringify(bancovalores));
	
	//+'&codigo='+codigo;

	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	
	xhr.onreadystatechange=function(){
		
		if (xhr.readyState==4 && xhr.status==200){
		
			document.getElementById(div).innerHTML=xhr.responseText;
			if (xhr.responseText=='OK')
			{
			 carga_reports_liquidez(div,url,evento);
			}
		} 
	}
	
	xhr.send(data);
}



function SumarColumna() {

var colTotal = 0;
$('#tablabancos  tbody tr').each(function(){
var celda = $(this).children().eq(1);
var valor =  $(celda).find("input").val();

if((valor != "") && (valor != null)) colTotal  += parseFloat(valor);

});
var acu=colTotal.toFixed(2);
document.getElementById('sumbancos').value =acu;
} 

function SumarCuentasxPagar() {
	var rol1quincena = document.getElementById('rol1quincena').value;
	var Desc1quincena = document.getElementById('Desc1quincena').value;
	var rolneto2quincena = document.getElementById('rolneto2quincena').value;
	var Desc2quincena = document.getElementById('Desc2quincena').value;
	var IESS = document.getElementById('IESS').value;
	var SRI = document.getElementById('SRI').value;
	var bonificacion = document.getElementById('bonificacion').value;
	var dividendoInversionista = document.getElementById('dividendoInversionista').value;
	var prestamos = document.getElementById('prestamos').value;
	var liqui_proveedores = document.getElementById('liqui_proveedores').value;
	var acumulador = 0;


if((rol1quincena != "") && (rol1quincena != null)) acumulador  +=parseFloat(rol1quincena);
if((Desc1quincena != "") && (Desc1quincena != null)) acumulador  +=parseFloat(Desc1quincena);
if((rolneto2quincena != "") && (rolneto2quincena != null)) acumulador  +=parseFloat(rolneto2quincena);
if((IESS != "") && (IESS != null)) acumulador  +=parseFloat(IESS);
if((SRI != "") && (SRI != null)) acumulador  +=parseFloat(SRI);
if((bonificacion != "") && (bonificacion != null)) acumulador  +=parseFloat(bonificacion);
if((dividendoInversionista != "") && (dividendoInversionista != null)) acumulador  +=parseFloat(dividendoInversionista);
if((prestamos != "") && (prestamos != null)) acumulador  +=parseFloat(prestamos);
if((liqui_proveedores != "") && (liqui_proveedores != null)) acumulador  +=parseFloat(liqui_proveedores);

var acu=acumulador.toFixed(2);
document.getElementById('sumacuentasxpagar').value =acu;
} 

function SubtotalcuentasxCobrar() {
	var becasdescuentos = document.getElementById('becasdescuentos').value;
	var tarjetas = document.getElementById('tarjetas').value;
	var chequesposfechado = document.getElementById('chequesposfechado').value;

	var acumulador = 0;


if((becasdescuentos != "") && (becasdescuentos != null)) acumulador  -=parseFloat(becasdescuentos);
if((chequesposfechado != "") && (chequesposfechado != null)) acumulador  +=parseFloat(chequesposfechado);
if((tarjetas != "") && (tarjetas != null)) acumulador  +=parseFloat(tarjetas);


var acu=acumulador.toFixed(2);

document.getElementById('subtotal').value =acu;
} 


function del(codigo,div,url){
	var cmb_grupo = document.getElementById('codigoGrupo_mod');
	if(confirm("¿Está seguro que desea eliminar la información de la cuenta contable?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('codigo', codigo);
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				busca("",div,url)
			} 
		}
		xhr.send(data);
	}
}