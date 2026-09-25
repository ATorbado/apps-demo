<?php
ob_start();
?>
<?php
  session_start();
  require_once("check/funciones.php");
  //Comprueba que no se haya introducido ningún usuario antes, si se ha introducico, se redirecciona a la página de ininio
  if (isset($_SESSION['user'])){
?>
<!DOCTYPE html>
<html lang='es'>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,  initial-scale=1, shrink-to-fit=no">
    <title>Eliminar</title>

    <!-- Estilos de letra personalizada-->
    <link href="../css/annadircss.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap/fontawesome-free/css/all2.min.css "rel="stylesheet" type="text/css">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  </head>
  <body id="page-top">
    <!-- Envoltura de la página -->
    <div id="wrapper">
      <!-- Barra lateral -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Estilo de la barra lateral -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="inicio.php">
          <div class="mt-3">
            <img src="../img/logo.png" width="65px">
            <div class="sidebar-brand-text mx-3"> HEALEXY </div>
          </div>
        </a>

        <!-- Separador -->
        <br>
        <hr class="sidebar-divider">

        <!-- Cabezera -->
        <div class="sidebar-heading">
          <h7>Accesos rápidos</h7>
        </div>

        <!-- Elemento de navegación - Menú desplegable sobre los alimentos-->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDieta" aria-expanded="true" aria-controls="collapseDieta">
            <i class="fab fa-acquisitions-incorporated"></i>
            <span>Dieta</span>
          </a>
          <div id="collapseDieta" class="collapse" aria-labelledby="collapseDieta" data-parent="#accordionSidebar">
            <div class="bg py-2 collapse-inner rounded deploy">
              <a class="collapse-item text-white" href="alimentos.php">Ver alimentos</a>
              <a class="collapse-item text-white" href="annadir.php">Añadir alimento</a>
              <a class="collapse-item text-white" href="eliminar.php">Eliminar alimento</a>
              <a class="collapse-item text-white" href="subir-alimentos.php">Guardar día</a>
            </div>
          </div>
        </li>

        <!-- Elemento de navegación - Menú desplegable sobre la gestión de peso-->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePeso" aria-expanded="true" aria-controls="collapsePeso">
            <i class="fas fa-balance-scale-right"></i>
            <span>Peso</span>
          </a>
          <div id="collapsePeso" class="collapse" aria-labelledby="collapsePeso" data-parent="#accordionSidebar">
            <div class="bg py-2 collapse-inner rounded deploy">
              <a class="collapse-item text-white" href="peso.php">Ver peso</a>
              <a class="collapse-item text-white" href="adelgazar.php">Dieta</a>
            </div>
          </div>
        </li>

        <!-- Elemento de navegación - Menú desplegable sobre el historial-->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHistory" aria-expanded="true" aria-controls="collapseHistory">
            <i class="fas fa-book"></i>
            <span>Historial</span>
          </a>
          <div id="collapseHistory" class="collapse" aria-labelledby="collapseHistory" data-parent="#accordionSidebar">
            <div class="bg py-2 collapse-inner rounded deploy">
              <a class="collapse-item text-white" href="historialUNO.php">Historial del día</a>
              <a class="collapse-item text-white" href="historialBOTH.php">Historial de intervalo</a>
            </div>
          </div>
        </li>

        <!-- Elemento de navegación - Menú desplegable sobre el resto de páginas-->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOtros" aria-expanded="true" aria-controls="collapseOtros">
            <i class="fas fa-asterisk"></i>
            <span>Otros</span>
          </a>
          <div id="collapseOtros" class="collapse" aria-labelledby="collapseOtros" data-parent="#accordionSidebar">
            <div class="bg py-2 collapse-inner rounded deploy">
              <a class="collapse-item text-white" href="check/cerrar-sesion.php">Cerrar sesión</a>
            </div>
          </div>
        </li>

      <!-- Esto se muestra solo para el usuario de tipo root -->
      <?php
        if ($_SESSION['user']['tipo'] == "root"){
      ?>

        <!-- Separador -->
        <hr class="sidebar-divider">

        <!-- Cabezera -->
        <div class="sidebar-heading">
          <h7>ROOT</h7>
        </div>

        <!-- Elemento de navegación - Tablas -->
        <li class="nav-item">
          <a class="nav-link" href="mostrar-tablas.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
        </li>

      <?php
        }
      ?>

        <!-- Separador -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Botón de la barra lateral (Contraer) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

      </ul>
      <!-- Fin de la barra lateral -->

      <!-- Contenido de la envoltura de la página -->
      <div id="content-wrapper" class="d-flex flex-column">

        <!-- Contenido principal -->
        <div id="content">

          <!-- Ininicio barra superior -->
          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Botón de la barra superior -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>

            <!-- Eslogan -->
            <h4 class="h4slogan">Una dura Constancia</h4>

            <!-- Barra de navegación superior-->
            <ul class="navbar-nav ml-auto">

              <!-- Barra divisora -->
              <div class="topbar-divider d-none d-sm-block"></div>

              <!-- Elemento de navegación - Información del usuario -->
              <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <!-- Aqui se muestra el nickname del usuario logeado -->
                <?php
                  $eaA=$_SESSION['user']['nombre'];
                  $eaB=$_SESSION['user']['contrasena'];
                  $ea=array(
                    'nombre' => $eaA,
                    'contrasena' => $eaB,
                  );
                  $ae=obtenerNICK($ea);
                  echo"<h7 class='mr-2 d-none d-lg-inline text-gray-600 small'>$ae</h7>";
                ?>
                  <img class="img-profile rounded-circle" src="../img/fotoPerfil.png">
                </a>
              </li>
            </ul>
          </nav>
          <!-- Fin barra superior -->

          <!-- Inicio contenido de la página -->
          <div class="container-fluid">

            <?php
              if (!isset($_REQUEST['delete'])) {
                echo "
                <form action='eliminar.php' method='post'>
                  <div class='form-group row text-uppercase text-danger text-center'>
                    <div class='d-none col-sm-4 d-md-block mb-2'>
                      <h2 class='font-weight-bold'>SelecT</h2>
                    </div>
                    <div class='d-none col-sm-4 d-md-block mb-2'>
                      <h2 class='font-weight-bold'>Nombre</h2>
                    </div>
                    <div class='d-none col-sm-4 d-md-block mb-2'>
                      <h2 class='font-weight-bold'>Cantidad en gramos</h2>
                    </div>
                  </div>

                  </br></br>
                ";

                foreach ($_SESSION['comida'] as $key2 => $productos){
                  echo "
                    <div class='form-group row text-center'>
                      <div class='col-sm-4 mb-2'>
                        <input type='radio' name='modificarradio' value='$key2'>
                      </div>
                          ";

                          foreach ($productos as $key => $value) {
                            echo "
                      <div class='col-sm-4 mb-2'>
                        <h5 class='text-capitalize font-weight-bold text-hard-black'>$value</h5>
                      </div>
                    ";
                  }
                  echo "
                    </div>
                  ";
                }

                echo "
                  </br></br></br>

                  <div class='form-group row'>
                    <div class='col-sm-6 mb-3'>
                      <input type='submit' name='delete' value='Eliminar alimento' class='btn btn-primary btn-block'>
                    </div>
                    <div class='col-sm-6 mb-3'>
                      <a href='check/cancelar.php' class='btn btn-info btn-block' role='button'>Cancelar acción</a>
                    </div>
                  </div>
                </form>
                ";
              }elseif (isset($_REQUEST['modificarradio'])) {
                $position = $_REQUEST['modificarradio'];

                unset($_SESSION['comida'][$position]);
                $_SESSION['comida']= array_values($_SESSION['comida']);

                header('Location: alimentos.php');
                //echo "<a href='alimentos.php'><h4>Ver alimentos</h4></a>";
              }elseif (isset($_REQUEST['delete']) && !isset($_REQUEST['modificarradio'])) {
                header('Location: eliminar.php');
                //echo "<a href='eliminar.php'><h4>Seleccione un alimento por favor</h4></a>";
              }
            ?>

          </div>
        </div>
        <!-- Fin del contenido -->

        <!-- Fin del pie de página -->
        <footer class="page-footer font-small blue">
          <!-- Copyright -->
          <div class="footer-copyright text-center py-3">
            <h6>© 2020 Copyright: HEALEXY by Alex Torbado Aller</h6>
          </div>
          <!-- Copyright -->
        </footer>
        <!-- Fin del pie de página -->

      </div>
      <!-- Fin del contenido de la envoltura de la página -->

    </div>
    <!-- Fin de la envultura de la página -->

  <!-- Scrips de boostrap y JavaScrip usado de forma general para las paginas web -->
  <script src="../bootstrap/jquery/jquery.min.js"></script>
  <script src="../bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../bootstrap/jquery-easing/jquery.easing.min.js"></script>
  <script src="../bootstrap/JavaScript/sb-admin-2.min.js"></script>
  <script src="../bootstrap/chart.js/Chart.min.js"></script>

  </body>
</html>

<?php
  }else{
    header('location: ../index.php');
  }
?>
<?php
ob_end_flush();
?>
