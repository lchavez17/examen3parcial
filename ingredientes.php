<?php
	include('header.php');

	try {
		$conn = new mysqli('localhost', 'root', 'asdfg123..', 'restaurante');

		if(!$conn->connect_error){
			$sql = "
				select
					in_id, in_nombre, in_unidad,
					(
						select
							count(pi_id_platillo)
						from
							platillos_ingredientes
						where
							pi_id_ingrediente = in_id
					) as tot_platillos
				from
					ingredientes
					";
			$sql_respuesta = $conn->query($sql);
		}
	} catch (Exception $e){}
?>

	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-12 col-md-8 header">
				<h2>Lista de ingredientes</h2>
				<small>Se encontraron <?php echo($sql_respuesta->num_rows); ?> ingredientes registrados</small>
			</div>
			<div class="col-xs-12 col-md-4 opciones">
				<ul class="col-xs-12">
					<li class="col-xs-6">
						<a class="btn btn-info" href="in_formulario.php">
							<span class="glyphicon glyphicon-plus"></span>
							Nuevo
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-xs-12 contenido">
			<?php if(isset($response)): ?>
				<div class="text-center bold alert alert-<?php echo(($response['done']) ? 'success' : 'warning'); ?>">
					<?php echo($response['message']); ?>
				</div>
			<?php endif; ?>
			<table class="table table-bordered">
				<thead>
					<tr>
						<td class="text-center">#</td>
						<td class="text-center">Id</td>
						<td>Nombre</td>
						<td class="text-center">Unidad</td>
						<td class="text-center">Cant. Pla.</td>
						<td class="text-center">Acciones</td>
					</tr>
				</thead>
				<tbody>
					<?php
						$num_rows = 0;
						while($row = $sql_respuesta->fetch_assoc()):
							$Rmivec[] = $row;
							$num_rows++;
					?>
							<tr>
								<td class="text-center"><?php echo $num_rows ?></td>
								<td class="text-center"><?php echo $row['in_id'] ?></td>
								<td><?php echo $row['in_nombre'] ?></td>
								<td><?php echo $row['in_unidad'] ?></td>
								<td class="text-center"><?php echo $row['tot_platillos'] ?></td>
								<td class="text-center">
									<a href="in_formulario.php?id=<?php echo $row['in_id'] ?>" class="btn btn-primary btn-sm">
										Editar
									</a>
									<?php if($row['tot_platillos'] == 0): ?>
										<a href="in_eliminar.php?id=<?php echo $row['in_id'] ?>" class="btn btn-danger btn-sm btn-eliminar">
											Eliminar
										</a>
									<?php endif; ?>
								</td>
							</tr>
					<?php
						endwhile;
					?>
				</tbody>
			</table>
		</div>
	</div>
<?php include('footer.php'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="assets/js/views/ingredientes.js"></script>
