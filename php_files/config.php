<?php
//  This file contains database configuration assuming you are running mysql using user "root" and password ""

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'login');


//  Connecting to the Database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//  To check connection
if($conn == false){
    dir('Error: Cannot connect');
}

?>