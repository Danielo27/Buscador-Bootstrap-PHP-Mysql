<?php
/**
 * Clase Database
 * Esta clase contiene los metodos para conectarse y 
 * desconectarse de la base de datos asi como los parametros
 * de conexion con la base de datos
 * @package WebsiteStore
 * @version 1.7
 */
class Database{
    /**
     * @var mixed host de la BD
     */
    private $host;
    /**
     * @var mixed Nombre de la BD
     */
    private $db_name;
    /**
     * @var mixed Nombre de usuario de la BD
     */
    private $username;
    /**
     * @var mixed Contraseña de conexion con la BD
     */
    private $password;
    /**
     * @var object Almacenar conexion con la base de datos
     */
    private $conn;    

    private $port;
    /**
     * Contructor de la clase
     * @param mixed $host host de la BD
     * @param mixed $db_name nombre de la BD a usar
     * @param mixed $username nombre usuario DBA
     * @param mixed $password contraseña usuraio DBA
     */
    public function __construct(){
        $this->host = HOST;
        $this->db_name = DATABASE;
        $this->username = USER;
        $this->password = PASSWORD;
        $this->port = PORT;
    }
    /**
     * Establece conexion con la base de datos
     * @return object Crea una instacia de la clase mysqli y establece una conexion con los parametros suministrados en la clase
     */
    public function db_conection(){
        $this->conn = null;
        try{
           $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name,$this->port);

           if ($this->conn->connect_errno) {
            throw new Exception(strtoupper("failed to connect : " . $this->conn->connect_error));
           }
        }catch(Exception $e){
           die(strtoupper('error to conect with database <br>' . $e->getMessage()));
        }
        return $this->conn;
    }
    /**
     * Cerrar conexion con la base de datos
     * @param object $conn instancia de la clase mysqli
     */
    public function db_close($conn){
        $conn->close();
    }
}

