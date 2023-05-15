<?php

	session_start();
	
	if ((!isset($_POST['nazwa_podrozy']))||!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
</head>
<body>

</body>
</html>