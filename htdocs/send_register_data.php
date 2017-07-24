<?php
    //checking if data has been entered
    if( isset( $_POST['inputFname'] ) && !empty( $_POST['inputFname'] ) &&
        isset( $_POST['inputMname'] ) && !empty( $_POST['inputMname'] ) &&
        isset( $_POST['inputLname'] ) && !empty( $_POST['inputLname'] ) &&
        isset( $_POST['inputUsername'] ) && !empty( $_POST['inputUsername'] ) &&
        isset( $_POST['inputPassword'] ) && !empty( $_POST['inputPassword'] ) &&
        isset( $_POST['inputAddress'] ) && !empty( $_POST['inputAddress'] ) &&
        isset( $_POST['inputCardNumber'] ) && !empty( $_POST['inputCardNumber'] ))
    {
        $fnameData = $_POST['inputFname'];
        $mnameData = $_POST['inputMname'];
        $lnameData = $_POST['inputLname'];
        $usernameData = $_POST['inputUsername'];
        $passwordData = $_POST['inputPassword'];
        $addressData = $_POST['inputAddress'];
        $cardnumberData = $_POST['inputCardNumber'];
    } else {
        header( 'location: register.html' );
        exit();
    }

    //setting up mysql details
    $sql_server = 'localhost';
    $sql_user = 'root';
    $sql_pwd = 'password';
    $sql_db = 'test';

    //connecting to sql database
    $connection = new mysqli($sql_server, $sql_user, $sql_pwd, $sql_db);

    //creating customerID
    $customerID = uniqid();

    //insert data into Customer table
    $register = "INSERT INTO Customer (customerID, balance, fName, mName, lName, customerUsername, customerPassword)
                 VALUES ('$customerID','0','$fnameData','$mnameData','$lnameData','$usernameData', '$passwordData')";

    //perform query
    mysqli_query($connection, $register);

    //create random portfolioID
    $portfolioID = rand(10000000,99999999);


    //insert data into Portfolio table
    $registerPortfolio = "INSERT INTO Portfolio (customerID, portfolioID, netWorth)
                          VALUES ('$customerID','$portfolioID','0')";

    //perform query
    mysqli_query($connection, $registerPortfolio);

    //insert data into billing info table
    $registerBilling = "INSERT INTO customerBillingInfo (customerID, address, cardNumber)
                          VALUES ('$customerID','$addressData','$cardnumberData')";

    //perform query
    mysqli_query($connection, $registerBilling);

    //sends the user back to the login page
    header('location: login.html');

    //closing mysqli connection
    $connection->close();
?>
