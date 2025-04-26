<?php
session_start(); 

// CHECK KUNG NAKA LOGIN
if (!isset($_SESSION['ID'])) {

   
    header("Location: index.php");
    exit(); 
}

require 'db_connect.php'; 




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="static/home.css">

    <script src="static/main.js"></script>

</head>

<body>
<nav>
    <div>
        <ul class="sidebar">
            <li onclick=hideSidebar()><a><svg xmlns="http://www.w3.org/2000/svg" height="26" viewBox="0 -960 960 960" width="26"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="logout.php">Logout</a></li>
        
        </ul>


        <ul>
            <li><a href="#main-section"><img src="Images/Black Camera Icon Photography Logo.png" alt=""></a></li>
            <li class="hideOnMobile"><a href="home.php">Home</a></li>
            <li class="hideOnMobile"><a href="about.php">About</a></li>
            <li class="hideOnMobile"><a href="logout.php">Logout</a></li>
            <li class="Menubtn" onclick=showSidebar()><a><svg xmlns="http://www.w3.org/2000/svg" height="26" viewBox="0 -960 960 960" width="26"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>
        </ul>
    </div>
</nav>



<main>
    <div class="container-home">
        <h2>Account Information</h2>
        <p>Name: <?php echo $_SESSION["fullname"] ?></p>
        <p>Email: <?php echo $_SESSION["email"] ?></p>
        <p>Role: <?php echo htmlspecialchars($_SESSION["role"]); ?>.</p><br>
    </div>

</main>
</body>

</html>
