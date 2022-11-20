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
		
		<form action="" method="post">
			<h2>Creacion de salas</h2>
			<label>Nombre de la sala:</label> 
			<br><input type="text" name="Nombre" class="entrada"><br>
			<label>Código de la Sala: </label>
			<br><input type="text" name="Codigo" class="entrada"><br>
			<label>Capacidad de la sala:</label> 
			<br><input type="text" name="Capacidad" class="entrada"><br><br>
			<input type="submit" name="ingresar" value="Ingresar" class="submit">
		</form>
	</body>
	</html>
	
<?PHP
if(isset($_POST['ingresar'])){
	
	if ($conexion->connect_errno) {
		echo "Falló la conexión a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
	}else{
		if(!empty($_POST['Nombre']) && !empty($_POST['Codigo']) && !empty($_POST['Capacidad'])){
			$nombre = $_POST['Nombre'];
			$codigo = $_POST['Codigo'];
			$capacidad = $_POST['Capacidad'];
			$sql = "INSERT INTO sala (nombresala, codigo, capacidad) VALUES ('$nombre', '$codigo', '$capacidad')";
			$result = $conexion->query($sql);
			if($result==true){
				?><p class="good"><?php echo "Sala Creada exitosamente";?></p><?php
			}else{
				echo"Error al crear la sala ".$conexion->error;
			}
		}else{
			?><p class="error"><?php echo "Debe llenar los campos anteriores";?></p><?php
		}
	}
	
}
?>

<?php

		$sql = "SELECT * FROM sala";
		$result = $conexion->query($sql);
		?>
		<br>
		<center>
		<table class="tabla">
				
					<thead>
						<tr>
							<th>Nombre de la Sala</th>
							<th>Código</th>
							<th>Capacidad</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
	<?php
		while ($datauser = $result->fetch_assoc()) {
			?>
					
						<tr>
							<td><?php echo $datauser['nombresala']; ?></td>
							<td><?php echo $datauser['codigo']; ?></td>
							<td><?php echo $datauser['capacidad']; ?></td>
							<td>
					            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					                <input type="hidden" name="Codigo" value="<?php echo $datauser['codigo']; ?>">
					                <button type="submit" name="Eliminar">Eliminar</button>
					            </form>
		            		</td>
						</tr>
			<?php
		}
		?>
	</tbody>
		</table>
		</center>

<?php 
	if (isset($_POST['Eliminar'])) { 
        $eliminar_confirmacion = true;
        $cod_reg = $_POST['Codigo'];
        $cod_eli = $conexion -> query('SELECT codigosala FROM funcion');
        foreach ($cod_eli as $cod) {
	        if ($cod['codigosala'] == $cod_reg) {
	            $eliminar_confirmacion = false;
	        }
        }
        if($eliminar_confirmacion) {
            $eliminar = $conexion -> query("DELETE FROM sala WHERE codigo = '$cod_reg'");
        }else{ 
            $nom_sala = $conexion -> query("SELECT nombresala  FROM sala WHERE codigo = '$cod_reg'");
            foreach ($nom_sala as $sala) {
 ?>
                <p class="mensaje"><b>Error:</b> La <b><?php echo $sala['nombresala']; ?></b> esta asignada a una funcion, por lo tanto no se puede eliminar</p>
<?php
             
            }
        }
    }

 ?>