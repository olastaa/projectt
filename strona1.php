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
    <link rel="icon" type="image/png" href="favicon-16x16.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Project Tracker - Aleksandra i Łukasz</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Ubuntu&display=swap" rel="stylesheet">
    <title>Witaj w aplikacji</title>
    <link rel="icon" type="image/png" href="favicon-16x16.png">
  </head>
  
  <body>
      <header>
        <nav class="navbar navbar-light" style="background-color: #babec1;>
          <a class="navbar-brand" href="strona1.php"><img src="p_logo.png" width="40" height="40" alt="projecttracker logo"></a>
          <a class="navbar-brand" href="projekty.php">Projekty</a>
          <a class="navbar-brand" href="klienci.php">Klienci</a>
          <a class="navbar-brand" href="pracownicy.php">Pracownicy</a>
          <a class="navbar-brand" href="zadania.php">Zadania</a>            
          <a class="navbar-brand" href="logout.php"><input type="button" value="Wyloguj"></a>
        </nav>           
        <main class="container-fluid" {% block body %}{% endblock %}>
      </header>
      
      <?php
        echo "<h1>Witaj ".$_SESSION['user']."!</h1>";
       //echo "<p><b>Twoje projekty</b>: <br>
        //".$_SESSION['ID_Klienta'];
      ?>
    </body>
</html>
