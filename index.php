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
        <title>ProjectTracker</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" type="image/png" href="favicon-16x16.png">
        <link href="https://fonts.googleapis.com/css?family=Roboto|Ubuntu&display=swap" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    </head>
    <body onload="start();">
        <div id="frm">
            <img src="p_logo.png" alt="projecttracker logo" width="110" height="110">
            <h3>Zaloguj się do<br />Project Tracker!</h3> <br />
        
            <form action="zaloguj.php" method="post"> 
                Login: <input type="text" name="login" /><br /><br />
                Hasło: <input type="password" name="haslo" /><br /><br />
                <input type="submit" class="dodaj" value="Zaloguj" />
            </form>
        </div>
        <?php
        if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
        ?>
    </body>
</html>