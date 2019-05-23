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
        <title>Project Tracker - Aleksandra i Łukasz</title>
         <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <title>Witaj w aplikacji</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    </head>
    <body>
        <header>
            <nav class="navbar bg-primary navbar-light">
                <a class="navbar-brand" href="#"><img src="alien_head.gif" width="30" height="30" alt="">Projekty</a>
            <a class="navbar-brand" href="#">Klient</a>
            <a class="navbar-brand" href="#">Pracownicy</a>
            <a class="navbar-brand" href="#">Zadania</a>
            <a class="navbar-brand" href="logout.php"><input type="button" value="Wylogowanie"</a>
            </nav>
             <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Projekty</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Klienci <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pracownicy</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Zadania</a>
      </li>
    </ul>
  </div>
</nav>
      <main class="container-fluid" {% block body %}{% endblock %}>
        </header>
        <h2>Projekty w bazie</h2>
        <br />

        <?php
        echo "<table>";
        echo "<p>Witaj ".$_SESSION['user']."!</p>";
        echo "<p><b>Projekt</b>: ".$_SESSION['Projekt'];
        echo " | <b>Klient</b>: ".$_SESSION['Klient'];
        echo " | <b>Pracownik</b>: ".$_SESSION['Pracownik']."</p>";
        echo "</table>";
        
?>
        <br /><br />
        <a href="dodajnowyp.php"><input type="submit" value="Dodaj nowy Projekt!"></a>
        <br /><br />
    </body>
</html>
