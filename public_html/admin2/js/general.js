var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36251023-1']);
_gaq.push(['_setDomainName', 'jqueryscript.net']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

$(document).ready(function(){
	// run test on initial page load
	checkSize();
	// run test on resize of the window
	$(window).resize(checkSize);
	
	var toggle = $('#ss_toggle');
    var menu = $('#ss_menu');
    var rot;
  
	$('#ss_toggle').on('click', function(ev) {
		rot = parseInt($(this).data('rot')) - 180;
		menu.css('transform', 'rotate(' + rot + 'deg)');
		menu.css('webkitTransform', 'rotate(' + rot + 'deg)');
		if ((rot / 180) % 2 == 0) {
		    //Moving in
		    toggle.parent().addClass('ss_active');
		    toggle.addClass('close');
		} else {
		    //Moving Out
		    toggle.parent().removeClass('ss_active');
		    toggle.removeClass('close');
		}
		$(this).data('rot', rot);
	});

	menu.on('transitionend webkitTransitionEnd oTransitionEnd', function() {
		if ((rot / 180) % 2 == 0) {
		    $('#ss_menu div i').addClass('ss_animate');
		} else {
		    $('#ss_menu div i').removeClass('ss_animate');
		}
	});
    //actualiza_badge_sms();
	if(document.getElementById( 'hd_chan_flag' ))
	{   if( document.getElementById( 'hd_chan_flag' ).value > 0 )
		{   $('#modal_changelog').modal('show');
			$('#modal_changelog').on('shown.bs.modal',function(){
				$('.carousel').slick({
					dots: true,
					fade: true,
					speed: 500,
					autoplay: true,
					adaptiveHeight: true,
					prevArrow:'<span style="left: -15px;width: 20px;height: 18px;transform: translate(0, -50%);cursor: pointer;position: absolute;top: 50%;" class="fa fa-chevron-left fa-2x"></span>',
					nextArrow:'<span style="right: -15px;width: 20px;height: 18px;transform: translate(0, -50%);cursor: pointer;position: absolute;top: 50%;" class="fa fa-chevron-right fa-2x"></span>'
				});
			});
		}
	}
});
//Function to the css rule
function checkSize()
{
	if (window.matchMedia('(max-width:960px)').matches)
		$('body').addClass("fixed");

	if (window.matchMedia('(min-width:961px)').matches)
		$('body').removeClass("fixed");
	
	enquire.register("screen and (orientation: landscape)", {
		match : function() {
			$('body').removeClass("fixed");
		},
		unmatch : function() {
			$('body').addClass("fixed");
		}
	});
}
function cerrar_changelog(){
    if($('#chk_mostrar').is(':checked')==true){
        registrar_changelog();
        $('#modal_changelog').modal('toggle');
    }else
        $('#modal_changelog').modal('toggle');
}
function registrar_changelog(){
  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  var jsonC = [];
  $('.changelog_div').each(function(){ 
    jsonC.push({
        chan_codi: $(this).attr('id')
    });
  });
  var data = new FormData();
  data.append('opc', 'validate_changelog_show');
  data.append('jsonC', JSON.stringify(jsonC));
  xmlhttp.onreadystatechange=function()
  {
      if (xmlhttp.readyState==4 && xmlhttp.status==200){
          var json = JSON.parse(xmlhttp.responseText);
          
      }
  };
  xmlhttp.open("POST",'script_general.php',true);
  xmlhttp.send(data);
}
function toggleFullScreen(  ) {
    var toggle = 'false';
    if ((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen))
    {   if (document.documentElement.requestFullScreen)
        {   document.documentElement.requestFullScreen();  
        }
        else if (document.documentElement.mozRequestFullScreen)
        {   document.documentElement.mozRequestFullScreen();  
        }
        else if (document.documentElement.webkitRequestFullScreen)
        {   document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
        } 
        toggle = 'true';
    }
    else 
    {   if (document.cancelFullScreen)
        {   document.cancelFullScreen();  
        }
        else if (document.mozCancelFullScreen)
        {   document.mozCancelFullScreen();  
        }
        else if (document.webkitCancelFullScreen)
        {   document.webkitCancelFullScreen();  
        }
        toggle = 'false';
    }
    var data = new FormData();
    data.append('event', 'toggle_fullscreen');
    data.append('toggle', toggle);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_common').value + '/general/controller.php' , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState === 4 && xhr.status === 200){
            console.log(xhr.responseText);
            console.log(toggle);console.log(document.getElementById('hd_toggle_fullscreen').value)
            document.getElementById('hd_toggle_fullscreen').value = xhr.responseText;console.log(document.getElementById('hd_toggle_fullscreen').value)
        }
    };
    xhr.send(data);
}
function js_general_educalinks_settings_get ()
{
	
}