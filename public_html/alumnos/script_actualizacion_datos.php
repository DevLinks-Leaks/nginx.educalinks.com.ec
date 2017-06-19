<?php
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'alum_upd':
        $alum_tiene_seguro = ($_POST['alum_tiene_seguro']=='true'?1:0);
        $sql	= "{call actualiza_estudiante(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $params	= array($_SESSION['alum_codi'],
                        $_POST['alum_mail'],
                        $_POST['alum_celu'],
                        $_POST['alum_domi'],
                        $_POST['alum_telf'],
                        $_POST['alum_ciud'],
                        $_POST['alum_parroq'],
                        $_POST['alum_pais'],
                        $_POST['alum_nacionalidad'],
                        $_POST['alum_religion'],
                        $_POST['alum_vive_con'],
                        $_POST['alum_parentesco_vive_con'],
                        $_POST['alum_estado_civil_padres'],
                        $_POST['alum_movilizacion'],
                        $_POST['alum_activ_deportiva'],
                        $_POST['alum_activ_artistica'],
                        $_POST['alum_enfermedades'],
                        $_POST['alum_telf_emerg'],
                        $_POST['alum_parentesco_emerg'],
                        $_POST['alum_pers_emerg'],
                        $_POST['alum_tipo_sangre'],
                        $_POST['alum_prov_naci'],
                        $_POST['alum_ciud_naci'],
                        $_POST['alum_parr_naci'],
                        $_POST['alum_sect_naci'],
                        $_POST['alum_ex_plantel'],
                        $_POST['alum_ex_plantel_dire'],
                        $_POST['alum_prov'],
                        $_POST['alum_etnia'],
                        $alum_tiene_seguro,
                        $_SESSION['repr_codi']);
        $stmt_al	= sqlsrv_query($conn,$sql,$params);
        if ($stmt_al===false){
            $result= json_encode(array ('state'=>'error',
                        'result'=>'No se pueden actualizar los datos.',
                        'console'=> sqlsrv_errors() ));
        }else{
            $_SESSION['alum_upd']=1;

            $repr_fech_promoc=substr($_POST['repr_fech_promoc'],6,4)."".substr($_POST['repr_fech_promoc'],3,2)."".substr($_POST['repr_fech_promoc'],0,2);
            $es_colaborador = ($_POST['repr_escolaborador']=='true' ? 1 : 0 );
            $repr_ex_alum = ($_POST['repr_ex_alum']=='true' ? 1 : 0 );
            $sql	= "{call actualiza_representante(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
            $params	= array(    $_POST['repr_email'],
                                $_POST['repr_telf'],
                                $_POST['repr_domi'],
                                $_POST['repr_estado_civil'],
                                $_POST['repr_celular'],
                                $_SESSION['repr_codi'],
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
                                $_POST['repr_telf_trab'],
                                $repr_fech_promoc,
                                $repr_ex_alum,
                                $_POST['repr_pais_naci'],
                                $_POST['repr_prov_naci'],
                                $_POST['repr_ciud_naci'],
                                $_POST['ident_niv_1'],
                                $_POST['ident_niv_2'],
                                $_POST['ident_niv_3']);
            $stmt_rep	= sqlsrv_query($conn,$sql,$params);
            if ($stmt_rep===false)
            {
                $result= json_encode(array ('state'=>'error',
                    'result'=>'No se pueden actualizar los datos.',
                    'console'=> sqlsrv_errors() ));
            }
            else
            {
                $_SESSION['repr_upd']=1;
                $result= json_encode(array ('state'=>'success',
                    'result'=>'¡Los datos fueron actualizados!' ));
            }



        }

		echo $result;
	break;
}
?>