<?php

session_start();

if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
{
    header('Location: strona1.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang ="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Project Tracker</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    </head>
    <body>
        <h2>Witamy w aplikacji<b>Project Tracker</b></h2> <br />
        
        <form action="zaloguj.php" method="post"> 
            LOGIN: <br /> <input type="text" name="login" /> <br />
            HASŁO: <br /> <input type="password" name="haslo" /> <br />
            <input type="submit" value="Logowanie" />
        </form>
        
        <?php
        if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
        ?>
    </body>
</html>
