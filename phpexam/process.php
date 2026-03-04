<?php require "includes/connect.php";

if($_SERVER["REQUEST_METHOD"]!=="POST"){
    echo "<p>Did not receive a POST form submission.</p>";
    exit;
}

$firstName = trim(filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_SPECIAL_CHARS));
$lastName = trim(filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_SPECIAL_CHARS));
$phone = trim(filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS));

$errors = [];

if($firstName === null || $firstName === ""){
    $errors[] = "First name is required.";
}
if($lastName === null || $firstName === ""){
    $errors[] = "Last name is required.";
}
if($phone === null || $phone === ''){
    $errors[] = "Phone number is required.";
}
elseif(!filter_var($phone, FILTER_VALIDATE_REGEXP, ['options' => [ 'regexp' => '/^[0-9\-\+\(\)\s]{7,25}$/']])){
    $errors[]="Phone number format is invalid.";
}

if(!empty($errors)){
    require "includes/header.php";
    echo "<div class='alert alert-danger'>";
    echo "<h2>Errors(s) detected, please fix:</h2>";
    echo"<ul>";
    foreach($errors as $error){
        echo"<li>" .htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    echo "</div>";

    include "includes/footer.php";
    exit;
}

$sql = "INSERT INTO events(firstName, lastName, phone) VALUES (:firstName, :lastName, :phone)";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(":firstName", $firstName);
$stmt->bindParam(":lastName",$lastName);
$stmt->bindParam(":phone",$phone);

$stmt->execute();

?>

<? require "includes/header.php";?>

<div class="alert alert-success">
    <h1>You were added to the event registry, <?= htmlspecialchars($firstName) ?>!</h1>
</div>
<?php require "includes/footer.php"; ?>
