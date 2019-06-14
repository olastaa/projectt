<?php
session_start();

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
$polaczenie->set_charset("utf8");

if(isset($_POST['Zadanie']))
{
    //udana walidacja, tak!
    $wszystko_OK=true;

    //Sprawdzenie User
    $Zadanie = $_POST['Zadanie'];
    
    //Sprawdzenie dlugosci nazwy projektu
    if((strlen($Zadanie)<3) || (strlen($Zadanie)>50))
    {
        $wszystko_OK=false;
        $_SESSION['e_Zadanie']="Nazwa zadania musi zawierać od 3 do 50 znaków";
    }
    
    try{
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception($polaczenie->connect_errno);
        }
        else
        {
            $rezultat = $polaczenie->query("SELECT * FROM zadania WHERE opis='$Zadanie'");
            if(!rezultat) throw new Exception($polaczenie->error);
            
            $ile_takich_Zadan = $rezultat->num_rows; //ilosc zwroconych rekordow
            if($ile_takich_Zadan>0)
            {
                $wszystko_OK=false;
                $_SESSION['e_Zadanie']="Takie zadanie już istnieje w bazie!";
            }
            
            if($wszystko_OK==true)
            {
                //umieszenie danych w bazie!!!!!!!!!!!
             if($polaczenie->query("INSERT INTO zadania VALUES (NULL, '$Zadanie')"))
             {
               $_SESSION['udanaweryfikacja']=true;
               echo "Dodano do bazy";
               header('Location: zadania.php');
             }
             else
             {
               throw new Exception($polaczenie->error);  
             }
            }
            
            $polaczenie->close();
        }
    } catch (Exception $e) {
        echo '<span style="color:red;">Bląd Serwera - juhu</span>';
        echo '<br />Informacja developerska: '.$e;
    }
}   
?>

<!DOCTYPE html>
<html lang ="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel="stylesheet" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto|Ubuntu&display=swap" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="icon" type="image/png" href="favicon-16x16.png">
        <title>Dodawanie nowego zadania </title>       
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
        <h1>Dodaj nowe zadanie</h1>

        <form method="post">
            Nazwa zadania: <input type="text" name="Zadanie" placeholder="Nazwa zadania"/>
            <input type="submit" class="dodaj" name="dodajz" value="Dodaj" />
            <?php
            if(isset($_SESSION['e_Zadanie'])) {
                echo'<div class="error">'.$_SESSION['e_Zadanie'].'</div>';
                unset($_SESSION['e_Zadanie']);
            }
            ?>            
            <br />
            <br />
        </form>   
        <a href="zadania.php"><input type="button" value="Powrót" />
    </body>
</html>