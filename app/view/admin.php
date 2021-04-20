    <!--Header-->
<header>
	  <nav class="navbar navbar-dark bg-search">
      <div class="container-fluid">
      <a class="btn btn-dark" href="<?php URL; ?>index">
      <img src="<?php Echo IMG; ?>Back_Icon.svg" alt="" width="30" height="24" class="d-inline-block align-text-top">
       Volver
    </a>
  </div>
</nav>
</header>

 <!--Section-->
<section class="container main">
<form class="row g-3 " action="" method="POST">
  <div class="col-12">
     <label class="form-label">Correo Electronico</label>
    <input name="mail" type="mail" class="form-control"  placeholder="correo@ejemplo.com">
  </div>
  <div class="col-12">
     <label class="form-label">Contraseña</label>
    <input name="password" type="password" class="form-control"  placeholder="Contraseña">
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-dark mb-3">Iniciar Sesion</button>
  </div>
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
</div>

    