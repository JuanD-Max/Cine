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
		<title>Funcion</title>
	</head>
	<body>
		<header class="cabecera"><?php require 'header.php'; ?></header>
		<form action="" method="post">
			<h2>Ingreso de funciones</h2>
			<label>Codigo de la Funcion</label> 
			<br><input type="text" name="CodiFun" class="entrada"><br>
			<label>Fecha de la funcion: </label>
			<br><input type="date" name="Fecha" class="entrada"><br>
			<label>Hora de la funcion: </label>
			<br><input type="time" name="Hora" class="entrada"><br>
			<label>Pelicula:</label>
			<br><select name="pelicula" class="entrada">
				<?php
					if ($conexion->connect_errno) {
						echo "Falló la conexión a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
					}else{
						$consulta = "SELECT * FROM pelicula ORDER BY codigo ASC";
						$ejecuta = mysqli_query($conexion,$consulta) or die(mysqi_error($conexion));
				?>
				<?php foreach ($ejecuta as  $opciones): ?>
					<option value="<?php echo $opciones['codigo'] ?>"><?php echo $opciones['nombrepelicula'] ?></option>	
				<?php endforeach ?>
					<?php }?>
			</select><br>
			<label>Sala:</label>
			<br><select name="sala" class="entrada">
				<?php

					if ($conexion->connect_errno) {
						echo "Falló la conexión a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
					}else{
						$consulta = "SELECT * FROM sala ORDER BY codigo ASC";
						$ejecuta = mysqli_query($conexion,$consulta) or die(mysqi_error($conexion));
				?>
				<?php foreach ($ejecuta as  $opciones): ?>
					<option value="<?php echo $opciones['codigo'] ?>"><?php echo $opciones['nombresala'] ?></option>	
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
		if (isset($_POST['pelicula']) && isset($_POST['sala'])) {
			if (isset($_POST['ingresar'])) {
				if ($conexion->connect_errno) {
					echo "Falló la conexión a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
				}else{
					if(!empty($_POST['CodiFun']) && !empty($_POST['Fecha']) && !empty($_POST['Hora'])){
						$codigoFuncion = $_POST['CodiFun'];
						$fecha = $_POST['Fecha'];
						$hora = $_POST['Hora'];
						$pelicula = $_POST['pelicula'];
						$sala = $_POST['sala'];
						$sql = "INSERT INTO funcion (codigofuncion, fecha, hora, codigopelicula, codigosala) VALUES ('$codigoFuncion', '$fecha', '$hora', '$pelicula', '$sala')";
						$result = $conexion->query($sql);
						if($result==true){
							?><p class="good"><?php echo "Funcion Añadida exitosamente";?></p><?php
						}else{
							echo"Error al crear el Usuario ".$conexion->error;
						}
					}else{
						?>
						<p><?php echo "Debe llenar los campos anteriores";?></p>
						<?php
					}
				}
			}
		}
	?>

	<?php

		$sql = "SELECT codigofuncion, fecha, hora, p.nombrepelicula, c.nombreclasificacion,s.nombresala 
		 FROM funcion f 
		 INNER JOIN pelicula p ON f.codigopelicula = p.codigo 
		 INNER JOIN sala s ON f.codigosala = s.codigo 
		 INNER JOIN clasificacion c ON p.idclasificacion = c.id";
		$result = $conexion->query($sql);
		?>
		<br>
		<center>
		<table class="tabla">
				<center>
					<thead>
						<tr>
							<th>Código de la función</th>
							<th>Fecha</th>
							<th>Hora</th>
							<th>Película</th>
							<th>Clasificación de la película</th>
							<th>Sala</th>
							<th></th>
						</tr>
					</thead>
	<?php
		while ($datauser = $result->fetch_assoc()) {
			?>
				<tbody>
					<tr>
						<td><?php echo $datauser['codigofuncion']; ?></td>
						<td><?php echo $datauser['fecha']; ?></td>
						<td><?php echo $datauser['hora']; ?></td>
						<td><?php echo $datauser['nombrepelicula']; ?></td>
						<td><?php echo $datauser['nombreclasificacion'] ?></td>
						<td><?php echo $datauser['nombresala']; ?></td>
						<td><a href="eliminarfun.php?codigo=<?php echo $datauser['codigofuncion']; ?>" class="link">Eliminar</a></td>
						</tr>
					</tbody>
				</center>
			
			<?php
		}
		?>
		</table>
		</center>
		<?php
?>
