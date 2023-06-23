<?php
/**
 * Clase Views
 * Esta clase contiene los metodos para cargar las vistas de mi aplicacion
 * @package WebsiteStore
 * @version 1.7
 */
class Views{
    /**
     * @var mixed variable para almacenar la ruta de las vistas
    */
    private $templateDirectory;
    /**
     * @param mixed $templateDirectory metodo constructor para asignar la ruta de las vistas
     */
    public function __construct($templateDirectory){
           $this->templateDirectory = $templateDirectory;
    }
    /**
     * Function render, funcion para llamar las vistas a presentar en la aplicacion
     * @param mixed $viewFile variable para almacenar el nombre de la vista sin extension de archivo
     * @param array $data array para almacenar los datos a mosrar en la vista
     * 
     * en caso de error se dara un error 404 nombre plantilla template not found si no se da el error
     * se incluira la vista donde el dev podra cargar la data.
     */
    public function render($viewFile,$data = []){
        $templatePath = "$this->templateDirectory/$viewFile.php";

        if(file_exists($templatePath)){
            extract($data);
            include $templatePath;
        }else{
            throw new Exception("404 Error $templatePath Template not found");
        }
    }
}

