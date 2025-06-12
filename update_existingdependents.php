<?php
session_start();
include 'config.php'; // Ensure database connection

// Check if user is logged in
if (!isset($_SESSION['userPIN'])) {
    header("Location: index.php"); // Redirect to login if not authenticated
    exit();
}

$pin = $_SESSION['userPIN']; // Get the logged-in user's PIN and prevent SQL injection


// Fetch current member data
$member = [];
if ($pin) {
    $stmt = $conn->prepare("SELECT * FROM memberdetails WHERE PIN = ?");
    $stmt->bind_param("s", $pin);
    $stmt->execute();
    $result = $stmt->get_result();
    $member = $result->fetch_assoc();
    $stmt->close();
}

// Fetch existing dependents
$dependents = [];
if ($pin) {
    $stmt = $conn->prepare("SELECT * FROM dependents WHERE PIN = ?");
    $stmt->bind_param("s", $pin);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $dependents[] = $row;
    }
    $stmt->close();
}

// Handle form submission for updating dependents
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $allUpdated = true;
    $errorMessages = [];
    
    // Update each dependent
    foreach ($_POST['dependents'] as $dependentID => $dependentData) {
        $stmt = $conn->prepare("UPDATE dependents SET depName=?, relationship=?, depBirthdate=?, depPWD=? WHERE depID=? AND PIN=?");
        $stmt->bind_param("ssssss",
            $dependentData['depName'],
            $dependentData['relationship'],
            $dependentData['depBirthdate'],
            $dependentData['depPWD'],
            $dependentID,
            $pin
        );
        
        if (!$stmt->execute()) {
            $allUpdated = false;
            $errorMessages[] = "Failed to update dependent: " . $dependentData['depName'];
        }
        $stmt->close();
    }
    
    if ($allUpdated) {
        $success = "All dependents updated successfully!";
    } else {
        $error = "Some updates failed: " . implode(", ", $errorMessages);
    }
    
    // Refresh dependents data after update
    $dependents = [];
    $stmt = $conn->prepare("SELECT * FROM dependents WHERE PIN = ?");
    $stmt->bind_param("s", $pin);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $dependents[] = $row;
    }
    $stmt->close();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Dependent Information</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/update_dependent.css">
</head>
<body>

    <div class="parent">

        <div class="topbar">
            
            <div class="logo">
                <div class="logo-picture">
                    <svg width="50" height="57" viewBox="0 0 50 57" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect width="50" height="57" fill="url(#pattern0_14_125)"/>
                        <defs>
                        <pattern id="pattern0_14_125" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_14_125" transform="matrix(0.000729367 0 0 0.000639795 -0.07 0)"/>
                        </pattern>
                        <image id="image0_14_125" width="1563" height="1563" preserveAspectRatio="none" xlink:href="data:image/png;base64,"/>
                        </defs>
                    </svg>    
                </div>
                <div class="logo-title">
                    <div>Membrease</div>
                    <div>Your Philhealth Companion</div>
                </div>
            </div>

            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search">
            </div>

            <div class="account">
                <div class="profile-picture">
                    <i class="fa-regular fa-user"></i>
                </div>
                
                <div class="member-name-id-wrapper">
                    <div class="member-name">
                        <div><?php echo htmlspecialchars($member['memberName'] ?? "Not available"); ?></div>
                    </div>
                    <div class="member-id">
                        <div><?php echo htmlspecialchars($member['PIN'] ?? "Not available"); ?></div>
                    </div>
                </div>
                
            </div>

        </div>
        
        <main class="main">

            <section class="sidebar">

                <div class="sidebar-title">
                    <p>Dashboard</p>
                </div>

                <div class="sidebar-tools">
                    <div class="member-information">
                        <svg width="28" height="24" viewBox="0 0 28 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 19H14V17C13.9992 16.2046 13.6829 15.442 13.1204 14.8796C12.558 14.3171 11.7954 14.0008 11 14H7C6.20459 14.0008 5.44199 14.3171 4.87956 14.8796C4.31712 15.442 4.00079 16.2046 4 17V19H2V17C2.00159 15.6744 2.52888 14.4036 3.46622 13.4662C4.40356 12.5289 5.67441 12.0016 7 12H11C12.3256 12.0016 13.5964 12.5289 14.5338 13.4662C15.4711 14.4036 15.9984 15.6744 16 17V19ZM9 2C9.59334 2 10.1734 2.17595 10.6667 2.50559C11.1601 2.83524 11.5446 3.30377 11.7716 3.85195C11.9987 4.40013 12.0581 5.00333 11.9424 5.58527C11.8266 6.16721 11.5409 6.70176 11.1213 7.12132C10.7018 7.54088 10.1672 7.8266 9.58527 7.94236C9.00333 8.05811 8.40013 7.9987 7.85195 7.77164C7.30377 7.54458 6.83524 7.16006 6.50559 6.66671C6.17595 6.17336 6 5.59334 6 5C6 4.20435 6.31607 3.44129 6.87868 2.87868C7.44129 2.31607 8.20435 2 9 2ZM9 0C8.01109 0 7.04439 0.293245 6.22215 0.842652C5.3999 1.39206 4.75904 2.17295 4.3806 3.08658C4.00216 4.00021 3.90315 5.00555 4.09607 5.97545C4.289 6.94536 4.7652 7.83627 5.46447 8.53553C6.16373 9.2348 7.05464 9.711 8.02455 9.90393C8.99445 10.0969 9.99979 9.99784 10.9134 9.6194C11.827 9.24096 12.6079 8.6001 13.1573 7.77785C13.7068 6.95561 14 5.98891 14 5C14 3.67392 13.4732 2.40215 12.5355 1.46447C11.5979 0.526784 10.3261 0 9 0ZM0 22H28V24H0V22ZM28 4H26V2H24V0H28V4ZM17 0H21V2H19V4H17V0ZM26 9H28V11H26V9ZM24 7H26V9H24V7ZM17 7H19V9H21V11H17V7Z" fill="#275853"/>
                        </svg>                            
                        Member Information
                    </div>
                    <div class="contributor-information">
                        <svg width="28" height="24" viewBox="0 0 28 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27 9H24.98C24.9512 8.20994 24.7606 7.43419 24.42 6.72072C24.0795 6.00725 23.5962 5.37124 23 4.852V1C23 0.814289 22.9483 0.632245 22.8507 0.474269C22.753 0.316293 22.6133 0.188626 22.4472 0.105573C22.2811 0.0225203 22.0952 -0.0126368 21.9102 0.00404117C21.7252 0.0207191 21.5486 0.0885731 21.4 0.2L17.667 3H13C7.49 3 3.537 6.241 3.052 11H3C2.73478 11 2.48043 10.8946 2.29289 10.7071C2.10536 10.5196 2 10.2652 2 10V8H0V10C0.000794215 10.7954 0.31712 11.558 0.879557 12.1204C1.44199 12.6829 2.20459 12.9992 3 13H3.07C3.21483 14.3113 3.64091 15.5759 4.31915 16.7076C4.99738 17.8392 5.91181 18.8111 7 19.557V23C7 23.2652 7.10536 23.5196 7.29289 23.7071C7.48043 23.8946 7.73478 24 8 24H12C12.2652 24 12.5196 23.8946 12.7071 23.7071C12.8946 23.5196 13 23.2652 13 23V21H16V23C16 23.2652 16.1054 23.5196 16.2929 23.7071C16.4804 23.8946 16.7348 24 17 24H21C21.2652 24 21.5196 23.8946 21.7071 23.7071C21.8946 23.5196 22 23.2652 22 23V19.637C22.722 19.2941 23.3533 18.7863 23.843 18.1545C24.3327 17.5227 24.667 16.7847 24.819 16H27C27.2652 16 27.5196 15.8946 27.7071 15.7071C27.8946 15.5196 28 15.2652 28 15V10C28 9.73478 27.8946 9.48043 27.7071 9.29289C27.5196 9.10536 27.2652 9 27 9ZM26 14H23.124C22.819 16.753 22.301 17.485 20 18.315V22H18V19H11V22H9V18.378C7.79567 17.8054 6.77964 16.9013 6.07114 15.7715C5.36263 14.6418 4.99105 13.3335 5 12C5 7.165 9.018 5 13 5H18.334L21 3V5.776C23.418 7.636 22.913 8.962 23.018 11H26V14Z" fill="#275853"/>
                        </svg>                                               
                        Contributor Information
                    </div>
                    <div class="dependents-information">
                        <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23 22H21.3571V18.0714C21.3558 17.0299 20.9227 16.0314 20.1528 15.2949C19.3828 14.5584 18.3389 14.1441 17.25 14.1429V12.5714C18.7743 12.5735 20.2356 13.1536 21.3135 14.1846C22.3913 15.2156 22.9978 16.6134 23 18.0714V22ZM16.4286 22H14.7857V18.0714C14.7844 17.0299 14.3513 16.0314 13.5813 15.2949C12.8114 14.5584 11.7675 14.1441 10.6786 14.1429H5.75C4.66112 14.1441 3.61721 14.5584 2.84725 15.2949C2.0773 16.0314 1.64416 17.0299 1.64286 18.0714V22H0V18.0714C0.00217296 16.6134 0.608673 15.2156 1.68654 14.1846C2.7644 13.1536 4.22567 12.5735 5.75 12.5714H10.6786C12.2029 12.5735 13.6642 13.1536 14.742 14.1846C15.8199 15.2156 16.4264 16.6134 16.4286 18.0714V22ZM14.7857 0V1.57143C15.875 1.57143 16.9197 1.98533 17.6899 2.72208C18.4601 3.45883 18.8929 4.45808 18.8929 5.5C18.8929 6.54192 18.4601 7.54117 17.6899 8.27792C16.9197 9.01467 15.875 9.42857 14.7857 9.42857V11C16.3107 11 17.7732 10.4205 18.8516 9.38909C19.9299 8.35764 20.5357 6.95869 20.5357 5.5C20.5357 4.04131 19.9299 2.64236 18.8516 1.61091C17.7732 0.579463 16.3107 0 14.7857 0ZM8.21429 1.57143C9.0266 1.57143 9.82068 1.80184 10.4961 2.23351C11.1715 2.66519 11.6979 3.27875 12.0088 3.9966C12.3197 4.71445 12.401 5.50436 12.2425 6.26643C12.084 7.02849 11.6929 7.7285 11.1185 8.27792C10.5441 8.82734 9.81226 9.2015 9.01555 9.35309C8.21884 9.50467 7.39303 9.42687 6.64255 9.12953C5.89207 8.83218 5.25062 8.32865 4.79932 7.6826C4.34802 7.03655 4.10714 6.277 4.10714 5.5C4.10714 4.45808 4.53986 3.45883 5.3101 2.72208C6.08034 1.98533 7.125 1.57143 8.21429 1.57143ZM8.21429 0C7.07704 0 5.96534 0.322569 5.01976 0.926917C4.07417 1.53126 3.33718 2.39025 2.90198 3.39524C2.46677 4.40023 2.35291 5.5061 2.57477 6.573C2.79664 7.63989 3.34427 8.6199 4.14842 9.38909C4.95257 10.1583 5.97713 10.6821 7.09252 10.8943C8.20791 11.1065 9.36404 10.9976 10.4147 10.5813C11.4654 10.1651 12.3634 9.46011 12.9952 8.55564C13.6271 7.65117 13.9643 6.5878 13.9643 5.5C13.9643 4.04131 13.3585 2.64236 12.2801 1.61091C11.2018 0.579463 9.73928 0 8.21429 0Z" fill="#275853"/>
                        </svg>
                        Dependents Information
                    </div>
                 </div>

                 <div class="about-logout">
                    <div></div>
                    <div></div>
                </div>

            </section>

            <section class="dashboard">
                <div class="section-4" style="overflow: auto;">
                    <div class="update-information">
                        <div class="update-information-title">Update Dependents Information:</div>
                        <div class="update-information-list">
                            <form method="POST">
                                
                                <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
                                <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

                                <?php if (empty($dependents)): ?>
                                    <p>No dependents found. <a href="add_dependent.php">Add a dependent</a></p>
                                <?php else: ?>
                                    <?php foreach ($dependents as $index => $dependent): ?>
                                        <div class="update-dependent-information">
                                            <p>Dependent <?= $index + 1 ?></p>
                                            
                                            <div class="dependent-name">
                                                <div class="form-group">
                                                    <label>Dependent Name:</label>
                                                    <input type="text" 
                                                           name="dependents[<?= $dependent['depID'] ?>][depName]" 
                                                           value="<?= htmlspecialchars($dependent['depName'] ?? '') ?>" 
                                                           class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="relationship">
                                                <div class="form-group">
                                                    <label>Relationship:</label>
                                                    <select name="dependents[<?= $dependent['depID'] ?>][relationship]" class="form-control" required>
                                                        <option value="">Select Relationship</option>
                                                        <option value="Sibling" <?= (isset($dependent['relationship']) && $dependent['relationship'] == 'Sibling') ? 'selected' : '' ?>>Sibling</option>
                                                        <option value="Daughter" <?= (isset($dependent['relationship']) && $dependent['relationship'] == 'Daughter') ? 'selected' : '' ?>>Daughter</option>
                                                        <option value="Parent" <?= (isset($dependent['relationship']) && $dependent['relationship'] == 'Parent') ? 'selected' : '' ?>>Parent</option>
                                                        <option value="Son" <?= (isset($dependent['relationship']) && $dependent['relationship'] == 'Son') ? 'selected' : '' ?>>Son</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="dependent-birthdate">
                                                <div class="form-group">
                                                    <label>Birthdate:</label>
                                                    <input type="date" 
                                                           name="dependents[<?= $dependent['depID'] ?>][depBirthdate]" 
                                                           value="<?= htmlspecialchars($dependent['depBirthdate'] ?? '') ?>" 
                                                           class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="disability-status">
                                                <div class="form-group">
                                                    <label>PWD Status:</label>
                                                    <div class="pwd-input">
                                                        <div class="options">
                                                            <label><input type="radio" 
                                                                         name="dependents[<?= $dependent['depID'] ?>][depPWD]" 
                                                                         value="1" 
                                                                         <?= (isset($dependent['depPWD']) && $dependent['depPWD'] == '1') ? 'checked' : '' ?>> Yes</label>
                                                            <label><input type="radio" 
                                                                         name="dependents[<?= $dependent['depID'] ?>][depPWD]" 
                                                                         value="0" 
                                                                         <?= (isset($dependent['depPWD']) && $dependent['depPWD'] == '0') ? 'checked' : '' ?>> No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        
                                        <?php if ($index < count($dependents) - 1): ?>
                                            <hr style="margin: 20px 0; border: 1px solid #ddd;">
                                        <?php endif; ?>
                                        
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <?php if (!empty($dependents)): ?>
                                    <button class="save-button" type="submit">Update All</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

                    <div style="display:flex; justify-content: space-between;">
                        <button class="cancel-button" onclick="window.location.href='dependentsDisplay.php'">Cancel</button>
                    </div>    

                </div>

            </section>

        </main>

    </div>

</body>
</html>