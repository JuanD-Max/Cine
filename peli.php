<?php
	session_start();
	require('conexion.php');

?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;900&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="estilos.css">
		<title></title>
	</head>
	<body>
		<header class="cabecera"><?php require 'header.php'; ?></header>
		<link rel="stylesheet" type="text/css" href="estilos.css">
		
		<form action="" method="post">
			<h2>Ingreso de películas</h2>
			<label>Nombre de la película:</label> 
			<br><input type="text" name="Nombre" class="entrada"><br>
			<label>Código de la película: </label>
			<br><input type="text" name="Codigo" class="entrada"><br>
			<label>Clasificación:</label>
			<br><select name="clasificacion" class="entrada">
			<?php
				if ($conexion->connect_errno) {
					echo "Falló la conexión a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
				}else{
					$consulta = "SELECT * FROM clasificacion ORDER BY id ASC";
					$ejecuta = mysqli_query($conexion,$consulta) or die(mysqi_error($conexion));
			?>
				<?php foreach ($ejecuta as  $opciones): ?>
				<option value="<?php echo $opciones['id'] ?>"><?php echo $opciones['nombreclasificacion'] ?></option>	
				<?php endforeach ?>
				<?php

					}
			?>

			</select><br>
			<input type="submit" name="ingresar" value="Ingresar" class="submit">
			
	</form>
	</body>
	</html>

	<?php
		if (isset($_POST['clasificacion'])) {
			if (isset($_POST['ingresar'])) {
				
				if ($conexion->connect_errno) {
					echo "Falló la conexión a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
				}else{
					if(!empty($_POST['Nombre']) && !empty($_POST['Codigo'])){
						$nombre = $_POST['Nombre'];
						$codigo = $_POST['Codigo'];
						$clasi = $_POST['clasificacion'];
						$sql = "INSERT INTO pelicula (nombrepelicula, codigo, idclasificacion) VALUES ('$nombre', '$codigo', '$clasi')";
						$result = $conexion->query($sql);
						if($result==true){
							?><p class="good"><?php echo "Película Añadida exitosamente";?></p><?php
						}else{
							echo"Error al crear el Usuario ".$conexion->error;
						}
					}else{
						?><p class="error"><?php echo "Debe llenar los campos anteriores";?></p><?php
					}
				}

			}
		}
	?>

<?php
		$sql = "SELECT nombrepelicula, codigo, c.nombreclasificacion FROM pelicula p 
		INNER JOIN clasificacion c ON p.idclasificacion = c.id";
		$result = $conexion->query($sql);
		?>
		<br>
		<center>
		<table class="tabla">
			
				<thead>
					<tr>
						<th>Nombre de la Pelicula</th>
						<th>Código</th>
						<th>Clasificacion</th>
						<th></th>
					</tr>
				</thead>
	<?php
		while ($datauser = $result->fetch_assoc()) {
			?>
				<tbody>
					<tr>
						<td><?php echo $datauser['nombrepelicula']; ?></td>
						<td><?php echo $datauser['codigo']; ?></td>
						<td><?php echo $datauser['nombreclasificacion']; ?></td>
						<td>
			                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			                    <input type="hidden" name="Codigo" value="<?php echo $datauser['codigo']; ?>">
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

<?php 
	if (isset($_POST['Eliminar'])) { // si presionamos en boton eliminar
        $eliminar_confirmacion = true;
        $cod_reg = $_POST['Codigo'];
        $cod_eli = $conexion -> query('SELECT codigopelicula FROM funcion'); // hacemos la consulta
        foreach ($cod_eli as $cod) { // recorremos el array
	        if ($cod['codigopelicula'] == $cod_reg) {
	            $eliminar_confirmacion = false; // verificamos que el registro no este siendo utilizado en otra tabla
	        }
        }
                        if ($eliminar_confirmacion) { // si no esta siendo utilizado, eliminamos el registro
                            $eliminar = $conexion -> query("DELETE FROM pelicula WHERE codigo = '$cod_reg'");
                        } else { // caso contrario mandamos error
                            $nom_peli = $conexion -> query("SELECT nombrepelicula FROM pelicula WHERE Codigo = '$cod_reg'");
                            foreach ($nom_peli as $peli) {
                            	?>
                            		<p class="mensaje"><b>Error:</b> una funcion esta ocupando la pelicula <b><?php echo $peli['nombrepelicula']; ?></b>, Por lo tanto no se puede eliminar</p>
                            	<?php
             
                            }
                        }
                    }

 ?>