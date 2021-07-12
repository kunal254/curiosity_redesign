<?php 
    require './student_header.php'; 
    $info="";

if (isset($_POST['nPass'])) {
    $id = $_SESSION['stu']['stu_id'];
    $pass = $conn->real_escape_string($_POST['nPass']);

    if (empty($pass)) {
        $info = "<span class='text-info'>password field is empty !</span><br>";
    } else {
        $sql = "UPDATE student SET stu_pass='$pass' WHERE stu_id=$id";
        $conn->query($sql);
        if ($conn->affected_rows != -1) {
            $info = "<span class='text-success'>password changed succesfully !</span><br>";
        } else {
            $info = "<span class='text-danger'>An error occured :(</span><br>";
        }
    }
}
?>
<main>
<form action="" method="post"  autocomplete="off">
    <div class="form-group">
        <label>Email</label><br>
        <input type="text" value="<?php echo  $_SESSION['stu']['stu_email'] ?>" disabled><br>
    </div>
    <div class="form-group">
        <label for="nPass">New Password</label><br>
        <input type="text" name="nPass" id="nPass"><br>
    </div>
    <?php echo  $info ?>
    <button class="btn btn-primary" type="submit">Submit</button>
    <button class="btn btn-secondary" type="reset">Reset</button>
    </form> 
</main>
<?php require './student_footer_script.php'; ?>
