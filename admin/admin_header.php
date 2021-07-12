<?php
session_start();
if (empty($_SESSION['aid'])) {
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
        .report {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            text-align: center;
            font-weight: 700;
            font-family: monospace;
            font-size: 1.2rem;
        }

        .report div {
            border: 3px solid cyan;
            border-radius: 10px;
            width: 30%;
            padding: 10px 0;
        }

        .report a {
            text-decoration: none;
            color: royalblue;
        }

        main h2 {
            text-align: center;
        }

        table {
            margin: 0 auto;
        }

        table th {
            background-color: cyan;
        }

        .svg {
            padding: 5px 0;
            text-align: center;
        }

        td a {
            display: block;
        }
        a[href^="<?php echo $file_name; ?>"]{
            color: hsla(180, 93%, 35%, 0.857);
        }
        .add_btn {
            text-align: end;
        }

        .add_btn a {
            font-size: 3.5rem;
            padding: 10px;
        }

        .add_btn a:hover {
            text-decoration: none;
        }
    </style>
    <title>
        <?php
        switch ($file_name) {
            case 'admin_dashboard.php':
                echo "Dashboard";
                break;
            case 'admin_courses.php':
                echo "Courses";
                break;
            case 'admin_lessons.php':
                echo "Lessons";
                break;
            case 'admin_stu.php':
                echo "Students";
                break;
            case 'enroll_report.php':
                echo "Enrolls";
                break;
            case 'admin_feed.php':
                echo "Feedbacks";
                break;
            case 'admin_chPass.php':
                echo "Change Password";
                break;
            default:
                echo 'Curiosity';
        }
        ?>
    </title>
</head>

<body>
    <header class="d-print-none">
        <div class="nav_bar container">
            <a class="head_img" href="../index.php"><img src="../images/main_logo.png" alt="CURIOSITY"></a>

            <a class="logout" href="logout.php"><i class="material-icons">logout</i> Logout</a>

            <div class="menu">
                <svg class="ham hamRotate ham1" viewBox="0 0 100 100" width="60" onclick="this.classList.toggle('active')">
                    <path class="line top" d="m 30,33 h 40 c 0,0 9.044436,-0.654587 9.044436,-8.508902 0,-7.854315 -8.024349,-11.958003 -14.89975,-10.85914 -6.875401,1.098863 -13.637059,4.171617 -13.637059,16.368042 v 40" />
                    <path class="line middle" d="m 30,50 h 40" />
                    <path class="line bottom" d="m 30,67 h 40 c 12.796276,0 15.357889,-11.717785 15.357889,-26.851538 0,-15.133752 -4.786586,-27.274118 -16.667516,-27.274118 -11.88093,0 -18.499247,6.994427 -18.435284,17.125656 l 0.252538,40" />
                </svg>
            </div>
        </div>
    </header>
    <section id="sec" class="container">
        <aside>
            <h2 style="text-align: center;">Admin Panel</h2>
            <ul>
                <li><a href="admin_dashboard.php"><i class="material-icons">insert_chart</i> Dashboard</a></li>
                <li><a href="admin_courses.php"><i class="material-icons">local_library</i> Courses</a></li>
                <li><a href="admin_lessons.php"><i class="material-icons">library_books</i> Lessons</a></li>
                <li><a href="admin_stu.php"><i class="material-icons">groups</i> Students</a></li>
                <li><a href="enroll_report.php"><i class="material-icons">trending_up</i> Enroll Report</a></li>
                <li><a href="admin_feed.php"><i class="material-icons">question_answer</i> FeedBack</a></li>
                <li><a href="admin_chPass.php"><i class="material-icons">vpn_key</i> Change Password</a></li>
                <li class="bg-danger mt-3"><a class="text-white" href="logout.php"><i class="material-icons">logout</i> Logout</a></li>
            </ul>
        </aside>