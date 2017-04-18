/**
 * Created by Juan Carlos on 28/03/2017.
 */
$('#btn_activar_licencia').click(function(){
    var pin = $('#txt_pin').val();
    var alum_curs_para_codi = $('#txt_alum_curs_para_codi').val();

    if (pin == ""){
        $('#msj_error').text("Ingrese el código de activación");
        $('#txt_pin').focus();
    }
    else{
        var data_post = "pin="+pin+"&alum_curs_para_codi="+alum_curs_para_codi+"&opc=check_licencia";
        $.ajax({
            type: "POST",
            url: "script_licencia_activar.php",
            data: data_post,
            success: function(res){
                var json_res = $.parseJSON(res);
                if (json_res.res == "error")
                    $('#msj_error').text(json_res.msj);
                else
                    window.location.href = "index.php";
            },
            error: function(res){
                $('#msj_error').text(json_res.msj);
            }
        });
    }
});