<?php
require 'functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
        $_SESSION['email'] = $email;
        $code = generateVerificationCode();
        $_SESSION['verification_code'] = $code;
        sendVerificationEmail($email, $code);
        $msg = "Code sent to $email";
    } elseif (isset($_POST['verification_code'])) {
        if ($_POST['verification_code'] === $_SESSION['verification_code']) {
            registerEmail($_SESSION['email']);
            $msg = "Registered!";
        } else {
            $msg = "Wrong code, try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
<h2>Sign Up</h2>
<?php if (!empty($msg)) echo "<p>$msg</p>"; ?>

<form method="POST">
  <label for="email">Email Address:</label><br>
  <input type="email" name="email" id="email" placeholder="Enter your email" required><br><br>
  <button id="submit-email">Submit</button>
</form>

<form method="POST">
  <label for="verification_code">Verification Code:</label><br>
  <input type="text" name="verification_code" id="verification_code" maxlength="6" placeholder="Enter 6-digit code" required><br><br>
  <button id="submit-verification">Verify</button>
</form>
</body>
</html>
