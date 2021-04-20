    <!--Header-->
<header>
	  <nav class="navbar navbar-dark bg-search">
      <div class="container-fluid">
      <a class="btn btn-light" href="<?php echo URL; ?>admin">
      <img src="<?php Echo IMG; ?>User_icon.svg" alt="" width="30" height="24" class="d-inline-block align-text-top">
      Administrador
    </a>
  </div>
</nav>
</header>
    <!--Section-->
<section class="container main">
	<img src='<?php Echo IMG; ?>logo.png' alt='buscador logo' width='50%' height='30%'>
    <form action="" method="POST" class="d-flex" id="search">
           <input class="form-control me-2" name="search" type="search" placeholder="Buscar" aria-label="Search" required="">
           <button class="btn btn-success" type="submit"><img src="<?php echo IMG ?>Search_icon.svg" width="30" height="24" class="d-inline-block">Busqueda</button>
    </form>
</section>
    <!--Footer-->
  <footer class="container-fluid footer-main bg-search">
        <div class="row">
            <strong>Hecho Por Daniel Quintero Henriquez</strong>
        <p>Buscador Bootstrap PHP Mysql</p>
        <small>Version 1.5</small>
        </div>
  </footer>

