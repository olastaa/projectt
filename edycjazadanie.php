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
    $rezultat = $polaczenie->query("SELECT * FROM zadania WHERE ID_Zadanie = $edit_id");
    $row = $rezultat->fetch_array();
}

if(isset($_POST['update']))
{
    //udana walidacja, tak!
    $wszystko_OK=true;

    $zadanie = $_POST['opis'];

    //Sprawdzenie dlugosci nazwy
    if((strlen($zadanie)<3) || (strlen($zadanie)>50))
    {
        $wszystko_OK=false;
        $_SESSION['e_zadanie']="Opis zadania musi posiadać od 3 do 50 znaków";
    }
    
    if ($polaczenie -> connect_error) {
        die("Nieudane połączenie: " . $conn->connect_error);
    } else {
        $rezultat = $polaczenie->query("UPDATE zadania SET opis = '$zadanie' WHERE ID_Zadanie =" .$_GET['edit_id']);
        echo "<meta http-equiv='refresh' content=0;url='zadania.php'>";
    }
}

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" /> 
        <title>Project Tracker | Lista klientów</title>
        <meta name="description" content="....">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" type="image/png" href="favicon-16x16.png">
        <link href="https://fonts.googleapis.com/css?family=Roboto|Ubuntu&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    </head>
    <body> 
    <header>
        <nav class="navbar navbar-light" style="background-color: #babec1;">
        <a class="navbar-brand" href="strona1.php'><img src="p_logo.png" width="40" height="40" alt=""></a>
          <a class="navbar-brand" href="projekty.php">Projekty</a>
          <a class="navbar-brand" href="klienci.php">Klienci</a>
          <a class="navbar-brand" href="pracownicy.php">Pracownicy</a>
          <a class="navbar-brand" href="zadania.php">Zadania</a>            
          <a class="navbar-brand" href="logout.php"><input type="button" value="Wyloguj"></a>
        </nav>           
        <main class="container-fluid" {% block body %}{% endblock %}>
      </header>
        <h1>Edycja nazwy zadania</h1>
        <br>

        <form method="post">       
            Opis zadania: <input type="text" name="opis" value="<?php echo $row['opis']; ?>" > 
            <?php
            if(isset($_SESSION['e_zadanie']))
            {
                echo'<div class="error">'.$_SESSION['e_zadanie'].'</div>';
                unset($_SESSION['e_zadanie']);
            }
            ?>
            <input type="submit" class="dodaj" name="update" value="Aktualizuj" />    
            <br>
            <a href="zadania.php"><input type="button" value="Powrót">    
        </form>
    </body>
</html>