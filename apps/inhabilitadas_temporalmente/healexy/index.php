<?php
	session_start();
	require_once("php/check/funciones.php");
	//Comprueba que no se haya introducido ningún usuario antes, si se ha introducico, se redirecciona a la página de ininio
	if (!isset($_SESSION['user'])){
?>
<!DOCTYPE html>
<html lang='es'>
	<head>
		<meta charset='utf-8'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, 	initial-scale=1, shrink-to-fit=no">
		<title>Login</title>

		<!-- Tipos de letra personalizada-->
		<link href="bootstrap/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="bootstrap/fontawesome-free/css/all2.min.css "rel="stylesheet" type="text/css">

		<!-- Estilos personalizadados-->
		 <link href="css/sb-admin-2.min.css" rel="stylesheet">
	</head>
		<body class="bg-gradient-primary">
			<div class="container">
			<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="card-body p-0">
				<div class="row">
					<div class="col-lg-5 d-none d-lg-block">
						<img src="img/calorias.jpg" width='500px' height='500px'>
					</div>
					         <div class="col-lg-7">
						        <div class="p-5">
							<div class="text-center">
						<h1 class="h4 text-gray-900 mb-4">Bienvenido</h1></br>

									<?php
										if (isset($_REQUEST['enviarlog'])){
											$apodo=$_REQUEST['apodolog'];
											$passwd=$_REQUEST['contrasenalog'];
										//Uso una funcion para comprobar que el usuario que esta dando existe en la base de datos
											$comprobar=comprobarUsuario($apodo,$passwd);

											if ($comprobar==0) {
												echo "<h3>El apodo de usuario incorrecto, intentelo de nuevo porfavor</h3>";
												header( "refresh:2;url=index.php" );
											}elseif ($comprobar==1) {
												echo "<h3>El apodo de usuario o contraseña son erroneos</h3>";
												header( "refresh:2;url=index.php" );
											}elseif ($comprobar==2) {
												//Función para obtener el tipo de usuario si es admin o no, y se añade a un array que luego usaremos
												$tipoUser=obtenerTipo($apodo,$passwd);
												$usuario=array(
													'nombre'=>$apodo,
													'contrasena'=>$passwd,
													'tipo' =>$tipoUser
												);


												 $_SESSION['user'] = $usuario;
										        header('location: php/inicio.php');

											}else{
												echo "<p>Error</p>";
											}
										}else{
											echo"
											<form class='user' method='POST' action='index.php'>
												<div class='form-group'>
													<input type='text' class='form-control form-control-user' name='apodolog' placeholder='Tu apodo' required='' />
												</div>
												<div class='form-group'>
									<input type='password' class='form-control form-control-user' name='contrasenalog' placeholder='Contraseña' required=''/>
												</div>
												</br><input type='submit' class='btn btn-primary btn-block' name='enviarlog' value='Entrar'>
											</form>";
											}


echo"
										<hr>
							<div class='text-center'>
							</br><a class='small' href='php/registro.php'>Registrate AHORA!!!</a>
						</div>";
					                ?>

					                </div>
					</div>
				            </div>
				        </div>
				    </div>
				</div>
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

	<!-- Scrips de boostrap y JavaScrip usado de forma general para las paginas web -->
	<script src="bootstrap/jquery/jquery.min.js"></script>
	<script src="bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="bootstrap/jquery-easing/jquery.easing.min.js"></script>
	<script src="bootstrap/JavaScript/sb-admin-2.min.js"></script>
	<!-- Fin de Scrips generales -->

	</body>
</html>

<?php
	}else{
		header('location: php/inicio.php');
	}
?>
