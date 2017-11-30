<?php
	include('header.php');

	try {
		$conn = new mysqli('localhost', 'root', 'asdfg123..', 'restaurante');

		if(!$conn->connect_error){
			$sql = "
				select
					*
				from
					usuarios";
			$sql_respuesta = $conn->query($sql);
		}
	} catch (Exception $e){}
?>

	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-12 col-md-8 header">
				<h2>Lista de usuarios</h2>
				<small>Se encontraron <?php echo($sql_respuesta->num_rows); ?> usuarios registrados</small>
			</div>
			<div class="col-xs-12 col-md-4 opciones">
				<ul class="col-xs-12">
					<li class="col-xs-6">
						<a class="btn btn-info" href="us_formulario.php">
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
						<td>Correo electrónico</td>
						<td class="text-center">Status</td>
						<td class="text-center">Acciones</td>
					</tr>
				</thead>
				<tbody>
					<?php
						$num_rows = 0;
						while($row = $sql_respuesta->fetch_assoc()):
							$num_rows++;
					?>
							<tr>
								<td class="text-center"><?php echo $num_rows; ?></td>
								<td class="text-center"><?php echo $row['us_id']; ?></td>
								<td><?php echo $row['us_nombre']; ?></td>
								<td><?php echo $row['us_correo_electronico']; ?></td>
								<td class="text-center">
									<label class="label label-<?php echo(($row['us_status']) ? 'success' : 'warning') ?>">
										<?php echo(($row['us_status']) ? 'ACTIVO' : 'INACTIVO') ?>
									</label>
								</td>
								<td class="text-center">
									<a href="us_formulario.php?id=<?php echo $row['us_id'] ?>" class="btn btn-primary btn-sm">
										Editar
									</a>
									<?php if($row['us_id'] != $_SESSION['bsd1']['us_id']): ?>
										<a href="us_eliminar.php?id=<?php echo $row['us_id'] ?>" class="btn btn-danger btn-sm">
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
