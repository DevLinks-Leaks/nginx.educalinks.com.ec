<?php
session_start();
include("../framework/dbconf.php");
include("../framework/funciones.php");
	
	$array_color = array('#ccffcc','#ffcccc','#FFE5CC','#FFFFCC','#D1F2EB','#F5F5F5','#CCE5FF','#CCCCFF','#E5CCFF',
						'#FFCCFF','#E0E0E0','#F0E68C','#F0F8FF','#CCFFE5','#FEF5E7','#E5FFCC','#F2D7D5','#F5B7B1','#F9E79F');
	$activo_color = '#c3ffc1';
	$vencer_color= '#ffcccc';
	$inactivos_color = '#F5F5F5';
	$pendientes_color = '#D1F2EB';

	$cant_total_colores=18;
	$params_mate = array($_SESSION['alum_codi'],$_SESSION['curs_para_codi']);
	$sql_mate="{call alum_curs_peri_mate_view(?,?)}";
	$stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
	$cont=0;
	while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate)){
		$params_agen = array($row_curs_mate_view['curs_para_mate_prof_codi'],$_SESSION['peri_codi']);
		$sql_agen="{call agen_curs_para_mate_view_calendar(?,?)}";
		$stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen);

		
		while($row_agen_curs_view= sqlsrv_fetch_array($stmp_agen)){
			switch ($row_agen_curs_view['agen_tipo']) {
				case 'A':
					$color=$activo_color;
					break;
				case 'I':
					$color=$inactivos_color;
					break;
				case 'R':
					$color=$vencer_color;
					break;
				case 'P':
					$color=$pendientes_color;
					break;
				default:
					$color=$inactivos_color;
					break;
			}

			$agenda_day=date_format($row_agen_curs_view['agen_fech_ini'],'d');
			$agenda_month=date_format($row_agen_curs_view['agen_fech_ini'],'m')-1;
			$agenda_year=date_format($row_agen_curs_view['agen_fech_ini'],'Y');
			$agenda_day_fin=date_format($row_agen_curs_view['agen_fech_fin'],'d');
			$agenda_month_fin=date_format($row_agen_curs_view['agen_fech_fin'],'m')-1;
			$agenda_year_fin=date_format($row_agen_curs_view['agen_fech_fin'],'Y');

			//str_replace('\n','<br>',str_replace('"','',str_replace('\r','',json_encode($row_agen_curs_view['agen_titu']))))  str_replace(' \','
			//preg_replace('/[^A-Za-z0-9 \-]/', '',$row_agen_curs_view['agen_deta'])
			$agendas_mes.='{title: " '.str_replace('\n','<br>',str_replace('"','',str_replace('\r','',json_encode($row_agen_curs_view['mate_deta'])))).' " ,titu: " '.str_replace('\n','<br>',str_replace('"','',str_replace('\r','',json_encode($row_agen_curs_view['agen_titu'])))).' ",description: " '.str_replace('\n','<br>',str_replace('"','',str_replace('\r','',json_encode($row_agen_curs_view['agen_deta'])))).' " ,start: new Date('.$agenda_year.', '.$agenda_month.', '.$agenda_day.',9,0), end: new Date('.$agenda_year_fin.', '.$agenda_month_fin.', '.$agenda_day_fin.',9,0), backgroundColor: "'.$color.'" ,borderColor: "'.$color.'" ,textColor: "#000000"},';

			//,backgroundColor: ".'"'.$color.'"'.",borderColor: ".'"'.$color.'"'."},";
		}
		$cont++;
	}
?>
<div id="calendar"></div>
<div class="modal fade " id="agenda_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div width="100%" class="modal-content">
            <div class="modal-header" id="modal-header" style="font-weight: bold !important;">
		      	<button 
		            type="button" 
		              class="close" 
		              data-dismiss="modal">
		              <span aria-hidden="true">&times;</span>
				</button>
		      	<h3 class="modal-title" id="modal-title"> 
		      	</h3>
			</div>
			<div width="100%" id="modal-body" class="modal-body" style="height:300px;overflow-y:scroll;">
			</div>
			<div class="modal-footer" id="modal-footer">

					<button 
					type="button" 
					  class="btn btn-default" 
					  data-dismiss="modal">
					Cerrar
					</button>  
			</div>
        </div>
    </div>
</div>
<script type="text/javascript">  
	$(document).ready(function(){  
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'month,basicWeek'
			},
			buttonText: {
				today: 'hoy',
				month: 'mes',
				week: 'semana',
				day: 'día'
			},
			defaultView: 'basicWeek',
			aspectRatio: 2,
			forceEventDuration: true,
			contentHeight: 600,

			//Random default events
			events: [ 
				<?php echo str_replace('
','',str_replace('                ','',str_replace("`",'',str_replace('
',' ',$agendas_mes))));?>
			],
			eventRender: function(event, element) { 
				element.find('.fc-time').remove();
				element.find('.fc-title').append("<br/>" + event.titu+"<br/> Ver más..."); 
			},
			eventClick: function(event){
				$('#modal-title').html(event.titu+'<small> - '+event.title+'</small>');
				inidate = $.datepicker.formatDate( "d-M-yy",new Date(event.start));
				findate = $.datepicker.formatDate( "d-M-yy",new Date(event.end));
            	$('#modal-body').html('<p> <b>Fecha inicio:</b> '+inidate+'&ensp; <b>Fecha fin: </b>'+findate+'</p>'+'<p>'+event.description+'</p>');
				$('#agenda_modal').modal();
			} 
	  });
	});
</script>
<style>
.fc-content {
    cursor: pointer;
}
</style>