<?php

session_start();

if(isset($_POST['Projekt']))
{
    //udana walidajca, tak!
    $wszystko_OK=true;
    //Sprawdzenie User
    $Projekt = $_POST['Projekt'];

    //Sprawdzenie dlugosci usera
    if((strlen($Projekt)<3) || (strlen($Projekt)>20))
    {
        $wszystko_OK=false;
        $_SESSION['e_Projekt']="Projekt musi posiadać od 3 do 20 znaków";
    }
    
    if(ctype_alnum($Projekt)==false)
    {
        $wszystko_OK=false;
        $_SESSION['Projekt']="Projekt może skłdać się z liter i cyfr (bez polskich znaków)";
    }
    $haslo_hash = password_hash("admin1", PASSWORD_DEFAULT);
    /* robocze wyświtlanie Hasha przez php:
    echo $haslo_hash; exit(); 
    */
    
    // chekbox - czy dane sa poprawne: //
    if(!isset($_POST['akceptacja']))
        {
        $wszystko_OK=false;
        $_SESSION['e_akceptacja']="Zaznacz pole 'Dane są poprawne'";
    }
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    
    try{
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            $rezultat = $polaczenie->query("SELECT ID FROM projekty WHERE Projekt='$Projekt'");
            if(!rezultat) throw new Exception($polaczenie->error);
            
            $ile_takich_Projektow = $rezultat->num_rows;
            if($ile_takich_Projektow>0)
            {
                $wszystko_OK=false;
                $_SESSION['e_Projekt']="Nazwa projektu już istnieje!";
            }
            
            $polaczenie->close();
        }
        
    } catch (Exception $ex) {
echo '<span style="color:red;">Bląd Serwera - juhu</span>';
echo '<br />Informacja developerska: '.$ex;
    }
    
    
       /* if($wszystko_OK==true)
        {
            //udana walidacja
            echo "Udana walidacja!"; exit();
        } */
        }
    
?>

<!DOCTYPE html>
<html lang ="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Dodawanie nowego Projektu </title>
        <style>
            .error
            {
                color:red;
                margin-top: 10px;
                marginbottom: 10px;
            }
            </style>        
    </head>
    <body>
        <form method="post">
            Nazwa nowego projektu: <br/> <input type="text" name="Projekt" /><br />
            <?php
            if(isset($_SESSION['e_Projekt']))
            {
            echo'<div class="error">'.$_SESSION['e_Projekt'].'</div>';
            unset($_SESSION['e_Projekt']);
                    }
                    ?>
            Projekt dla klienta: <br/> <input type="text" name="ID_Klienta" /><br />
            Właściciel projektu: <br/> <input type="text" name="ID_Pracownika" /><br />
            Data Start: <br/> <input type="datetime-local" name="Data_start" /><br />
            Data Stop: <br/> <input type="datetime" name="Data_stop" /><br />     
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
                <input type="checkbox" name="akceptacja" /> Dane są porawne
            </label><br />
            <?php
            if(isset($_SESSION['e_akceptacja']))
            {
            echo'<div class="error">'.$_SESSION['e_akceptacja'].'</div>';
            unset($_SESSION['e_akceptacja']);
                    }
                    ?>
            <br />
            <input type="submit" value="DODAJ" /><br />
            <br />
            
        </form>
        <a href="strona1.php"</a><input type="submit" value="POWRÓT" />
    </body>
</html>
