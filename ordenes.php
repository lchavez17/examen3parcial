<?php
	include('header.php');
$fechareg =date('Y-m-d');
$auxfecha='';
	try {
		$conn = new mysqli('localhost', 'root', 'asdfg123..', 'restaurante');

		if(!$conn->connect_error){
			$fechas="SELECT or_fecha FROM ordenes ORDER BY or_id DESC";
			$sql = "select op_id_orden,TIME_FORMAT(`or_fecha`, '%H:%I'),or_mesa,op_precio from ordenes_platillos join ordenes on ordenes.or_id=ordenes_platillos.op_id_orden group by ordenes.or_fecha";
			$sql_sum_platillos="select  sum(ordenes_platillos.op_cantidad) as suma_platillos  from ordenes_platillos inner join ordenes on ordenes.or_id=ordenes_platillos.op_id_orden group by ordenes.or_id";
			$sql_total="select op_precio,op_cantidad, op_precio * op_cantidad as 'total' from ordenes_platillos group by ordenes_platillos.op_id_orden";
				// select
				// 	*,
				// 	(
				// 		select
				// 			count(pi_id_ingrediente)
				// 		from
				// 			platillos_ingredientes
				// 		where
				// 			pi_id_platillo = pa_id
				// 	) as tot_ingredientes
				// from
				// 	platillos
				// 	inner join tipos_comidas on pa_id_tipo_comida = ti_id";
			$sql_respuesta = $conn->query($sql);
			$sql_respuesta_suma_platillos = $conn->query($sql_sum_platillos);
			$sql_total=$conn->query($sql_total);
			$result_fechas = mysqli_query($conn, $fechas)
      or die("Error: ".mysqli_error($conn));
			$contador = 0;
      while($row = mysqli_fetch_array($result_fechas)){
        $valor_fecha[$contador]=$row['or_fecha'];
        $valor_fecha[$contador]=date("d/m/Y", strtotime($row['or_fecha']));
        $contador++;
      }
		}
	} catch (Exception $e){}
?>

	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-12 col-md-8 header">
				<h2>Lista de ordenes</h2>
				<small>Se encontraron <?php echo($sql_respuesta->num_rows); ?> ordenes registradas</small>
			</div>
			<div class="col-xs-12 col-md-4 opciones">
				<ul class="col-xs-12">
					<li class="col-xs-6">
						<a class="btn btn-info" href="or_formulario.php">
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
						<td>Hora</td>
						<td class="text-center">Mesa</td>
						<td class="text-center">Cant. de platillos</td>
						<td class="text-center">Monto</td>
						<td class="text-center">Acciones</td>
					</tr>
				</thead>
				<tbody>
					<?php 	$contador=0;
						$auxiliar=0; ?>
					<td COLSPAN="7" style="text-align: center; background-color:#ccc" ><?php echo ($valor_fecha[$contador]) ?> </td>

					<?php
						$num_rows = 0;
						while($row = $sql_respuesta->fetch_assoc()):
							$num_rows++;
							$row_suma=$sql_respuesta_suma_platillos->fetch_assoc();
							$total=$row['op_precio']*$row_suma['suma_platillos'];
					?>
					<?php if ($valor_fecha[$auxiliar]>$valor_fecha[$contador]): ?>
						<tr>
          <td COLSPAN="7" style="text-align: center; background-color:#ccc" ><?php echo ($valor_fecha[$contador]) ?> </td>
						</tr>
					 <?php $auxiliar=$contador ?>
					<?php endif; ?>
							<tr>
								<td class="text-center"><?php echo $num_rows ?></td>
								<td class="text-center"><?php echo $row['op_id_orden'] ?></td>
								<td><?php echo $row["TIME_FORMAT(`or_fecha`, '%H:%I')"] ?></td>
								<td class="text-center"><?php echo $row['or_mesa'] ?></td>
								<td class="text-center"><?php echo $row_suma['suma_platillos'] ?></td>
								<td class="text-center"><?php echo $total ?></td>
								<td class="text-center">
									<a href="or_formulario.php?id=<?php echo $row['op_id_orden'] ?>" class="btn btn-primary btn-sm">
										Editar
									</a>
									<a href="or_eliminar.php?id=<?php echo $row['op_id_orden'] ?>" class="btn btn-danger btn-sm btn-eliminar">
										Eliminar
									</a>
								</td>
							</tr>
					<?php
					$contador++;
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
