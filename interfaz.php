
<?php
	session_start();
	if(isset($_SESSION['Reg'])){
		if($_SESSION['Reg'] =='ok'){
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inicio</title>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>
	<form action="" method="post">
		<button name="crear_usu" class="interfaz">Crear Usuarios</button><br><br>
		<button name="crear_sala" class="interfaz">Crear Salas</button><br><br>
		<button name="crear_peli" class="interfaz">Ingresar Película</button><br><br>
		<button name="crear_funci" class="interfaz">Crear Funcion</button><br><br>
		
		<br><br>
		<button name="logout" class="interfaz salir">Cerrar Sesión</button>
	</form>
</body>
</html>

<?php
	}else{
		header("Location: index.php");
	}
}else{
	header("Location: index.php");
}		
?>

<?php
	if (isset($_POST['crear_usu'])) {
		header("Location: registro.php");
	}else if (isset($_POST['crear_sala'])){
		header("Location: sala.php");
	}else if (isset($_POST['crear_peli'])){
		header("Location: peli.php");
	}else if (isset($_POST['crear_funci'])){
		header("Location: funcion.php");
	}else if (isset($_POST['admin_usu'])){
		header('Location: listausuarios.php');
	}else if (isset($_POST['logout'])){
		header('Location: logout.php');
	}

?>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;900&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="estilos.css">