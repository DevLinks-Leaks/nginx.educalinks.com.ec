	<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="<?= $_SESSION['ruta_foto_logo_web'];?>" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info" style='font-size:x-small;'>
					<p>Unidad Educativa<br>
					<?php echo $_SESSION['menu_institucion']; ?></p>
				</div>
			</div>
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">MÓDULO FINANCIERO</li>
				<li class="<? if (substr($Menu,0,1)==0) echo 'active'; ?>"><a href="index.php"><i class="fa fa-home"> </i> <span>Inicio</span></li></a>
				<?php //if (permiso_activo(2)){?>
				<li class="<? if (substr($Menu,0,1)==1) echo 'active'; ?> treeview">
					<a href="#"><i class="fa fa-money"></i> <span>Caja</span> <span class="pull-right-container" id="badge_gest_fac"></span></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo(126))?> <li <? if($Menu==101) echo 'class="active"'; ?>><a href="../../finan/cobros/"><span class="submenu"><span class='fa fa-dollar'></span> Cobrar deuda</span></a></li>
						<?php if(permiso_activo(130))?> <li <? if($Menu==102) echo 'class="active"'; ?>><a href="../../finan/facturas/"><span class="submenu"><span class='fa fa-clipboard'></span> Generar deuda</span></a></li>
						<?php if(permiso_activo(133))?> <li <? if($Menu==103) echo 'class="active"'; ?>><a href="../../finan/notaCredito/"><span class="submenu"><span class='fa fa-minus'></span> Generar n/crédito</span></a></li>
						<?php if(permiso_activo(125))?> <li <? if($Menu==105) echo 'class="active"'; ?>><a href="../../finan/gestionFacturas/"><span class="submenu"><span class='icon icon-sri'></span> Gestión facturas</span><span id="badge_gest_fac_in"></span></a></li>
						<?php if(permiso_activo(207))?> <li <? if($Menu==105) echo 'class="active"'; ?>><a href="../../finan/gestionNotascredito/"><span class="submenu"><span class='icon icon-sri'></span> Gestión n/c</span><span id="badge_gest_nc_in"></span></a></li>
						<?php if(permiso_activo(226))?> <li <? if($Menu==106) echo 'class="active"'; ?>><a href="../../finan/gestionContifico/"><span class="submenu"><span class='icon icon-ctfco'></span> Contífico</span><span id="badge_gest_contifico"></span></a></li>
						<?php if(permiso_activo(196))?> <li <? if($Menu==106) echo 'class="active"'; ?>><a href="../../finan/valida_cheques/"><span class="submenu"><span class='fa fa-check-circle-o'></span> Validar cheques</span><span id="badge_gest_cheques_in"></span></a></li>
						<?php if(permiso_activo(170))?> <li <? if($Menu==106) echo 'class="active"'; ?>><a href="../../finan/cierre_caja/"><span class="submenu"><span class='fa fa-folder'></span> Cerrar caja</span></a></li>
					</ul>
				</li>
				<?php //}?>
				<?php //if (permiso_activo(3)){?>
				<li class="<? if (substr($Menu,0,1)==2) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-list"></i> <span>Ver</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo(209))?> <li <? if($Menu==201) echo 'class="active"'; ?>><a href="../../finan/saldoaFavor/"><span class='fa fa-balance-scale'></span> Saldos a favor</a></li>
						<?php if(permiso_activo(227))?> <li <? if($Menu==202) echo 'class="active"'; ?>><a href="../../finan/VerDocumentosAutorizados/"><span class='fa fa-barcode'></span> Doc. autorizados</a></li>
						<?php if(permiso_activo(227))?> <li <? if($Menu==206) echo 'class="active"'; ?>><a href="../../finan/pagos/"><span class='fa fa-list'></span> Pagos recibidos</a></li>
						<?php if(permiso_activo(227))?> <li <? if($Menu==203) echo 'class="active"'; ?>><a href="../../finan/verCaja/"><span class='fa fa-history'></span> Historial cajas</a></li>
					</ul>
				</li>
				<?php //}?>
				<?php //if (permiso_activo(4)){?>
				<li class="<? if (substr($Menu,0,1)==4) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-wrench"></i> <span>Mantenimiento</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo(149))?> <li <? if($Menu==404) echo 'class="active"'; ?>><a href="../../finan/nivelEconomico/"><span class='fa fa-diamond'></span> Nivel económico</a></li>
						<!--<?php if(permiso_activo(153))?> <li <? //if($Menu==406) echo 'class="active"'; ?>><a href="../../finan/nivelEconomicoCursos/"><span class='fa fa-object-group'></span> Agrupación de cursos</a></li>-->
						<?php if(permiso_activo(145))?> <li <? if($Menu==403) echo 'class="active"'; ?>><a href="../../finan/gruposEconomico/"><span class='fa fa-users'></span> Grupo económico</a> </li>
						<?php if(permiso_activo(136))?> <li <? if($Menu==401) echo 'class="active"'; ?>><a href="../../finan/categorias/"><span class='fa fa-tags'></span> Categoría Items</a></li>
						<?php if(permiso_activo(139))?> <li <? if($Menu==402) echo 'class="active"'; ?>><a href="../../finan/items/"><span class='fa fa-shopping-cart'></span> Items</a></li>
						<?php if(permiso_activo(143))?> <li <? if($Menu==407) echo 'class="active"'; ?>><a href="../../finan/precios/"><span class='fa fa-dollar'></span> Precios</a></li>
						<li class="{menu21} treeview"><a href="#"><i class="fa fa-list"></i> <span>Catálogos</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<?php if(permiso_activo(186))?> <li <? if($Menu==410) echo 'class="active"'; ?>><a href="../../finan/bancos/"><span class='glyphicon glyphicon-piggy-bank'></span> Bancos</a></li>
								<?php if(permiso_activo(193))?> <li <? if($Menu==411) echo 'class="active"'; ?>><a href="../../finan/tarjetasCredito/"><span class='fa fa-cc-mastercard'></span> Tarjetas de créito</a></li>
							</ul>
						</li>
						<li><a href='#/' 
							onclick="js_general_settings_get();"
							data-toggle="modal"
							data-target="#modal_configColecturia"><i class="fa fa-wrench"></i> Configuración general</a></li>
					</ul>
				</li>
				<?php //}?>
				<?php if (permiso_activo(4)){?>
				<li class="<? if (substr($Menu,0,1)==4) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-cogs"></i> <span>Administración</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo(15))?> <li <? if($Menu==401) echo 'class="active"'; ?>><a href="roles_main.php"><span class='fa fa-briefcase'></span> Roles </a></li>
						<?php if(permiso_activo(16))?> <li <? if($Menu==402) echo 'class="active"'; ?>><a href="usuarios_main.php"><span class='fa fa-users'></span> Usuarios</a></li>
						<?php if(permiso_activo(71))?> <li <? if($Menu==407) echo 'class="active"'; ?>><a href="reset_pass.php"><span class='fa fa-key'></span> Reseteo de Clave</a></li>
						<?php if(permiso_activo(17))?> <li <? if($Menu==403) echo 'class="active"'; ?>><a href="admin_periodos.php"><span class='fa fa-circle-o'></span> Periodos</a> </li>
						<?php if(permiso_activo(18))?> <li <? if($Menu==404) echo 'class="active"'; ?>><a href="admin_auditoria.php"><span class='fa fa-wpforms'></span> Auditoria</a></li>
						<!--<?php if(permiso_activo(19))?> <li <? if($Menu==405) //echo 'class="active"'; ?>><a href="alumnos_blacklist_main.php"><span class='fa fa-circle-o'></span> Parámetros generales</a></li>-->
						<?php if(permiso_activo(20))?> <li <? if($Menu==406) echo 'class="active"'; ?>><a href="admin_permisos.php"><span class='fa fa-lock'></span> Permisos</a></li>
						<?php if(permiso_activo(84))?> <li <? if($Menu==410) echo 'class="active"'; ?>><a href="para_sistema_main.php"><span class='fa fa-toggle-on'></span> Parámetros sistema</a></li>
						<?php if(permiso_activo(87))?> <li <? if($Menu==411) echo 'class="active"'; ?>><a href="usua_pass_main.php"><span class='fa fa-key'></span> Usuarios y Claves</a></li>
					</ul>
				</li>
				<?php }?>
				<?php //if (permiso_activo(4)){?>
				<li class="<? if (substr($Menu,0,1)==4) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-certificate"></i> <span>Supervisor</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo(103))?> <li <? if($Menu==401) echo 'class="active"'; ?>><a href="../../finan/clientes/"><span class='fa fa-graduation-cap'></span> Clientes </a></li>
						<?php if(permiso_activo(103))?> <li <? if($Menu==402) echo 'class="active"'; ?>><a href="../../finan/clientes_externos/"><span class='fa fa-users'></span> Clientes externos</a></li>
						<?php if(permiso_activo(106))?> <li <? if($Menu==407) echo 'class="active"'; ?>><a href="../../finan/sucursales/"><span class='fa fa-institution'></span> Sucursales</a></li>
						<?php if(permiso_activo(110))?> <li <? if($Menu==403) echo 'class="active"'; ?>><a href="../../finan/puntos_emision/"><span class='glyphicon glyphicon-tent'></span> Puntos de emisión</a> </li>
						<?php if(permiso_activo(115))?> <li <? if($Menu==404) echo 'class="active"'; ?>><a href="../../finan/tipo_descuento/"><span class='fa fa-percent'></span> Tipos de dsctos.</a></li>
						<?php if(permiso_activo(119))?> <li <? if($Menu==406) echo 'class="active"'; ?>><a href="../../finan/aniosPeriodo/"><span class='fa fa-calendar'></span> Períodos anuales</a></li>
						<?php if(permiso_activo(205))?> <li <? if($Menu==410) echo 'class="active"'; ?>><a href="../../finan/descuentofacturas/"><span class='fa fa-barcode'></span> Dsctos. de facturas</a></li>
						<?php if(permiso_activo(206))?> <li <? if($Menu==411) echo 'class="active"'; ?>><a href="../../finan/debitosAutomaticos/"><span class='glyphicon glyphicon-import'></span> Débitos bancarios</a></li>
						<?php if(permiso_activo(208))?> <li <? if($Menu==411) echo 'class="active"'; ?>><a href="../../finan/descuentoalumnos/"><span class='fa fa-graduation-cap'></span> Dsctos. por alumnos</a></li>
						<?php if(permiso_activo(226))?> <li <? if($Menu==411) echo 'class="active"'; ?>><a href="../../finan/contabilidad/"><span class='icon icon-ctfco'></span> Contabilidad</a></li>
					</ul>
				</li>
				<?php// }?>
				<?php //if (permiso_activo(66)){?>
				<li class="<? if (substr($Menu,0,1)==6) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-book"></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo(202))?> <li <? if($Menu==605) echo 'class="active"'; ?>><a href="../../finan/rep_facturas/"><span class='fa fa-bookmark-o'></span> Facturas Emitidas</a></li>
						<?php if(permiso_activo(201))?> <li <? if($Menu==604) echo 'class="active"'; ?>><a href="../../finan/rep_notaCredito/"><span class='fa fa-bookmark-o'></span> Notas de Crédito</a></li>
						<?php if(permiso_activo(202))?> <li <? if($Menu==607) echo 'class="active"'; ?>><a href="../../finan/rep_ctasporcobrar/"><span class='fa fa-bookmark-o'></span> Cuentas por Cobrar</a></li>
						<?php if(permiso_activo(202))?> <li <? if($Menu==607) echo 'class="active"'; ?>><a href="../../finan/rep_emisiones/"><span class='fa fa-bookmark-o'></span> Reporte de emisiones</a></li>
						<?php if(permiso_activo(202))?> <li <? if($Menu==607) echo 'class="active"'; ?>><a href="../../finan/rep_mediacion/"><span class='fa fa-bookmark-o'></span> Reporte de mediación</a></li>
						<?php if(permiso_activo(202))?> <li <? if($Menu==607) echo 'class="active"'; ?>><a href="../../finan/rep_antiquity/"><span class='fa fa-bookmark-o'></span> R. Antigüedad Saldos</a></li>
						<li class="{menu41} treeview"><a href="#"><i class="fa fa-book"></i> <span>Otros reportes</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<?php if(permiso_activo(194))?> <li <? if($Menu==603) echo 'class="active"'; ?>><a href="../../finan/rep_cobranza/"><span class='fa fa-bookmark-o'></span> CRM Cobranza</a></li>
								<?php if(permiso_activo(202))?> <li <? if($Menu==607) echo 'class="active"'; ?>><a href="../../finan/rep_debito/"><span class='fa fa-bookmark-o'></span> R. débito bancario</a></li>
								<?php if(permiso_activo(202))?> <li <? if($Menu==606) echo 'class="active"'; ?>><a href="../../finan/rep_descuentos/"><span class='fa fa-bookmark-o'></span> Descuentos otorgados</a></li>
								<?php if(permiso_activo(224))?> <li <? if($Menu==607) echo 'class="active"'; ?>><a href="../../finan/rep_saldosafavor/"><span class='fa fa-bookmark-o'></span> Saldos a favor</a></li>
								<?php if(permiso_activo(192))?> <li <? if($Menu==602) echo 'class="active"'; ?>><a href="../../finan/liquidez/"><span class='fa fa-bookmark-o'></span> R. de liquidez</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<?php //}?>
				
				<?php //if (permiso_activo(66)){?>
				<li class="<? if (substr($Menu,0,1)==6) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-headphones"></i> <span>Cobranza</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo(173))?> <li <? if($Menu==602) echo 'class="active"'; ?>><a href="../../finan/cobranza/"><span class='fa fa-phone-square'></span> Cobranza</a></li>
						<?php if(permiso_activo(175))?> <li <? if($Menu==603) echo 'class="active"'; ?>><a href="../../finan/crm_resultados/"><span class='fa fa-book'></span> Resultados</a></li>
					</ul>
				</li>
				<?php //}?>
				<li class="<? if ($Menu==700) echo 'active'; ?>">
					<a href="mensajes.php"><i class="fa fa-envelope"></i> <span>Mensajes</span>
						<span class="pull-right-container">
							<span class="label label-success pull-right">4</span>
						</span>
					</a>
				</li>
				<li><a href="../../../manuales/Manual_Educalinks_financiero_2016_04_11_v041.pdf" target='_blank'><i class="fa fa-info-circle"></i> <span>Manual de ayuda</span></a></li>
				<li class="<? if ($Menu==800) echo 'active'; ?>"><a href="../../common/acerca/"><i class="icon icon-logo"></i> <span>Acerca de Educalinks</span></a></li>
			</ul>
        </section>
    </aside>