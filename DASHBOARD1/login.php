<?php
require 'db_connect.php'; 

session_start(); 

// Brute force protection parameters
$maxAttempts = 5; // Maximum login attempts allowed
$lockoutTime = 15 * 60; // Lockout time (in seconds) = 15 minutes

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    try {
        // Step 1: Fetch user ID and validate email
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            // Log failed attempt if email is invalid
            $_SESSION['error_message'] = "Invalid email or password.";
            logLoginAttempt($pdo, null, 'Failed'); // Log as "Failed"
            header("Location: index.php");
            exit();
        }
        
        $userId = $user['id']; // User's ID for login attempts

        // Step 2: Check login attempts for brute force protection
        $stmt = $pdo->prepare("SELECT COUNT(*) as attempts FROM login_attempts 
                               WHERE user_id = :userId AND time > NOW() - INTERVAL :lockoutTime SECOND");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':lockoutTime', $lockoutTime, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['attempts'] >= $maxAttempts) {
            $_SESSION['error_message'] = "Too many login attempts. Please try 15 mins later.";
            logLoginAttempt($pdo, $userId, 'Failed'); // Log as "Failed"
            header("Location: index.php");
            exit();
        }

        // Step 3: Verify password
        if (password_verify($password, $user['password'])) {
            // Successful login - set session variables
            $_SESSION['ID'] = $user['id'];
            $_SESSION['email'] = $email;

            // Clear login attempts after successful login
            $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE user_id = :userId");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();

            // Log success attempt
            logLoginAttempt($pdo, $userId, 'Success'); // Log as "Success"

            // Redirect to the user's dashboard
            header("Location: user_dashboard.php");
            exit();
        } else {
            // Invalid password - log the attempt
            $_SESSION['error_message'] = "Invalid email or password.";
            logLoginAttempt($pdo, $userId, 'Failed'); // Log as "Failed"
            header("Location: index.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Function to log login attempts with status
function logLoginAttempt($pdo, $userId, $status) {
    $stmt = $pdo->prepare("INSERT INTO login_attempts (user_id, attempt, time, status) 
                           VALUES (:userId, 1, CURRENT_TIMESTAMP, :status)");
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status);
    $stmt->execute();
}
?>
