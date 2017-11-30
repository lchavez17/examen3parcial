<?php
	session_start();
	$iniciar = false;

	try {
		$conn = new mysqli('localhost', 'root', 'asdfg123..', 'restaurante');

		if(!$conn->connect_error){
			$correo = $_POST['correo'];
			$clave = $_POST['clave'];

			$sql = "
				select 
					*
				from
					usuarios
				where
					us_correo_electronico = '".$correo."'
					and us_clave = '".$clave."'";
			$sql_respuesta = $conn->query($sql);

			if($sql_respuesta->num_rows == 1){
				$_SESSION['bsd1'] = $sql_respuesta->fetch_assoc();
				$iniciar = true;
			}
		}
	} catch (Exception $e){}

	if($iniciar){
		header('Location: panel.php');
	}else{
		header('Location: index.php?error=1');
	}
?>
