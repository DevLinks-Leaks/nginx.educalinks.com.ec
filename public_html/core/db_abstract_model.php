<?php
/* 
 * Clase para establecer la conexión con la BD y gestion de los procesos a ejecutar.
 * @package core
 * @abstract
 */session_start();


//require_once('../core/db_abstract_model.php');

abstract class DBAbstractModel{
	
    private $configuracion;     /*Arreglo con la configuracion global de conexion del archivo settings.ini.php. @var array @access private */
    private $connectionInfo;    /*Arreglo con la configuracion de conexion a la BD. @var array @access private */
    private $conn;              /*Objeto de conexion @var object @access Private  */
    protected $query;           /*Sentencia SQL a ejecutar @var string @access protected */
    protected $sp;              /*Nombre del procedimiento almacenado a ejecutar @var string @access protected */
    protected $parametros;      /*Arreglo con los valores de los parametros de los procedimientos almacenados @var array @access */
    public $rows= array();      /*Filas devueltas de la consulta @var array @access Public */
    public $filasAfectadas = 0; /*Numero de filas afectadas con la sentencia o procedimiento almacenado @var integer @access public */
    public $filasDevueltas = 0; /*Numero de filas devuletas con la sentencia o procedimiento almacenado @var integer @access public */
    public $error = array();    /*Arreglo con los errores por excepcion o de BD. @var array @access public */
    
    public $mensaje;
	
    # métodos abstractos para ABM de clases que hereden
    /*abstract protected function get();
    abstract protected function set();
    abstract protected function edit();
    abstract protected function delete();*/
    # los siguientes métodos pueden definirse con exactitud y
    # no son abstractos 
    # Conectar a la base de datos

    
    /*
     * Crea la conexion a la base de datos.
     * 
     * @access Private
     */
    private function open_connection(){
        /*$this->configuracion = parse_ini_file("settings.ini.php");

        $this->connectionInfo = array("Database"=>$this->configuracion['dbname'], "UID"=>$this->configuracion['user'], "PWD"=>$this->configuracion['password']);*/

        /*if(!isset($_SESSION['dbname'])){
            get_database_params();
        } */     
	
        $this->connectionInfo = array("Database"=>$_SESSION['dbname'], "UID"=>$_SESSION['user'], "PWD"=>$_SESSION['pass']
                                      ,"CharacterSet"=>"UTF-8", "LoginTimeout"=>6000);
        $this->conn= sqlsrv_connect($_SESSION['host'],$this->connectionInfo);
        if( $this->conn === false){
            echo "Error in connection.\n";
            die( print_r( sqlsrv_errors(), true));
        }
    }
    /*
     * Cierra la conexion existente con la base de datos.
     * 
     * @access Private
     */
    private function close_connection(){
        sqlsrv_close($this->conn);
    }
    /*
     * Mantiene de manera temporal informacion del error ocurrido.
     * 
     * @access Private
     * @param String $funcion Nombre del procedimiento donde sucedio el error.
     * @param String $sentencia Nombre de la sentencia o procedimiento almacenado donde se origino el error.
     * @param String $excecion Mensaje del error arrojado por el try catch.
     * @param Array $sqlsrv Arreglo con los errores generados por la libreria sqlsrv.
     */
    private function guardaError($funcion = '', $sentencia = '', $excepcion = '', $sqlsrv = array()){
        $this->error['funcion'] = $funcion;
        $this->error['sentencia'] = $sentencia;
        $this->error['excepcion'] = $excepcion;
        foreach($sqlsrv as $error){
            $this->error['sqlestado'] = $error['SQLSTATE'];
            $this->error['sqlcodigo'] = $error['code'];
            $this->error['sqlmensaje'] = $error['message'];						
        }
    }
    /*
     * Retorna lo almacenado en el arreglo $error formateado en un mensaje tecnico.
     * @access Public
     * @return String Mensaje del error.
     */
    public function ErrorToString(){
        $mensaje = "";
        if(count($this->error)>0){
            $mensaje = " Error en la funcion ".$this->error['funcion'].", al ejecutar la sentencia ".$this->error['sentencia'];
            $mensaje .= "Excepcion: ".$this->error['excepcion'];
            $mensaje .= "SQLSTATE: ".$this->error['sqlestado']."; SQLCODE: ".$this->error['sqlcodigo']."; SQLMESSAGE: ".$this->error['sqlmensaje'];
        }
        return $mensaje;	
    }
    /*
     * Genera el patron de parametrizacion del procedimiento almacenado deacuerdo al numero de 
     * elementos definidos en la variable $parametros.
     * 
     * @access Private
     * @return String Patron de parametrizacion: (?,?,..)
     */
    private function parametrizacion(){
        $parametrizacion = "";
        if(count($this->parametros)>0){
            $parametrizacion = "(";
            foreach($this->parametros as $parametro){
                $parametrizacion .= "?,";
            }
            $parametrizacion = substr_replace($parametrizacion, ")", -1);
        }
        return $parametrizacion;
    }
    /*
     * Ejecuta un procedimiento almacenado de tipo no consulta.
     * 
     * @access protected
     * @return Integer Numero de filas afectadas.
     */
    protected function executeSPAccion(){
        $this->filasAfectadas = 0;
        try{
            $this->open_connection();
            $this->query = "{CALL ".$this->sp.$this->parametrizacion().'}';
            $stmt = sqlsrv_query($this->conn,$this->query,$this->parametros);

            if(!$stmt){ 
                $this->guardaError("executeSPAccion", $this->sp, "Error SQL  ", sqlsrv_errors() ); 
            }else{ 
                //sqlsrv_next_result($stmt); // Esto es para los SPs con parametros de salida
                $this->filasAfectadas =  sqlsrv_rows_affected($stmt); 
            }
            sqlsrv_free_stmt($stmt);
            $this->close_connection();          
        }catch(Exception $e){
            $this->guardaError("executeSPAccion", $this->sp, $e->getMessage(), array() );
        }
        return $this->filasAfectadas;
    }

    protected function executeSPAccionOut(){
        $this->filasAfectadas = 0;
        try{
            $this->open_connection();
            $this->query = "{CALL ".$this->sp.$this->parametrizacion().'}';
            $stmt = sqlsrv_query($this->conn,$this->query,$this->parametros);

            if(!$stmt){ 
                $this->guardaError("executeSPAccion", $this->sp, "Error SQL  ", sqlsrv_errors() ); 
            }else{ 
                sqlsrv_next_result($stmt); // Esto es para los SPs con parametros de salida
                $this->filasAfectadas =  sqlsrv_rows_affected($stmt); 
            }
            sqlsrv_free_stmt($stmt);
            $this->close_connection();          
        }catch(Exception $e){
            $this->guardaError("executeSPAccion", $this->sp, $e->getMessage(), array() );
        }
        return $this->filasAfectadas;
    }
    /*
     * Ejecuta un procedimiento almacenado de tipo consulta.
     * 
     * @access protected
     * @return Integer Numero de filas devueltas.
     */
    protected function executeSPConsulta(){
        $this->rows = array();
        $this->filasDevueltas = 0;
        try{
            $this->open_connection();
            $this->query = "{CALL ".$this->sp.$this->parametrizacion().'}';
            $result = sqlsrv_query($this->conn,$this->query,$this->parametros);	
            if(!$result){
                $this->guardaError("executeSPConsulta", $this->sp, "Error SQL", sqlsrv_errors() );				
            }else{
                while ($this->rows[]=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC));
                $this->filasDevueltas = count($this->rows);
            }
            sqlsrv_close($result);
            $this->close_connection();			
        }catch(Exception $e){
            $this->guardaError("executeSPConsulta", $this->sp, $e->getMessage(), array() );
        }
        return $this->rows;	
    }
    /*
     * Ejecuta una sentencia de tipo consulta.
     * 
     * @access protected
     * @return Integer Numero de filas devueltas.
     */
    protected function executeSentenciaConsulta(){
        $this->rows = array();
        $this->filasDevueltas = 0;
        try{
            $this->open_connection();
            $result = sqlsrv_query($this->conn,$this->query, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
            if(!$result){
                $this->guardaError("executeSentenciaConsulta", $this->query, "Error SQL", sqlsrv_errors() );	
            }else{
                while ($this->rows[]=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC));
                $this->filasDevueltas = sqlsrv_num_rows($result);
            }
            sqlsrv_close($result);
            $this->close_connection();			
        }catch(Exception $e){
            $this->guardaError("executeSentenciaConsulta", $this->query, $e->getMessage(), array() );
        }
        return $this->rows;	
    }
    /*
     * Ejecuta una sentencia de tipo no consulta.
     * 
     * @access protected
     * @return Integer Numero de filas afectadas.
     */
    protected function executeSentenciaAccion(){
        $this->filasAfectadas = 0;
        try{
            $this->open_connection();
            $stmt = sqlsrv_query($this->conn,$this->query, array());
            if(!$stmt){
                $this->guardaError("executeSentenciaAccion", $this->query, "Error SQL", sqlsrv_errors() );	
            }else{
                $this->filasAfectadas =  sqlsrv_rows_affected($stmt);
            }
            $this->close_connection();			
        }catch(Exception $e){
            $this->guardaError("executeSentenciaAccion", $this->query, $e->getMessage(), array() );
        }
        return $this->filasAfectadas;
    }
}
?>