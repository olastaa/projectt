<?php
session_start();

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
//$rezultat2 = $polaczenie->query("SELECT * FROM projekty "); 
$rezultat3 = $polaczenie->query("SELECT * FROM zadania"); 
$rezultat4 = $polaczenie->query("SELECT * FROM pracownicy"); 
$polaczenie->set_charset("utf8");

if(isset($_GET['edit_id']))
{
    $edit_id = $_GET['edit_id'];
    $rezultat = $polaczenie->query("SELECT * FROM projekty WHERE ID_Projektu = $edit_id");
    
}

if(isset($_POST['nowyuser']))
{
    //udana walidacja, tak!
    $wszystko_OK=true;

    //Sprawdzenie User
    $Projekt_id = $edit_id;
    $Zadanie_wybrane = $_POST['opis'];
    $Pracownik_wybrany = $_POST['imie_nazwisko'];
    $Estymowany_czas = $_POST['Estymowany_czas'];
    $Realizowany_czas = $_POST['Realizowany_czas'];
   // echo $Estymowany_czas;

    if($Estymowany_czas<0) 
    {
        $wszystko_OK=false;
        $_SESSION['e_nowyuser']="Podaj estymowany czas realizacji większy niż 0";
    }
    
    try{
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception($polaczenie->connect_errno);
        }
        else
        {            
            if($wszystko_OK==true)
            {
                //umieszenie danych w bazie!!!!!!!!!!!
             if($polaczenie->query("INSERT INTO tracker VALUES (NULL, '$Projekt_id', '$Zadanie_wybrane', '$Pracownik_wybrany', $Estymowany_czas, $Realizowany_czas)"))
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

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" /> 
    <title>Project Tracker | Dodawanie nowego użytkownika</title>
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
      <a class="navbar-brand" href="klienci.php">Projekty</a>                   
      <a class="navbar-brand" href="klienci.php">Klienci</a>
        <a class="navbar-brand" href="pracownicy.php">Pracownicy</a>
      <a class="navbar-brand" href="zadania.php">Zadania</a>            
      <a class="navbar-brand" href="logout.php"><input type="button" value="Wyloguj"></a>
    </nav>           
    <main class="container-fluid" {% block body %}{% endblock %}>
</header>
    <h1>Dodaj nowe zadanie</h1>
    <br>
    <form method="post">
        <label for="projekt">Projekt: </label> 
        <?php
            $rows = $rezultat -> fetch_array();
            $Projekt = $rows['Projekt'];  
            echo $Projekt;
        ?>  
        <br> 

        <label for="zadanie">Zadanie: </label>
        <select name="opis">
                <?php
                    echo "<option value='0'>Wybierz</option>";
                    while($rows = $rezultat3 -> fetch_assoc())
                    {
                        $opis = $rows['opis'];  
                        $ID_Zadanie = $rows['ID_Zadanie'];
                        echo "<option value='$ID_Zadanie'>$opis</option>";
                    }
                ?>
            </select>
            <br>

        <label for="user">Realizowane przez: </label>
        <select name="imie_nazwisko" >
                <?php
                    echo "<option value='0'>Wybierz</option>";
                    while($rows = $rezultat4 -> fetch_assoc())
                    {
                        $imie_nazwisko = $rows['imie_nazwisko'];  
                        $ID_Pracownik = $rows['ID_Pracownik'];
                        echo "<option value='$ID_Pracownik'>$imie_nazwisko</option>";
                    }
                ?>
            </select>
            <br>

        <label for="estymowanyCzas">Estymowany czas realizacji zadania: </label> 
        <input type="number" name="Estymowany_czas" placeholder="Podaj planowany czas realizacji" required>
        <br> 
        <?php
            if(isset($_SESSION['e_nowyuser']))
            {
                echo'<div class="error">'.$_SESSION['e_nowyuser'].'</div>';
                unset($_SESSION['e_nowyuser']);
            }
        ?>  

        <label for="realizowanyCzas">Faktyczny czas realizacji zadania: </label> 
        <input type="number" name="Realizowany_czas" value="0">
        <br> 
        <br>
        <input type="submit" name="nowyuser" class="dodaj" value="Dodaj"> 
        <br><br>
        <a href="projekt.php?edit_id=<?php echo $edit_id;?>"><input type="button" value="Powrót" />
    </form>	  
</body>
</html>