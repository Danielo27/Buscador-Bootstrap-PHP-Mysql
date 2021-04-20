    <!--Header-->
    <header>	
	     <nav class="navbar navbar-light bg-light ">
            <div class="container-fluid">
                <form action="" method="POST" class="d-flex" id="search">
                       <input class="form-control me-2" name="search" type="search" placeholder="Buscar" aria-label="Search" required="">
                        <button class="btn btn-outline-success" type="submit">Busqueda</button>
                </form>
                <a class="navbar-brand" href=" " data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <img src="<?php echo IMG ?>More_Icon.svg" alt="" width="100" height="30" class="d-inline-block align-text-top">
                </a>
             </div>
         </nav>
	</header>
  <br>
    <!--Section-->
	<section class="container">
         <div>
         	<?php  foreach ($render as $print) {  echo $print;} ?>
         </div>
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
  <div class="made modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buscador Bootstrap PHP Mysql V1.5</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
        <p>Este Buscador Basicamente fue realizado para poder almacenar los enlaces de una
        Intranet que habia realizado pero que me era dificil recordar cada link a cada trabajo, tanto para mi como para aquellos que trabajaban conmigo en el mismo servidor, por dicha razon fue hecha de manera bastante basica; tiene muchas cosas que ser mejoraradas pero cumple su proposito.
       </p>
        <p><small>Hecho Por Daniel Quintero Henriquez</small></p>
     </div>
     <div class="modal-footer">
     	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
     </div>
   </div>
  </div>

