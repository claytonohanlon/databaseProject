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
$savedUserID = $_SESSION['customerID'];
$typeofStock;


//input variables
$inputSellAmt = $_POST['inputSellAmt'];
$inputSellTick = $_POST['inputSellTick'];


//check to see if you have the stock in your portfolio
$currentOwnStock = "SELECT amount
                    FROM portfolioContents
                    WHERE customerID = '$savedUserID' AND
                          tickerSymbol = '$inputSellTick'";
$resultFind = mysqli_query($connection, $currentOwnStock);
$amtOfStockOwned;
if(mysqli_num_rows($resultFind) > 0)
{
  while($row50=mysqli_fetch_assoc($resultFind))
  {
    $amtOfStockOwned = $row50["amount"];
  }
}



//queries for price per stock and what kind of stock it is
$csp = "SELECT sharePrice
         FROM commonStock
         WHERE tickerSymbol='$inputSellTick'";
$cspResult=mysqli_query($connection, $csp);
$pricePerStock;
if(mysqli_num_rows($cspResult) > 0)
{
  while($cspRow=mysqli_fetch_assoc($cspResult))
  {
    $pricePerStock = $cspRow["sharePrice"];
  }
  $typeofStock = 'C';
}


$psp = "SELECT sharePrice
         FROM preferredStock
         WHERE tickerSymbol='$inputSellTick'";
$pspResult=mysqli_query($connection, $psp);

if(mysqli_num_rows($pspResult) > 0)
{
  while($pspRow=mysqli_fetch_assoc($pspResult))
  {
    $pricePerStock = $pspRow["sharePrice"];
  }
  $typeofStock = 'P';
}


//query to get current balance
$sql = "SELECT balance
        FROM Customer
        WHERE customerID='$savedUserID'";
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


//query for net worth
$currentNetWorth = "SELECT netWorth
                    FROM portfolio
                    WHERE customerID = '$savedUserID'";
$CNWresult = mysqli_query($connection, $currentNetWorth);
$currentNW;
if(mysqli_num_rows($CNWresult) > 0)
{
  while($row33=mysqli_fetch_assoc($CNWresult))
  {
    $currentNW = $row33["netWorth"];
  }
}


//query to get amount of stock available for common and preferredStock
$camt = "SELECT sharesAvailable
         FROM commonStock
         WHERE tickerSymbol='$inputSellTick'";
$camtResult=mysqli_query($connection, $camt);

$amtAvailable;

if(mysqli_num_rows($camtResult) > 0)
{
  while($camtRow=mysqli_fetch_assoc($camtResult))
  {
    $amtAvailable = $camtRow["sharesAvailable"];
  }
}

$pamt = "SELECT sharesAvailable
         FROM preferredStock
         WHERE tickerSymbol='$inputSellTick'";
$pamtResult=mysqli_query($connection, $pamt);

if(mysqli_num_rows($pamtResult) > 0)
{
  while($pamtRow=mysqli_fetch_assoc($pamtResult))
  {
    $amtAvailable = $pamtRow["sharesAvailable"];
  }
}



//check to see that you aren't selling more then you have
if($amtOfStockOwned >= $inputSellAmt)
{
  //if you still have some stock remaining...
  if($amtOfStockOwned != $inputSellAmt)
  {
    $updatePortfolio = "UPDATE portfolioContents
                        SET amount = $amtOfStockOwned - $inputSellAmt
                        WHERE tickerSymbol = '$inputSellTick'";
    mysqli_query($connection, $updatePortfolio);
  }
  //if not, remove from portfolio
  else
  {
    $removeStock = "DELETE FROM portfolioContents
                    WHERE tickerSymbol = '$inputSellTick'";
    mysqli_query($connection, $removeStock);
  }


//adjust balance
  $increaseBalance = "UPDATE Customer
                  SET balance = $currentBalance + ($inputSellAmt * $pricePerStock)
                  WHERE customerID='$savedUserID'";
  mysqli_query($connection, $increaseBalance);


  //adjust net Worth
  $modNW = "UPDATE portfolio
            SET netWorth = $currentNW - ($inputSellAmt * $pricePerStock)
            WHERE customerID = '$savedUserID'";
  mysqli_query($connection, $modNW);


  //add shares back to market
  if($typeofStock === 'C')
  {
    $comAmt = "UPDATE commonStock
               SET sharesAvailable = $amtAvailable + $inputSellAmt
               WHERE tickerSymbol='$inputSellTick'";
    mysqli_query($connection, $comAmt);
  }
  else
  {
    $prefAmt = "UPDATE preferredStock
               SET sharesAvailable = $amtAvailable + $inputSellAmt
               WHERE tickerSymbol='$inputSellTick'";
    mysqli_query($connection, $prefAmt);
  }
}

header('location: index.html');


?>
