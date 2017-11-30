<?php
	session_start();

	if(isset($_SESSION['bsd1'])){
		header('Location: panel.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>PHP</title>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/js/libs/jquery.validate.min.js"></script>
		<link rel="stylesheet" type="text/css" href="assets/css/views/index.css">
	</head>
	<body>
		<header>
			<section class="container">
				<div class="col-xs-12">
					<h1>Clima</h1>
					<span class="help-block">Iniciar sesión</span>
				</div>
			</section>
		</header>
		<main>
			<section class="container">
				<div class="col-xs-12">
					<form name="frminiciarsesion" class="col-xs-12 col-md-6 col-md-offset-3" method="post" action="iniciar_sesion.php">
						<div class="col-xs-12">
							<img src="assets/resources/images/dbsuper.png">
						</div>
						<div class="col-xs-12 datos">
							<?php
								if(isset($_GET['error'])):
							?>
								<div class="col-xs-12 alert alert-warning">
									El correo electrónico y/o contraseña es/son incorrecto(s)
								</div>
							<?php
								endif;
							?>
							<div class="col-xs-12">
								<h2>Iniciar sesión</h2>
								<span>Favor de ingresar todos los datos solicitados</span>
							</div>
							<div class="form-group">
								<input type="email" placeholder="Correo electrónico" name="correo" class="form-control input-md" maxlength="30" required>
							</div>
							<div class="form-group">
								<input type="password" placeholder="Contraseña" name="clave" class="form-control input-md" maxlength="20" required>
							</div>
							<div class="form-group">
								<input type="submit" value="Iniciar sesión" class="form-control btn btn-info" name="">
							</div>
						</div>
						<div class="col-xs-12">
							<p>
								En caso de no contar con alguno de los datos puede recuperar su contraseña dando click <a href="javascript: void(0)">AQUI</a>
							</p>
						</div>
					</form>
				</div>
			</section>
		</main>
		<footer>
		</footer>
		<script type="text/javascript">
			// errorPlacement evita que se muestren los mensajes de error
			$("form").validate({ errorPlacement: function(error, element) {} });
		</script>
	</body>
</html>
