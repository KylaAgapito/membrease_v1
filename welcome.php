<?php
session_start();
include 'config.php'; // Ensure database connection

// Check if user is logged in
if (!isset($_SESSION['userPIN'])) {
    header("Location: index.php"); // Redirect to login if not authenticated
    exit();
}

$PIN = $_SESSION['userPIN']; // Get the logged-in user's PIN and prevent SQL injection

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

// Mapping sex attribute to full description
$sex_map = [
    'M' => 'Male',
    'F' => 'Female'
];

// Mapping civil status attribute to full description
$civil_status_map = [
    'S' => 'Single',
    'M' => 'Married',
    'W' => 'Widowed',
    'A' => 'Annulled',
    'LS' => 'Legally Separated'
];

// Convert the sex attribute
$sex_display = $sex_map[$personData['sex']] ?? 'Unknown';

// Convert the civil status attribute
$civil_status_display = $civil_status_map[$personData['civilStatus']] ?? 'Unknown';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Page</title>
</head>
<body>
    <h1>Member Information</h1>
    <h2>PhilHealth Identification Number: <?php echo htmlspecialchars($personData['PIN'] ?? "Not available"); ?></h2>
    <h2>Member Name: <?php echo htmlspecialchars($personData['memberName'] ?? "Not available"); ?></h2>

    <h3>Personal Information</h3>
    <h4>Basic Information:</h4>
    <ul>
        <li><strong>Birthdate:</strong> <?php echo htmlspecialchars($personData['birthdate'] ?? "Not available"); ?></li>
        <li><strong>Birthplace:</strong> <?php echo htmlspecialchars($personData['birthplace'] ?? "Not available"); ?></li>
        <li><strong>Sex:</strong> <?php echo htmlspecialchars($sex_display); ?></li>
        <li><strong>Civil Status:</strong> <?php echo htmlspecialchars($civil_status_display); ?></li>
        <li><strong>Citizenship:</strong> <?php echo htmlspecialchars($personData['citizenship'] ?? "Not available"); ?></li>
        <li><strong>Address:</strong> <?php echo htmlspecialchars($personData['permaHomeAddress'] ?? "Not available"); ?></li>
        <li><strong>Mailing Address:</strong> <?php echo htmlspecialchars($personData['mailingAddress'] ?? "Not available"); ?></li>
        <li><strong>Mother Name:</strong> <?php echo htmlspecialchars($personData['motherMaidenName'] ?? "Not available"); ?></li>
    </ul>
    <h4>Contact Information:</h4>
    <ul>
        <li><strong>Home Phone Number:</strong> <?php echo htmlspecialchars($personData['homePhoneNo'] ?? "Not available"); ?></li>
        <li><strong>Direct Number:</strong> <?php echo htmlspecialchars($personData['directNo'] ?? "Not available"); ?></li>
        <li><strong>Email Address:</strong> <?php echo htmlspecialchars($personData['emailAdd'] ?? "Not available"); ?></li>
    </ul>

    <h4>Contributor Information:</h4>
    <ul>
        <li><strong>Preferred Konsulta Provider</strong> <?php echo htmlspecialchars($personData['pkp'] ?? "Not available"); ?> </li>
        <li><strong>Contributor Type:</strong> <?php echo htmlspecialchars($personData['contributorType'] ?? "Not available"); ?></li>
        <li><strong>Profession:</strong> <?php echo htmlspecialchars($personData['profession'] ?? "Not available"); ?></li>
        <li><strong>Monthly Income:</strong> <?php echo "₱" . number_format($personData['monthlyIncome'] ?? 0, 2); ?></li>
        <li><strong>Income Proof:</strong> <?php echo htmlspecialchars($personData['incomeProof'] ?? "Not available"); ?></li>
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
