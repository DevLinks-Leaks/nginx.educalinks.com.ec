function IniciarForm(alum_nombres,alum_curs_para_mate_codi,alum_codi)
{	document.getElementById('alum_nombres').innerHTML=alum_nombres;
	document.getElementById('alum_curs_para_mate_codi_in').value=alum_curs_para_mate_codi;
	document.getElementById('alum_codi').value=alum_codi;
	document.getElementById('alum_notas_ing').innerHTML='';
	document.getElementById('sl_peri_dist_codi').value=0;
}
function consNotas()
{	div = 'alum_notas_ing';
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
	data.append('opc', 'consNotas');
	data.append('alum_curs_para_mate_codi',document.getElementById('alum_curs_para_mate_codi_in').value);
	data.append('peri_dist_codi',document.getElementById('sl_peri_dist_codi').value);
	data.append('nota_refe_cab_tipo',document.getElementById('nota_refe_cab_tipo').value);
	data.append('nota_refe_cab_codi',document.getElementById('nota_refe_cab_codi').value);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'script_notas_secretaria.php' , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById(div).innerHTML=xhr.responseText;			
			$(document).ready(function() {
			$("input.cls_validar").keydown(function (e) {
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					 // Allow: Ctrl+A
					(e.keyCode == 65 && e.ctrlKey === true) || 
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) 
				{
					e.preventDefault();
				}		
			});
		 });
		} 
	}
	xhr.send(data);
}
function saveNotas(curs_deta,para_deta,mate_deta)
{	num_inputs = document.getElementById('num_inputs').value;
	var data = new FormData();
	data.append('opc', 'saveNotas');
	data.append('alum_curs_para_mate_codi',document.getElementById('alum_curs_para_mate_codi_in').value);
	data.append('peri_dist_codi',document.getElementById('sl_peri_dist_codi').value);
	data.append('nota_refe_cab_tipo',document.getElementById('nota_refe_cab_tipo').value);
	data.append('nota_refe_cab_codi',document.getElementById('nota_refe_cab_codi').value);
	data.append('mate_padr',document.getElementById('mate_padr').value);
	data.append('alum_codi',document.getElementById('alum_codi').value);
	data.append('curs_deta',curs_deta);
	data.append('para_deta',para_deta);
	data.append('mate_deta',mate_deta);
	var select = document.getElementById('sl_peri_dist_codi').options[document.getElementById('sl_peri_dist_codi').selectedIndex].text;
	data.append('peri_dist_deta',select);
	data.append('num_inputs',num_inputs);
	for (i=1;i<=num_inputs;i++)
	{
		data.append('n_'+i,document.getElementById('n_'+i).value);
		data.append('p_'+i,document.getElementById('n_'+i).getAttribute('data-peri_dist_codi_in'));
		data.append('a_'+i,document.getElementById('n_'+i).getAttribute('data-peri_dist_abre'));
	}
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'script_notas_secretaria.php' , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{	obj = JSON.parse(xhr.responseText);
			if (obj.error == "no")
			{	$.growl.notice({ title: "Educalinks informa: ",message: obj.mensaje });
				consNotas();
			}
			else
			{	$.growl.error({ title: "Educalinks informa: ",message: obj.mensaje });
			}
		} 
	}
	xhr.send(data);
}
function TEXTVALI(nota_nuev,nuev_actu,maximo)
{	if (nota_nuev.value == "") {
		//alert("El valor esta en blanco");			
		nota_nuev.value=0;
	}
	else if (isNumber(nota_nuev.value)!= true ) {
			//alert("El valor no es numerico");			
			nota_nuev.value=0;
	}
	else{
		if (nota_nuev.value > maximo) {
			//alert("El valor no puede ser mayor a " + maximo);		
			nota_nuev.value=0;	
		}
		if (nota_nuev.value < 0) {
			//alert("El valor debe ser mayor a cero");			
			nota_nuev.value=0;
		}		 
  	}
}
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}