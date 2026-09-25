<?php
// Procesamos en envio desde el input via POST
$palabraclave = strval($_POST['busqueda']);
$busqueda = "{$palabraclave}%";
// Realizamos la conexión MySQLi
$conexion =new mysqli(getenv('HEALEXY_DB_HOST'), getenv('HEALEXY_DB_USER'), getenv('HEALEXY_DB_PASSWORD') , getenv('HEALEXY_DB_NAME'));
// Preparamos la consulta para realizar la busqueda del criterio
$consultaDB = $conexion->prepare("SELECT Nombre FROM alimentos WHERE Nombre LIKE ?");
$consultaDB->bind_param("s",$busqueda);
$consultaDB->execute();
$resultado = $consultaDB->get_result();
// Condicional para tratar a los resultados encontrados
if ($resultado->num_rows > 0) {
	while($registros = $resultado->fetch_assoc()) {
	// Llamando a la columna Nombre
	$ResultadoAlimentos[] = $registros["Nombre"];
	}
	echo json_encode($ResultadoAlimentos);
	}
// Cerramos la conexión con el servidor
$consultaDB->close();
