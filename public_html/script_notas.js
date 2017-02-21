function Crear_Xml ()
{
	peri_dist_main = $('#peri_dist_main').val();
	num_filas = $('#num_filas').val();
	num_columnas = $('#num_columnas').val();
	
	ind_fil=1;
	
	/*Filas*/
	while (ind_fil<=num_filas)
	{
		xml='';
		xml='<?xml version="1.0" encoding="utf-8"?>';
		xml=xml+'<ns u="'+'ADMIN"'+' t="'+'A"'+'>';
		xml=xml+'<a c="'+$('#alum_curs_para_mate_codi_'+ind_fil).val()+'">';
		ind_col=1;
		/*Columnas*/
		while (ind_col<=num_columnas)
		{
			xml=xml+'<n p="'+$('#peri_dist_codi_'+ind_col).val()+'" v="'+$('#nota_'+ind_fil+'_'+(ind_col-1)).val()+'" />';
			ind_col++;
		}
		xml=xml+'</a>';
		xml=xml+'</ns>';
		Guardar_Notas(xml,ind_fil);
		ind_fil++;
	}
}

function Guardar_Notas (xml_notas_filas,ind_fil)
{
	var jqxhr = $.ajax({
		  type: "POST",
		  async: false,
		  url: "script_notas.php",
		  data: {xml_notas_filas:xml_notas_filas},
		  dataType: "text",
		  success: function (res)
		  {
			  $("#"+ind_fil).html(res);
		  }
		});
	 /*$.post("script_notas.php",
	    {
	      mensaje: xml_notas_filas
	    },
	    function(data,status){
	        alert(data);
	    });*/
	
}
