<?php

session_start();

if(!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>ProjectTracker</title>
    </head>
    <body>
        <?php
        echo "<p>Witaj ".$_SESSION['user'].'![ <a href="logout.php">Wylogowanie!</a>]</p>';
        echo "<p><b>Project</b>:".$_SESSION['Project'];
        echo " | <b>Klient</b>:".$_SESSION['Klient'];
        echo " | <b>Pracownik</b>:".$_SESSION['Pracownik']."</p>";
        
        echo "<p><b>Status</b>:".$_SESSION['Status']."</p>";
        ?>
    </body>
</html>
