<?php
/**
 * Clase AdminController
 * Esta clase sera el controlador que contendra las funciones
 * que podra realizar un administrador
 * @package WebsiteStore
 * @version 1.7
 */
class AdminController{
   /** 
    * @var object $view contendra una instancia de la clase Views del core 
     */
   private $view;
   /**
    * @var object $site contendra una instancia de la clase site del modelo
    */
   private $site;
   /**
    * @var object $user contendra una instancia de la clase user del modelo
    */
   private $user;
   /**
    * funcion contructora que realizara una instancia de las clases necesarias y las
    * almacenara en las variables dispuestas
    */
    public function __construct(){
          $this->view = new Views("./app/view");
          $this->site = new Site();
          $this->user = new User();
    }
    /**
     * funcion index esta funcion sera la entrada principal de la clase 
     * sirve para que el administrador registre y elimine sitios por
     * defecto al ingresar un administrador le mostrar los ultimos 5 sitios
     * registrados tambien permitira buscar los sitios al administrador.
    */
    public function index(){
      $this->view->render('/partial/header');
      $state = true;

       if(isset($_SESSION['user'])){
        
         if(isset($_REQUEST['title']) && isset($_REQUEST['link']) && isset($_REQUEST['description']) && isset($_REQUEST['tags'])){
          
          $title = $_REQUEST['title'];
          $descritpion = $_REQUEST['description'];
          $url = $_REQUEST['link'];

          $tags = explode('#', $_REQUEST['tags']);

          $idPage = $this->site->set_page($title,$descritpion,$url);
          $keyPage = array_values($idPage);

          foreach($tags as $row){
              $keyword = new Keyword();
              
              if($row != null){
                $id = $keyword->set_keyword($row);
                $key_KeyWord = array_values($id);

                $this->site->set_Relation_Page($key_KeyWord[0],$keyPage[0]);

              }
          }
          header("location:/admin?sucess");
  
        }else if(isset($_REQUEST['search'])){
          $response = $this->site->get_Page($_REQUEST['search']);
  
          if($response == null){
             $response = "no se han encontrado resultados para <strong>{$_REQUEST['search']}</strong>";
             $state = false;
          }
  
          $this->view->render('panel',['response' => ['state' => $state ,'data' => $response]]);

       }else if(isset($_REQUEST['delete']) && $_REQUEST['delete'] != null){
             $this->site->delete_site($_REQUEST['delete']);
             header("Location:/admin?success");
       }else{
            $response = $this->site->get_Last_Page(5);

            if($response == null){
              $response = "no hay registros para mostrar</strong>";
              $state = false;
           }
           
           $this->view->render('panel', ['response' => ['state' => $state ,'data' => $response]]);
       }
      }else{
        header("location:".ROUTE);
      }
      $this->view->render('/partial/footer');
    }

     /**
      * Funcion signin esta funcion registrara administradores en la base de 
      * datos no aplicada aun
      */
      public function signin(){
        if(isset($_SESSION['user'])){
          if(isset($_POST['mail']) && isset($_POST['password'])){
            $mail =  $_POST['mail']; 
            $password = $_POST['password'];
  
            if($this->user->setMail($mail) &&  $this->user->setPassword($password)){
               $this->user->db_set_Users($this->user);
               die("REGISTRO EXITOSO");
            }else{
               die("ERROR AL REALIZAR EL REGISTRO");
            }
          }
        }else{
            die("ERROR AL REQUEST ERRONEO");
        }
   }
    /**
     * Funcion para cerrar la sesion del administrador
     * esta eliminara la sesion creada y lo redireccionara 
     * al menu principal
     */
    public function logout(){
        if(isset($_SESSION['user'])){
          session_destroy();
          header('Location:'.ROUTE);
        }
     }
}