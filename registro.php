

<?php
	session_start();
	require('conexion.php');
?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Registro</title>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;900&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="estilos.css">	
	</head>
	<body>
		<header class="cabecera"><?php require 'header.php'; ?></header>
		
		<form action="" method="post">
			<h2>Registro de Usuario</h2>
			<label>Nombre: </label>
			<br><input type="text" name="Nombre" class="entrada"><br>
			<label>Username: </label>
			<br><input type="text" name="Username" class="entrada"><br>
			<label>Password: </label>
			<br><input type="password" name="Password" class="entrada"><br>
			<label>Mail: </label>
			<br><input type="text" name="Mail" class="entrada"><br>
			<input type="submit" name="ingresar" value="Ingresar" class="submit">	
	</form>
	


<?PHP
	if(isset($_POST['ingresar'])){
		
		
		if ($conexion->connect_errno) {
			echo "Falló la conexión a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
		}else{
			if(!empty($_POST['Nombre']) && !empty($_POST['Username']) && !empty($_POST['Password']) && !empty($_POST['Password'])){
				$nombre = $_POST['Nombre'];
				$username = $_POST['Username'];
				$password = $_POST['Password'];
				$mail	= $_POST['Mail'];
				$sql = "INSERT INTO users (nombre, username, password, email) VALUES ('$nombre', '$username', '$password', '$mail')";
				$result = $conexion->query($sql);
				if($result==true){
					?><p class="good"><?php echo "Usuario Creado Exitosamente";?></p><?php
				}else{
					echo"Error al crear el Usuario ".$conexion->error;
				}
			}else{
				?><p class="error"><?php echo "Debe llenar los campos anteriores";?></p><?php
			}
		}
		
	}
?>


<?php
	$sql = "SELECT * FROM users";
	$result = $conexion->query($sql);
?>
	<br>
	<center>
		<table class="tabla">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Username</th>
					<th>Email</th>
					<th></th>
				</tr>
			</thead>
<?php
	while ($datauser = $result->fetch_assoc()) {
?>
			<tbody>
				<tr>
					<td><?php echo $datauser['nombre']; ?></td>
					<td><?php echo $datauser['username']; ?></td>
					<td><?php echo $datauser['email']; ?></td>
					<td>
			            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			                <input type="hidden" name="Codigo" value="<?php echo $datauser['nombre']; ?>">
			                <button type="submit" name="Eliminar">Eliminar</button>
			            </form>
            		</td>
				</tr>
			</tbody>
<?php
		}
?>
		</table>
	</center>
	</body>
	</html>
<?php 
	if (isset($_POST['Eliminar'])) { // si presionamos en boton eliminar
        $eliminar_confirmacion = false;
        $cod_reg = $_POST['Codigo'];
        $cod_eli = $conexion -> query('SELECT nombre FROM users');
        foreach ($cod_eli as $cod) { 
	        if ($cod['nombre'] == $cod_reg) {
	            $eliminar_confirmacion = true;
	        }
        }
        if ($eliminar_confirmacion) { // si no esta siendo utilizado, eliminamos el registro
            $eliminar = $conexion -> query("DELETE FROM users WHERE nombre = '$cod_reg'");
        } else{
             $nom_user = $conexion -> query("SELECT id FROM users WHERE id = '$cod_reg'");
             foreach ($nom_user as $peli) {
?>
     <p class="mensaje"><b>Error:</b> una funcion esta ocupando la pelicula <b><?php echo $peli['nombre']; ?></b>, Por lo tanto no se puede eliminar</p>
                            	<?php
             
                            }
                        }
                    }

 ?>