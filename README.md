# curiosity_redesign
 **Redesign of curiosity web app both front-end and back-end**
 
## Installation Details
 Navigate to /var/www/html and then, Clone REPO.  
 ```bash
 sudo git clone https://github.com/kunal254/curiosity_redesign.git  
 ```
 
 Give permissions 
 ```bash
 sudo chmod -R 777 curiosity_redesign/
 ```
 
 Setup database  
 ```sql
 CREATE DATABASE curiosity;  
 ```
 ```sql
 CREATE USER 'start'@'localhost' IDENTIFIED BY 'jetnasalab';  
 ```
 ```sql
 GRANT ALL ON curiosity.* TO 'start'@'localhost';  
 ```
   
   In linux, apache(no xampp)
   ```bash
   mysql -u 'start' -p curiosity < /var/www/html/curiosity_redesign/curiosity.sql  
   ```
   ### ERRORS
   If you get an error while importing curiosity.sql into your database server, 
   change **utf8mb4_0900_ai_ci** To **utf8_general_ci** and **utf8mb4** To **utf8** in curiosity.sql file (use VScode change all occurence)

   ***See database for admin and user login details, passwords are not encrypted.***  
   
## Screenshots
### home page :point_down:
<kbd>![home page](https://github.com/kunal254/curiosity_redesign/blob/main/screens/HOME%20CURIOSITY.png)</kbd>
### all courses :point_down:
<kbd>![all courses](https://github.com/kunal254/curiosity_redesign/blob/main/screens/All%20Courses.png)</kbd>
### user profile :point_down:
<kbd>![user profile](https://github.com/kunal254/curiosity_redesign/blob/main/screens/user%20profile.png)</kbd>
### admin dashboard :point_down:
<kbd>![admin dashboard](https://github.com/kunal254/curiosity_redesign/blob/main/screens/Dashboard.png)</kbd>
### responsive :see_no_evil:
<kbd>![responsive](https://github.com/kunal254/curiosity_redesign/blob/main/screens/IMG_20210711_205656.jpg)</kbd>

## task left 
* optimise home.js
* look for mysqli open connections, then $conn->close();
* linked list lessons 
