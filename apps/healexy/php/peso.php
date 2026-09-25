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
    <title>Añadir</title>

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
              if (!isset($_REQUEST['savePESO'])) {
                echo "
                <form action='peso.php' method='post'>
                  <div class='form-group row text-uppercase text-danger text-center'>
                    <div class='col-sm-12 mb-3 col-lg-12'>
                      <h3 class='font-weight-bold'>Introduzca su peso actual porfavor</h3>
                    </div>
                  </div>
                  <div class='form-group row text-uppercase text-warning text-center'>
                    <div class='col-sm-12  col-lg-12'>
                      <h5 class='font-weight-bold'>A ser posible pesarse siempre una vez despierte</h5>
                    </div>
                  </div>

                  <div class='form-group row text-uppercase text-danger text-center'>
                    <div class='d-none d-md-block mb-4 col-lg-2'></div>
                    <div class='col-sm-12 mb-3 col-lg-8'>
                      <input type='number' class='form-control form-control-user' name='valorPeso' min='40' max='350'/>
                    </div>
                    <div class='d-none d-md-block mb-4 col-lg-2'></div>
                  </div>

                  <div class='form-group row'>
                    <div class='col-sm-6 mb-2'>
                      <input type='submit' name='savePESO' value='Guardar el peso' class='btn btn-primary btn-block'>
                    </div>

                    <div class='col-sm-6 mb-2'>
                      <a href='adelgazar.php' class='btn btn-info btn-block' role='button'>Dieta</a>
                    </div>
                  </div>
                </form>

                  <div class='form-group row'>
                    <div class='col-xs-12 mb-2 col-lg-12'>
                      <canvas id='lineChart'></canvas>
                    </div>
                  </div>
                ";

              }else{
                $cantpeso=$_REQUEST['valorPeso'];
                if ($cantpeso>1) {
                  $aid = $_SESSION['user'];
                  $aidi=obtenerID($aid);
                  $upDates = subirPeso($aidi, $cantpeso);

                  if ($upDates == true) {
                    echo"<h2>Se han almacenado los datos correctamente</h2>";
                    header("refresh:1;url=peso.php");
                    //echo "<a href='peso.php'><h4>Volver al inicio</h4></a>";
                  }else{
                    echo "<h1>Error por algún motivo desconocido por el creador de este contenido; pongase en contacto con el porfavor</h1>";
                  }
                }else{
                  //echo "<a href='peso.php'><h4>Seleccione un peso porfavor</h4></a>";
                  header('location: peso.php');
                }
              }

              //Aqui realizo las funciones de nuevo para mostra luego la tabla en el scrip, las he puesto aqui porque al final me da problemas a la hora de ejecución del código
              $aid = $_SESSION['user'];
              $aidi=obtenerID($aid);
              $Ddiagrama=DiagramadePeso($aidi);

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
  <script type="text/javascript" src="../bootstrap/JavaScript/js/jquery.min.js"></script>
  <script src="../bootstrap/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../bootstrap/JavaScript/js/typeahead.js"></script>

  <script type="text/javascript">
    //line
    var ctxL = document.getElementById("lineChart").getContext('2d');
    var myLineChart = new Chart(ctxL, {
      type: 'line',
      data: {
        labels:
          [
             <?php
              //Fecha de la BD del usuario en cuestión
                $fechacharts="";
                for ($i=0; $i < count($Ddiagrama); $i++) {
                  $fechacharts = $fechacharts."\"".$Ddiagrama[$i]['fecha']."\", ";
                }
                echo "$fechacharts";
              ?>
          ],
        datasets: [{
          label: "Peso",
          data:
            [
              <?php
              //Peso de la BD del usuario en cuestión
                $pesocharts="";
                for ($i=0; $i < count($Ddiagrama); $i++) {
                    $pesocharts = $pesocharts.$Ddiagrama[$i]['peso'].", ";
                }
                echo "$pesocharts";
              ?>
            ],
          backgroundColor: [
          'rgba(105, 0, 132, .2)',
          ],
          borderColor: [
          'rgba(200, 99, 132, .7)',
          ],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true
      }
    });
  </script>

  </body>
</html>

<?php
  }else{
    header('location: ../index.php');
  }
?>
<?php
ob_start();
?>
