<?php

require "includes/connect.php";
//Gets the id of the register we are deleting.
$registrationID = $_GET["id"];
//Makes sure we're only deleting the register we want to delete according to the ID.
$sql = "DELETE from event_registrations WHERE registrationID = :registrationID";

$stmt = $pdo->prepare($sql);
//Binding the ID before executing.
$stmt->bindParam(":registrationID", $registrationID);

$stmt->execute();

header("Location: registration.php");

exit;