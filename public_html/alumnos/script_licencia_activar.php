<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 28/03/2017
 * Time: 11:58
 */
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){
    $opc = $_POST['opc'];
}
else{
    $opc = "";
}
switch($opc){
    case 'check_licencia':
        if(isset($_POST['alum_curs_para_codi'])){
            $alum_curs_para_codi = $_POST['alum_curs_para_codi'];
        }
        else{
            $alum_curs_para_codi = "";
        }
        if(isset($_POST['pin'])){
            $pin = $_POST['pin'];
        }
        else{
            $pin = "";
        }
        $params = array($alum_curs_para_codi, $pin);
        $sql = "{call activar_licencia (?,?)}";
        $stmt = sqlsrv_query($conn, $sql, $params);
        if( $stmt === false ){
            $res = "error";
            $errors = sqlsrv_errors();
            $msj = "";
            foreach ($errors as $error)
                $msj .= $error["message"]." ";
        }
        else{
            $row = sqlsrv_fetch_array($stmt);
            $res = $row['res'];
            $msj = $row['msj'];
            if ($res == "success")
                $_SESSION['pin'] = $pin;
        }
        print json_encode(array("res"=>$res, "msj"=>$msj));
}