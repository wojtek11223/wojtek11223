<?php
session_start();
// Sprawdzanie, czy formularz został przesłany
if (isset($_POST["submit"])&&isset($_SESSION['zalogowany'])) {

    // Pobieranie id_podrozy z sesji
    
    $id_podrozy = $_SESSION["id_podrozy"];

    // Definiowanie ścieżki do katalogu, w którym będą przechowywane przesłane pliki
    $katalog_zapisu = "uploads/";

    // Przechowywanie informacji o przesłanych plikach
    $targetDir = "zdjecia/";
    $fileNames = array();
    $fileErrors = array();
    
    for ($i = 0; $i < count($_FILES["fileToUpload"]["name"]); $i++) {
        $fileName = basename($_FILES["fileToUpload"]["name"][$i]);
        $targetFile = $targetDir . $fileName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
    
        // Check if file already exists
        if (file_exists($targetFile)) {
            $fileErrors[] = "Plik o nazwie $fileName już istnieje.";
            $uploadOk = 0;
        }
    
        // Check file size
        if ($_FILES["fileToUpload"]["size"][$i] > 5000000) {
            $fileErrors[] = "Plik $fileName jest za duży.";
            $uploadOk = 0;
        }
    
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif" ) {
            $fileErrors[] = "Dozwolone są tylko pliki JPG, JPEG, PNG i GIF.";
            $uploadOk = 0;
        }
    
        if ($uploadOk == 0) {
    
             $fileErrors[] = "Nie udało się przesłać pliku $fileName.";
        }
        else
        {
            // Pobieranie pozostałych danych z formularza
            $komentarz = $_POST["komentarz"];
            $data_wyk_zdjecia = $_POST["data_wyk_zdjecia"];

            // Dodawanie rekordu do bazy danych dla każdego przesłanego pliku
            $conn = mysqli_connect("localhost", "username", "password", "database");

            
            if ($fileNames[$i] != "") {
            $sql = "INSERT INTO zdjecia (id_zdjecie, id_etap, komentarz, data_wyk_zdjecia) VALUES (NULL, '$id_podrozy', '$komentarz', '$data_wyk_zdjecia')";

            if (mysqli_query($conn, $sql)) {
                echo "Rekord został dodany do bazy danych.";
            } else {
                echo "Błąd: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
            

            mysqli_close($conn);

            // Wyświetlanie informacji o przesłanych plikach i ich ewentualnych błędach
            echo "<h2>Zdjęcia zostały dodane.</h2>";
            
            if ($fileNames[$i] != "") {
                echo "<p>Plik <strong>" . $fileNames[$i] . "</strong> został pomyślnie przesłany.</p>";
            } else {
                echo "<p>" . $fileErrors[$i] . "</p>";
            }
            
        }
        }
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <h2>Dodaj zdjęcia</h2>
    <input type="file" name="fileToUpload[]" multiple><br><br>
<label for="komentarz">Komentarz:</label><br>
<textarea name="komentarz" rows="5" cols="40"></textarea><br><br>
<label for="data_wyk_zdjecia">Data wykonywania zdjęć:</label>
<input type="date" name="data_wyk_zdjecia"><br><br>
<input type="submit" name="submit" value="Dodaj zdjęcia">

</form>