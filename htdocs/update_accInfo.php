<?php

//setting up mysql details
$sql_server = 'localhost';
$sql_user = 'root';
$sql_pwd = 'password';
$sql_db = 'test';

//connecting to sql database
$connection = new mysqli($sql_server, $sql_user, $sql_pwd, $sql_db);

//start session and grab the cached username
session_start();
$savedUser = $_SESSION['username'];
$savedCustID = $_SESSION['customerID'];

//new vars for updated info
$newFnameData = $_POST['inputFname'];
$newMnameData = $_POST['inputMname'];
$newLnameData = $_POST['inputLname'];
$newAddressData = $_POST['inputAddress'];
$newCardnumberData = $_POST['inputCardNumber'];
$newPasswordData = $_POST['inputPassword'];

//checking to see which info the user updated. If it's equal to "",
//then they didn't update it
//FIRST NAME
if($newFnameData != "")
{
  $fnameUpdate = "UPDATE Customer
                  SET fName='$newFnameData'
                  WHERE customerID='$savedCustID'";
  mysqli_query($connection, $fnameUpdate);
}


//MIDDLE NAME
if($newMnameData != "")
{
  $mnameUpdate = "UPDATE Customer
                  SET mName='$newMnameData'
                  WHERE customerID='$savedCustID'";
  mysqli_query($connection, $mnameUpdate);
}

//LAST NAME
if($newLnameData != "")
{
  $lnameUpdate = "UPDATE Customer
                  SET lName='$newLnameData'
                  WHERE customerID='$savedCustID'";
  mysqli_query($connection, $lnameUpdate);
}


//ADDRESS
if($newAddressData != "")
{
  $addressUpdate = "UPDATE customerBillingInfo
                  SET address='$newAddressData'
                  WHERE customerID='$savedCustID'";
  mysqli_query($connection, $addressUpdate);
}


//Cardnumber
if($newCardnumberData != "")
{
  $cardnumberUpdate = "UPDATE customerBillingInfo
                  SET cardNumber='$newCardnumberData'
                  WHERE customerID='$savedCustID'";
  mysqli_query($connection, $cardnumberUpdate);
}


//PASSWORD
if($newPasswordData != "")
{
  $passwordUpdate = "UPDATE Customer
                  SET customerPassword='$newPasswordData'
                  WHERE customerID='$savedCustID'";
  mysqli_query($connection, $passwordUpdate);
}

header('location: index.html');


?>
