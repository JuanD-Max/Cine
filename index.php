<?php require('conexion.php') ?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="estilos.css">	
</head>
<body>
	<header class="cabecera">
		<h1>Cine</h1>
	</header>
	<form action="" method="post">
		<label>Mail </label><br>
		<input type="text" name="Mail" class="entradalog"><br>
		<label>Password</label><br>
		<input type="password" name="Password" class="entradalog"><br>
		<input type="submit" name="login" class="submit" value="Ingresar">
	</form>
</body>
</html>
<?PHP	
if(isset($_POST['login'])){
	
	
	
	if ($conexion->connect_errno) {
			echo "Falló la conexión a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
		}else{
			if(!empty($_POST['Mail']) && !empty($_POST['Password'])){
				$mail = $_POST['Mail'];
				$password = $_POST['Password'];
				$sql ="SELECT password FROM users WHERE email = '$mail' and password = '$password'";

				$result = $conexion->query($sql);
				if($result->fetch_assoc()){
					session_start();
					$_SESSION['Reg']='ok';
					header('Location: interfaz.php');
				}else{
					$_SESSION['Reg']='fail';
					echo "Usuario o Contraseña Incorrecto";
				}
			}else{
				echo "Debe llenar los campos anteriores";
			}
			
		}
	mysqli_close($conexion);
}
?>