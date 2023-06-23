<?php
/**
 * Clase Keyword
 * Esta clase representa una palabra clave estas son las #etiquetas con las cuales el usuario relacionara cada sitio registrado
 * en la aplicacion y sera la base de las busquedas de los sitios en base a las palabras claves asignadas a cada sitio
 * @package WebsiteStore
 * @version 1.7
 */
class Keyword{
    /**
     * @var object $conn esta variable almacenara una instacia de la clase Database
    */
    private $conn;
    /**
     * funcion constructor con el cual se creara una instancia de la base de datos
     *  y se alamacenara en la variable dispuesta.
    */
    public function __construct(){
        $this->conn = new Database();
    }
    /**
     * funcion set_keyword sera la encargada de almacenar en la BD las palabras claves ingresadas por el usuario
     * haciendo uso de una funcion save_keyword de la base de datos esta funcion retornara la primary key del registro
     * ingresado retornandonos el id de la keyword registrada.
     * @param mixed $keyword palabra clave a registrar.
     * @return array $result id del registro ingresado.
     */
    public function set_keyword($keyword){
        $newConn = $this->conn->db_conection();
        $query = $newConn->prepare("SELECT save_keyword(?)");
        if($query === false){
            die('Error en la preparación de la consulta: ' . $newConn->error);
        }
        $query->bind_param('s',$keyword);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
         
        $this->conn->db_close($newConn);
        unset($query,$keyword);
        return $result;
    }

}

