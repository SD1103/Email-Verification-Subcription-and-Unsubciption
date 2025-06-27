<?php
require 'functions.php';
session_start();

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['unsubscribe_email'])) {
        $email = trim($_POST['unsubscribe_email']);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['unsubscribe_email'] = $email;
            $code = generateVerificationCode();
            $_SESSION['unsubscribe_code'] = $code;
            sendVerificationEmail($email, $code); // Reuse same function
            $msg = "Unsubscribe code sent to <strong>$email</strong>.";
        } else {
            $msg = "Invalid email.";
        }

    } elseif (isset($_POST['unsubscribe_verification_code'])) {
        $enteredCode = trim($_POST['unsubscribe_verification_code']);
        $sessionCode = $_SESSION['unsubscribe_code'] ?? '';
        $email = $_SESSION['unsubscribe_email'] ?? '';

        if ($enteredCode === $sessionCode && !empty($email)) {
            unsubscribeEmail($email);
            $msg = "<strong>$email</strong> unsubscribed successfully.";
            unset($_SESSION['unsubscribe_code'], $_SESSION['unsubscribe_email']);
        } else {
            $msg = "Wrong code.";
        }
    }
}
?>
<!doctype html>
<html><body>
<h2>Unsubscribe from GitHub Timeline Emails</h2>
<?php if (!empty($msg)) echo "<p>$msg</p>"; ?>

<form method="POST">
  <label>Enter your email to unsubscribe:</label><br>
  <input type="email" name="unsubscribe_email" required>
  <button id="submit-unsubscribe">Unsubscribe</button>
</form>

<form method="POST">
  <label>Enter the unsubscribe code:</label><br>
  <input type="text" name="unsubscribe_verification_code">
  <button id="verify-unsubscribe">Verify</button>
</form>
</body></html>
