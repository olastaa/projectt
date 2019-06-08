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
    $rezultat = $polaczenie->query("SELECT * FROM projekty WHERE ID_Projektu = $edit_id");
    $row = $rezultat->fetch_array();
}

if(isset($_POST['update']))
{
    //udana walidacja, tak!
    $wszystko_OK=true;

    $projekt = $_POST['Projekt'];
    $ID_Klienta_wybrany = $_POST['klienci'];
    $ID_Pracownik_wybrany = $_POST['pracownicy'];
    $data_start = $_POST['Data_start'];
    $data_stop = $_POST['Data_stop'];

    // Sprawdzenie dlugosci tekstu
    if((strlen($projekt)<3) || (strlen($projekt)>50))
    {
        $wszystko_OK=false;
        $_SESSION['e_Projekt']="Nazwa projektu musi zawierać od 3 do 50 znaków";
        echo $projekt;
    }
    
    if ($polaczenie -> connect_error) {
        die("Nieudane połączenie: " . $conn->connect_error);
    } else {
        $rezultat = $polaczenie->query("UPDATE projekty SET Projekt = '$projekt', ID_Klienta = '$ID_Klienta_wybrany', imie_nazwisko = '$ID_Pracownik_wybrany', Data_start = '$data_start', Data_stop = '$data_stop' WHERE ID_Projektu =" .$_GET['edit_id']);
        //echo "<meta http-equiv='refresh' content=0;url='projekt.php?edit_id=$edit_id'>";
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
        <a class="navbar-brand" href="strona1.php"><img src="p_logo.png" width="40" height="40" alt=""></a>
          <a class="navbar-brand" href="projekty.php">Projekty</a>
          <a class="navbar-brand" href="klienci.php">Klienci</a>
          <a class="navbar-brand" href="pracownicy.php">Pracownicy</a>
          <a class="navbar-brand" href="zadania.php">Zadania</a>            
          <a class="navbar-brand" href="logout.php"><input type="button" value="Wyloguj"></a>
        </nav>           
        <main class="container-fluid" {% block body %}{% endblock %}>
      </header>
        <h1>Edycja danych projektu</h1>
        <br>

        <form method="post"> 
            <?php
                $result = $polaczenie->query("SELECT * FROM projekty INNER JOIN klienci ON projekty.ID_Klienta = klienci.ID_Klienta 
                INNER JOIN pracownicy ON projekty.ID_Pracownik = pracownicy.ID_Pracownik
                WHERE ID_Projektu = $edit_id"); 
                if ($result -> num_rows > 0){
                $row = $result->fetch_assoc();
                }  
            ?>    
            Nazwa projektu: <input type="text" name="projekt" value="<?php echo $row['Projekt']; ?>"> <br>
            <?php
            if(isset($_SESSION['e_Projekt']))
            {
                echo'<div class="error">'.$_SESSION['e_Projekt'].'</div>';
                unset($_SESSION['e_Projekt']);
            }
            ?>  

            Klient: 
                <select name="klienci" >
                    <?php
                        $rezultat2 = $polaczenie->query("SELECT * FROM klienci ORDER BY Klient ASC"); 
                        echo "<option value='0'>Wybierz</option>";
                        while($rows = $rezultat2 -> fetch_assoc())
                        {
                            $Klient = $rows['Klient'];  
                            $ID_Klienta = $rows['ID_Klienta']; 
                            echo "<option value='$ID_Klienta'>$Klient</option>";
                        }
                ?>
                </select>
            <br> 

            Project manager: 
            <select name="pracownicy" >
                <?php
                    $rezultat3 = $polaczenie->query("SELECT * FROM pracownicy ORDER BY imie_nazwisko ASC");  
                    echo "<option value='0'>Wybierz</option>";
                    while($rows = $rezultat3 -> fetch_assoc())
                    {
                        $imie_nazwisko = $rows['imie_nazwisko'];  
                        $ID_Pracownik = $rows['ID_Pracownik'];
                        echo "<option value='$ID_Pracownik'>$imie_nazwisko</option>";
                    }
                ?>
            </select>
            <br>

            Start projektu: <input type="date" name="data_start" value="<?php echo $row['Data_start']; ?>" required> <br>
            Prognozowane zakończenie projektu: <input type="date" name="data_stop" value="<?php echo $row['Data_stop']; ?>" required> <br>

            <input type="submit" name="update" class="dodaj" value="Aktualizuj" />    
            <br><br>
            <a href="projekty.php"><input type="button" value="Powrót" />     
        </form>
    </body>
</html>