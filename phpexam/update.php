<?php

require "includes/header.php";
require "includes/connect.php";
//If you don't have an ID you can't be updated.
if(!isset($_GET["id"])){
    die("No registration ID.");
}
//This gets the registration ID so that it is adjusting the correct one.
$registrationID =  $_GET["id"];
//Trims them as long as the method is POST.
if($_SERVER["REQUEST_METHOD"]==="POST"){
    $firstName = trim($_POST["firstName"]?? "");
    $lastName = trim($_POST["lastName"]?? "");
    $phone = trim($_POST["phone"]?? "");

    if($firstName===""|| $lastName === "" || $phone === ""){
        $error = "Everything is required.";
    }
    //Catches if the phone number is invalid.
    elseif(!filter_var($phone, FILTER_VALIDATE_REGEXP, ['options' => [ 'regexp' => '/^[0-9\-\+\(\)\s]{7,25}$/']])){
        $error = "Phone number format is invalid.";
    }
    else{
        //Updates the information according to the registration ID. I, unfortunately, cannot tell you how I fixed it other than retyping it and praying.
        $sql = "UPDATE event_registrations SET firstName = :firstName, lastName = :lastName, phone = :phone WHERE registrationID = :registrationID";
        
        $stmt = $pdo->prepare($sql);
        //Binds the variables to the table.
        $stmt->bindParam(":firstName", $firstName);
        $stmt->bindParam(":lastName",$lastName);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":registrationID",$registrationID);

        $stmt->execute();
        //Sends you back to registration.php
        header("Location: registration.php");
        exit;
    }
}
//Selects all the information to be shown in the table when updating.
$sql = "SELECT * FROM event_registrations WHERE registrationID = :registrationID";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":registrationID",$registrationID);
$stmt->execute();
//Fetches the information.
$event_registration = $stmt->fetch();
//If you don't exist you don't exist.
if(!$event_registration){
    die("Register not found.");
}
?>
<!--Table with all the information in it displayed. -->
<main class="container mt-4">
    <h2>Update Register #<?= htmlspecialchars($event_registration["registrationID"]); ?></h2>
    <!-- Catches the error if you've made one. -->
    <?php if (!empty($error)): ?>
        <p class="text-danger"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method = "post">
        <h4 class="mt-3">Register's Info</h4>

        <label class="form-label">First Name</label>
        <input type="text" name="firstName" class="form-control mb-3" value="<?= htmlspecialchars($event_registration["firstName"]); ?>" required>
        <label class="form-label">Last Name</label>
        <input type="text" name="lastName" class="form-control mb-3" value="<?= htmlspecialchars($event_registration["lastName"]); ?>" required>
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control mb-3" value="<?= htmlspecialchars($event_registration["phone"]); ?>" required>

        <button class="btn btn-outline-primary">Update Info</button><a href="registration.php" class="btn btn-outline-danger">Cancel</a>
    </form>
</main>

<?php require "includes/footer.php";?>