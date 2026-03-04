<?php

require "includes/connect.php";

$registrationID = $_GET["id"];

$sql = "DELETE from event_registrations WHERE registrationID = :registrationID";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(":registrationID", $registrationID);

$stmt->execute();

header("Location: registration.php");

exit;