<?php

//header( 'location: accountInfo.html' );

$sql_server = 'localhost';
$sql_user = 'root';
$sql_pwd = 'password';
$sql_db = 'test';

//connecting to sql database
$connection = new mysqli($sql_server, $sql_user, $sql_pwd, $sql_db);

//start session
session_start();
$savedUser = $_SESSION['username'];

//querying Customer table
$query1 = "SELECT customerID, balance, fName, mName, lName
          FROM Customer
          WHERE customerUsername='$savedUser'";

$result1=mysqli_query($connection, $query1);

$varScope;

//printing out customer info
if(mysqli_num_rows($result1) > 0)
{
  while($row1=mysqli_fetch_assoc($result1))
  {
    echo "First Name: " . $row1["fName"] . "<br>";
    echo "Middle Name: " . $row1["mName"] . "<br>";
    echo "Last Name: " . $row1["lName"] . "<br>" . "<br>";
    echo "Customer ID: " . $row1["customerID"] . "<br>";
    echo "Current Balance($): " . $row1["balance"] . "<br>" . "<br>";
    $varScope = $row1["customerID"];
  }
}


//saving customerID for querying customer billing info
$savedUserID = $varScope;

//querying customer billing info table
$query2 = "SELECT address, cardNumber
           FROM customerBillingInfo
           WHERE customerID='$savedUserID'";

$result2=mysqli_query($connection, $query2);

//printing out customer billing info
if(mysqli_num_rows($result2) > 0)
{
  while($row2=mysqli_fetch_assoc($result2))
  {
    echo "Address: " . $row2["address"] . "<br>";
    echo "Card Number: " . $row2["cardNumber"] . "<br>" . "<br>";
  }
}


//querying customer billing info table
$query3 = "SELECT portfolioID, netWorth
           FROM Portfolio
           WHERE customerID='$savedUserID'";

$result3=mysqli_query($connection, $query3);

//printing out customer billing info
if(mysqli_num_rows($result3) > 0)
{
  while($row3=mysqli_fetch_assoc($result3))
  {
    echo "Portfolio ID: " . $row3["portfolioID"] . "<br>";
    echo "Portfolio Net Worth: " . $row3["netWorth"] . "<br>";
  }
}

?>
