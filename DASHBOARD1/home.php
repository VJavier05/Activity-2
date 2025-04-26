<?php
session_start(); 

// CHECK IF LOGGED IN
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit(); 
}

require 'db_connect.php'; 

try {
    // Prepare and execute the SQL query to fetch all users
    $stmt = $pdo->prepare("SELECT * FROM login_users");
    $stmt->execute();
    
    // Fetch all users
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error fetching data: " . $e->getMessage();
    exit();
}

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
            <li class="Menubtn logout" onclick=showSidebar()><a><svg xmlns="http://www.w3.org/2000/svg" height="26" viewBox="0 -960 960 960" width="26"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>
        </ul>
    </div>
</nav>



<main>
    <div class="container-home2">
    <h2>Welcome to the Dashboard!</h2>
        <p>You are logged in as <?php echo htmlspecialchars($_SESSION["fullname"]); ?>.</p><br>
        <p>You're role is <?php echo htmlspecialchars($_SESSION["role"]); ?>.</p><br>

        <table class="user-table" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Gender</th>
            <th>Country</th>
            <th>Role</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['ID']); ?></td>
                <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['address']); ?></td>
                <td><?php echo htmlspecialchars($user['gender']); ?></td>
                <td><?php echo htmlspecialchars($user['country']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


    </div>

</main>
</body>

</html>
