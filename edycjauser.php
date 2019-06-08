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
    $rezultat = $polaczenie->query("SELECT * FROM pracownicy WHERE ID_Pracownik = $edit_id");
    $row = $rezultat->fetch_array();
}

if(isset($_POST['update']))
{
    //udana walidacja, tak!
    $wszystko_OK=true;

    $user = $_POST['user'];
    $imie_nazwisko = $_POST['imie_nazwisko'];
    $email = $_POST['email'];
    $rola_wybrana = $_POST['roles'];

    // Sprawdzenie dlugosci usera
    if((strlen($user)<3) || (strlen($user)>10))
    {
        $wszystko_OK=false;
        $_SESSION['e_user']="Nazwa użytkownika musi posiadać od 3 do 10 znaków";
    }
    
    if ($polaczenie -> connect_error) {
        die("Nieudane połączenie: " . $conn->connect_error);
    } else {
        $rezultat = $polaczenie->query("UPDATE pracownicy SET user = '$user', imie_nazwisko = '$imie_nazwisko', email = '$email', ID_Roles = '$rola_wybrana' WHERE ID_Pracownik =" .$_GET['edit_id']);
        echo "<meta http-equiv='refresh' content=0;url='pracownicy.php'>";
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
        <h1>Edycja danych pracownika</h1>
        <br>

        <form method="post">       
            Login użytkownika: <input type="text" name="user" value="<?php echo $row['user']; ?>" > <br>
            Imię i nazwisko: <input type="text" name="imie_nazwisko" value="<?php echo $row['imie_nazwisko']; ?>" > <br>
            Adres email: <input type="email" name="email" value="<?php echo $row['email']; ?>" > <br>
            Poziom uprawnień: 
            <select name="roles" >
                <?php
                    $rezultat2 = $polaczenie->query("SELECT * FROM roles"); 
                    echo "<option value='0'>Wybierz</option>";
                    while($rows = $rezultat2 -> fetch_assoc())
                    {
                        $rola = $rows['rolename'];  
                        $ID_Roles = $rows['ID_Roles'];  
                        echo "<option value='$ID_Roles'>$rola</option>";
                    }
                    //$polaczenie -> close();
                ?>
            </select><br>
            <input type="submit" name="update" class="dodaj" value="Aktualizuj" />    
            <br>
            <a href="javascript:history.go(-1)"><input type="button" value="Powrót" />       
        </form>
    </body>
</html>