#!/bin/bash
CRON="*/5 * * * * php /absolute/path/to/GH-timeline/src/cron.php"
(crontab -l 2>/dev/null; echo "$CRON") | crontab -
echo "Cron job added"
