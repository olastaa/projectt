<?php

session_start();

if(!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name); 
$polaczenie->set_charset("utf8");

if(isset($_GET['edit_id']))
{
    $edit_id = $_GET['edit_id'];
    $rezultat = $polaczenie->query("SELECT * FROM tracker WHERE ID_Tracker = $edit_id");
}

if(isset($_POST['update']))
{
    //udana walidacja, tak!
    $wszystko_OK=true;

    $dodatkowyCzas = $_POST['czas'];

    // Sprawdzenie dlugosci tekstu
    if($dodatkowyCzas<0) 
    {
        $wszystko_OK=false;
        $_SESSION['e_czas']="Podaj dodatkowy czas większy niż 0h";
    }
    
    if ($polaczenie -> connect_error) {
        die("Nieudane połączenie: " . $conn->connect_error);
    } else {
        $rezultat = $polaczenie->query("UPDATE tracker SET Realizowany_czas = Realizowany_czas + $dodatkowyCzas WHERE ID_Tracker =" .$_GET['edit_id']);
        echo "<meta http-equiv='refresh' content=0;url='projekty.php";
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" /> 
        <title>Project Tracker | Lista klientów</title>
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
        <h1>Aktualizacja czasu pracy nad zadaniem</h1>
        <br>

        <form method="post"> 
            <?php
                $result = $polaczenie->query("SELECT * FROM tracker INNER JOIN projekty ON tracker.ID_Projekt = projekty.ID_Projektu 
                INNER JOIN zadania ON tracker.ID_Zadanie = zadania.ID_Zadanie
                INNER JOIN pracownicy ON tracker.ID_Pracownik = pracownicy.ID_Pracownik
                WHERE ID_Tracker = $edit_id"); 
                if ($result -> num_rows > 0){
                $row = $result->fetch_assoc();
                } 
            ?>    
            Nazwa projektu: <?php echo $row['Projekt']; ?> <br>
            Zadanie: <?php echo $row['opis']; ?> <br>
            Osoba realizująca zadanie: <?php echo $row['imie_nazwisko']; ?> <br>
            Estymowany czas pracy: <?php echo $row['Estymowany_czas']; ?> h<br>
            Dotychczasowy czas realizacji zadania: <?php echo $row['Realizowany_czas']; ?> h<br>
            Dodaj godziny pracy: <input type="number" name="czas" placeholder="Wprowadź dodatkowe godziny" required> <br>
            <?php
            if(isset($_SESSION['e_czas']))
            {
                echo'<div class="error">'.$_SESSION['e_czas'].'</div>';
                unset($_SESSION['e_czas']);
            }
            ?>  

            <input type="submit" name="update" class="dodaj" value="Aktualizuj" />    
            <br>
            <a href="javascript:history.go(-1)"><input type="button" value="Powrót" />       
        </form>
    </body>
</html>