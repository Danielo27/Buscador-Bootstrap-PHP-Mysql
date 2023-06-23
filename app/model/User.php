<?php
/**
 * Clase User
 * Esta clase representa un usuario del sistema
 * Proporciona metodos para gestionar la informacion de los usuarios
 * @package WebsiteStore
 * @version 1.7
 */
class User{
    /**
     * @var mixed Correo electronico del usuario
     */
    private $mail;
    /**
     * @var mixed Contraseña del usuario 
     */
    private $password;
    /**
     * @var object variable para almacenar instancia de la BD
     */
    private $conn;
    /**
     *  Contructor de la clase
     *  crea una instancia de la clase database
     */
    public function __construct(){
        $this->conn = new Database();
    }
    /**
     * @param mixed $mail almacena el correo del usuario si es valido
     */
    public function setMail($mail){
        $response = false;
        if(preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $mail)){
            $this->mail = $mail;
            $response = true;
        }
        return $response;
    }
    /**
     * @param mixed $password almacena la contraseña del usuario si es valida
     */
    public function setPassword($password){
        $response = false;
        if($password != null){
          $this->password = $password;
          $response = true;
        }
        return $response;
    }
    /**
    * @return mixed Correo del usuario
    */
    public function getMail(){
        return $this->mail;
    }
    /**
     * @return mixed Contraseña del usuario
     */
    public function getPassword(){
        return $this->password;
    }
    /**
     * Funcion para registrar un usuario en la BD
     * @param object $user objeto usuario a registrar en la base de datos
     * */ 
    public function db_set_Users(Object $user){
        $mail = $user->getMail();
        $password = $user->getPassword();

        $newConn = $this->conn->db_conection();
        
        $query = $newConn->prepare("CALL save_user(?,?)");
        if($query === false){
            die('Error en la preparación de la consulta: ' . $newConn->error);
        }
        $query->bind_param('ss',$mail,$password);
        $query->execute();

        $this->conn->db_close($newConn);
    }
    /**
     * Funcion para retorna un objeto usuario luego de consultarlo con su correo en BD
     * @param mixed $mail correo del usuario para consultar si existe
     * @return object $user objeto usuario para validar inicio de sesion
     **/
    public function db_get_user($mail){
        $newConn = $this->conn->db_conection();

        $query = $newConn->prepare("SELECT (user_password) FROM users WHERE user_mail = ?");
        $query->bind_param('s',$mail);
        if($query === false){
            die('Error en la preparación de la consulta: ' . $newConn->error);
        }
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        
        $user = new User();
        
        if(!is_array($result)){
            $result = ['user_password' => 'none'];
        }

        $user->setMail($mail);
        $user->setPassword($result['user_password']);

        $this->conn->db_close($newConn);
        return $user;
    }
}




