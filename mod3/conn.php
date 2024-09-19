<?php
    //authentication credentials
    //dangerous for security reasons
    $host = "localhost";
    $port = "5432";
    $dbname = "sunfreshdb";
    $user = "postgres";
    $password = "Anaethan03";


    //connection string
    $dsn = ("pgsql:host=$host dbname=$dbname");

    echo "My first PHP connection";

    try {
        //grabs all credentials needed to get into postgres to start session
        $instance = new PDO($dsn ,$user, $password);



        //set an error alert
        //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Echo messages
        echo "Suxxessfully connected to the database";
    } catch (PDOException $e) {
        //catches error and gets the error message to show the user
        echo "Connection Failed: " . $e->getMessage();
    }

?>