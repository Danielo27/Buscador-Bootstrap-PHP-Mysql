<?php
  /*Parametros de Conexion*/
  require_once "./config.php";

  /*Iniciar sesiones*/
  session_start();

  /*Archivos de la aplicacion*/
  require_once "./app/core/Database.php";
  require_once './app/core/Router.php';
  require_once './app/core/Views.php';


  if(DEBUG === true){

    die("<h1>Estamos Arreglando algunos fallos regresa mas tarde</h1>");

  }else{

  /*Controladores*/ 
  require_once './app/controller/HomeController.php';
  require_once './app/controller/AdminController.php';

  /*Archivos del modelo*/
  require_once './app/model/User.php';
  require_once './app/model/Keyword.php';
  require_once './app/model/Site.php';

  /*instancia del router*/
  $router = new Router();
  $url = isset($_GET['url']) ? $_GET['url'] : '/';

  /*rutas la aplicacion*/
  $router->addRoute('/', 'HomeController::index');
  $router->addRoute('login', 'HomeController::login');
  $router->addRoute('signin', 'HomeController::signin');

  $router->addRoute('admin', 'AdminController::index');
  $router->addRoute('logout', 'AdminController::logout');

  $router->handleRequest($url);
  
 }
