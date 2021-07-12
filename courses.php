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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/nav-bar_drawer.css">
    <link rel="stylesheet" href="./css/home.css">
    <style>
        h1 {
            text-align: center;
            padding: 20px 0;
        }

        .card-container {
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .card
        {
            text-align: center;
            min-width: 200px;
            max-width: 250px;
            margin-bottom: 10px;
        }
        #close{
            font-size: 2em;
        }

    </style>
    <title>All Courses</title>
</head>

<body>
    <?php require './header.php'; ?>

    <section class="container">
        <h1>All Courses</h1>
        <div class="card-container mb-5">
            <?php
            $result = $conn->query("SELECT * FROM course");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card'>
                    <img style='max-width: 300px;margin:auto' class='card-img-top' src='./images/course_img/{$row['course_img']}' alt='course_img'>
                    <div class='card-body'>
                        <h3 class='card-title'>{$row['course_name']}</h3>
                        <p class='card-text'>{$row['course_desc']}</p>
                        <p class='card-text'>{$row['course_author']}</p>
                        <p class='card-text'>{$row['course_dur']}</p>
                        <a style='display: block;' class='btn btn-primary' href='./coursedetails.php?id={$row['course_id']}' class='card-link'>Enroll Now</a>
                    </div>
                </div>";
                }
            }
            ?>
        </div>
    </section>

    <div id="modal">
        <div id="modal_content">
            <span id="close">&times;</span>
            <?php require './modal.php' ?>
        </div>
    </div>

    <script src="./js/home.js"></script>

</body>

</html>