<?php
/**
 * Created by PhpStorm.
 * User: Juan Carlos
 * Date: 24/04/2017
 * Time: 12:25
 */
include ('../framework/dbconf.php');
include ('../framework/funciones.php');

$params = array($_POST["repr_codigo"]);
$sql = "{call alum_repr_info(?)}";
$stmt = sqlsrv_query($conn, $sql, $params);
while($row = sqlsrv_fetch_array($stmt)){
    echo $row['alum_codi']."-".$row['alum_apel']." ".$row['alum_nomb']." (".$row['curs_deta']." ".$row['para_deta'].")";
}