<?php
    //checking if data has been entered
    if( isset( $_POST['inputUsername'] ) && !empty( $_POST['inputUsername'] ) &&
        isset( $_POST['inputPassword'] ) && !empty( $_POST['inputPassword'] ) )
    {
        $usernameData = $_POST['inputUsername'];
        $passwordData = $_POST['inputPassword'];
    } else {
        header( 'location: login.html' );
        exit();
    }

    //setting up mysql details
    $sql_server = 'localhost';
    $sql_user = 'root';
    $sql_pwd = 'password';
    $sql_db = 'test';

    //connecting to sql database
    $connection = new mysqli($sql_server, $sql_user, $sql_pwd, $sql_db);

    //begin session to recall username in other .php files
    session_start();

    //check info for normal user
    $login1 = "SELECT customerUsername, customerPassword
              FROM Customer
              WHERE customerUsername='$usernameData' AND
                    customerPassword='$passwordData'";

    //check info for admin
    $login2 = "SELECT adminUsername, adminPassword
               FROM Admin
               WHERE adminUsername='$usernameData' AND
                    adminPassword='$passwordData'";

    //create session ID to store username
    $_SESSION['username'] = $usernameData;

    //query for the customerID in order to cache it for later use
    $query1 = "SELECT customerID, balance, fName, mName, lName
              FROM Customer
              WHERE customerUsername='$usernameData'";

    $result1=mysqli_query($connection, $query1);

    //temp variable to move scope
    $varScope;

    //query the session cache for customer ID
    if(mysqli_num_rows($result1) > 0)
    {
      while($row1=mysqli_fetch_assoc($result1))
      {
        $varScope = $row1["customerID"];
      }
    }

    //actually creating the new session ID
    $_SESSION['customerID'] = $varScope;


    //query on database. If the user exists, take them to index.html
    //if they don't exist, invalid username/password
    if((mysqli_query($connection, $login1)->num_rows > 0) OR
       (mysqli_query($connection, $login2)->num_rows > 0))
    {
      header('location: index.html');
    }
    else
    {
      echo("invalid username/password");
    }

    $connection->close();
?>
