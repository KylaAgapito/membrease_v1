<?php
session_start();
include 'config.php'; // Ensure database connection

// Check if user is logged in
if (!isset($_SESSION['userPIN'])) {
    header("Location: index.php"); // Redirect to login if not authenticated
    exit();
}

$pin = $_SESSION['userPIN']; // Get the logged-in user's PIN and prevent SQL injection

$query = $conn->prepare("SELECT depName, relationship, depBirthdate, depCitizenship FROM dependents WHERE PIN = ?");
$query->bind_param("s", $pin);
$query->execute();
$dependents_result = $query->get_result();
$query->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dependents Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   
     <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-users"></i> Dependents Information</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Relationship</th>
                    <th>Birthdate</th>
                    <th>Citizenship</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($dep = $dependents_result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($dep['depName']); ?></td>
                        <td><?php echo htmlspecialchars($dep['relationship']); ?></td>
                        <td><?php echo htmlspecialchars($dep['depBirthdate']); ?></td>
                        <td><?php echo htmlspecialchars($dep['depCitizenship']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <div class="button-group">
            <a href="update_dependents.php" class="btn btn-primary">
                <i class="fas fa-edit"></i> Update Dependents
            </a>
            <a href="dashboard.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <form action="logout.php" method="post" style="margin-left: auto;">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </button>
            </form>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>