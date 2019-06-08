<?php

session_start();

if(!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$db = new mysqli($host, $db_user, $db_password, $db_name);
if ($db -> connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" /> 
        <title>Project Tracker | Lista pracowników</title>
        <meta name="description" content="....">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" type="image/png" href="favicon-16x16.png">
        <link href="https://fonts.googleapis.com/css?family=Roboto|Ubuntu&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    </head>
    <body> 
    <header>
    <nav class="navbar navbar-light" style="background-color: #babec1;">
        <a class="navbar-brand" href="strona1.php"><img src="p_logo.png" width="40" height="40" alt=""></a>
          <a class="navbar-brand" href="projekty.php">Projekty</a>
          <a class="navbar-brand" href="klienci.php">Klienci</a>
          <a class="navbar-brand" href="pracownicy.php">Pracownicy</a>
          <a class="navbar-brand" href="zadania.php">Zadania</a>            
          <a class="navbar-brand" href="logout.php"><input type="button" value="Wyloguj"></a>
        </nav>           
        <main class="container-fluid" {% block body %}{% endblock %}>
      </header>
    </head>
    <body> 
        <h1>Lista pracowników</h1>
        <br>
        <a href='dodajnowyuser.php'><input type="button" class="dodaj" value="Dodaj pracownika"></a>
        <br>
        <br>
        
            <?php
                $result = $db->query("SELECT * FROM pracownicy INNER JOIN roles ON pracownicy.ID_Roles = roles.ID_Roles ORDER BY user ASC"); //or die('Error querying database.');
                if ($result -> num_rows > 0){
                    echo "<table>
                            <tr>
                            <th>Login</th> 
                            <th>Imię i nazwisko</th>
                            <th>Adres email</th>
                            <th>Poziom uprawnień</th>
                            <th>Edycja</th>
                            </tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>".$row["user"]."</td>
                        <td>".$row["imie_nazwisko"]."</td>
                        <td>".$row["email"]."</td>
                        <td>".$row["rolename"]."</td>
                        <td><a name='edycjauser' href='edycjauser.php?edit_id=".$row["ID_Pracownik"]."' alt='edit'>Edycja</a></td>
                        </tr>";
             }
                    echo "</table>";
                } else {
                    echo "Brak pracowników w bazie.";
                }
            $db -> close();
            ?>
        <br>
        <a href="strona1.php"><input type="button" value="Powrót"></a>  
     
    </body>
</html>