<?php
	session_start();

	if(!isset($_SESSION['bsd1']))
		header('Location: index.php');

	$id = $_GET['id'];

	try {
		$conn = new mysqli('localhost', 'root', 'asdfg123..', 'restaurante');

		if(!$conn->connect_error){
			$sql = "
				select
					*
				from
					platillos_ingredientes
				where
					pi_id_ingrediente = ".$id;
			$sql_respuesta = $conn->query($sql);

			if ($sql_respuesta->num_rows == 0){
				$sql = "delete from ingredientes where in_id = ".$id;
				$sql_respuesta = $conn->query($sql);

				if($sql_respuesta)
					$response =  array(
						'done' => true,
						'message' => 'Se eliminó el ingrediente'
					);
			}else{
				$response = array(
					'done' => false,
					'message' => 'No se puede eliminar el ingrediente porque está siendo usado en al menos un platillo'
				);
			}
		}
	} catch (Exception $e){
	}

	include 'ingredientes.php';
?>
