<?php

if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
    
?>