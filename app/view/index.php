<link rel="stylesheet" href="<?php echo ASSETS ?>/css/index.css" type="text/css"> </head>  <body> <!--Cabecera--> <header class="header container-fluid"> <nav class="header__nav row"> <div class="header__nav__div col-auto"> <a href="<?php echo ROUTE ?>/login" class="header__nav__div__a btn customButton"><i class="bi bi-person-circle"></i> Administrador</a> </div> </nav> </header>  <!--Seccion--> <section class="index container"> <div class="index__div row d-flex justify-content-center"> <div class="index__div__div col-auto"> <div class="index__div__div__div d-flex justify-content-center"> <img class="index__div__div__div__img img-fluid" src="<?php echo ASSETS ?>/img/Logo.png" alt="logo proyecto buscador bootstrap php y mysql" title="Buscador Bootstrap PHP MySQL"> </div> <form method="GET"  class="index__div__div__form"> <div class="index__div__div__form__div input-group"> <input name="search" type="text" class="index__div__div__form__div__input form-control" placeholder="Buscar"> <span class="index__div__div__form__div__span input-group-text"><i class="bi bi-search"></i></span> </div> <div class="index__div__div__form__div d-flex justify-content-center"> <input type="submit" value="Buscar" class="index__div__form__div__div__btn btn customButton"> </div> </form> </div> </div> </section>