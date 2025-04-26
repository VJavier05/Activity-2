<?php
require 'db_connect.php'; 


// CHECK KUNG REQUESTED IS POST (SUBMIT)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // COLLECT DATA FROM INPUT FIELDS
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);
   


    // CHECK IF PAREHAS PASSWORD
    if ($password !== $confirm_password) {
        session_start();
        $_SESSION['error_message'] = "Password Does not Match";
        header("Location: register_form.php");
        exit();

    }

    

    

    // HASH PASSWORD FOR SECURTY
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {

        //FOR EMAIL CHECKING
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // FETCH THE RESULT
        $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existing_user) {
            session_start();
            $_SESSION['error_message'] = "Email is already taken.";
            header("Location: register_form.php");
            exit();
        }

        // PREPARE SQL STATEMENT
        $stmt = $pdo->prepare("INSERT INTO users ( email, password) 
                               VALUES (:email, :password)");

        // BIND WITH COLLECTED DATA
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password',  $hashed_password);



        // EXECUTE THE STATEMENT
        $stmt->execute();

        session_start();
        $_SESSION['success_message'] = "Registration successful!";
        header("Location: index.php"); // Ensure you redirect to index.php
        exit();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        
    }
}
?>
