<?php
// do poprawy nazwa tabeli z userami
$mysqli = new mysqli('localhost','root', '', 'pracownicy');

if ($mysqli->connect_error) { 
    die('Błąd połączenia z bazą danych.'    
    . $mysqli->connect_error);
    }

$sql = "INSERT INTO pracownicy (user, email, pass, roles)
VALUES ('$_POST[user]', '$_POST[email]', '$_POST[pass]', '$_POST[roles]')";

if ($mysqli -> query($sql))
    {
    die('Error: ' . mysql_error());
    }
    echo "Dodano użytkownika.";

$mysqli -> close();

?>