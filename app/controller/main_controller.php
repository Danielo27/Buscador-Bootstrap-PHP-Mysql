<?php
/*=================================================
==============|MAIN CONTROLLER V1.5===============
===================================================|*/
//incluyo los archivos
require "app/model/SE_model.php";
require "app/model/DB_model.php";

//llamo las clases
$DB_model = new DataBase();
$SearchEngine = new Search_Engine();

/*Empiezo a Cargar la vista*/
require "app/view/inc/header.php";

if(isset($_POST['search'])){

	$search = $_POST['search']; 
    $conn = $DB_model->conection();
    $result = $DB_model->search($search,$conn);
    $render = $SearchEngine->render($result,0);

    $cont = count($result);

    if($cont < 6){ /*para que no vaya a quedar el footer ala mitad*/
      echo "<style> .footer-second{position: fixed; bottom: 0; } </style>";
    }
    include_once "app/view/search.php";	
    }else{//Si no hay ninguna peticion imprimo la pagina principal
    include_once"app/view/main.php";
    }
    
require "app/view/inc/footer.php";
?>