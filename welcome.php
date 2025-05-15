<?php
session_start();
include 'config.php'; // Ensure database connection

// Check if user is logged in
if (!isset($_SESSION['userPIN'])) {
    header("Location: index.php"); // Redirect to login if not authenticated
    exit();
}

$PIN = $_SESSION['userPIN']; // Get the logged-in user's PIN

// Fetch person details
$personQuery = "SELECT * FROM person WHERE PIN = ?";
$stmt = $conn->prepare($personQuery);
$stmt->bind_param("s", $PIN);
$stmt->execute();
$personResult = $stmt->get_result();
$personData = $personResult->fetch_assoc() ?? [];

// Fetch spouse details if spouseID exists
$spouseData = null;
if (!empty($personData['spouseID'])) {
    $spouseQuery = "SELECT * FROM spouse WHERE spouseID = ?";
    $stmt = $conn->prepare($spouseQuery);
    $stmt->bind_param("s", $personData['spouseID']);
    $stmt->execute();
    $spouseResult = $stmt->get_result();
    $spouseData = $spouseResult->fetch_assoc() ?? [];
}

// Fetch all dependents
$dependentQuery = "SELECT * FROM dependent WHERE PIN = ?";
$stmt = $conn->prepare($dependentQuery);
$stmt->bind_param("s", $PIN);
$stmt->execute();
$dependentResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Page</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['userName'] ?? "Guest"); ?>!</h2>

    <h3>Personal Information</h3>
    <ul>
        <li><strong>PIN:</strong> <?php echo htmlspecialchars($personData['PIN'] ?? "Not available"); ?></li>
        <li><strong>Birthdate:</strong> <?php echo htmlspecialchars($personData['birthdate'] ?? "Not available"); ?></li>
        <li><strong>Birthplace:</strong> <?php echo htmlspecialchars($personData['birthplace'] ?? "Not available"); ?></li>
        <li><strong>Sex:</strong> <?php echo htmlspecialchars($personData['sex'] ?? "Not available"); ?></li>
        <li><strong>Email:</strong> <?php echo htmlspecialchars($personData['emailAdd'] ?? "Not available"); ?></li>
    </ul>

    <?php if ($spouseData): ?>
    <h3>Spouse Information</h3>
    <ul>
        <li><strong>Name:</strong> <?php echo htmlspecialchars($spouseData['spouseName'] ?? "Not available"); ?></li>
    </ul>
    <?php endif; ?>

    <h3>Dependents</h3>
    <?php if ($dependentResult->num_rows > 0): ?>
        <ul>
            <?php while ($row = $dependentResult->fetch_assoc()): ?>
                <li><strong>Name:</strong> <?php echo htmlspecialchars($row['depName']); ?> (Relationship: <?php echo htmlspecialchars($row['relationship']); ?>)</li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No dependents registered.</p>
    <?php endif; ?>

</body>
</html>
