<?php
	session_start();
	require_once("check/funciones.php");
	//Comprueba que no se haya introducido ningún usuario antes, si se ha introducico, se redirecciona a la página de ininio
	if (!isset($_SESSION['user'])){
?>
<!DOCTYPE html>
<html lang='es'>
	<head>
		<meta charset='utf-8'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, 	initial-scale=1, shrink-to-fit=no">
		<title>Registro</title>

		<!-- Tipos de letra personalizada-->
		<link href="../bootstrap/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="../bootstrap/fontawesome-free/css/all2.min.css "rel="stylesheet" type="text/css">

		<!-- Estilos personalizadados-->
		<link href="../css/sb-admin-2.min.css" rel="stylesheet">
	</head>
		<body class="bg-gradient-primary">
			<div class="container">
			<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="card-body p-0">
				<div class="row">
					<div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
					         <div class="col-lg-7">
						        <div class="p-5">
							<div class="text-center">
						<h1 class="h4 text-gray-900 mb-4">Crear una cuenta</h1>

										<?php
											if(isset($_REQUEST['resgistrar'])){
												//Concatenar correo
												$correo1 = $_REQUEST['correo1'];
												$correo2 = $_REQUEST['correo2'];
												$correo3 = $_REQUEST['correo3'];
												$correo = $correo1.$correo2.$correo3;

												//Pido la contraseña 2 veces para confirmar que el usuario la ha escrito correctamente
												$unopwd = $_REQUEST['contrasena1'];
												$dospwd = $_REQUEST['contrasena2'];
												$nick = $_REQUEST['nickname'];

												if ($unopwd != $dospwd) {
														echo "<br><br><br><br><br><br><br><br><br>";
													echo "Las contraseñas no coinciden";
														echo "<br><br><br><br><br><br><br><br><br>";
													header( "refresh:2;url=registro.php" );
												//Si las contraseñas son identicas, se procede a insertar los datos en la BD.
												}elseif ($unopwd === $dospwd) {
													$annadiruser=array(
														'nickname'=>$_REQUEST['nickname'],
														'Usuario'=>$_REQUEST['usuario'],
														'Contrasena'=>$_REQUEST['contrasena1'],
														'TipoUser'=>"user",
														'Correo'=>$correo,
														'Altura'=>$_REQUEST['altura'],
														'Peso'=>$_REQUEST['peso'],
														'Metabolismo'=>$_REQUEST['metabolismo'],
													);
												//Esta función comprueba que el nickname no exista otro en BD
												$comprobarNick=comprobarNickOnly($nick);
												$comprobarCorreo=comprobarCorreoOnly($correo);
													if ($comprobarNick==true && $comprobarCorreo==true) {
														if(introducir($annadiruser)==true){
																echo "<br><br><br><br><br><br><br><br><br>";
															echo"Te has registrado correctamente";
																echo "<br><br><br><br><br><br><br><br><br>";
															header( "refresh:1;url=../index.php" );
														}else{
																echo "<br><br><br><br><br><br><br><br><br>";
															echo"Su registro no ha sido posible";
																echo "<br><br><br><br><br><br><br><br><br>";
															header( "refresh:2;url=registro.php" );
														}
													}else{
															echo "<br><br><br><br><br><br><br><br><br>";
														echo "<p>Error en el correo electrónico o en el nickname</p>";
															echo "<br><br><br><br><br><br><br><br><br>";
														header( "refresh:2;url=registro.php" );
													}
												}
											}else{

												echo"
												<form class='user' method='POST' action='registro.php' autocomplete='off'>
													<div class='form-group row'>
														<div class='col-sm-6 mb-3 mb-sm-0'>
											<input type='text' class='form-control form-control-user' id='nickname' name='nickname' placeholder='Apodo' minlength='5' maxlength='15' required='' />
										</div>
														<div class='col-sm-6'>
											<div id='mostrar-nickname'></div>
										</div>
													</div>

													<div class='form-group'>
														<input type='text' class='form-control form-control-user' name='usuario' placeholder='Nombre y/o apellidos' required='' minlength='3' maxlength='30'/>
													</div>

													<div class='form-group row'>
														<div class='col-sm-6 mb-3 mb-sm-0'>
											<input type='password' class='form-control form-control-user' name='contrasena1'
											pattern='\S{8,16}$'	placeholder='Contraseña' required=''/>
										</div>
														<div class='col-sm-6'>
											<input type='password' class='form-control form-control-user' name='contrasena2' placeholder='Repita su contraseña' required=''/>
										</div>
													</div>

													<div class='form-group row'>
														<div class='col-xs-4 col-sm-4 mb-3 col-md-4'>
															<input type='text' class='form-control form-control-user' name='correo1' placeholder='Correo' required='' maxlength='15' pattern='[a-zA-Z0-9_]{5,15}' />
														</div>
														<div class='col-xs-4 col-sm-4 mb-3 col-md-4'>
															<select name='correo2' class='form-control custom-select'>
																<option value='@gmail' selected=''>gmail</option>
																<option value='@outlook'>outlook</option>
																<option value='@hotmail'>hotmail</option>
															</select>
														</div>
														<div class='col-xs-4 col-sm-4 mb-3 col-md-4'>
															<select name='correo3' class='form-control'>
																<option value='.es'>.es</option>
																<option value='.com'>.com</option>
																<option value='.org'>.org</option>
															</select>
														</div>
													</div>

										<div class='form-group row'>
														<div class='col-sm-6 mb-3 mb-sm-0'>
											<input type='number' class='form-control form-control-user' name='altura' placeholder='Altura en \"cm\"' min='50' max='250' required='' />
										</div>
														<div class='col-sm-6'>
											<input type='number' class='form-control form-control-user' name='peso' placeholder='Peso en \"kg\"' min='40' max='350' required='' />
										</div>
													</div>

									<div class='form-group'>
										<h1></h1>
														<select name='Const. física' class='form-control'>
															<option value='mesomorfo' selected=''>Es una mezcla entre los posteriores.[mesomorfo]
															</option>

															<option value='endomorfo'>Tu cuerpo es delgado, bajo peso.[endomorfo]
															</option>

															<option value='ectomorfo'>Tu cuerpo el algo grueso, y gran peso.[ectomorfo]
															</option>
														</select>
													</div>
													<input type='submit'name='resgistrar' class='btn btn-primary btn-block'>
												</form>
												";
											}


echo"
										<hr>
							<div class='text-center'>
							<a class='small' href='../index.php'>Inicia sesión aquí!!</a>
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
	<script src="../bootstrap/jquery/jquery.min.js"></script>
	<script src="../bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../bootstrap/jquery-easing/jquery.easing.min.js"></script>
	<script src="../bootstrap/JavaScript/sb-admin-2.min.js"></script>
	<!-- Sustituye un enlace a la internet y contiene dicha librería -->
	<script src="../bootstrap/JavaScript/libreria_java3-2-1.js"></script>

	<!-- Se encarga de comprobar la existencia de un nick igual en la BD a tiempo real -->
	<script type="text/javascript">
		$(document).ready(function() {
		    $('#nickname').on('blur', function() {
		        $('#mostrar-nickname').html('<img src="../img/cagando.gif" />').fadeOut(1000);

		        var nickname = $(this).val();
		        var dataString = 'nickname='+nickname;

		        $.ajax({
		            type: "POST",
		            url: "check/comprobar_nickname.php",
		            data: dataString,
		            success: function(data) {
		                $('#mostrar-nickname').fadeIn(1000).html(data);
		            }
		        });
		    });
		});
	</script>

	</body>
</html>

<?php
	}else{
		header('location: inicio.php');
	}
?>
