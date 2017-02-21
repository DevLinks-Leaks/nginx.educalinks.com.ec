<?php
# Importar modelo de abstracción de base de datos
//require_once('../../../framework/switch.php');
require_once('../../../core/db_abstract_model.php');


class visorFacturas extends DBAbstractModel{
    #propiedades
    public $cliente_codigo;
    public $cliente_nombres;
    public $cliente_apellidos;
    public $cliente_email;
    public $cliente_clave;
    public $cliente_estado;

    #metodos
    public function login($numeroIdentificacion="", $clave=""){
        if($numeroIdentificacion!="" && $clave!=""){
            $this->parametros = array($numeroIdentificacion, $clave);
            $this->sp = "str_consultaCliente_login";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="OK";
        }else{
            $this->mensaje="No coinciden las credenciales.";
        }
    }

    public function existeCliente($numeroIdentificacion=""){
        if($numeroIdentificacion!=""){
            $this->parametros = array($numeroIdentificacion);
            $this->sp = "str_consultaCliente_existencia";
            $this->executeSPConsulta();
        }

        if (count($this->rows)>1){
            foreach($this->rows[0] as $propiedad=>$valor){
                $this->$propiedad=$valor;
            }
            $this->mensaje="Cliente si existe";
        }else{
            $this->mensaje="No existe el cliente.";
        }
    }

    /*public function cambiarClaveCliente($codigoCliente="", $nuevaClave="") {
        if($codigoCliente!="" && $nuevaClave!=""){
            $this->parametros = array($codigoCliente, $nuevaClave);
            $this->sp = "str_consultaLogErr_add";
            $this->executeSPAccion();
        }
        if($this->filasAfectadas > 0){
            $this->mensaje="Clave cambiada con éxito";
        }else{
            $this->mensaje="Error al modificar la clave del cliente.";
        }
    }*/

    # Método constructor
    function __construct() {
        //$this->db_name = 'URBALINKS_FINAN';
    }

    # Método destructor del objeto
    function __destruct() {
        unset($this);
    }
}

?>