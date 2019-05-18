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
         <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    {% block stylesheets %}{% endblock %}
    <title>{% block title %}Witaj na Uczelni!{% endblock %}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    </head>
    <body>
        <header>
            <nav class="navbar bg-primary">
                <a class="navbar-brand" href="#"><img src="alien_head.gif" width="30" height="30" alt="">Projekty</a>
            <a class="navbar-brand" href="#">Klient</a>
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
    </ul>
  </div>
</nav>
      <main class="container-fluid">
  {% block body %}{% endblock %}
        </header>
        <table>
                    <tr><th>ID</th>
                    <th>Klient</th>
                    <th>Opis</th>
                    </tr>
        <?php
        echo "<p>Witaj ".$_SESSION['user'].'! <a href="logout.php"><input type="submit" value="Wylogowanie!"</a></p>';       
        echo "<p><b>Projekt</b>:".$_SESSION['Projekt'];
        echo " | <b>Klient</b>:".$_SESSION['Klient'];
        echo " | <b>Pracownik</b>:".$_SESSION['Pracownik']."</p>";
        
        echo "<p><b>Status</b>:".$_SESSION['Status']."</p>";  

        $conn = mysqli_connect("localhost", "root", "");  
        $sql = "SELECT ID, user, email from ID_Pracownicy";
        $result = $conn-> query($sql);
        
        if ($result-> num_rows > 0) {
        while ($row = $result-> fetch_assoc()) {
        echo "<tr><td>". $row["ID"] . "</td><td>". $row["user"] ."</td><td>". $row["email"] ."</td></tr>";
    }
        echo "</table>";
}
else {
echo "0 result";
}
$conn-> close();
?>
</table>
        <br /><br />
        <a href="dodajnowyp.php"><input type="submit" value="Dodaj nowy Projekt!"></a>
    </body>
</html>
