<?php
session_start();
include_once('../db.php');

if (isset($_POST['admin_email']) && isset($_POST['admin_pass'])) {
    $email = sanitize_data($_POST['admin_email'],$conn);
    $pass = sanitize_data($_POST['admin_pass'],$conn);

    $sql = "SELECT admin_id,admin_email FROM admin WHERE admin_email='$email' AND admin_pass='$pass'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $token = $result->fetch_row();
        $_SESSION['aid'] = $token[0];
        $_SESSION['admin_email'] = $token[1];
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
function sanitize_data($data, $conn)
{
    $data = $conn->real_escape_string($data);
    $data = htmlspecialchars($data);
    return $data;
}