<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
include ('../framework/lenguaje.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'repr_add':
		$repr_fech_promoc=substr($_POST['repr_fech_promoc'],6,4)."".substr($_POST['repr_fech_promoc'],3,2)."".substr($_POST['repr_fech_promoc'],0,2);
		$repr_fech_naci = substr($_POST['repr_fech_naci'],6,4)."".substr($_POST['repr_fech_naci'],3,2)."".substr($_POST['repr_fech_naci'],0,2);
		$es_colaborador = ($_POST['repr_escolaborador']=='true' ? 1 : 0 );
		$repr_ex_alum = ($_POST['repr_ex_alum']=='true' ? 1 : 0 );
		$sql_opc = "{call repr_add(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$params_opc= array( $_POST['repr_codi'],
							$_POST['repr_nomb'],
							$_POST['repr_apel'],
							$_POST['repr_cedula'],
							$_POST['repr_tipo_iden'],
							$_POST['repr_email'],
							$_POST['repr_telf'],
							$_POST['repr_domi'],
							$_POST['repr_estado_civil'],
							$_POST['repr_celular'],
							$_POST['alum_codi'],
							$_POST['repr_profesion'],
							$_POST['repr_nacionalidad'],
							$_POST['repr_lugar_trabajo'],
							$_POST['repr_direc_trabajo'],
							$_POST['repr_cargo'],
							$_POST['repr_religion'],
							$_POST['repr_estudios'],
							$_POST['repr_institucion'],
							$_POST['repr_motivo_representa'],
							$es_colaborador,
							$repr_ex_alum,
							$repr_fech_promoc,
							$_POST['repr_telf_trab'],
							$repr_fech_naci,
							$_POST['repr_pais_naci'],
							$_POST['repr_prov_naci'],
							$_POST['repr_ciud_naci'],
                            $_POST['identificacion_niv_1'],
                            $_POST['identificacion_niv_2'],
                            $_POST['identificacion_niv_3']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		
		$repr_view_opc=0;
		$repr_view_opc=lastId($stmt_opc);
		echo $repr_view_opc>0?"OK":"KO";
		
		//Para auditoría
		if ($repr_view_opc>0)
		{
			$detalle= lng_form_label('code').": ".$repr_view_opc;
			$detalle.= lng_form_label('name').": ".$_POST['repr_nomb'].' '.$_POST['repr_apel'];
			$detalle.= lng_form_label('id card').": ".$_POST['repr_cedula'];
			$detalle.= lng_form_label('email').": ".$_POST['repr_email'];
			$detalle.= lng_form_label('phone').": ".$_POST['repr_telf'];
			$detalle.= lng_form_label('cellphone').": ".$_POST['repr_celular'];
			$detalle.= lng_form_label('address').": ".$_POST['repr_domi'];
			$detalle.= lng_form_label('marital status').": ".$_POST['repr_estado_civil'];
			$detalle.= lng_form_label('relation').": ".$_POST['repr_parentesco'];
			$detalle.= lng_form_label('student code').": ".$_POST['alum_codi'];
			registrar_auditoria (16, $detalle);
		}
	break;
	case 'repr_upd':
		$repr_fech_promoc=substr($_POST['repr_fech_promoc'],6,4)."".substr($_POST['repr_fech_promoc'],3,2)."".substr($_POST['repr_fech_promoc'],0,2);
		$repr_fech_naci = substr($_POST['repr_fech_naci'],6,4)."".substr($_POST['repr_fech_naci'],3,2)."".substr($_POST['repr_fech_naci'],0,2);
		$es_colaborador = ($_POST['repr_escolaborador']=='true' ? 1 : 0 );
		$repr_ex_alum = ($_POST['repr_ex_alum']=='true' ? 1 : 0 );
		$sql_opc = "{call repr_upd(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$params_opc= array( $_POST['repr_nomb'],
							$_POST['repr_apel'],
							$_POST['repr_cedula'],
							$_POST['repr_tipo_iden'],
							$_POST['repr_email'],
							$_POST['repr_telf'],
							$_POST['repr_domi'],
							$_POST['repr_estado_civil'],
							$_POST['repr_celular'],
							$_POST['repr_codi'],
							$_POST['repr_profesion'],
							$_POST['repr_nacionalidad'],
							$_POST['repr_lugar_trabajo'],
							$_POST['repr_direc_trabajo'],
							$_POST['repr_cargo'],
							$_POST['repr_religion'],
							$_POST['repr_estudios'],
							$_POST['repr_institucion'],
							$_POST['repr_motivo_representa'],
							$es_colaborador,
							$repr_ex_alum,
							$repr_fech_promoc,
							$_POST['repr_telf_trab'],
							$repr_fech_naci,
							$_POST['repr_pais_naci'],
							$_POST['repr_prov_naci'],
							$_POST['repr_ciud_naci'],
                            $_POST['identificacion_niv_1'],
                            $_POST['identificacion_niv_2'],
                            $_POST['identificacion_niv_3']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$repr_view_opc=0;
		$repr_view_opc=lastId($stmt_opc);
		echo $repr_view_opc>0?"OK":"KO";
		
		//Para auditoría
		if ($repr_view_opc>0)
		{
			$detalle = lng_form_label('code').": ".$repr_view_opc;
			$detalle.= lng_form_label('last name').": ".$_POST['repr_apel'];
			$detalle.= lng_form_label('id card').": ".$_POST['repr_cedula'];
			$detalle.= lng_form_label('email').": ".$_POST['repr_email'];
			$detalle.= lng_form_label('phone').": ".$_POST['repr_telf'];
			$detalle.= lng_form_label('cellphone').": ".$_POST['repr_celular'];
			$detalle.= lng_form_label('address').": ".$_POST['repr_domi'];
			$detalle.= lng_form_label('marital status').": ".$_POST['repr_estado_civil'];
			$detalle.= lng_form_label('last relation').": ".$_POST['repr_parentesco'];
			registrar_auditoria (17, $detalle);
		}
		
	break;
	case 'repr_del':
		$sql_opc = "{call repr_del(?)}";
		$params_opc= array($_POST['repr_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$repr_view_opc=$_POST['repr_codi'];
		echo $repr_view_opc;
		
		//Para auditoría
		$detalle="Código: ".$_POST['repr_codi'];
		registrar_auditoria (18, $detalle);
	break;
	// case 'repr_exist':
	// 	$sql	= "{call repr_exist(?,?)}";
	// 	$params	= array($_POST['repr_cedula'],$_POST['repr_tipo_iden']);
	// 	$repr_exist	= sqlsrv_query($conn,$sql,$params);
	// 	if ($repr_exist===false){
	// 		$result= json_encode(array ('state'=>'error',
	// 					'result'=>'Error al consultar datos del representante.',
	// 					'console'=> sqlsrv_errors() ));
	// 	}else{
	// 		$result= json_encode(array ('state'=>'success',
	// 					'result'=>'Se encontraron coincidencias con el número de identificación de acuerdo al tipo.' ));
	// 	}
	// 	echo $result;
	// break;
	case 'repr_list':
		/*Para los parentescos*/
		$row_parentescos = array();
		$sql="{call parentescos_cons()}";
		$stmt = sqlsrv_query($conn, $sql);
		if( $stmt === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		else
			if (sqlsrv_has_rows($stmt))
				while($row_parentescos[]= sqlsrv_fetch_array($stmt));
			array_pop($row_parentescos);
		
		$sql_opc = "{call repr_alum_info(?)}";
		$params_opc= array($_POST['alum_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} ?>
		<table class="table table-stripped">
        <tr>       
			<td style='text-align:center'><?php echo show_this_phrase(20000020); ?></td>
			<td style='text-align:center'><?php echo PrimeraMayuscula(show_this(10000015)); ?></td>
			<td style='text-align:center'>Rel.</td>
			<td style='text-align:center'><?php echo PrimeraMayuscula(lng_options('main guardian')); ?></td>
			<td style='text-align:center'><?php echo PrimeraMayuscula(lng_options('financial guardian')); ?></td>
			<td style='text-align:center'>Opciones.</td>
        </tr>
        <?php while($row_repr_view=sqlsrv_fetch_array($stmt_opc)){?>
        <tr>
		<td style='text-align:center'><?=$row_repr_view['repr_cedula'];?></td>
        <td style='text-align:center'><?= $row_repr_view['repr_nomb']." ".$row_repr_view['repr_apel'];?></td>
		<td style='text-align:center'>
		<select id="<?= $row_repr_view['repr_codi'];?>" onchange="update_relative('div_repr_list','script_repr.php','<?=$_POST['alum_codi']?>','<?=$row_repr_view['repr_codi']?>',this.value);">
		 <option value="0">Elija</option>
		 <?
		 $selected="";
		 foreach ($row_parentescos as $row_par)
		 {
			 if ($row_par["codigo"]==$row_repr_view["idparentesco"])
				 $selected="selected";
			 else
				 $selected="";
		 	echo "<option value='".$row_par["codigo"]."' $selected>".$row_par["descripcion"]."</option>";
		 }
		?>
		</select>
		</td>
		<td style='text-align:center'><input type="radio" name="principal" onclick="javascript:repr_upd_princ('div_repr_list','script_repr.php','<?=$_POST['alum_codi']?>','<?=$row_repr_view['repr_codi']?>');"
			title='<?php echo PrimeraMayuscula(lng_options('make primary')); ?>'
			<?php if($row_repr_view['repre_alum_princ']=='P'){echo " checked='checked' ";}?> /></td>
        <td style='text-align:center'><input type="radio" name="financiero"  onclick="javascript:repr_upd_princ_finan('div_repr_list','script_repr.php','<?=$_POST['alum_codi']?>','<?=$row_repr_view['repr_codi']?>');"
			title='<?php echo PrimeraMayuscula(lng_options('make financial primary')); ?>'
			<?php if($row_repr_view['repre_alum_fact']=='S'){echo " checked='checked' ";}?> /></td>
		<td>
			<div class="menu_options">
			<ul>
				<li>
				<a class="option" href="representantes_add.php?repr_codi=<?=$row_repr_view['repr_codi']?>"><span class="icon-pencil2 icon"></span> Editar</a>
				</li>
				<li>
				<a class="option" href="javascript:quitar_representado('script_repr.php','<?=$_POST['alum_codi']?>','<?=$row_repr_view['repr_codi']?>');"><span class="icon-remove icon"></span> Eliminar</a>
				</li>
			</ul>
			</div>
		</td>
		</tr>
		<?php }?>
        </table>

	<?php break;
	case 'vali_repr':
		$sql_opc = "{call repr_info_cedu_vali(?)}";
		$params_opc= array($_POST['repr_cedu']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$row_repr_view=sqlsrv_fetch_array($stmt_opc);
		if ($row_repr_view['repr_cant']>0){
			echo 'OK';
		}else{
			$result_CI_valid = validarNI($_POST['repr_cedu'],$_POST['tipo_iden']);
			echo $result_CI_valid;
		}
	break;
	case 'repr_search':
		$sql_opc = "{call repr_info_search(?)}";
		$params_opc= array($_POST['repr_cedu']);
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$repr_info_search = sqlsrv_query( $conn, $sql_opc,$params_opc,$options);
		if( $repr_info_search === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$row_count = sqlsrv_num_rows( $repr_info_search );
		if ($row_count>0){
			$row_repr_info_search=sqlsrv_fetch_array($repr_info_search);
			$result= json_encode(array ('state'=>'OK',
						'result'=>$row_repr_info_search['repr_codi'] ));		
		}else{
			$result= json_encode(array ('state'=>'NO',
						'result'=>'' ));
		}
		echo $result;
	break;
	case 'upd_repr_princ':
		$sql_opc = "{call repr_alum_upd(?,?)}";
		$params_opc= array($_POST['alum_codi'],$_POST['repr_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} else {echo "1";} 
	break;
		case 'upd_repr_princ_finan':
		$sql_opc = "{call repr_finan_alum_upd(?,?)}";
		$params_opc= array($_POST['alum_codi'],$_POST['repr_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));}  else {echo "1";}
	break;
	case 'remove_alum':
		$sql_opc = "{call repr_alum_del(?,?)}";
		$params_opc= array($_POST['alum_codi'],$_POST['repr_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
	break;
	case 'update_relative':
		$sql_opc = "{call repr_parentesco_upd(?,?,?)}";
		$params_opc= array($_POST['alum_codi'],$_POST['repr_codi'],$_POST['idparentesco']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		echo "Todo OK";
	break;
    case 'cargar_idenficacion_nivel_2':
        $data = array(); $res = ""; $msj = "";
        $sql = "{call identificaciones_niv2_view(?)}";
        $params = array($_POST['id']);
        $stmt = sqlsrv_query( $conn, $sql,$params);
        if( $stmt === false ){
            $res = "error";
            $msj = "Error en la conexión";
        }
        else{
            $res = "success";
            $msj = "Todo Ok";
            while ($row = sqlsrv_fetch_array($stmt))
                array_push($data,array("id"=>$row["id"], "nombre"=>$row["nombre"]));
        }
        print json_encode(array("res"=>$res, "msj"=>$msj, "data"=>$data));
    break;
    case 'cargar_idenficacion_nivel_3':
        $data = array(); $res = ""; $msj = "";
        $sql = "{call identificaciones_niv3_view(?)}";
        $params = array($_POST['id']);
        $stmt = sqlsrv_query( $conn, $sql,$params);
        if( $stmt === false ){
            $res = "error";
            $msj = "Error en la conexión";
        }
        else{
            $res = "success";
            $msj = "Todo Ok";
            while ($row = sqlsrv_fetch_array($stmt))
                array_push($data,array("id"=>$row["id"], "nombre"=>$row["nombre"]));
        }
        print json_encode(array("res"=>$res, "msj"=>$msj, "data"=>$data));
    break;
    case 'repr_info_search':
		$sql_opc = "{call repr_info_search(?)}";
		$params_opc= array($_POST['repr_cedu']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if ($stmt_opc===false){
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al consultar datos del representante.',
						'console'=> sqlsrv_errors() ));
		}else{
			$result= json_encode(array ('state'=>'success',
						'result'=>'Se encontraron coincidencias con el número de identificación.' ));
		}
		$row_repr_view=sqlsrv_fetch_array($stmt_opc);
		
	break;
}
?>