<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Estudiantes
 *
 * @author Gustavo
 */
session_start();
include_once('../../framework/db_abstract.php');
include_once('../framework/db_abstract.php');
class Ficha_medica extends DB_Abstract{
    //put your code here
    public $fmex;
    public $peri_codi;
    public $alum_codi;
    public $tipo_ficha;
    
	public function get_ficha_medica_listado_individual( $fmex_codi='-1', $alum_codi='-1' )
	{	$this->parametros =	array( $fmex_codi, $alum_codi );
        $this->sp = "str_medic_ficha_medica_list_cons";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Ficha(s) m&eacute;dica(s) encontrada(s).";
        }
        else
        {    $this->mensaje="¡Error! No existe registro de ficha médica.";
        }
    }
	
    # Método constructor
    function __construct() {
        $this->peri_codi = $_SESSION['peri_codi'];
        
    }
    # Método destructor del objeto
    function __destruct() {
        unset($this);
        
    }
}
