<?php
	include('header.php');
	$platillo = array(
		'or_id_orden' => 0,
		'or_mesa' => '',
		'or_fecha' => 0,
		'op_precio' => '',
	);

	try {
		$conn = new mysqli('localhost', 'root', 'asdfg123..', 'restaurante');

		if(!$conn->connect_error){
			$sql = "
				select
					*
				from
					tipos_comidas";
			$comidas = $conn->query($sql);

			$sql = "
				select
					*
				from
					platillos";
			$ordenes = $conn->query($sql);

			if(isset($_GET['id'])){
				$id = $_GET['id'];

				$sql = "
					select
						*
					from
						ordenes join ordenes_platillos on ordenes_platillos.op_id_orden=ordenes.or_id
					where
						or_id = ".$id
				;

				$orden = $conn->query($sql)->fetch_assoc();
				if(is_array($platillo)){
					$sql = "select * from platillos";
						// select
						// 	*
						// from
						// 	platillos_ingredientes
						// 	inner join ingredientes on pi_id_ingrediente = in_id
						// where
						// 	pi_id_platillo = ".$id."
						// order by
						// 	in_nombre
					// ";

					$platillos_ingredientes = $conn->query($sql);
				}else
					unset($id);
			}
		}
	} catch (Exception $e){}
?>
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-12 col-md-8 header">
				<h2><?php echo((isset($id)) ? 'Modificar' : 'Nuevo'); ?> orden</h2>
				<small>Ingrese todos los datos solicitados</small>
			</div>
			<div class="col-xs-12 col-md-4 opciones">
				<ul class="col-xs-12">
					<li class="col-xs-6">
						<a class="btn btn-info" href="platillos.php">
							<span class="glyphicon glyphicon-chevron-left"></span>
							Regresar
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
			<form name="frm" action="or_guardar.php" method="post" class="col-xs-12 form-horizontal">
				<div class="col-xs-12 col-md-4">
					<h3>Información general</h3>
					<div class="form-group">
						<div class="col-xs-12">
							<label for="">Mesa</label>
							<small>Obligatorio</small>
						</div>
						<div class="col-xs-12 col-md-12">
							<input type="text" name="mesa" placeholder="1" maxlength="10" class="form-control col-xs-8" value="<?php echo $orden['or_mesa'] ?>" required>
							<input type="hidden" readonly="readonly" name="or_id" value="<?php echo $orden['or_id'] ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<label for="">Fecha</label>
							<small>Obligatorio</small>
						</div>
						<div class="col-xs-12 col-md-4">
							<p><input type="text" id="datepicker" name="fecha" class="form-control col-xs-8" value="<?php echo $orden['or_fecha'] ?>"  required></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<label for="correo">Total</label>
							<small>Obligatorio</small>
							<input type="text" name="precio" class="form-control col-xs-8" value="<?php echo $orden['op_precio'] ?>"  required>
						</div>

					</div>
					<div class="form-group">
						<div class="col-xs-12 col-md-5">
							<button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-7">
					<h3>Platillos</h3>
					<div class="form-group">
						<div class="col-xs-12">
							<label for="correo">Platillos</label>
							<small>Elige uno y da click en el botón para añadirlo</small>
						</div>
						<div class="col-xs-12">
							<select name="platillos" class="form-control">
								<option value="">--Elige un platillo--</option>
								<?php while($row = $ordenes->fetch_assoc()): ?>
									<option value="<?php echo $row['pa_id'] ?>" precio="<?php echo $row['pa_precio'] ?>"><?php echo $row['pa_nombre'] ?></option>
								<?php endwhile; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<button type="button" class="btn btn-info btn-add-ingrediente" name="agregar">Agregar platillo</button>
						</div>
					</div>
					<table class="table table-bordered">
						<thead>
							<tr>
								<td></td>
								<td>Pedido</td>
								<td>Precio Sug.</td>
								<td>Precio</td>
								<td>Cant.</td>
								<td>Subtotal</td>

							</tr>
						</thead>
						<tbody>
							<?php
								if(isset($platillos_ingredientes)):
									while ($value = $platillos_ingredientes->fetch_assoc()):
							?>
									<tr>
										<td class="text-center">
											<button type="button" class="btn btn-danger btn-xs btn-delete-ingrediente">X</button>
										</td>
										<td><?php echo $value['pa_nombre'] ?></td>
										<td><?php echo $value['pa_precio'] ?></td>
										<td><?php echo $value['ca'] ?></td> -->
										<td><?php echo $value['pa_precio'] ?></td>




									</tr>
							<?php
									endwhile;
								endif;
							?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
<?php include('footer.php'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<link rel="stylesheet" href="assets/css/views/pl_formulario.css">
<script type="text/javascript" src="assets/js/libs/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/js/views/pl_formulario.js"></script>
