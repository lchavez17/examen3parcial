<?php
	session_start();

	if(!isset($_SESSION['bsd1']))
		header('Location: index.php');

	$id_usuario = $_GET['id'];


	try {
		$conn = new mysqli('localhost', 'root', 'asdfg123..', 'restaurante');

		if(!$conn->connect_error){
			if ($id_usuario != $_SESSION['bsd1']['us_id']){
				$sql = "delete from usuarios where us_id = ".$id_usuario;
				$sql_respuesta = $conn->query($sql);

				if($sql_respuesta)
					$response =  array(
						'done' => true,
						'message' => 'Se eliminó el usuario'
					);
			}else{
				$response = array(
					'done' => false,
					'message' => 'No se puede eliminar el usuario porque tienes la sesión iniciada'
				);
			}
		}
	} catch (Exception $e){}

	include 'usuarios.php';
?>
