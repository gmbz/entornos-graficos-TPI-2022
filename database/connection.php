<?php
function databaseConnection()
{
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gestionConsultasDB";

    $conn = mysqli_connect($server, $username, $password, $dbname) or die("Connection failed");
    return $conn;
}
