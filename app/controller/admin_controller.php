<?php
/*=================================================
==============|ADMIN CONTROLLER V1.5===============
===================================================|*/
session_start();

//Incorporo los archivos Necesarios
require "app/model/SE_model.php";
require "app/model/DB_model.php";

/*Inicializo las clases*/
$DB_model = new DataBase();
$SearchEngine = new Search_Engine();

//Establezco una Variable con un script en caso de error
$error = "<script>Swal.fire({icon: 'error',title: 'Lo Sentimos...',text: 'Ha ocurrido un error!',footer: 'Intentalo nuevamente'})</script>";

//LLamare la funcion de cerrar sesion si existe un request
if(isset($_REQUEST['logout']))
  {
    $SearchEngine->logout();
    header("location:".URL."admin");
  }

/*Empiezo a imprimir la pagina: cabezera*/
require "app/view/inc/header.php";

//Si no existe ninguna peticion traere los ultimos 6 registros
  if(!isset($_POST['search'])){
    $conn = $DB_model->conection();
    $result = $DB_model->resultGET($conn);
    $render = $SearchEngine->render($result,1);
    $count = count($render);
    if($count < 4 ){
      echo "<style> .footer-second{position: fixed; bottom: 0; } </style>";
    }
  }

//Verifico si existe alguna sesion
if(isset($_SESSION['sesion'])){
  //verifico si existe un post
  if(isset($_POST['search'])){
    //si lo hay almacenare dicho post en una variable
    $search = $_POST['search'];
    $conn = $DB_model->conection();
    $result = $DB_model->search($search,$conn);
    $render = $SearchEngine->render($result,1);
    $cont = count($result); 
    if($cont < 4){ 
      echo "<style> .footer-second{position: fixed; bottom: 0; } </style>";
    }/*para que no vaya a quedar el footer ala mitad*/
  }

//Continuo Imprimiendo La parte central de la pagina
require "app/view/controlPanel.php"; 

//Si existen los siguientes post los almacenare en variables
if(isset($_POST['title']) AND isset($_POST['link']) AND isset($_POST['description']) AND isset($_POST['tags'])){      

      $title = ucwords($_POST['title']." : ");
      $link = strtolower($_POST['link']);
      $description = ucfirst($_POST['description']);
      $dataTags = strtolower($_POST['tags']);
      $tags = explode("#", $dataTags);
      
      //ejecuto una funcion para ver si el link ingresado existe
      $conn = $DB_model->conection();
      $result = $DB_model->linkGET($link,$conn);

      if($result == false){ //si no existe registrare los datos
          if($DB_model->pageSET($title,$link,$description,$conn) == true){

              $result = $DB_model->linkGET($link,$conn);
              if($result == false){
                 echo $error;//si retorna false entendere que ha ocurrido un error
              }else{
                 //si no ha ocurrido ningun error
                foreach ($result as $print) {//extraigo el id de la pagina ingresada
                  $link_id = $print['id_metainf_pk'];
                }

                foreach ($tags as $insert) {//empiezo a verificar si las palabras claves existen
                 $validation = $DB_model->tagGET($insert,$conn);
                 if($validation == false)//si no existe la palabra clave
                 {
                   if(!empty($insert)){//Verifico que no este vacia la variable 
                    $DB_model->tagSET($insert,$conn);//Antes de ingresarlo
                   }
                 }
                }//Aqui empezare a registrar el id del link con sus keywords
                $tags_id = array();
                foreach ($tags as $validate) {
                    if(!empty($validate)){//si no esta vacia la variable
                        $result = $DB_model->tagGET($validate,$conn);
                        //consulto y traigo los datos de esa palabra clave
                    foreach ($result as $save) {
                      //almaceno el id de la palabra clave
                      $tags_id[ ] = $save['id_keywords'];
                    }
                  }
                }
                //ingreso el id de la pagina y el id de la keyword
                //creando asi la relacion palabra clave y pagina
                foreach ($tags_id as $var) {
                 $DB_model->page_tag_SET($var,$link_id,$conn);     
                }
                //una vez terminado imprimire un script en pantalla que todo es correcto
                Echo "<script>Swal.fire({icon: 'success',title: 'Los Registros Han sido Ingresados Exitosamente',text: 'Recarga Para Ver El Resultado',html: '<a href="." ".URL."admin".">Recargar</a>'})</script>";
                }
              }
          
      }else{
        //de lo contrario imprimire que ocurrio un error
        echo $error;
      }

}

if(isset($_REQUEST['del'])){
      $result = $DB_model->page_Drop($_REQUEST['del'],$conn);
      if($result == false){
        Echo $error;
      }else{
        Echo "<script>Swal.fire({icon: 'success',title: 'Los Registros Han sido Eliminados Exitosamente',text: 'Recarga Para Ver El Resultado',html: '<a href="." ".URL."admin".">Recargar</a>'})</script>";
      }
}

//si no existe una sesion
}else{
//si recibe el post mail y password se entendera que se va a iniciar sesion
  if(isset($_POST['mail']) AND isset($_POST['password'])){
    
    //valido que no esten vacias las dos peticiones
    if(!is_null($_POST['mail']) AND !is_null($_POST['password'])){

    //los almaceno en variables
    $user = htmlentities($_POST['mail']);
    $password = htmlentities($_POST['password']);

$conn = $DB_model->conection();
$result = $DB_model->loggin($user,$password,$conn);//valido los datos

if($result == true){ 
//si es correcto creo una sesion
$SearchEngine->sesion($result);
require "app/view/controlPanel.php"; //llamo a la nueva vista

}else{
echo $error;//de lo contrario imprimo que hubo un error
require "app/view/admin.php";
}
}
else{//si falta alguno de los post 
echo $error;//imprimire que ha ocurrido un error
require "app/view/admin.php";//y la vista
}

}else{
  //vista de inicio de sesion si no existe una sesion iniciada
	require "app/view/admin.php";
  }
}

//imprimo el pie de pagina
require"app/view/inc/footer.php";

?>