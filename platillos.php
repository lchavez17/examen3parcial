<?php
	include('header.php');

	try {
		$conn = new mysqli('localhost', 'root', 'asdfg123..', 'restaurante');

		if(!$conn->connect_error){
			$sql = "
				select
					*,
					(
						select
							count(pi_id_ingrediente)
						from
							platillos_ingredientes
						where
							pi_id_platillo = pa_id
					) as tot_ingredientes
				from
					platillos
					inner join tipos_comidas on pa_id_tipo_comida = ti_id";
			$sql_respuesta = $conn->query($sql);
		}
	} catch (Exception $e){}
?>

	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-12 col-md-8 header">
				<h2>Lista de platillos</h2>
				<small>Se encontraron <?php echo($sql_respuesta->num_rows); ?> platillos registrados</small>
			</div>
			<div class="col-xs-12 col-md-4 opciones">
				<ul class="col-xs-12">
					<li class="col-xs-6">
						<a class="btn btn-info" href="pl_formulario.php">
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
						<td class="text-center">Precio</td>
						<td class="text-center">Cant. Ing.</td>
						<td class="text-center">Tipo</td>
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
								<td class="text-center"><?php echo $num_rows ?></td>
								<td class="text-center"><?php echo $row['pa_id'] ?></td>
								<td><?php echo $row['pa_nombre'] ?></td>
								<td class="text-center"><?php echo $row['pa_precio'] ?></td>
								<td class="text-center"><?php echo $row['tot_ingredientes'] ?></td>
								<td class="text-center"><?php echo $row['ti_tipo_comida'] ?></td>
								<td class="text-center">
									<a href="pl_formulario.php?id=<?php echo $row['pa_id'] ?>" class="btn btn-primary btn-sm">
										Editar
									</a>
									<a href="pl_eliminar.php?id=<?php echo $row['pa_id'] ?>" class="btn btn-danger btn-sm btn-eliminar">
										Eliminar
									</a>
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
<script src="assets/js/views/platillos.js"></script>
