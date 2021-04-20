    <!--Header-->
<header>
	<nav class="navbar navbar-light bg-light">
      <div class="container-fluid">
      	  <div class="row">
      	   <form action="" method="POST" class="d-flex col-auto" >
           <input class="form-control me-2" name="search" type="search" placeholder="Buscar" aria-label="Search" required="">
           <button class="btn btn-outline-success" type="submit">Busqueda</button>
          </form>
          <button class="btn btn-outline-dark col-auto"  data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-right: 10px;">
                  Registrar
           </button>

             <a class="btn btn-danger col-auto" href="<?php URL; ?>?logout">
                <img src="<?php  echo IMG; ?>Back_Icon.svg" alt="" width="30" height="24" class="d-inline-block align-text-top">
                      Salir
               </a>
      	  </div>
      </div>
  </nav>
</header>

 <!--Section-->
<section class="container">
          <?php  if(isset($render)){foreach ($render as $print) {  echo $print;}} unset($result,$print) ?>
</section>

    <!--Footer-->
  <footer class="container-fluid footer-second bg-search">
        <div class="row">
            <strong>Hecho Por Daniel Quintero Henriquez</strong>
        <p>Buscador Bootstrap PHP Mysql</p>
        <small>Version 1.5</small>
        </div>
  </footer>

		<!-- Modal -->
  <div class=" modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Pagina</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
	       <form action="" method="POST">
	        <div class="mb-3">
               <label class="form-label">Nombre Pagina</label>
               <input name="title" type="text" class="form-control" placeholder="MiWeb" required>
             </div>
	         <div class="mb-3">
               <label  class="form-label">Link Pagina</label>
               <input name="link" type="text" class="form-control" placeholder="http://www.tuweb.com/" required>
            </div>
            <div class="mb-3">
               <label  class="form-label">Breve Descripcion</label>
              <textarea  name="description" class="form-control"  rows="3" required></textarea>
           </div>
           <div class="mb-3">
               <label  class="form-label">Palabras Claves</label>
               <input name="tags" type="text" class="form-control" placeholder="#miweb #musica #etc" required>
          </div>
          <input type="submit" value="Registrar" class="btn btn-outline-success">
      </form>
     </div>
     <div class="modal-footer">
     	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
     </div>
   </div>
  </div>
