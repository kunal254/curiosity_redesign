<?php
    session_start();
    unset($_SESSION['stu']);
    header('Location: ../index.php');
?>