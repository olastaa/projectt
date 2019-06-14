<?php

session_start();

if(!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Project Tracker - Aleksandra i Łukasz</title>
         <!-- Bootstrap CSS -->
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Witaj w aplikacji</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
        <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <link rel="icon" type="image/png" href="favicon-16x16.png">
    </head>
    <body>
        <header>
            <nav class="navbar bg-primary navbar-light" style="background-color: #babec1">
            <a class="navbar-brand" href="projekty.php"><img src="p_logo.png" width="40" height="40" class="d-inline-block mr-1 align-bottom" alt=""> Projekty</a>       
            <a class="navbar-brand" href="klienci.php">Klient</a>
            <a class="navbar-brand" href="pracownicy.php">Pracownicy</a>
            <a class="navbar-brand" href="dodajnowyuser.php">Pracownicy</a>
            <a class="navbar-brand" href="zadania.php">Zadania</a>
            <form class="form-inline">
                <input class="form-control mr-1" type="search" placeholder="Wyszukaj" aria-label="Wyszukaj">
                <button class="btn btn-light" type="submit">Znajdź</button>
            </form>
            
            <a class="navbar-brand" href="logout.php"><button class="btn btn-light" type="submit">Wylogowanie</button></a>
            </nav>
            <br>
             <nav class="navbar2 navbar-expand-lg navbar-light bg-light">
                 <a class="navbar-brand" href="#"><h2><?php
        echo "<p>Witaj ".$_SESSION['user']."!</p>"; ?></h2></a>
</nav>

        </header>
        <div id="pierwszy">
        <br />
<table width="90%" align="left" border="1" bordercolor="#d5d5d5" cellpadding="0" cellspacing="0">     
<tr>
        
        <?php
 
        echo "<p><b>|Projekt</b>: ".$_SESSION['Projekt'];
        echo "<p><b>|Projekt</b>: ".$_SESSION['Projekt'];
        echo " <br /><b>|Klient</b>: ".$_SESSION['Klient'];
        echo " <br /><b>|Pracownik</b>: ".$_SESSION['Pracownik'];
        echo " <br /><b>|Zadanie</b>: ".$_SESSION['Zadanie']."</p>";

              
             
        //nawigacja za pomocą: json
        /*       
        function parseNodes($nodes) {
        $ul = "<ul>\n";
        foreach ($nodes as $node) {
                $ul .= parseNode($node);
        }
        $ul .= "</ul>\n";
        return $ul;
}

function parseNode($node) {
        $li = "\t<li>";
        $li .= '<a href="'.$node->url.'">'.$node->title.'</a>';
        if (isset($node->nodes)) $li .= parseNodes($node->nodes);
        $li .= "</li>\n";
        return $li;
}
$json = '[{
"title":"About",
"url":"/about",
"nodes":[
    {"title":"Staff","url":"/about/staff"},
    {"title":"Location","url":"/about/location"}
]},{
"title":"Contact",
"url":"/contact"
}]';
$nodes = json_decode($json);

$html = parseNodes($nodes);
echo $html;
*/

        ?>
    </tr>
        <br /><br />
        <a href="dodajnowyp.php"><input type="submit" value="Dodaj nowy Projekt!"></a>
        <br /><br />
        
        </tr></table>
        </div>
    </body>
</html>