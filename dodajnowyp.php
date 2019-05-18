<?php

session_start();

if(isset($_POST['email']))
{
    //udana walidajca, tak!
    $wszystko_OK=true;
    //Sprawdzenie User
    $user = $_POST['user'];

    //Sprawdzenie dlugosci usera
    if((strlen($user)<3) || (strlen($user)>20))
    {
        $wszystko_OK=false;
        $_SESSION['e_user']="User musi posiadać od 3 do 20 znaków";
    }
        if($wszystko_OK==true)
        {
            //udana walidacja
            echo "Udana walidacja!"; exit();
        }
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
            User: <br/> <input type="text" name="user" /><br />
            <?php
            if(isset($_SESSION['e_user']))
            {
            echo'<div class="error">'.$_SESSION['e_user'].'</div>';
            unset($_SESSION['e_user']);
                    }
                    ?>
            Email: <br/> <input type="text" name="email" /><br />
            Nazwa Projektu: <br/> <input type="text" name="Projekt" /><br />
           Zadanie: <br/> <input type="text" name="Zadanie" /><br />
            Czas realizacji: <br/> <input type="text" name="Czas realizacji" /><br />
            Twoje Haslo: <br/> <input type="password" name="haslo1" /><br />
            <br/>
            <label>
                <input type="checkbox" name="akceptacja" /> Dane są porawne
            </label><br />
            <br />
            <input type="submit" value="DODAJ" /><br />
            <br />
            
        </form>
        <a href="strona1.php"</a><input type="submit" value="POWRÓT" />
    </body>
</html>
