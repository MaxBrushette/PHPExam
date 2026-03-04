<?php
$host = "localhost";
$db = "events";
$user = "root";
$password  = "";
//This is making sure that we connect to the database so we can access the table.
$dsn = "mysql:host=$host;dbname=$db";

try{
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    die("Database couldn't connect: " . $e->getMessage());
}