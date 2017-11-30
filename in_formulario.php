<?php
	include('header.php');
	$datos = array(
		'in_id' => 0,
		'in_nombre' => '',
		'in_unidad' => ''
	);

	try {

		if(isset($_POST['guardar'])){
			$nombre = $_POST['nombre'];
			$unidad = $_POST['unidad'];
			$id = $_POST['id'];
			$response = array(
				'done' => false,
				'message' => 'No se pudo guardar la información del ingrediente'
			);

			if ($nombre != '' && $unidad != ''){
				$conn = new mysqli('localhost', 'root', 'asdfg123..', 'restaurante');

				if(!$conn->connect_error){

					if($id == 0){
						$sql = "insert into ingredientes(in_nombre, in_unidad) values('".$nombre."', '".$unidad."')";
					}else{
						$sql = "update ingredientes set in_nombre = '".$nombre."', in_unidad = '".$unidad."' where in_id = ".$id;
					}

					$sql_respuesta = $conn->query($sql);
					if($sql_respuesta){
						$response['done'] = true;
						$response['message'] = 'Se guardó la información del ingrediente';
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
							ingredientes
						where
							in_id = ".$id;
					$sql_respuesta = $conn->query($sql);
					if ($sql_respuesta->num_rows == 1){
						$datos = $sql_respuesta->fetch_assoc();
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
				<h2><?php echo((isset($id)) ? 'Modificar' : 'Nuevo'); ?> ingrediente</h2>
				<small>Ingrese todos los datos solicitados</small>
			</div>
			<div class="col-xs-12 col-md-4 opciones">
				<ul class="col-xs-12">
					<li class="col-xs-6">
						<a class="btn btn-info" href="ingredientes.php">
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
			<form name="frm" action="in_formulario.php" method="post" class="col-xs-12 form-horizontal">
				<div class="form-group">
					<div class="col-xs-12">
						<label for="nombre">Nombre</label>
						<small>Obligatorio</small>
					</div>
					<div class="col-xs-12 col-md-6">
						<input type="text" name="nombre" placeholder="Tomate" maxlength="70" class="form-control col-xs-8" required value="<?php echo($datos['in_nombre']); ?>">
						<input type="hidden" readonly="readonly" name="id" value="<?php echo($datos['in_id']); ?>">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12">
						<label for="unidad">Unidad</label>
						<small>Obligatorio</small>
					</div>
					<div class="col-xs-12 col-md-6">
						<input type="text" name="unidad" placeholder="GR" maxlength="5" class="form-control col-xs-8" value="<?php echo($datos['in_unidad']); ?>" required>
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
<script type="text/javascript">
	$("form").validate({ errorPlacement: function(error, element) {} });
</script>
