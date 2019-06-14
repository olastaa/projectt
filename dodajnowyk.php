<?php
session_start();

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
$polaczenie->set_charset("utf8");

if(isset($_POST['Klient']))
{
    //udana walidacja, tak!
    $wszystko_OK=true;

    //Sprawdzenie User
    $Klient = $_POST['Klient'];
    
    //Sprawdzenie dlugosci nazwy projektu
    if((strlen($Klient)<3) || (strlen($Klient)>20))
    {
        $wszystko_OK=false;
        $_SESSION['e_Klient']="Nazwa klienta musi zawierać od 3 do 20 znaków";
    }
    
    try{
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception($polaczenie->connect_errno);
        }
        else
        {
            $rezultat = $polaczenie->query("SELECT * FROM klienci WHERE Klient='$Klient'");
            if(!rezultat) throw new Exception($polaczenie->error);
            
            $ile_takich_Klientow = $rezultat->num_rows; //ilosc zwroconych rekordow
            if($ile_takich_Klientow>0)
            {
                $wszystko_OK=false;
                $_SESSION['e_Klient']="Taki klient już istnieje w bazie!";
            }
            
            if($wszystko_OK==true)
            {
                //umieszenie danych w bazie!!!!!!!!!!!
             if($polaczenie->query("INSERT INTO klienci VALUES (NULL, '$Klient')"))
             {
               $_SESSION['udanaweryfikacja']=true;
               echo "Dodano do bazy";
               header('Location: klienci.php');
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
        <title>Dodawanie nowego klienta </title> 
        <link rel="icon" type="image/png" href="favicon-16x16.png">      
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
        <h1>Dodaj nowego klienta</h1>

        <form method="post">
            Nazwa klienta: <input type="text" name="Klient" placeholder="Nazwa klienta"/>
            <input type="submit" name="dodajz" class="dodaj" value="Dodaj" />
            <?php
            if(isset($_SESSION['e_Klient'])) {
                echo'<div class="error">'.$_SESSION['e_Klient'].'</div>';
                unset($_SESSION['e_Klient']);
            }
            ?>          
            <br />
            <br />
            <a href="klienci.php"><input type="button" value="Powrót" />
        </form>   
    </body>
</html>