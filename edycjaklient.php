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

if(isset($_GET['edit_id']))
{
    $edit_id = $_GET['edit_id'];
    $rezultat = $polaczenie->query("SELECT Klient FROM klienci WHERE ID_Klienta = $edit_id");
    $row = $rezultat->fetch_array();
}

if(isset($_POST['update']))
{
    //udana walidacja, tak!
    $wszystko_OK=true;

    $Klient = $_POST['Klient'];

    //Sprawdzenie dlugosci usera
    if((strlen($Klient)<3) || (strlen($Klient)>50))
    {
        $wszystko_OK=false;
        $_SESSION['e_Klient']="Nazwa klienta musi posiadać od 3 do 50 znaków";
        echo $Klient;
        }
    
    /*  do poprawy!!!!!!!!!!!!!!!!
    $rezultat = $polaczenie->query("SELECT * FROM klienci WHERE Klient='$Klient'");
    //if(!rezultat) throw new Exception($polaczenie->error);
            
    
    $ile_takich_klientow = $rezultat->num_rows; //ilosc zwroconych rekordow
    if($ile_takich_klientow>1) {
        $wszystko_OK=false;
        $_SESSION['e_Klient']="Taki klient już istnieje!";
    }*/
            
    if ($polaczenie -> connect_error) {
        die("Nieudane połączenie: " . $conn->connect_error);
    } else {
        if($wszystko_OK==true) {
            $rezultat = $polaczenie->query("UPDATE klienci SET Klient = '$Klient' WHERE ID_Klienta =" .$_GET['edit_id']);
            echo "<meta http-equiv='refresh' content=0;url='klienci.php'>";
        } else {
                $polaczenie -> connect_error;      
        }
    }
    $polaczenie->close();
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" /> 
        <title>Project Tracker | Lista klientów</title>
        <meta name="description" content="....">
        <link rel="stylesheet" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto|Ubuntu&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="favicon-16x16.png">
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
        <h1>Edycja klienta</h1>
        <br>

        <form method="post">       
            Nazwa klienta: <input type="text" name="Klient" value="<?php echo $row['Klient']; ?>" > 
            <?php
            if(isset($_SESSION['e_Klient']))
            {
                echo'<div class="error">'.$_SESSION['e_Klient'].'</div>';
                unset($_SESSION['e_Klient']);
            }
            ?>
            <input type="submit" name="update" class="dodaj" value="Aktualizuj" />  
            <br> 
            <a href="zadania.php"><input type="button" value="Powrót" />    
        </form>     
    </body>
</html>