$(function () {
	//Enable iCheck plugin for checkboxes
	//iCheck for checkbox and radio inputs
	$('.mailbox-messages input[type="checkbox"]').iCheck({
		checkboxClass: 'icheckbox_flat-blue',
		radioClass: 'iradio_flat-blue'
	});

	//Enable check and uncheck all functionality
	$(".checkbox-toggle").click(function () {
		var clicks = $(this).data('clicks');
		if (clicks) {
		//Uncheck all checkboxes
		$(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
		$(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
		} else {
		//Check all checkboxes
		$(".mailbox-messages input[type='checkbox']").iCheck("check");
		$(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
		}
		$(this).data("clicks", !clicks);
	});
});
function check_favorite(obj, url, mens_codi)
{	var data = new FormData();
    data.append('event', 'favorite');
    data.append('mens_codi', mens_codi);
	var xhr = new XMLHttpRequest();
	xhr.open("POST",url,true);
	xhr.onreadystatechange=function()
	{	if (xhr.readyState==4 && xhr.status==200)
		{	var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
			}
			var i = $(obj).find("a > i");
			var fa = i.hasClass("fa fa-flag");

			if (fa) {
				i.toggleClass("fa-flag-o");
			}else
			{   i.toggleClass("fa-flag");
			}
		}
	};
	xhr.send(data);	
}
function get_box(box, url, div)
{   var data = new FormData();
    data.append('event', 'get_box');
    data.append('box', box);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
		}
	};
	xhr.send(data);
}
function leer_mensaje(url, mens_codi, box, div)
{   var data = new FormData();
    data.append('event', 'leer');
    data.append('mens_codi', mens_codi);
    data.append('box', box);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
		}
	};
	xhr.send(data);
}