<?php
/**
 * Clase HomeController
 * Esta clase sera el controlador principal de la aplicacion contiene
 * las funciones que podra realizar un cliente que no este registrado
 * asi como el inicio de sesion necesario para el administrador
 * @package WebsiteStore
 * @version 1.7
 */
class HomeController{
     /**
      * @param object $view contendra una instancia de la clase Views del core
      */
     private $view;
     /**
      * @param object $user contendra una instancia de la clase User del modelo
      */
     private $user;
     /**
      * @param object $site contendra una instancia de la clase Site del modelo
      */
     private $site;
     /**
      * Funcion construct para realizar las instancias de las clases que usaremos almacenando
      * estas instancias en las variables preparadas.
      */
     public function __construct(){
        $this->view = new Views("./app/view");
        $this->user = new User();
        $this->site = new Site();
     }
     /**
      * Funcion index esta funcion sera la entrada principal a la aplicacion 
      * si se realiza un request este enviara al modelo el request y enviara
      * la respuesta del modelo a la vista
      */
     public function index(){
      $this->view->render('/partial/header');
        if(isset($_REQUEST['search'])){
          $result = $this->site->get_page($_REQUEST['search']);

          $state = true;

          if($result == null){
             $result = "no se han encontrado resultados para <strong>{$_REQUEST['search']}</strong>";
             $state = false;
          }

          $this->view->render('search',['response' => ['state' => $state ,'data' => $result]]);
        }else{
           $this->view->render('index',['title' => '/login']);
        }
        $this->view->render('/partial/footer');
     }
     /**
      * Funcion login esta funcion sera la encargada de validar el inicio de sesion de un
      * administrador para esto capturara el request de correo y contraseña los validara en 
      * el modelo y si es correcto lo enviara al controlador encargado del administrador
      * y creara una sesion para el administrador que haya iniciado la sesion
      */
     public function login(){
      $this->view->render('/partial/header');
      
      if(isset($_SESSION['user'])){
          header("Location:/admin");
      }else if(isset($_REQUEST['mail']) && isset($_REQUEST['password'])){
        $mail = $_REQUEST['mail'];
        $hashPassword = md5($_REQUEST['password']);
        
        $validator = $this->user->db_get_user($mail);

        if($hashPassword != $validator->getPassword()){ 
          $this->view->render('login',['error' => 'Usuario o contraseña incorrectos']);
        }else{
          $_SESSION['user'] = $validator->getMail();
          header("Location:/admin");
        }
      }else{
        $this->view->render('login');
      }
      $this->view->render('/partial/footer');
     }
}