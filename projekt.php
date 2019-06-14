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
$db->set_charset("utf8");

if ($db -> connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['edit_id']))
{ 
    $edit_id = $_GET['edit_id'];
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" /> 
        <title>Project Tracker | Projekt</title>
        <meta name="description" content="....">
        <link rel="icon" type="image/png" href="favicon-16x16.png">
        <link rel="stylesheet" href="style.css">
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
        <?php 
        $result = $db->query("SELECT * FROM projekty INNER JOIN klienci ON projekty.ID_Klienta = klienci.ID_KLienta 
                    INNER JOIN pracownicy ON projekty.ID_Pracownik = pracownicy.ID_Pracownik
                    WHERE ID_Projektu = '$edit_id'"); 
            //or die('Error querying database.');
        if ($result -> num_rows > 0){
            $row = $result->fetch_assoc();
        ?>
        <h1><?php echo $row['Projekt']; ?></h1>
        <br>
        Nazwa projektu: <?php echo $row['Projekt']; ?><br>
        Klient: <?php echo $row['Klient']; ?><br>
        Project Manager: <?php echo $row['imie_nazwisko']; ?><br>
        Start projektu: <?php echo $row['Data_start']; ?><br>
        Prognozowane zakończenie projektu: <?php echo $row['Data_stop']; ?><br>
        <?php 
        }   ?>
        <br>
        <a href='edycjaprojekt.php?edit_id=<?php echo $edit_id;?>' alt='edit'>Edytuj dane projektu</a>
        <br>    
        <br>
        <h2>Zadania w projekcie:</h2>
        <a href="dodajnowyt.php?edit_id=<?php echo $edit_id;?>"><input type="button" class="dodaj" value="Dodaj zadanie"></a>
        <br><br>
        <?php
            $result = $db->query("SELECT * FROM tracker INNER JOIN projekty ON tracker.ID_Projekt = projekty.ID_Projektu 
                        INNER JOIN zadania ON tracker.ID_Zadanie = zadania.ID_Zadanie
                        INNER JOIN pracownicy ON tracker.ID_Pracownik = pracownicy.ID_Pracownik
                        WHERE ID_Projekt = '$edit_id'"); 
            //or die('Error querying database.');
                if ($result -> num_rows > 0){
                    echo "<table>
                            <tr>
                            <th>Zadanie</th> 
                            <th>Realizowane przez</th>
                            <th>Estymowany czas realizacji</th>
                            <th>Faktyczny czas realizacji</th>
                            <th>Edycja</th>
                            </tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>".$row["opis"]."</td>
                        <td>".$row["imie_nazwisko"]."</td>
                        <td>".$row["Estymowany_czas"]."h</td>
                        <td>".$row["Realizowany_czas"]."h</td>
                        <td><a name='edycjatask' href='edycjatask.php?edit_id=".$row["ID_Tracker"]."' alt='edit'>Aktualizuj</a></td>
                        </tr>";
             }
                    echo "</table>";
                } else {
                    echo "Brak zadań przypisanych do projektu.";
                }
            $db -> close();
            ?>            
        <br><br>
        <a href="projekty.php"><input type="button" value="Powrót" />        
    </body>
</html>