<?php
require "includes/header.php";
require "includes/connect.php";
//The registration.php shows you all of the registers in the table ordered by when it was created.
$sql = "SELECT * FROM event_registrations ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$event_registrations = $stmt->fetchAll();
?>

<main class="mt-4">
    <h2>Registry Configuration</h2>
    <!--Makes sure to let you know if no one has registered yet. -->
    <?php if(empty($event_registrations)): ?>
        <p>No people registered.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Registration ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- For each register, it produces a new row with the appropriate columns. -->
                    <?php foreach($event_registrations as $event_registration): ?>
                        <tr>
                            <td><?= htmlspecialchars($event_registration['registrationID']);?></td>
                            <td>
                                <?= htmlspecialchars($event_registration["firstName"]); ?>
                                <?= htmlspecialchars($event_registration["lastName"]); ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($event_registration["phone"]); ?>
                            </td>
                            <td><?= htmlspecialchars($event_registration["created_at"]); ?></td>
                            <td>
                                <a class="btn btn-outline-warning" href="update.php?id=<?= urlencode($event_registration["registrationID"]); ?>">Update</a>
                                <a class="btn btn-outline-danger" href="delete.php?id=<?= urlencode($event_registration["registrationID"]); ?>"onclick="return confirm('Delete this register? This cannot be undone.');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        <p class="mt-3">
            <a class="btn btn-outline-secondary" href="index.php">Back</a>
        </p>
</main>
<?php include "includes/footer.php"; ?>