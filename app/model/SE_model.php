  <?php
//SE_Model 1.5
  class Search_Engine
  {
          //Funcion para preparar el resultado de una busqueda para imprimir
           public function render($data,$view){

                $result = array();
                $count = count($data);

                if($count > 0 and $count != 404)
                {

                  foreach ($data as $print) { //ahora se imprimen las cordenadas

                  if($view == 1){
                  $del = "<a class='result' href='?del=".$print['id_metainf_pk']."'><p><small>Eliminar</small></p></a></div><br>";
                  }else{
                    $del = null;
                  }

                    $result[ ] =  "<div>
                             <a class='result' href='".$print['link_metainf']."'>".$print['title_metainf']."</a>
                            <a class='result'><p><small>".$print['link_metainf']." </small></p></a>
                            <p class='result'>".$print['description_metainf']."</p>".$del;
                            }
                
               }else{

                    $result[ ] = "<div class='card failed'>
                                   <div class='card-header'>ERROR 404</div> 
                                   <div class='card-body'> 
                                         <h5 class='card-title'>No se ha podido hallar nada</h5> 
                                         <p class='card-text'>No se ha podido encontrar contenido que concuerde con tu busqueda</p> 
                                        <a href='".URL."' class='btn btn-primary'>Volver al Principio</a> 
                                  </div> 
                               </div>";
                }
                return $result;
                unset($count,$data,$print);
           }
            //Funcion para crear una sesion
           public function sesion($data)
           {
              $_SESSION['sesion'] = $data;
           }
           //Funcion para cerrar sesion
           public function logout()
           {
             session_unset();
             session_destroy();
           }

  }
  ?>