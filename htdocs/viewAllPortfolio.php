<?php

//setting up mysql details
$sql_server = 'localhost';
$sql_user = 'root';
$sql_pwd = 'password';
$sql_db = 'test';

//connecting to sql database
$connection = new mysqli($sql_server, $sql_user, $sql_pwd, $sql_db);

//begin session to recall username in other .php files
session_start();
$savedID = $_SESSION['customerID'];

$list = "SELECT *
         FROM portfolioContents
         WHERE customerID = '$savedID'";

$listResult = mysqli_query($connection, $list);
if(mysqli_num_rows($listResult) > 0)
{
  while($row1=mysqli_fetch_assoc($listResult))
  {
    echo "Ticker: " . $row1["tickerSymbol"] . "<br>";
    echo "Amount: " . $row1["amount"] . "<br>";
    echo("<br>");
    echo("<br>");
  }
}

?>
