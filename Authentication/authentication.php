<?php
//start session
session_start();

//Database configuration
$host = 'localhost';
$db = 'LiquorProject';
$user = 'postgres';
$pass = 'Anaethan03';
$port = '5432';

//Create connection to PostGres
$conn = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass");

//Validate the connection works
if (!$conn){
    die("Connection failed " . pg_last_error());
}

//Get user account info
$username = $_POST['username'];
$password = $_POST['password'];

//SQL Query
$sql = "SELECT * FROM users WHERE username= $1";
$result = pg_query_params($conn, $sql, array($username));

if(pg_num_rows($result) > 0){
    //fetch user data
    $user = pg_fetch_assoc($result);

    //verify password using password_verify()
    if (password_verify($password, $user['password'])) {
        //generate session id if password is right
        session_regenerate_id(true);

        //store username in session
        $_SESSION['username'] = $username; 
        
        //redirects to new page
        header("Location: homePage.php");
        exit();
    }else{
        echo "Invalid password";
    }
} else{
    echo "no user found";
}

//close connection
pg_close($conn);
?>