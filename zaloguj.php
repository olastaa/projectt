<?php

session_start();

if((!isset($_POST['login'])) ||(!isset($_POST['haslo'])))
{
    header('Location: index.php');
    exit();
}

require_once "connect.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno!=0)
{
 echo "Error: ".$polaczenie->connect_errno . " Opis: ". $polaczenie->conect_error;
}
 else {
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];
  
    /* sprawdzenie czy dziala mozna sobie wpisac:
     * echo "It works";
     */
    
    /* zabezpieczenie przed wtryskiwaniem obcego mysql: */
    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
    $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
    
    if($rezultat = @$polaczenie->query(
            sprintf("SELECT * FROM pracownicy WHERE user='%s' AND pass='%s'",
    mysqli_real_escape_string($polaczenie,$login),
    mysqli_real_escape_string($polaczenie,$haslo))))
    {
      $ilu_userow = $rezultat->num_rows;
      if($ilu_userow>0)
      {
          $_SESSION['zalogowany'] = true;
          
          $wiersz = $rezultat->fetch_assoc();
          $_SESSION['id'] = $wiersz['id'];
          $_SESSION['user'] = $wiersz['user'];
          $_SESSION['Project'] = $wiersz['Project'];
          $_SESSION['Klient'] = $wiersz['Klient'];
          $_SESSION['Pracownik'] = $wiersz['Pracownik'];
          $_SESSION['Status'] = $wiersz['Status'];
          
          unset($_SESSION['blad']);
          $rezultat->free_result();
          
          /*przekierowanie do innego dokumnetu po logowaniu*/
          header('Location: strona1.php');
          
      } else {
          $_SESSION['blad'] = '<span style="color:red">Nieprawidlowy login lub hasło!</span>';
          header('Location: index.php');
    }
    $polaczenie->close();
}
 }
/* 
sprawdzenie, czy skrypt poprawnie czyta dane:
echo $login."<br />";
echo $haslo; 
*/
?>