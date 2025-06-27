XAMPP Control Panel is needed to be installed
As my project directory is C:\xampp\htdocs\GH-timeline\src

To register an email:
Open XAMPP Control Panel
Start Apache
Visit this URL-
http://localhost/GH-timeline/src/index.php
enter your email (e.g. souriktapal@gmail.com)
Click Submit
Open this file:
C:\xampp\htdocs\GH-timeline\src\log.txt
Find the 6-digit code 
enter the code and click verify
Now check the registered_emails.txt file the email will be present there

Manually Run the CRON:
Open Command Prompt and run:
C:\xampp\php\php.exe C:\xampp\htdocs\GH-timeline\src\cron.php
Now check log.txt again.
You’ll see:
A log of fake GitHub update emails sent to all registered users

To unsubscribe an email:
Open XAMPP Control Panel and start Apache
Visit the url-
http://localhost/GH-timeline/src/unsubscribe.php
Enter a registered email
Check log.txt → you’ll find a code
Enter that code → email will be removed from registered_emails.txt

I had the made the changes of the final code of my project in the already existing files of the src folder in the github provided by the company
