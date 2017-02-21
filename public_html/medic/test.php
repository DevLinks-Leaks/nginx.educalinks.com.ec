<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Gustavo Decker">
    <link rel="icon" href="../imagenes/favicon.png">
    <title>Educalinks | TEST</title>
    <!-- Latest compiled and minified CSS 
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optional theme 
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link href="css/theme.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css"/>
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs/dt-1.10.8,af-2.0.0,b-1.0.1,b-colvis-1.0.1,b-print-1.0.1,cr-1.2.0,fc-3.1.0,fh-3.0.0,kt-2.0.0,r-1.0.7,rr-1.0.0,sc-1.3.0,se-1.0.0/datatables.min.css"/>   

        <!-- Latest compiled and minified JQuery 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="bootstrap/js/bootstrap-datepicker.min.js"></script>
<script src="bootstrap/js/bootstrap-datepicker.es.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script src="https://cdn.datatables.net/r/bs/dt-1.10.8,af-2.0.0,b-1.0.1,b-colvis-1.0.1,b-print-1.0.1,cr-1.2.0,fc-3.1.0,fh-3.0.0,kt-2.0.0,r-1.0.7,rr-1.0.0,sc-1.3.0,se-1.0.0/datatables.min.js" type="text/javascript" ></script>
<script src="../framework/js/bootstrap3-typeahead.js"></script>
    </head>
    <body>
        <input id="motivo" name="motivo" class="typeahead" type="text" autocomplete="off" spellcheck="false" />
        <input id="motivo_id" name="motivo" class="typeahead" type="text" autocomplete="off" spellcheck="false" />
        <script type="text/javascript"> 
        
        /*var $input = $('#motivo');
        $.get('enfermedades_json.php', function(data){
            $input.typeahead({
                source:JSON.parse(data),
                items:'all'
            });
        });*/
        $.get('enfermedades_json.php', function(data){
        $('#motivo').typeahead(
	{
	items: 'all',
	/*source:function(request, response)
        {    
            return  response(  
                [{
                    "id": 221,
                    "name": "Business Management Consultants"
                },
                {
                    "id": 222,
                    "name": "Fuel Management"
                },
                {
                    "id": 223,
                    "name": "Financial Planning Consultants"
                },
                {
                    "id": 224,
                    "name": "Magnifying Glasses (Manufacturers)"
                },
                {
                    "id": 225,
                    "name": "Grinding Wheels (Manufacturers)"
                }]
            ); 
        },*/
        source:JSON.parse(data),
	autoSelect: true,
	displayText: function(item){ return item.name;}
	});
        });
        $('#motivo').change(function() {
            var current = $('#motivo').typeahead("getActive");
            if (current) {
                // Some item from your model is active!
                if (current.name == $('#motivo').val()) {
                    // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
                    $("#motivo_id").val(current.id);
                } else {
                    // This means it is only a partial match, you can either add a new item 
                    // or take the active if you don't want new items
                    $("#motivo_id").val("0");
                }
            } else {
                // Nothing is active so it is a new value (or maybe empty value)
                $("#motivo_id").val("0");
            }
        });
        </script>
    </body>
</html>
