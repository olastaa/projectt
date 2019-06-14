<?php
session_start();

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
$polaczenie->set_charset("utf8");
$rezultat2 = $polaczenie->query("SELECT * FROM klienci ORDER BY Klient ASC"); 
$rezultat3 = $polaczenie->query("SELECT * FROM pracownicy ORDER BY imie_nazwisko ASC");  


if(isset($_POST['Projekt']))
{
    //udana walidacja, tak!
    $wszystko_OK=true;

    //Sprawdzenie User
    $Projekt = $_POST['Projekt'];
    $ID_Klienta_wybrany = $_POST['klienci'];
    $ID_Pracownik_wybrany = $_POST['pracownicy'];
    $Data_start = $_POST['Data_start'];
    $Data_stop = $_POST['Data_stop'];
    
    //Sprawdzenie dlugosci nazwy projektu
    if((strlen($Projekt)<3) || (strlen($Projekt)>50))
    {
        $wszystko_OK=false;
        $_SESSION['e_Projekt']="Nazwa projektu musi zawierać od 3 do 50 znaków";
    }
    
    // chekbox - czy dane sa poprawne: //
    if(!isset($_POST['akceptacja']))
        {
        $wszystko_OK=false;
        $_SESSION['e_akceptacja']="Zaznacz pole 'Dane są poprawne'";
    }
    
    try{
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception($polaczenie->connect_errno);
        }
        else
        {
            $rezultat = $polaczenie->query("SELECT * FROM projekty WHERE Projekt='$Projekt'");
            if(!rezultat) throw new Exception($polaczenie->error);
            
            $ile_takich_Projektow = $rezultat->num_rows; //ilosc zwroconych rekordow
            if($ile_takich_Projektow>0)
            {
                $wszystko_OK=false;
                $_SESSION['e_Projekt']="Nazwa projektu już istnieje!";
            }
            
            if($wszystko_OK==true)
            {
                //umieszenie danych w bazie!!!!!!!!!!!
             if($polaczenie->query("INSERT INTO projekty VALUES (NULL, '$Projekt', '$ID_Klienta_wybrany', '$ID_Pracownik_wybrany', '$Data_start', '$Data_stop')"))
             {
               $_SESSION['udanaweryfikacja']=true;
               header('Location: projekty.php');
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
        <title>Dodawanie nowego Projektu </title> 
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
      <h1>Dodaj nowy projekt</h1>
        <form method="post">
            Nazwa nowego projektu: <input type="text" name="Projekt" placeholder="Nazwa projektu" required/><br />
            <?php
            if(isset($_SESSION['e_Projekt']))
            {
                echo'<div class="error">'.$_SESSION['e_Projekt'].'</div>';
                unset($_SESSION['e_Projekt']);
            }
                    ?>  
            
            Projekt dla klienta:
            <select name="klienci" >
                <?php
                    echo "<option value='0'>Wybierz</option>";
                    while($rows = $rezultat2 -> fetch_assoc())
                    {
                        $Klient = $rows['Klient'];  
                        $ID_Klienta = $rows['ID_Klienta'];  
                        echo "<option value='$ID_Klienta'>$Klient</option>";
                    }
                    //$polaczenie -> close();
                ?>
            </select>
            <br>
            <br>
            Właściciel projektu: 
            <select name="pracownicy" >
                <?php
                    echo "<option value='0'>Wybierz</option>";
                    while($rows = $rezultat3 -> fetch_assoc())
                    {
                        $imie_nazwisko = $rows['imie_nazwisko'];  
                        $ID_Pracownik = $rows['ID_Pracownik'];
                        echo "<option value='$ID_Pracownik'>$imie_nazwisko</option>";
                    }
                    //$polaczenie -> close();
                ?>
            </select>
            <br>
            <br>
            Data Start: <input type="date" name="Data_start" required/><br />
            <br>
            Data Stop: <input type="date" name="Data_stop" required/><br />     

<!-- Formularz Hashowania hasła: <br/> <input type="password" name="haslo" /><br /> -->
            <?php
            if(isset($_SESSION['e_haslo']))
            {
            echo'<div class="error">'.$_SESSION['e_haslo'].'</div>';
            unset($_SESSION['e_haslo']);
                    }
                    ?>
            <br/>
            
            <label>
                <input type="checkbox" name="akceptacja" /> Dane są poprawne
            </label><br />
            <?php
                if(isset($_SESSION['e_akceptacja']))
                {
                    echo'<div class="error">'.$_SESSION['e_akceptacja'].'</div>';
                    unset($_SESSION['e_akceptacja']);
                }
            ?>
            <br />
            <input type="submit" class="dodaj" value="Dodaj" /><br />
            <br />
            <a href="projekty.php"><input type="button" value="Powrót" />

        </form>   
        
    </body>
</html>
