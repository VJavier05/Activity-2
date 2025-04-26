<?php
require 'db_connect.php';
session_start();

// Prepare dynamic content
$dynamicContent = '';
if (isset($_SESSION['error_message'])) {
    $dynamicContent .= "<p class='error-mess'>" . $_SESSION['error_message'] . "</p>";
    unset($_SESSION['error_message']); // Clear the message after displaying
}

if (isset($_SESSION['success_message'])) {
    $dynamicContent .= "<p class='success-mess'>" . $_SESSION['success_message'] . "</p>";
    unset($_SESSION['success_message']); // Clear the message after displaying
}

// Load the HTML template and inject dynamic content
$template = file_get_contents('template_register.html');
echo str_replace('{{dynamic_content}}', $dynamicContent, $template);
?>
