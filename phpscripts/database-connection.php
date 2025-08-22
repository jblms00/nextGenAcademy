<?php

// Hostinger
// $dbhost = "localhost";
// $dbuser = "u378311255_nextgenacademy";
// $dbpass = "u/D7fG/RN5t0";
// $dbname = "u378311255_nextgen_db";

// Localhost
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "nextGen_db";

if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
    die("failed to connect!");
}