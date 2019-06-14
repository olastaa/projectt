<?php
session_start();

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
$rezultat2 = $polaczenie->query("SELECT * FROM roles"); 
$polaczenie->set_charset("utf8");

if(isset($_POST['user']))
{
    //udana walidacja, tak!
    $wszystko_OK=true;

    //Sprawdzenie User
    $User = $_POST['user'];
    $ImieNazwisko = $_POST['imie_nazwisko'];
    $Email = $_POST['email'];
    $Pass = $_POST['pass'];
    $Pass2 = $_POST['pass2'];
    $Rola_wybrana = $_POST['roles'];
    
    //Sprawdzenie dlugosci nazwy projektu
    if((strlen($User)<3) || (strlen($User)>10))
    {
        $wszystko_OK=false;
        $_SESSION['e_user']="Login użytkownika musi zawierać od 3 do 10 znaków";
    }
    //sprawdzenie czy wszystkie znaki są alfanumeryczne, polskie ogonki

    if(ctype_alnum($User)==false)
    {
        $wszystko_OK=false;
        $_SESSION['e_user']="Login użytkownika nie moze zawierać polskich znaków, może składać się z liter i cyfr.";
    }
    
    //walidacja poprawności maila
    $email = $_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) ||($emailB!=$email))
    {
        $wszystko_OK=false;
        $_SESSION['e_email']="Podaj poprawny adres e-mail!";
    }
        
    if((strlen($Pass)<6) || (strlen($Pass)>20))
    {
        $wszystko_OK=false;
        $_SESSION['e_pass']="Hasło musi posiadać od 6 do 20 znaków";
    }
    
    if($Pass!==$Pass2)
    {
        $wszystko_OK=false;
        $_SESSION['e_pass']="Podane hasła nie są identyczne";
    }

    $haslo_hash = password_hash("$Pass", PASSWORD_DEFAULT);
    /* robocze wyświetlanie Hasha przez php:
    echo $haslo_hash; exit(); 
    */    
    
    try{
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception($polaczenie->connect_errno);
        }
        else
        {
            $rezultat = $polaczenie->query("SELECT * FROM pracownicy WHERE user = '$User' or email = '$Email'");
            if(!rezultat) throw new Exception($polaczenie->error);
            
            $ile_takich_Userow = $rezultat->num_rows; //ilosc zwroconych rekordow
            if($ile_takich_Userow>0)
            {
                $wszystko_OK=false;
                $_SESSION['e_user']="Taki login/email już istnieje!";
            }
            
            if($wszystko_OK==true)
            {
                //umieszenie danych w bazie!!!!!!!!!!!
             if($polaczenie->query("INSERT INTO pracownicy VALUES (NULL, '$User', '$ImieNazwisko', '$Email', '$haslo_hash', '$Rola_wybrana')"))
             {
               $_SESSION['udanaweryfikacja']=true;
               header('Location: pracownicy.php');
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="favicon-16x16.png">
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
    <h1>Dodaj nowego użytkownika</h1>
    <br>
    <form method="post">
        <label for="user">Login użytkownika: </label> 
        <input type="text" name="user" placeholder="Podaj login" required>
        <?php
            if(isset($_SESSION['e_user']))
            {
                echo'<div class="error">'.$_SESSION['e_user'].'</div>';
                unset($_SESSION['e_user']);
            }
                    ?>  
        <br> 
        <label for="imie">Imię i nazwisko: </label> 
        <input type="text" name="imie_nazwisko" placeholder="Podaj imię i nazwisko" required>
        <?php
            if(isset($_SESSION['e_user']))
            {
                echo'<div class="error">'.$_SESSION['e_user'].'</div>';
                unset($_SESSION['e_user']);
            }
                    ?>  
        <br> 
        <label for="email">Adres email: </label> 
        <input type="email" name="email" placeholder="Podaj adres email" required>
        <br> 

        <label for="pass">Hasło: </label> 
        <input type="password" name="pass" placeholder="Podaj hasło" required>
        <br> 

        <label for="pass2">Powtórz hasło: </label> 
        <input type="password" name="pass2" placeholder="Powtórz hasło" required>
        <br> 
        <?php
            if(isset($_SESSION['e_pass']))
            {
                echo'<div class="error">'.$_SESSION['e_pass'].'</div>';
                unset($_SESSION['e_pass']);
            }
                    ?>  

        <label for="roles">Wybierz poziom uprawnień: </label>
        <select name="roles" >
                <?php
                    echo "<option value='0'>Wybierz</option>";
                    while($rows = $rezultat2 -> fetch_assoc())
                    {
                        $rolename = $rows['rolename'];  
                        $ID_Roles = $rows['ID_Roles'];
                        echo "<option value='$ID_Roles'>$rolename</option>";
                    }
                    //$polaczenie -> close();
                ?>
            </select>
            <br>
        <br>
        <input type="submit" class="dodaj" name="nowyuser" value="Dodaj"> 
        <br><br>
        <a href="pracownicy.php"><input type="button" value="Powrót" />
    </form>	  
</body>
</html>