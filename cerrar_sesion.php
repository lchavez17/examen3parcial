<?php
	session_start();

	if(isset($_SESSION['bsd1']))
		unset($_SESSION['bsd1']);

	header('Location: index.php');
?>