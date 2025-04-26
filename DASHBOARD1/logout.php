<?php
session_start();

// REMOVE ALL SESSION
session_unset();
session_destroy();

// Redirect to the login page
header("Location: index.php");
exit();
