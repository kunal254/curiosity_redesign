<?php
session_start();
require './db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="shortcut icon" href="#">

    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Custom style_sheets -->
    <link rel="stylesheet" href="./css/nav-bar_drawer.css">
    <link rel="stylesheet" href="./css/home.css">
    <title>CURIOSITY</title>
</head>

<body>
    <?php require './header.php'; ?>

    <section class="hero">
        <div class="container hero-content_container">
            <div class="hero-content">
                <h1>Next Generation Explorer</h1>
                <p>Learn Physics, Computer Science And Other Enginnering Subjects</p>
                <?php
                    if(isset($_SESSION['stu']))
                        echo "<a href='./student/studentProfile.php'>My Profile</a>";
                    else
                        echo "<a id='start' href='#'>Get Started</a>";
                ?>
            </div>
        </div>
    </section>
    <section id="course_sec" class="courses">
        <div class="container">
            <h1 class="section_title">Popular Courses</h1>
            <div class="courses_container">
                <?php
                /* grouping the course_id column's data after join, 
                then counting each group after then order by desc and then choose the top 3
                */
                $sql="SELECT course.* FROM course 
                JOIN course_enroll USING(course_id) 
                GROUP BY course_id 
                ORDER BY COUNT(course_id) DESC LIMIT 3";

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc())
                        echo  "<div class='courses_card'>
                            <img src='./images/course_img/{$row['course_img']}' alt='c_image'>
                            <h3>{$row['course_name']}</h3>
                            <p>{$row['course_desc']}</p>
                            <a href='./coursedetails.php?id={$row['course_id']}'>Enroll</a>
                        </div>";
                }
                ?>
            </div>
            <div class="enroll">
                <a href="./courses.php">View All Courses</a>
            </div>
        </div>
    </section>
    <section id="feed_sec" class="feedback">
        <div class="container">
            <h1 class="section_title">Student's FeedBack</h1>
            <div id="fmove" class="feedback_container">
                <?php
                $sql = "SELECT content,stu_img,stu_name,stu_occupation FROM feedback JOIN student ON feedback.stu_id=student.stu_id";

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="feedback_card">
                            <p class="content"><?php echo  $row['content'] ?>
                            </p>
                            <img src="<?php echo  "./images/stu_images/" . $row['stu_img'] ?>" alt="">
                            <p class="user_name"><?php echo  $row['stu_name'] ?></p>
                            <p class="user_occ"><?php echo  $row['stu_occupation'] ?></p>
                        </div>
                <?php
                    }
                } else {
                    echo "<p style='margin:0 auto;'>No feedback yet :(</p>";
                }
                $conn->close();
                ?>
            </div>
            <div class=fsb>
                <button id="lf">&lt;</button>
                <button id="rt">&gt;</button>
            </div>
        </div>
    </section>

    <section id="footer_sec" class="All_footer">
        <div class="footer">
            <div class="stay_updated">
                <h2>Stay Updated</h2>
                <div class="social">
                    <span class="s_icons"><img src="./images/icons/facebook.svg" alt=""></span>
                    <span class="s_icons"><img src="./images/icons/twitter.svg" alt=""></span>
                    <span class="s_icons"><img src="./images/icons/whatsapp.svg" alt=""></span>
                    <span class="s_icons"><img src="./images/icons/instagram.svg" alt=""></span>
                </div>
            </div>
            <div class="footer_links">
                <h3>About Us</h3>
                <p>Lorem ipsum dolor, sit amet <br> consectetur adipisicing elit. <br> Quis, magni? Voluptas <br> dignissimos ea iusto eveniet?</p>
            </div>
            <div class="footer_links">
                <h3>Category</h3>
                <a href="">Web Development</a><br>
                <a href="">Web Desiging</a><br>
                <a href="">Android App Dev</a><br>
                <a href="">iOS Development</a><br>
                <a href="">Data Analysis</a>
            </div>
            <div class="footer_links">
                <h3>Contact Us</h3>
                <p>e-curiosity Pvt Ltd<br>
                    New Police Camp 4 <br>
                    Bokaro, Jharkhand <br>
                    ph. 8452390252
                </p>
            </div>
        </div>
        <div class="copyright">
            <p>Copyright <span>&copy;</span> 2020 | Designed by E-curiosity ||
                <?php
                if (isset($_SESSION['aid']))
                    echo "<a href='./admin/admin_dashboard.php'>Admin login</a>";
                else
                    echo "<a id='adm_log' href='#'>Admin login</a>";
                ?>
        </div>
    </section>

    <div id="modal">
        <div id="modal_content">
            <span id="close">&times;</span>
            <?php require './ad_modal.php' ?>
            <?php require './modal.php' ?>
        </div>
    </div>
    <script>
        /* =========
        feedback 
        ======== */
        var lf = document.getElementById('lf');
        var rt = document.getElementById('rt');
        var fmove = document.getElementById('fmove');
        lf.addEventListener('click', function() {

            fmove.scrollLeft += -300;
        });
        rt.addEventListener('click', function() {
            fmove.scrollLeft += 300;
        });
        //admin modal
        $('#adm_log').click(function() {
            $('#modal').show();
            $('#admin_modal').show();
        });
        //get started
        $('#start').click(function(event) {
            launch(this);
        });
        // admin login
        $('#admin_login').click(function(event) {
            event.preventDefault();
            $.ajax({
                url: "admin/auth.php",
                method: "POST",
                data: $('#admin_form').serialize(),
                success: function(data) {
                    data = JSON.parse(data);
                    $('#admin_span').text(data['details']);
                    if (data['status'] == 'success') {
                        window.location.href = './admin/admin_dashboard.php';
                    }
                }
            })
        });      
    </script>
    <script src="./js/home.js"></script>

</body>

</html>