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

//user input variables
$searchInput = $_POST['inputSearch'];

$csearch = "SELECT *
           FROM commonStock
           WHERE tickerSymbol = '$searchInput'";
$csearchResult = mysqli_query($connection, $csearch);
if(mysqli_num_rows($csearchResult) > 0)
{
  while($row1=mysqli_fetch_assoc($csearchResult))
  {
    echo $row1["companyName"] . "<br>";
    echo "Ticker: " . $row1["tickerSymbol"] . "<br>";
    echo "Current Share Price: " . $row1["sharePrice"] . "<br>";
    echo "Current Available Shares: " . $row1["sharesAvailable"] . "<br>";
    echo "Total Shares: " . $row1["totalShares"] . "<br>";
    echo "Vote %: " . $row1["votePercentage"] . "<br>";
  }
}



$psearch = "SELECT *
           FROM preferredStock
           WHERE tickerSymbol = '$searchInput'";
$psearchResult = mysqli_query($connection, $psearch);
if(mysqli_num_rows($psearchResult) > 0)
{
  while($row11=mysqli_fetch_assoc($psearchResult))
  {
    echo $row11["companyName"] . "<br>";
    echo "Ticker: " . $row11["tickerSymbol"] . "<br>";
    echo "Current Share Price: " . $row11["sharePrice"] . "<br>";
    echo "Current Available Shares: " . $row11["sharesAvailable"] . "<br>";
    echo "Total Shares: " . $row11["totalShares"] . "<br>";
  }
}


?>
