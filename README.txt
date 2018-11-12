https://github.com/afl294/PHP_Image_Resize

1. Create a folder named "afl294" in your /www directory
2. Put all files into the "afl294" folder in your /www
3. Create a new database via localhost/phpmyadmin named "afl294"
4. Click on the new database, then import the afl294.sql file
5. Make sure the database username is "root" and password is "" (empty)
(If you need to change the username+password for your local database, edit it at the top of base.php)
6. In your browser, go to the url "localhost/afl294/index.php"
7. Log in with 
Username: test
Password: test
8. Upload an image file, set the width and height, then press upload
9. Your new file will be saved and viewable on localhost/afl294/home.php

(Optional)
10. Logout by clicking the logout link or go to localhost/afl294/logout.php
11. Create a new account on localhost/afl294/index.php

Security:
1. Hash + Salt passwords
I used stored a sha512 of the cleartext password + a random salt into the database so that way even if the database information is compromised, hackers would not be able to identify users passwords

2. Prepared MySQL statements
Prepared mysql statements prevent SQL injection attacks by not allowing any potential dangerous code to be injected from user input. The PHP/MYSQL prepared statement syntax which I used automatically prevents SQL injection from user input.

3. Log in Token Expiration
After a successful login, the code stores a random string login "token" into the users session cookie data which allows them to log in for an hour. After an hour, the token will expire and the user will have to log in again. This prevents hackers from gaining access to user accounts by stealing the tokens because even if they get the tokens, chances are they will be expired by the time the hacker can do anything with it. 

4. Log in token checks
All secure php files are protected by a login check "check_login_token()" which only allows that page to be accessed if the user is logged in with a valid token

5. Max login attempts
The code implements a max login attempt check which only allows for 5 failed login attempts within 1 hour. If the user fails to log in 5 times, they will be locked out for an hour. This prevents people from being able to brute force guess passwords because it would take way too long.

