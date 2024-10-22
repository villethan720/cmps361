<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <h2>Login to the Liquor Room</h2>
    </body>
    <form action="authentication.php" method="post">
        
        <!--Creates fields for the username and password that we can use to authenticate the session by having the user log in-->
        <label for="username">Username</label>
        <input type="text" name="username" required><br><br>
        <label for="password">Password</label>
        <input type="password" name="username" required><br><br>
        <button type="submit">Login</button>
    </form>
</html>
<?php

?>