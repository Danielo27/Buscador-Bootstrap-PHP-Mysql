<?php
//DB Model V1.5
class DataBase{
//Variables de conexion
   private $url;
   private $user;
   private $pass;
   private $db;

   public function __construct()
   {
       $this-> url = HOST;
       $this-> user = USER;
       $this-> pass = PASSWORD;
       $this-> db = DB;
   }
   //Funcion para conectar con la base de datos (funcional)
    public function conection()
    {
        $mysqli = new mysqli($this->url,$this->user,$this->pass,$this->db);
		
        if ($mysqli->connect_error)
        {
                echo "<script>alert('Ha ocurrido un error mientras se intentaba conectar con la base de datos')</script>";
        }
        else 
        {
        return $mysqli;
        }
    }
    // Funcion para buscar Paginas (funcional)
    public function search($data,$conn)
    {
    	   $data = strtolower($data);

           $sql = "SELECT `id_metainf_pk`,`title_metainf`,`description_metainf`,`link_metainf` FROM `metainf` INNER JOIN `SearchEngineRelation` ON `SearchEngineRelation`.`id_metainf_fk` = `metainf`.`id_metainf_pk` 
               INNER JOIN `keywords` ON `keywords`.`id_keywords` = `SearchEngineRelation`.`id_keywords_fk`
               WHERE `tags_keywords` = '$data'";

           if ($query = $conn->query($sql))
		       {
		       $count = $query->num_rows;
               if (!is_null($count))
                {
				         $result = array();
              				
	              while ($row = $query->fetch_array(MYSQLI_ASSOC))
	               {
		              $result[ ] = $row;
	               }
              }	else {
                 $result[ ] = 404;
              }
           return $result;
           mysql_close($conn);
        }
    }
    // Funcion para buscar ultimas 6 Paginas Registradas (funcional)
     public function resultGET($conn)
     {
       $sql = "SELECT `title_metainf`,`description_metainf`,`link_metainf`,`id_metainf_pk` FROM `metainf` ORDER BY `id_metainf_pk` DESC LIMIT 6";

        if ($query = $conn->query($sql))
           {
           $count = $query->num_rows;
               if (!is_null($count))
                {
                 $result = array();
                      
                while ($row = $query->fetch_array(MYSQLI_ASSOC))
                 {
                  $result[ ] = $row;
                 }
              } else {
                 $result[ ] = 404;
              }
           return $result;
           mysql_close($conn);
     }
   }

    //Funcion para validar inicio de sesion(funcional)
    public function loggin($user,$pasword,$conn)
    {
       $dataUser = strtolower($user);
       $dataPassword = md5($pasword);
       unset($user,$pasword);

        $query = $conn->prepare("SELECT `userid_lg` FROM `loggin` WHERE `mail_lg` = ? AND `password` = ? ");
        $query->bind_param("ss", $dataUser , $dataPassword );
        $query->execute();
        $count = $query->get_result()->num_rows; 
        $query->close();

         if($count > 0)
         {
             $result = true;
         }
         else
         {
           $result = false;
         }
       

       return $result;
    }
    //Funcion para registrar paginas(funcional)
    public function pageSET($title,$link,$description,$conn){

         $query = $conn->prepare("INSERT INTO `metainf` (`title_metainf`,`link_metainf`,`description_metainf`) VALUES (? , ? , ? ) ");
         $query->bind_param("sss", $title, $link, $description);
         if($query->execute()){
           $query->close();
           $var = true;
         }else{
          $var = false;
         }
         return $var;
    }
    //Funcion para ver Si el link de una pagina ya existe(funcional)
    public function linkGET($link,$conn){
      $sql = "SELECT * FROM `metainf` WHERE `link_metainf` =  '$link' ";
      if($query = $conn->query($sql)){
        $count = $query->num_rows;
         if($count > 0){
             $result = array();
              while ($row = $query->fetch_array(MYSQLI_ASSOC))
                 {
                  $result[ ] = $row;
                 }
         }else{
            $result = false;
         }
      }else{
         $result = false;
      }
      return $result;

    }
   //Funcion para ver si un tag ya existe(funcional)
    public function tagGET($tag,$conn)
    {
      $sql = "SELECT * FROM `keywords` WHERE `tags_keywords` = '$tag' ";
      if($query = $conn->query($sql)){
        $count = $query->num_rows;
        if($count > 0){
        $result = array();
        while ($row = $query->fetch_array(MYSQLI_ASSOC)){

          $result[ ] = $row;
        }
      }else{
        $result = false;
       }
      }else{
        $result = false;
      }
      return $result;
    }
    //Funcion para registrar el tag de una pagina(funcional)
    public function tagSET($tag,$conn)
    {
      $query = $conn->prepare("INSERT INTO `keywords` (`tags_keywords`) VALUES ( ? ) ");
      $query->bind_param("s",$tag);
      if($query->execute())
      {
        $result = true;
      }else{
        $result = false;
      }
      $query->close();
      return $result;
    }

    //Funcion para relacion tag pagina(funcional)
    public function page_tag_SET($idtag,$idpage,$conn)
    {
         $query = $conn->prepare(" INSERT INTO `searchenginerelation` (`id_keywords_fk`,`id_metainf_fk`) VALUES (? , ? ) ");
         $query->bind_param("ii", $idtag, $idpage);
         if($query->execute()){
           $result = true;
         }else{
           $result = false;
         }
         $query->close();
         return $result;
    }    
   
   //Funcion para Eliminar Pagina
    public function page_Drop($id_page,$conn){
      $query = $conn->prepare("DELETE FROM `metainf` WHERE `metainf`.`id_metainf_pk` = ? ");
      $query->bind_param("i",$id_page);
      if($query->execute()){
      $query = $conn->prepare("DELETE FROM `searchenginerelation` WHERE `searchenginerelation`.`id_metainf_fk` = ? ");
      $query->bind_param("i",$id_page);
      if($query->execute()){
        $result = true;
      }else{
        $result = false;
      }
      }else{
        $result = false;
      }
      return $result;
    }
}

?>

