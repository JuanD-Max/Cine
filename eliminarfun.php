<?php
	include("conexion.php");

			$codigo = $_REQUEST['codigo'];

			$sql = "DELETE FROM funcion WHERE codigofuncion = '$codigo'";
			$result = $conexion->query($sql);
			if ($result == true) {
				header('Location: funcion.php');
			}else{
				echo "<script>alert('".$conexion->error."');</script>";
			}
	
?>