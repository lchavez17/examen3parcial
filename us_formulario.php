<?php
	include('header.php');
	$datos = array(
		'us_id' => 0,
		'us_nombre' => '',
		'us_correo_electronico' => '',
		'us_clave' => ''
	);

	try {

		if(isset($_POST['guardar'])){
			// ejecuta el método de guardar
			// Ejercicio. Validar que el correo electrónico a guardar no se encuentre previamente registrado en la BD
			$nombre = $_POST['nombre'];
			$correo = $_POST['correo'];
			$clave = $_POST['clave'];
			$id = $_POST['id'];
			$response = array(
				'done' => false,
				'message' => 'No se pudo guardar la información del usuario'
			);

			if ($nombre != '' && $correo != '' && $clave != ''){
				$conn = new mysqli('localhost', 'root', 'asdfg123..', 'restaurante');

				if(!$conn->connect_error){

					if($id == 0){
						$sql = "insert into usuarios(us_correo_electronico, us_clave, us_nombre) values('".$correo."', '".$clave."', '".$nombre."')";
					}else{
						$sql = "update usuarios set us_correo_electronico = '".$correo."', us_nombre = '".$nombre."', us_clave = '".$clave."' where us_id = ".$id;
					}

					$sql_respuesta = $conn->query($sql);
					if($sql_respuesta){
						$response['done'] = true;
						$response['message'] = 'Se guardó la información de usuario';
					}
				}
			}else{
				$response['message'] .= ', favor de llenar todos los campos';
			}
		}else{
			if(isset($_GET['id'])){
				$conn = new mysqli('localhost', 'root', '', 'restaurante');
				$id = $_GET['id'];

				if(!$conn->connect_error){
					$sql = "
						select
							*
						from
							usuarios
						where
							us_id = ".$id;
					$sql_respuesta = $conn->query($sql);
					if ($sql_respuesta->num_rows == 1){
						$datos = $sql_respuesta->fetch_assoc();
						$datos['us_clave'] = '';
					}else
						unset($id);
				}
			}
		}

	} catch (Exception $e){}
?>
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-12 col-md-8 header">
				<h2><?php echo((isset($id)) ? 'Modificar' : 'Nuevo'); ?> usuario</h2>
				<small>Ingrese todos los datos solicitados</small>
			</div>
			<div class="col-xs-12 col-md-4 opciones">
				<ul class="col-xs-12">
					<li class="col-xs-6">
						<a class="btn btn-info" href="usuarios.php">
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
			<form name="frm" action="us_formulario.php" method="post" class="col-xs-12 form-horizontal">
				<div class="form-group">
					<div class="col-xs-12">
						<label for="nombre">Nombre</label>
						<small>Obligatorio</small>
					</div>
					<div class="col-xs-12 col-md-6">
						<input type="text" name="nombre" placeholder="Edgar C" maxlength="70" class="form-control col-xs-8" required value="<?php echo($datos['us_nombre']); ?>">
						<input type="hidden" readonly="readonly" name="id" value="<?php echo($datos['us_id']); ?>">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12">
						<label for="correo">Correo</label>
						<small>Obligatorio</small>
					</div>
					<div class="col-xs-12 col-md-6">
						<input type="email" name="correo" placeholder="edgar_campos@ucol.mx" maxlength="30" class="form-control col-xs-8" value="<?php echo($datos['us_correo_electronico']); ?>" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12">
						<label for="clave">Clave</label>
						<small>Obligatorio</small>
					</div>
					<div class="col-xs-12 col-md-5">
						<input type="password" name="clave" id="clave" placeholder="Clave" maxlength="20" class="form-control col-xs-8">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12">
						<label for="clave2">Confirmar Clave</label>
						<small>Obligatorio</small>
					</div>
					<div class="col-xs-12 col-md-5">
						<input type="password" name="clave2" id="clave2" placeholder="Repetir clave" maxlength="20" class="form-control col-xs-8">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12 col-md-5">
						<button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php include('footer.php'); ?>
<script type="text/javascript" src="assets/js/libs/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/js/views/us_formulario.js"></script>
