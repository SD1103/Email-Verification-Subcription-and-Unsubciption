<?php
// src/cron.php

require_once __DIR__ . '/functions.php';


file_put_contents(__DIR__ . "/log.txt", "Cron ran at " . date("Y-m-d H:i:s") . PHP_EOL, FILE_APPEND);


sendGitHubUpdatesToSubscribers();
