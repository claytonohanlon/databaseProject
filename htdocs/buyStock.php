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
$savedUser = $_SESSION['customerID'];

//input vars for requested ticker symbol and amount
$purchaseTick = $_POST['inputPurchaseTick'];
$purchaseAmt = $_POST['inputPurchaseAmt'];
$typeofStock;
$currentNW;

//query to get portfolioID
$queryPort = "SELECT portfolioID
           FROM Portfolio
           WHERE customerID='$savedUser'";

$result3=mysqli_query($connection, $queryPort);
$userPortfolioID;
if(mysqli_num_rows($result3) > 0)
{
  while($row3=mysqli_fetch_assoc($result3))
  {
    $userPortfolioID = $row3["portfolioID"];
  }
}

//query to get current balance
$sql = "SELECT balance
        FROM Customer
        WHERE customerID='$savedUser'";
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


//query to get share price for common and preferred stock
$csp = "SELECT sharePrice
         FROM commonStock
         WHERE tickerSymbol='$purchaseTick'";
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
         WHERE tickerSymbol='$purchaseTick'";
$pspResult=mysqli_query($connection, $psp);

if(mysqli_num_rows($pspResult) > 0)
{
  while($pspRow=mysqli_fetch_assoc($pspResult))
  {
    $pricePerStock = $pspRow["sharePrice"];
  }
  $typeofStock = 'P';
}


//query to get amount of stock available for common and preferredStock
$camt = "SELECT sharesAvailable
         FROM commonStock
         WHERE tickerSymbol='$purchaseTick'";
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
         WHERE tickerSymbol='$purchaseTick'";
$pamtResult=mysqli_query($connection, $pamt);

if(mysqli_num_rows($pamtResult) > 0)
{
  while($pamtRow=mysqli_fetch_assoc($pamtResult))
  {
    $amtAvailable = $pamtRow["sharesAvailable"];
  }
}



//checking that you have enough money and that there are enough stock available
if(($currentBalance >= ($purchaseAmt * $pricePerStock)) && ($purchaseAmt < $amtAvailable))
{

  //adjusting user balance
  $removeBalance = "UPDATE Customer
                  SET balance = $currentBalance - ($purchaseAmt * $pricePerStock)
                  WHERE customerID='$savedUser'";
  mysqli_query($connection, $removeBalance);
  $currentBalance -= ($purchaseAmt * $pricePerStock);
  //adjust amount of stock available
  if($typeofStock === 'C')
  {
    $comAmt = "UPDATE commonStock
               SET sharesAvailable = $amtAvailable - $purchaseAmt
               WHERE tickerSymbol='$purchaseTick'";
    mysqli_query($connection, $comAmt);
  }
  else
  {
    $prefAmt = "UPDATE preferredStock
               SET sharesAvailable = $amtAvailable - $purchaseAmt
               WHERE tickerSymbol='$purchaseTick'";
    mysqli_query($connection, $prefAmt);
  }

  //add purchased stock to your portfolioContents
  $currentOwnStock = "SELECT tickerSymbol
                      FROM portfolioContents
                      WHERE customerID = '$savedUser' AND
                            tickerSymbol = '$purchaseTick'";
  $resultFind = mysqli_query($connection, $currentOwnStock);




  $amtOfStockYouHave = "SELECT amount
                        FROM portfolioContents
                        WHERE portfolioID = '$userPortfolioID' and
                               tickerSymbol = '$purchaseTick'";
  $resultAmtYouHave = mysqli_query($connection, $amtOfStockYouHave);
  $amtYouHave;
  if(mysqli_num_rows($resultAmtYouHave) > 0)
  {
    while($row69=mysqli_fetch_assoc($resultAmtYouHave))
    {
      $amtYouHave = $row69["amount"];
    }
  }


  //stock already exists in portfolio
  if(mysqli_num_rows($resultFind) > 0)
  {
    $updatePortfolio = "UPDATE portfolioContents
                        SET amount = $amtYouHave + $purchaseAmt
                        WHERE tickerSymbol = '$purchaseTick'";
    mysqli_query($connection, $updatePortfolio);
  }

  //stock doesn't exist in portfolio
  else
  {
    $addNewStock = "INSERT INTO portfolioContents (customerID, portfolioID, tickerSymbol, amount)
                    VALUES ('$savedUser','$userPortfolioID','$purchaseTick','$purchaseAmt')";
    mysqli_query($connection, $addNewStock);
  }

  //adjust net Worth
  $currentNetWorth = "SELECT netWorth
                      FROM portfolio
                      WHERE portfolioID = '$userPortfolioID'";
  $CNWresult = mysqli_query($connection, $currentNetWorth);
  if(mysqli_num_rows($CNWresult) > 0)
  {
    while($row33=mysqli_fetch_assoc($CNWresult))
    {
      $currentNW = $row33["netWorth"];
    }
  }

  $modNW = "UPDATE portfolio
            SET netWorth = $currentNW + ($purchaseAmt * $pricePerStock)
            WHERE portfolioID = '$userPortfolioID'";
  mysqli_query($connection, $modNW);
}

header('location: index.html');

?>
