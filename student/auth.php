<?php
session_start();
require '../db.php';

/* =========
    student registration
    ========= */

if (isset($_POST['name'])) {
    $MYSQLI_ERROR_DUPLICATE_KEY = 1062;
    //getting and sanitizing data
    $name = sanitize_data($_POST['name'], $conn);
    $email = sanitize_data($_POST['email'], $conn);
    $pass = sanitize_data($_POST['pass'], $conn);

    //checking email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $data = array(
            "status" => "failed",
            "details" => "Invalid email format"
        );
        exit(json_encode($data));
    }

    //check whether all feilds are set
    if (empty($_POST['name']) || empty($_POST['email'])) {
        $data = array(
            "status" => "failed",
            "details" => "please fill all feilds"
        );
        exit(json_encode($data));
    }

    //query
    $sql = "INSERT INTO student(stu_name,stu_email,stu_pass) VALUES ('$name','$email','$pass')";

    //excuting and checking query
    if ($conn->query($sql)) {
        $data = array(
            "status" => "success",
            "details" => "Account Created Successfully"
        );
    } else {
        if ($conn->errno == $MYSQLI_ERROR_DUPLICATE_KEY) {
            $data = array(
                "status" => "failed",
                "details" => "Email already exits"
            );
        } else {
            $data = array(
                "status" => "failed",
                "details" => "An error Occured"
            );
        }
    }
    //echo the json result
    $json = json_encode($data);
    echo $json;
} else if (isset($_POST['stu_email'])) {
    /* =========
    student login
    ========= */
    $stu_email = sanitize_data(($_POST['stu_email']), $conn);
    $stu_pass = sanitize_data(($_POST['stu_pass']), $conn);

    $sql = "SELECT * FROM student WHERE stu_email='$stu_email' AND stu_pass='$stu_pass'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['stu'] = $result->fetch_assoc();
        unset($_SESSION['stu']['stu_pass']);
        $data = array(
            "status" => "success",
            "details" => "loggin you in...",
        );
    } else {
        $data = array(
            "status" => "failed",
            "details" => "email or password didn't match :(",
        );
    }
    $json = json_encode($data);
    echo $json;
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
