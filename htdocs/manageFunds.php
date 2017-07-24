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
$savedUser = $_SESSION['username'];


//query for current balance to make sure no overdraw/underdraw
$sql = "SELECT balance
        FROM Customer
        WHERE customerUsername='$savedUser'";
$result=mysqli_query($connection, $sql);

$currentBalance;

//loop to get value of current balance
if(mysqli_num_rows($result) > 0)
{
  while($row1=mysqli_fetch_assoc($result))
  {
    $currentBalance = $row1["balance"];
  }
}

//user input variables
$addFundData = $_POST['inputAdd'];
$removeFundData = $_POST['inputRemove'];


//check that resulting balance doesn't exceed max
if($addFundData > 0 && ($currentBalance + $addFundData)<9999999999.99)
{
  $addBalance = "UPDATE Customer
                  SET balance = $currentBalance + $addFundData
                  WHERE customerUsername='$savedUser'";
  mysqli_query($connection, $addBalance);

  //adjust local vars
  $currentBalance += $addFundData;
}


//check that resulting balance doesn't drop below 0.00
if($removeFundData > 0 && ($currentBalance - $removeFundData) > 0)
{
  $removeBalance = "UPDATE Customer
                  SET balance = $currentBalance - $removeFundData
                  WHERE customerUsername='$savedUser'";
  mysqli_query($connection, $removeBalance);

  //adjust local vars
  $currentBalance -= $addFundData;
}

header('location: index.html');

?>
