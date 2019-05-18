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
        <header>
            <nav class="navbar bg-primary">
                <a class="navbar-brand" href="#"><img src="alien_head.gif" width="30" height="30" alt="">Projekty</a>
            <a class="navbar-brand" href="#">Klient</a>
            </nav>
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
