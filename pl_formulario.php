<?php
	include('header.php');
	$platillo = array(
		'pa_id' => 0,
		'pa_nombre' => '',
		'pa_precio' => 0,
		'pa_descripcion' => '',
		'pa_id_tipo_comida' => 0
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
					ingredientes";
			$ingredientes = $conn->query($sql);

			if(isset($_GET['id'])){
				$id = $_GET['id'];

				$sql = "
					select
						*
					from
						platillos
					where
						pa_id = ".$id
				;

				$platillo = $conn->query($sql)->fetch_assoc();
				if(is_array($platillo)){
					$sql = "
						select
							*
						from
							platillos_ingredientes
							inner join ingredientes on pi_id_ingrediente = in_id
						where
							pi_id_platillo = ".$id."
						order by
							in_nombre
					";

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
				<h2><?php echo((isset($id)) ? 'Modificar' : 'Nuevo'); ?> platillo</h2>
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
			<form name="frm" action="pl_guardar.php" method="post" class="col-xs-12 form-horizontal">
				<div class="col-xs-12 col-md-7">
					<h3>Información general</h3>
					<div class="form-group">
						<div class="col-xs-12">
							<label for="">Nombre</label>
							<small>Obligatorio</small>
						</div>
						<div class="col-xs-12 col-md-12">
							<input type="text" name="pa_nombre" placeholder="Tostadas de lomo" maxlength="75" class="form-control col-xs-8" value="<?php echo $platillo['pa_nombre'] ?>" required>
							<input type="hidden" readonly="readonly" name="pa_id" value="<?php echo $platillo['pa_id'] ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<label for="">Precio</label>
							<small>Obligatorio</small>
						</div>
						<div class="col-xs-12 col-md-4">
							<input type="number" min="1" step=".1" name="pa_precio" placeholder="15.5" class="form-control col-xs-8" value="<?php echo $platillo['pa_precio'] ?>"  required>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<label for="correo">Instrucciones/descripción</label>
						</div>
						<div class="col-xs-12 col-md-12">
							<textarea name="pa_descripcion" class="form-control"><?php echo $platillo['pa_descripcion'] ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<label for="correo">Tipo de comida</label>
							<small>Obligatorio</small>
						</div>
						<div class="col-xs-12 col-md-6">
							<select name="pa_id_tipo_comida" class="form-control" required="">
								<option value="">--Elige un tipo--</option>
								<?php while($row = $comidas->fetch_assoc()): ?>
									<option value="<?php echo $row['ti_id'] ?>" <?php echo(($row['ti_id'] == $platillo['pa_id_tipo_comida']) ? "selected" : "") ?> ><?php echo $row['ti_tipo_comida'] ?></option>
								<?php endwhile; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12 col-md-5">
							<button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-5">
					<h3>Ingredientes</h3>
					<div class="form-group">
						<div class="col-xs-12">
							<label for="correo">Ingredientes</label>
							<small>Elige uno y da click en el botón para añadirlo</small>
						</div>
						<div class="col-xs-12">
							<select name="ingredientes" class="form-control">
								<option value="">--Elige un ingrediente--</option>
								<?php while($row = $ingredientes->fetch_assoc()): ?>
									<option value="<?php echo $row['in_id'] ?>" unidad="<?php echo $row['in_unidad'] ?>"><?php echo $row['in_nombre'] ?></option>
								<?php endwhile; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<button type="button" class="btn btn-info btn-add-ingrediente" name="agregar">Agregar ingrediente</button>
						</div>
					</div>
					<table class="table table-bordered">
						<thead>
							<tr>
								<td></td>
								<td>Ingrediente</td>
								<td>Unidad</td>
								<td>Cant.</td>
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
										<td><?php echo $value['in_nombre'] ?></td>
										<td><?php echo $value['in_unidad'] ?></td>
										<td class="col-xs-4">
											<input type="number" step=".1" value="0<?php echo $value['pi_cantidad'] ?>" name="cantidad[]" class="form-control">
											<input type="hidden" readonly value="<?php echo $value['in_id'] ?>" name="ingrediente[]" class="form-control">
										</td>
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
