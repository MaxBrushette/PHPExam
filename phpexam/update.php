<?php

require "includes/header.php";
require "includes/connect.php";

if(!isset($_GET["id"])){
    die("No registration ID.");
}

$registrationID =  $_GET["id"];

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $firstName = trim($_POST["firstName"]?? "");
    $lastName = trim($_POST["lastName"]?? "");
    $phone = trim($_POST["phone"]?? "");

    if($firstName===""|| $lastName === "" || $phone === ""){
        $error = "Everything is required.";
    }
    else{
        $sql = "UPDATE event_registrations
                SET firstName = :firstName,
                    lastName = :lastName,
                    phone = :phone,
                WHERE registrationID = :registrationID";
        
        $stmt = $pdo->prepare($sql);
        //binds all of the variables to the table.
        $stmt->bindParam(":firstName", $firstName);
        $stmt->bindParam(":lastName",$lastName);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":registrationID",$registrationID);

        $stmt->execute();

        header("Location: registration.php");
        exit;
    }
}

$sql = "SELECT * FROM event_registrations WHERE registrationID = :registrationID";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":registrationID",$registrationID);
$stmt->execute();

$event_registration = $stmt->fetch();

if(!$event_registration){
    die("Member not found.");
}
?>

<main class="container mt-4">
    <h2>Update Register #<?= htmlspecialchars($event_registration["registrationID"]); ?></h2>

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