	<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="../{fotoUsuario}" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p><small>{usua_nombres} {usua_apellidos} </small></p>
					<a href="#"><i class="fa fa-circle text-success"></i> En línea</a>
				</div>
			</div>
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">MÓDULO FINANCIERO</li>
				<li class="{open0}"><a href="../../finan/general/"><i class="fa fa-home"> </i> <span>Inicio</span></a></li><!-- {menu001} -->
				<li class="{open1} treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-money"></i><span>Caja<span id="badge_gest_fac"></span></span>
					<i id='cash_angle' name='cash_angle' ></i></a>
					<ul class="treeview-menu">
						<li class="{menu101}">{CobroGeneral}</li>
						<li class="{menu102}">{Deuda}</li>
						<li class="{menu103}">{NotadeCredito}</li>
						<li role="presentation" class="{menu105}">{GestionFacturas}</li>
						<li role="presentation" class="{menu106}">{GestionNotascredito}</li>
						<li role="presentation" class="{menu108}">{GestionContifico}</li>
						<li role="presentation" class="{menu109}">{ValidadorCheques}</li>
						<li role="presentation" class="{menu111}">{CierredeCaja}</li>
					</ul>
				</li>
				<li class="{open6} treeview">
					<a href="#"><i class="fa fa-list"></i> <span>Ver</span><i class="fa fa-angle-left pull-right"></i></a><!-- {open6}{menu6} -->
					<ul class="treeview-menu">
						<li role="presentation" class="{menu601}">{VerSaldoaFavor}</li>
						<li role="presentation" class="{menu602}">{VerDocumentosAutorizados}</li>
						<li role="presentation" class="{menu603}">{VerPagos}</li>
						<li role="presentation" class="{menu605}">{VerCaja}</li>
					</ul>
				</li>
				<li class="{open2} treeview">
					<a href="#"><i class="fa fa-wrench"></i> <span>Mantenimiento</span><i class="fa fa-angle-left pull-right"></i></a><!-- {open2}{menu2} -->
					<ul class="treeview-menu">
						<li class="{menu201}">{Categorias}</li>
						<li class="{menu202}">{Items}</li>
						<li class="{menu203}">{Precios}</li>
						<li class="{menu204}">{GruposEconomicos}</li>
						<li class="{menu205}">{NivelEconomico}</li>
						<li class="{menu206}">{AgrupaciondeCursos}</li>
						<!--<li class="{menu207}">{Usuarios}</li>-->
						<li class="{menu208}">{Bancos}</li>
						<li class="{menu209}">{tarjetasCredito}</li>
					</ul>
				</li>
				<li class="{open3} treeview">
					<a href="#"><i class="fa fa-certificate"></i> <span>Supervisor</span><i class="fa fa-angle-left pull-right"></i></a><!-- {open3}{menu3} -->
					<ul class="treeview-menu">
						<li class="{menu304}">{Clientes}</li>
						<li class="{menu317}">{Clientes_externos}</li>
						<li class="{menu301}">{Sucursales}</li>
						<li class="{menu302}">{PuntosdeEmision}</li>
						<li class="{menu303}">{TiposdeDescuentos}</li>                    
						<li class="{menu308}">{PeriodosAnuales}</li>
						<li class="{menu313}">{Descuentofacturas}</li>
						<li class="{menu314}">{DebitosAutomaticos}</li>
						<li class="{menu315}">{DescuentoAlumnos}</li>
						<li class="{menu316}">{Contabilidad}</li>
					</ul>
				</li>
				<li class="{open4} treeview">
					<a href="#"><i class="fa fa-book"></i> <span>Reportes</span><i class="fa fa-angle-left pull-right"></i></a><!-- {open4} -->
					<ul class="treeview-menu">
						<li class="{menu401}">{Liquidez}</li>
						<li class="{menu402}">{Reporte_CRM_Cobranza}</li>
						<li class="{menu404}">{RepNC}</li>
						<li class="{menu405}">{RepFACT}</li>
						<li class="{menu406}">{RepDescuentos}</li>
						<li class="{menu407}">{RepSaldosAFavor}</li>
						<li class="{menu408}">{RepCtasPorCobrar}</li>
						<li class="{menu411}">{RepAntiguedad}</li>
					</ul>
				</li>
				<li class="{open5} treeview">
					<a href="#"><i class="fa fa-headphones"></i> <span>CRM Cobranza</span><i class="fa fa-angle-left pull-right"></i></a><!-- {open5} -->
					<ul class="treeview-menu">
						<li class="{menu501}">{Cobranza}</li>
						<li class="{menu502}">{Resultados}</li>
					</ul>
				</li>
				<li><a href="../../../manuales/Manual_Educalinks_financiero_2016_04_11_v041.pdf" target='_blank'><i class="fa fa-info-circle"></i> <span>Manual de ayuda</span></a>
				</li>
				<li class="{open7}"><a href="../../common/acerca/"><i class="icon icon-logo"></i> <span>Acerca de Educalinks</span></a></li>
			</ul>
        </section>
        <!-- /.sidebar -->
    </aside>