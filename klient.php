<?php
// do poprawy nazwa tabeli z klientami
$mysqli = new mysqli('localhost','root', '', 'klienci');

if ($mysqli->connect_error) { 
    die('Błąd połączenia z bazą danych.'    
    . $mysqli->connect_error);
    }

$sql = "INSERT INTO klienci (klient)
VALUES ('$_POST[klient]')";

if ($mysqli -> query($sql))
    {
    die('Error: ' . mysql_error());
    }
    echo "Dodano klienta.";

$mysqli -> close();

?>