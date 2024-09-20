<?php
session_start();
if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
    // Set the HTTP response code to 403 Forbidden
    http_response_code(403);
    // Display an error message (optional)
    echo 'Access denied.';
    // Exit to ensure the rest of the script doesn't execute
    exit();
}

// Hardcoded PIN for the sake of the example
$correctPin = '9767'; // You can replace this with any PIN

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['pin'])) {
    $enteredPin = $_GET['pin'];

    // Check if the entered PIN matches the correct PIN
    if ($enteredPin === $correctPin) {
        $_SESSION['loggedin'] = true;
        echo "flag{Recon_MOre_MASter_MEow_8343c7b3d1d7425ad5}";
        exit;
    } else {
        echo "Incorrect PIN. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Enter your 4-digit PIN</h2>
    <form action="login.php" method="get">
        <input type="password" name="pin" maxlength="4" pattern="\d{4}" required>
        <input type="submit" value="Login">
    </form>
</body>
</html>
