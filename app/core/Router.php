<?php
/**
 * Clase Router
 * Esta clase es un controlador de las rutas del sistema
 * Proporciona funciones para crear y verificar rutas y llamar controladores
 * con sus funciones
 * @package WebsiteStore
 * @version 1.7
 */
class Router
{
    /**
     * @var array almacena las instancias creadas de rutas
     */
    private $routes;
    /**
     * Funcion constructor 
     */
    public function __construct()
    {
        $this->routes = [];
    }
    /**
     * Funcion para agregar rutas 
     * @param mixed $url direccion a agregar
     * @param mixed $controller controlador a utilizar 
     */
    public function addRoute($url,$controller)
    {
        $this->routes[$url] = $controller;
    }
    /**
     * Funcion para manejar las rutas 
     * @param mixed $url ruta solicitada por el usuario
     * se verifica que la ruta exista y si existe se llama 
     * al controlador configurado para esa ruta
     */
    public function handleRequest($url){
        if(array_key_exists($url,$this->routes)){
            $controller = $this->routes[$url];
            $this->callController($controller);
        }else{
            $this->getErrorPage($url);
        }
    }
    /**
     * Funcion para cargar el controlador
     * @param mixed $controller controlador a llamar
     * llama al controlador con el metodo solicitado
     */
    private function callController($controller){
        list($classname, $method) = explode("::", $controller); 
         if(class_exists($classname)){
            $controllerInstance = new $classname();
               if(method_exists($controllerInstance, $method)){
                  $controllerInstance->$method();
               }else{
                  $this->getErrorPage($controller);
               }
         }else{
              $this->getErrorPage($controller);
         }
    }
    /**
     * Metodo de error cuando la ruta o metodo solicitado no existen
     * @param mixed $url url que el usuario solicito
     */
    private function getErrorPage($url){
        header("HTTP/1.0 404 Not Found");
        die(strtoupper("error 404 $url not found"));
    }
}









