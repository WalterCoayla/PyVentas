<!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Inicio</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Nostros</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Acerca de ..</a>
      </li>


    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="btn btn-app" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
          Buscar ...
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-md">
              <input class="form-control form-control-navbar" type="search" placeholder="Buscar" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      <?php 
        if (isset($_SESSION['nombre'])){
        ?>
        <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="btn btn-app" data-toggle="dropdown" href="#" title=" <?=$_SESSION['nombre'];?>">
          <i class="far fa-user"></i>
          <?=$_SESSION['nombre'];?>
          
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  <?= (isset($_SESSION['nombre']))?$_SESSION['nombre']:'Visitante';?>
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">
                  <i class="far fa-envelope"></i> : <?= (isset($_SESSION['email']))?$_SESSION['email']:'-';?>
                </p>
                <p class="text-sm">
                  <i class="far fa-clock mr-1"></i> Hace 4 hrs.
                </p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="?ctrl=CtrlUsuario&accion=cambiarClave" 
            class="dropdown-item dropdown-footer">Cambiar Contraseña</a>
          <a href="#" class="dropdown-item dropdown-footer">Acerca de...</a>
          <div class="dropdown-divider"></div>
          <a href="?ctrl=CtrlUsuario&accion=cerrarSesion" class="dropdown-item dropdown-footer">Cerrar Sesión</a>
        </div>
      </li>
        <?php
        } else {
          ?>
        <li class="nav-item">
          <a class="btn btn-app" role="button" 
          data-toggle="modal" data-target="#modal-login" title="Ingresar ...">
          <i class="far fa-user"></i>
          Ingresar</a>

        </li>  
          <?php
        }
        $cantProductos =isset($_SESSION['carrito'])?$_SESSION['carrito']->getNroProductos():0;
      ?>
        <li class="nav-item">
          
          <a href="?ctrl=CtrlCarrito&accion=mostrar" 
          class="btn btn-app" title="Tiene <?= $cantProductos?> Elementos en el Carrito">
            <span class="badge bg-warning"><?= $cantProductos?></span>
              <i class="fa fa-cart-plus"></i>
              Ver Carrito</a>
           
          </a>
        </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  
  <div class="modal fade" id="modal-login">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Login</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p class="login-box-msg">Registre la siguiente información</p>

        <form action="?ctrl=CtrlUsuario&accion=validar" method="post">
            <div class="input-group mb-3">
            <input type="text" name="usuario" class="form-control" placeholder="Usuario">
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-envelope"></span>
                </div>
            </div>
            </div>
            <div class="input-group mb-3">
            <input type="password" name="clave" class="form-control" placeholder="Clave">
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-lock"></span>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                    Recuérdame
                </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
            </div>
            <!-- /.col -->
            </div>
        </form>

        <div class="social-auth-links text-center mt-2 mb-3">
            <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i> Ingresa usando Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i> Ingresa usando Google+
            </a>
        </div>
        <!-- /.social-auth-links -->

        <p class="mb-1">
            <a href="forgot-password.html">Perdiste tu Contraseña?</a>
        </p>
        <p class="mb-0">
            <a href="register.html" class="text-center">Regístrate como nuevo usuario</a>
        </p>
        </div>
        </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->