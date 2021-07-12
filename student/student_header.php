<?php
session_start();
if (empty($_SESSION['stu'])) {
    header("Location: ../index.php");
} else {
    require '../db.php';
    $file_name = basename($_SERVER['PHP_SELF']);
}
/*  =======
    sanitizer function 
    ========   */
    function sanitize_data($data, $conn)
    {
        $data = $conn->real_escape_string($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="shortcut icon" href="#">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/nav-bar_drawer.css">
    <link rel="stylesheet" href="../css/menu.css">
    <style>
        a[href^="<?php echo $file_name; ?>"]{
            color: hsla(180, 93%, 35%, 0.857);
        }
        .flex-card{
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
        }
        .flex-card>div{
            margin: 0 10px;
            max-width: 260px;
        }
        .videoWrapper {
            position: relative;
            /* relative to parent and not the element itself */
            padding-top: 56.25%;
        }
        .videoWrapper iframe{
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
        }
    </style>
    <title>
    <?php
        switch ($file_name) {
            // stu_profile title will set by js
            case 'stu_courses.php':
                echo "Courses";
                break;
            case 'stu_feedback.php':
                echo "FeedBack";
                break;
            case 'stu_ch_pass.php':
                echo "Change Password";
                break;
            default:
                echo 'Curiosity';
        }
        ?>
    </title>
</head>

<body>
    <header>
        <div class="nav_bar container">
            <a class="head_img" href="../index.php"><img src="../images/main_logo.png" alt="CURIOSITY"></a>

            <a class="logout" href="logout.php"><i class="material-icons">logout</i>  Logout</a>


            <div class="menu">
                <svg class="ham hamRotate ham1" viewBox="0 0 100 100" width="60"
                    onclick="this.classList.toggle('active')">
                    <path class="line top"
                        d="m 30,33 h 40 c 0,0 9.044436,-0.654587 9.044436,-8.508902 0,-7.854315 -8.024349,-11.958003 -14.89975,-10.85914 -6.875401,1.098863 -13.637059,4.171617 -13.637059,16.368042 v 40" />
                    <path class="line middle" d="m 30,50 h 40" />
                    <path class="line bottom"
                        d="m 30,67 h 40 c 12.796276,0 15.357889,-11.717785 15.357889,-26.851538 0,-15.133752 -4.786586,-27.274118 -16.667516,-27.274118 -11.88093,0 -18.499247,6.994427 -18.435284,17.125656 l 0.252538,40" />
                </svg>
            </div>
        </div>
    </header>
    <section id="sec"class="container">
        <aside>
            <a class="profile_img" href="studentProfile.php"><img id="user_profile_img" src="<?php echo  "../images/stu_images/".$_SESSION['stu']['stu_img'] ?>" alt="print _name"></a>

            <ul>

                <li><a href="studentProfile.php"><i class="material-icons">account_circle</i>Profile</a></li>

                <li><a  href="stu_courses.php"><i class="material-icons">local_library</i> My Courses</a></li>

                <li><a href="stu_feedback.php"><i class="material-icons">question_answer</i>FeedBack</a></li>

                <li><a href="stu_ch_pass.php"><i class="material-icons">vpn_key</i>Change Password</a></li>

                <li class="bg-danger mt-3"><a class="text-white" href="logout.php"><i class="material-icons">logout</i>Logout</a></li>

            </ul>
        </aside>
