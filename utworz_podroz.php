<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	if(isset($_POST["submit"]))
	{
		require_once "connect.php";
		
		$conn = @new mysqli($host, $db_user, $db_password, $db_name);
		if($conn->connect_errno)
		{
			$_SESSION['error']="Błąd z połączeniem się z bazą danych";
			exit();
		}
		else
		{
			$data_roz_podrozy= $_POST['poczatek_podrozy'];
			$data_kon_podrozy= $_POST['koniec_podrozy'];
			$nazwa_podrozy= $_POST['nazwa_podrozy'];
			$komentarz=$_POST['komentarz'];
			$id_user=$_SESSION['id_uzytkownik']

			$nazwa_podrozy=htmlentities($nazwa_podrozy, ENT_QUOTES, "UTF-8");
			$komentarz=htmlentities($komentarz, ENT_QUOTES, "UTF-8");
			
			$sql = "INSERT INTO podroze VALUES (NULL, '$id_user', '$komentarz','$nazwa_podrozy', '$data_roz_podrozy','$data_kon_podrozy')";
			if($rezultat = @$conn->query(sql));
			{
				$_SESSION['id_podrozu'] = $conn->insert_id;
				header('Location: lista_etapow.php');
				exit();
			}
			else{
				$_SESSION['error']="Wystpił podczas tworzenie nowej podrozy";
			}
			
		}
		}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
</head>

<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	
	Nazwa prodróży: <br /> <input type="text" name="nazwa_podrozy" /> <br />
	<label for="story">Komentarz:</label>

		<textarea id="story" name="komentarz"
				rows="5" cols="33">
		
		</textarea>
	<br /><br />
		<label for="start">Data początku podóży:</label>

	<input type="date" id="start" name="poczatek_podrozy"
       value="2018-07-22"
       min="2018-01-01" max="<?php echo date('d-m-Y');?>"><br/><br/>

	
	<label for="start">Data końca podróży</label>

	<input type="date" id="start" name="koniec_podrozy"
       value="2018-07-22"
       min="2018-01-01" max="<?php echo date('d-m-Y');?>">

	<input type="submit" value="Utworz etapy" />
	<?php
		if(isset($_SESSION['error']))
		{
			echo $_SESSION['error'];
			unset($_SESSION['error']);
		}
	?>


</form>

</body>
</html>