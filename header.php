<header>
    <div class="nav_bar container">
        <a class="head_img" href="./index.php"><img src="./images/main_logo.png" alt="CURIOSITY"></a>
        <ul class="nav_list">
            <li><a href="./index.php">Home</a></li>
            <li><a href="./index.php#course_sec">Courses</a></li>
            <li><a href="./index.php#feed_sec">FeedBack</a></li>
            <li><a href="./index.php#footer_sec">Contact us</a></li>
            <?php
            if (isset($_SESSION['stu']))
                echo "<li class='profile_img'><a href='./student/studentProfile.php'><img src='./images/stu_images/" . $_SESSION['stu']['stu_img'] . "' alt='print _name'></a></li>";
            else
                echo "<li> <a id='get_login' href='#'>Login</a></li>";
            ?>
        </ul>
        <div class="menu">
            <svg class="ham hamRotate ham1" viewBox="0 0 100 100" width="60" onclick="this.classList.toggle('active')">
                <path class="line top" d="m 30,33 h 40 c 0,0 9.044436,-0.654587 9.044436,-8.508902 0,-7.854315 -8.024349,-11.958003 -14.89975,-10.85914 -6.875401,1.098863 -13.637059,4.171617 -13.637059,16.368042 v 40" />
                <path class="line middle" d="m 30,50 h 40" />
                <path class="line bottom" d="m 30,67 h 40 c 12.796276,0 15.357889,-11.717785 15.357889,-26.851538 0,-15.133752 -4.786586,-27.274118 -16.667516,-27.274118 -11.88093,0 -18.499247,6.994427 -18.435284,17.125656 l 0.252538,40" />
            </svg>
        </div>
    </div>
</header>