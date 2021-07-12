# curiosity_redesign
 **Redesign of curiosity web app both front-end and back-end**
 
## Installation Details
 Clone REPO.  
 ```bash
 username@hostname:/var/www/html$ git clone https://github.com/kunal254/curiosity_redesign.git  
 ```
 
 Give permissions 
 ```bash
 username@hostname:/var/www/html$ sudo chmod -R 777 curiosity_redesign/
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
   If you get an error while importing curiosity.sql into your database server
   change **utf8mb4_0900_ai_ci** To **utf8_general_ci** in curiosity.sql file (use VScode change all occurence)

   ***See database for admin and user logins details, passwords are not encrypted.***  
   
## Screenshots
### home page :point_down:
![home page](https://github.com/kunal254/curiosity_redesign/blob/main/screens/HOME%20CURIOSITY.png)
### all courses :point_down:
![all courses](https://github.com/kunal254/curiosity_redesign/blob/main/screens/All%20Courses.png)
### user profile :point_down:
![user profile](https://github.com/kunal254/curiosity_redesign/blob/main/screens/user%20profile.png)
### admin dashboard :point_down:
![admin dashboard](https://github.com/kunal254/curiosity_redesign/blob/main/screens/Dashboard.png)
### responsive :see_no_evil:
![responsive](https://github.com/kunal254/curiosity_redesign/blob/main/screens/IMG_20210711_205656.jpg)

## task left 
* optimise home.js
* close mysqli connection $conn->close();
* linked list lessons 
