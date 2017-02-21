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
require_once('../../framework/db_abstract.php');
class Profesores extends DB_Abstract{
    //put your code here
    Public $prof_codi;
    Public $prof_nomb;
    Public $prof_apel;
    Public $prof_cedu;
    Public $prof_usua;
    Public $prof_pass;
    public $usua_codi;
    public $usua_tipo;
    public $usua_nomb;
    public $usua_apel;
    public $usua_mail;
    public $usua_dire;
    public $usua_telf;
    
    public function get_all_profesores($busq=""){
        $this->parametros = array($busq);
        $this->sp = "prof_busq";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Profesores encontrados";
            $this->cant_profesores=count($this->rows);
        }else{
            $this->mensaje="Profesores no encontrados";
            $this->cant_profesores=0;
        }
    }
    public function get_all_personal($busq=""){
        $this->parametros = array($busq);
        $this->sp = "med_personal_busq";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Profesores encontrados";
            $this->cant_profesores=count($this->rows);
        }else{
            $this->mensaje="Profesores no encontrados";
            $this->cant_profesores=0;
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
