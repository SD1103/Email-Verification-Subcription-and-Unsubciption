<?php

function generateVerificationCode() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

function registerEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    $list = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
    if (!in_array($email, $list)) {
        file_put_contents($file, $email . PHP_EOL, FILE_APPEND);
    }
}

function unsubscribeEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    $list = file($file, FILE_IGNORE_NEW_LINES);
    $list = array_filter($list, fn($e) => trim($e) !== trim($email));
    file_put_contents($file, implode(PHP_EOL, $list) . PHP_EOL);
}

function sendVerificationEmail($email, $code) {
    $subject = "Your Verification Code";
    $msg = "<p>Your verification code is: <strong>$code</strong></p>";

    // Log to log.txt instead of using mail()
    file_put_contents(__DIR__ . '/log.txt',
        "FAKE EMAIL to: $email\nSubject: $subject\n$msg\n\n",
        FILE_APPEND
    );
}

function fetchGitHubTimeline() {
    // Static fake data (you can replace with real fetch later)
    return [
        ['event' => 'Push', 'user' => 'testuser']
    ];
}

function formatGitHubData($items) {
    $html = "<h2>GitHub Timeline Updates</h2>";
    $html .= "<table border='1'><tr><th>Event</th><th>User</th></tr>";
    foreach ($items as $i) {
        $html .= "<tr><td>{$i['event']}</td><td>{$i['user']}</td></tr>";
    }
    $html .= "</table>";
    return $html;
}

function sendGitHubUpdatesToSubscribers() {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
    $html = formatGitHubData(fetchGitHubTimeline());

    foreach ($emails as $e) {
        $link = "http://localhost/GH-timeline/src/unsubscribe.php?email=" . urlencode($e);
        $body = $html . "<p><a href='$link' id='unsubscribe-button'>Unsubscribe</a></p>";

        // Log instead of sending
        file_put_contents(__DIR__ . '/log.txt',
            "FAKE EMAIL to: $e\nSubject: Latest GitHub Updates\n$body\n\n",
            FILE_APPEND
        );
    }

    // Log CRON execution
    file_put_contents(__DIR__ . '/log.txt',
        "Cron ran at " . date("Y-m-d H:i:s") . "\n",
        FILE_APPEND
    );
}
