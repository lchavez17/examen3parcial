<?php
	$response = array(
		'done' => false,
		'message' => 'No se pudo guardar la información del platillo'
	);

	if(isset($_POST['guardar'])){
		$pa_id = $_POST['pa_id'];
		$pa_nombre = $_POST['pa_nombre'];
		$pa_precio = $_POST['pa_precio'];
		$pa_descripcion = $_POST['pa_descripcion'];
		$pa_id_tipo_comida = $_POST['pa_id_tipo_comida'];

		$ingredientes = $_POST['ingrediente'];
		$cantidad = $_POST['cantidad'];

		if ($pa_nombre != '' && $pa_precio != '' && $pa_id_tipo_comida != 0){
			if (count($ingredientes) > 0){
				$conn = new mysqli('localhost', 'root', 'asdfg123..', 'restaurante');

				if(!$conn->connect_error){
					if ($pa_id == 0){
						$sql = "
							insert into
								platillos
									(pa_nombre, pa_descripcion, pa_precio, pa_id_tipo_comida)
									values
										(
											'".$pa_nombre."',
											'".$pa_descripcion."',
											".$pa_precio.",
											".$pa_id_tipo_comida."
										);
						";
					}else{
						$sql = "
							update
								platillos
							set
								pa_nombre = '".$pa_nombre."',
								pa_descripcion = '".$pa_descripcion."',
								pa_precio = ".$pa_precio.",
								pa_id_tipo_comida = ".$pa_id_tipo_comida."
							where
								pa_id = ".$pa_id."
						";
					}

					$sql_respuesta = $conn->query($sql);
					if($sql_respuesta){
						if($pa_id == 0)
							$pa_id = $conn->insert_id;

						$sql = "
							delete from
								platillos_ingredientes
							where
								pi_id_platillo = ".$pa_id
						;
						$sql_respuesta = $conn->query($sql);
						if ($sql_respuesta){
							for($i = 0; $i <= count($ingredientes)-1; $i++){
								$sql = "
									insert into
										platillos_ingredientes
											(pi_id_platillo, pi_id_ingrediente, pi_cantidad)
										values
											(".$pa_id.",".$ingredientes[$i].", ".$cantidad[$i].");
								";
								$conn->query($sql);
							}
						}

						$response['done'] = true;
						$response['message'] = 'El platillo se guaró correctamente';
					}
				}

			}else
				$response['message'] = 'Debe indicar al menos un ingrediente';
		}else
			$response['message'].= ', favor de llenar todos los campos';
	}

	//$id = (isset($_POST['pa_id']) ? $_POST['pa_id'] : 0);

	if($response['done'])
		include 'platillos.php';
	else
		include('pl_formulario.php');
?>
