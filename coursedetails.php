<?php
session_start();
if (!empty($_GET['id']))
    require './db.php';
else
    header("Location: ./index.php");
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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="./css/nav-bar_drawer.css">
    <link rel="stylesheet" href="./css/home.css">
    <style>
        .c_detail {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .c_detail img {
            min-width: 250px;
            width: 30%;
            max-width: 300px;
        }

        .about_course {
            width: 60%;
        }

        .l_detail {
            margin-top: 40px;
        }

        table th {
            background-color: cyan;
        }
        #close{
            font-size: 2em;
        }

        @media (max-width:960px) {
            .c_detail {
                flex-direction: column;
                align-items: center;
            }

            .c_detail img {
                width: 100%;
            }

            .about_course {
                width: 100%;
                text-align: center;
            }

            .l_detail table {
                margin: 40px auto;
            }

            h2 {
                margin-top: 20px;
            }
        }
    </style>
    <title>Document</title>
</head>

<body>
    <?php require './header.php'; ?>

    <section class="container">
        <div class="c_detail">
            <?php
            $info = "";

            if (isset($_GET['enroll'])) {
                if ($_GET['enroll'] !== $_GET['id'])
                {
                    echo "<span class='text-danger'>AN ERROR OCCURED :(</span>";
                    goto footer;
                }
                    

                else {
                    if (isset($_SESSION['stu'])) {
                        $c_id = $_GET['id'];
                        $s_id = $_SESSION['stu']['stu_id'];

                        $result = $conn->query("SELECT enroll_date FROM course_enroll WHERE course_id=$c_id AND stu_id=$s_id");

                        if ($result->num_rows == 1)
                            $info = "<b class='text-info'>you alreay taken this course on " . $result->fetch_assoc()['enroll_date'] . " <a href='./student/watchcourse.php?id=" . $c_id . "'>Watch Now</a></b>";

                        else {
                            $date = date("Y-m-d");
                            $sql = "INSERT INTO course_enroll(enroll_date,course_id,stu_id) VALUES('$date',$c_id,$s_id)";

                            if ($conn->query($sql))
                                $info = "<b class='text-success'>course added successfully <a href='./student/watchcourse.php?id=" . $c_id . "'>Watch Now</a></b>";
                            else
                                $info = "<b class='text-danger'>An error occured :(</b>";
                        }
                    } else
                        $info = "<b class='text-danger'>you need to log in first</b>";
                }
            }

            $id = $_GET['id'];
            if (is_numeric($id)) {
                $result = $conn->query("SELECT * FROM course WHERE course_id=$id");
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    echo "<img src='./images/course_img/{$row['course_img']}' alt='course_img'>
                        <div class='about_course'>
                            <h2>Course Name: {$row['course_name']}</h2>
                            <p>{$row['course_desc']}</p>
                            <p>Duration: {$row['course_dur']}</p>
                            <p>Author: {$row['course_author']}</p>
                            <a href='?id={$row['course_id']}&enroll={$row['course_id']}' class='btn btn-primary'>Enroll Now</a><br>
                            {$info}
                        </div>";
                } else
                    $err = "<span class='text-danger'>COURSE NOT FOUND !</span>";
            } else
                $err = "<span class='text-danger'>COURSE NOT FOUND !</span>";

            if (isset($err))
            {
                echo $err;
                goto footer;
            }
            ?>
        </div>

        <div class="l_detail">
            <table class="table table-bordered">
                <tr>
                    <th>Lesson ID</th>
                    <th>Lesson Name</th>
                </tr>
                <?php
                $result = $conn->query("SELECT lesson_id,lesson_name FROM lesson WHERE course_id=$id");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                         <td>{$row['lesson_id']}</td>
                         <td>{$row['lesson_name']}</td>
                         </tr>";
                    }
                } else
                    echo "<tr>
                    <td style='color:red' colspan='2'>NO LESSON IN THIS COURSE RIGHT NOW :(</td>
                 </tr>";
                ?>
            </table>
        </div>
    </section>
<?php 
footer: ;
?>

    <div id="modal">
        <div id="modal_content">
            <span id="close">&times;</span>
            <?php require './modal.php' ?>
        </div>
    </div>

    <script src="./js/home.js"></script>

</body>

</html>