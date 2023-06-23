<?php
/**
 * Clase Site
 * Esta clase representa un sitio web sera la encargada de registrar los sitios web y retornarlos tras las busquedas 
 * realizadas por los clientes.
 * @package WebsiteStore
 * @version 1.7
 */
class Site{
    /**
     * @param object $conn esta variable almacenara una instancia de la clase Database
     */
    private $conn;
    /***
     * Funcion constructor para crear la instancia de la clase database y almacenarla en la variable
     * correspondiente.
     */
    public function __construct(){
        $this->conn = new Database();
    }
    /**
     * Funcion set_Page para registrar una pagina web
     * @param string $pageTitle titulo de la pagina a registrar
     * @param string $pageDescription breve descripcion de la pagina a registrar
     * @param string $pageUrl url de la pagina a registrar
     * 
     * @return array $result contiene el id o primary key del registro ingresado
     */
    public function set_Page($pageTitle,$pageDescription,$pageUrl){
       $newConection = $this->conn->db_conection();
       $query = $newConection->prepare("SELECT save_sites(?, ?, ?)");
       if($query === false){
        die('Error en la preparación de la consulta: ' . $newConection->error);
       }
       $query->bind_param("sss",$pageTitle,$pageDescription,$pageUrl);
       $query->execute();
       $result = $query->get_result()->fetch_assoc();

       $this->conn->db_close($newConection);
       unset($newConection,$query,$pageTitle,$pageDescription,$pageUrl);
       return $result;
    }
    /**
     * Funcion set_Relation_Page para almacenar las relaciones de la tabla Sitio y Keyword
     * @param integer $idKeyword llave primaria de la palabra clave a relacionar
     * @param integer $idPage llave primaria del sitio a relacionar
     * 
     * Esta funcion llenara la tabla relacional de sql que conecta los sitios con las
     * palabras clave.
     */
    public function set_Relation_Page($idKeyword,$idPage){
        $newConection = $this->conn->db_conection();
        $query = $newConection->prepare("CALL save_site_keyword(?,?)");
        if($query === false){
            die('Error en la preparación de la consulta: ' . $newConection->error);
        }
        $query->bind_param("ii",$idKeyword,$idPage);
        
        if(!$query->execute()){
            die("REQUEST ERROR");
        }
        $this->conn->db_close($newConection);
        unset($newConection,$query);
    }
    /**
     * Funcion get_Page para retornar una busqueda
     * @param string $keyword este parametro contendra la busqueda a realizar
     * 
     * Este funcion buscara la palabra clave ingresada en la base de datos para ver que sitios
     * estan relacionados con esa palabra clave y retornarlos que se relacionen con la busqueda.
     * 
     * @return array retornara los datos del sitio web que contenga entre sus palabras clave la palabra
     * buscada.
    */
    public function get_Page($keyword){
        $newConection = $this->conn->db_conection();
        $query = $newConection->prepare("SELECT * FROM sitesInformation 
        INNER JOIN sitesInf_keywrd ON sitesInf_keywrd.id_site_fk=sitesInformation.site_id_pk 
        INNER JOIN keywords ON keywords.id_keyword=sitesInf_keywrd.id_keywords_fk WHERE tag_keyword = ?");
        if($query === false){
           die('Error en la preparación de la consulta: ' . $newConection->error);
        }
        $query->bind_param("s",$keyword);
        $query->execute();
        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        
        $this->conn->db_close($newConection);
        unset($newConection,$query,$keyword);
        return $result;
    }
    /**
     * Funcion get_Last_Page para buscar ultimos sitios registrados
     * @param integer $count parametro que contiene la cantidad de ultimos sitios registrados a retornar
     * 
     * Este funcion traera los ultimos sitios registrados en base al parametro ingresado el tope maximo sera
     * de los ultimos 10 sitios registrados.
     * 
     * @return array $result este retorna la cantidad solicitada por el parametro de entrada de los ultimos
     * sitios registrados.
    */
    public function get_Last_Page($count){
        if($count >! 10){
            $newConnection = $this->conn->db_conection();
            $query = $newConnection->prepare("SELECT * FROM sitesInformation ORDER BY site_id_pk DESC LIMIT ?");
            if($query === false){
                die('Error en la preparación de la consulta: ' . $newConnection->error);
            }
            $query->bind_param("i",$count);
            $query->execute();
            $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        }else{
            die("error request");
        }
        $this->conn->db_close($newConnection);
        unset($query,$newConnection,$count);
        return $result;
    }
    /**
     * Funcion delete_site esta funcion sera para eliminar un sitio
     * @param integer $id esta funcion recibe el id del sitio a eliminar
     *
     * la funcion recibira un identificador del sitio a eliminar y por medio
     * de un procedimiento almacenado en la base de datos se eliminara de la tabla
     * del sitio y de la tabla de relaciones del sitio
     */
    public function delete_site($id){
          $newConnection = $this->conn->db_conection();
          $query =  $newConnection->prepare("CALL delete_sites(?)");
          if($query === false){
            die('Error en la preparación de la consulta: ' . $newConnection->error);
          }
          $query->bind_param("i",$id);
          if(!$query->execute()){
              die("REQUEST ERRROR"); 
          }
          $this->conn->db_close($newConnection);
          unset($newConnection,$query,$id);
    }
}
