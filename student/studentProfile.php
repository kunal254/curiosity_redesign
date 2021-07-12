<?php
require './student_header.php';
$message = "";
echo "<main>";
if (isset($_POST['stu_name'])) {
    //getting and sanitizing data
    $id = $_SESSION['stu']['stu_id'];
    $name = sanitize_data($_POST['stu_name'], $conn);
    $occ = sanitize_data($_POST['stu_occ'], $conn);
    
    $img = "";
    //if image is selected
    if (isset($_FILES['fileToUpload']) && !empty($_FILES['fileToUpload']['name'])) {
        $get_file = upload_img($id);
        if ($get_file !== false) {
            // if image is set build query for image file
            $img = ",stu_img='" . $get_file . "'";
            //and update session variable
            $_SESSION['stu']['stu_img'] = $get_file;
        }
    }
    $sql = "UPDATE student SET stu_name='$name',stu_occupation='$occ'" . $img . " WHERE stu_id=$id";

    if ($conn->query($sql) && $conn->affected_rows == 1) {
        $message = "<span class='text-success'>Profile Updated !</span><br>";
        //update session variable
        $_SESSION['stu']['stu_name'] = $name;
        $_SESSION['stu']['stu_occupation'] = $occ;
    } else {
        $message = "<span class='text-danger'>profile not updated :(</span><br>";
    }
}
//image uploader
function upload_img($id)
{

    $file_name = $id . rand(10, 1000) . basename($_FILES['fileToUpload']['name']);
    $target_location = "../images/stu_images/" . $file_name;

    if (getimagesize($_FILES['fileToUpload']['tmp_name']) === false) {
        return false;
    }

    if ($_FILES['fileToUpload']['size'] > 500000) {
        echo "<span class='text-danger'>CAN'T UPLOAD IMAGE BECAUSE SIZE IS TOO LARGE</span><br>";
        return false;
    }
    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_location)) {
        $p_img = $_SESSION['stu']['stu_img'];

        if ($p_img !== 'stu_default.png')
            unlink("../images/stu_images/" . $p_img);

        return $file_name;
    }
}
?>
    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">

        <div class="form-group">
            <label>Student ID</label><br>
            <input type="text" value="<?php echo  $_SESSION['stu']['stu_id'] ?>" disabled><br>
        </div>

        <div class="form-group">
            <label>Email</label><br>
            <input type="text" value="<?php echo  $_SESSION['stu']['stu_email'] ?>" disabled><br>
        </div>

        <div class="form-group">
            <label for="stu_name">Name</label><br>
            <input type="text" name="stu_name" id="stu_name" value="<?php echo  $_SESSION['stu']['stu_name'] ?>"><br>
        </div>

        <div class="form-group">
            <label for="stu_occ">Occupation</label><br>
            <input type="text" name="stu_occ" id="stu_occ" value="<?php echo  $_SESSION['stu']['stu_occupation'] ?>"><br>
        </div>

        <div class="form-group">
            <label for="up_img">Upload Image</label><br>
            <input type="file" name="fileToUpload" id="up_img"><br>
            <img class="mt-2" id="load_img" src="#" style="display:none;">
        </div>
        <?php echo  $message ?>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</main>
<script>
    document.title = "<?php echo  $_SESSION['stu']['stu_name'] . "'s profile" ?>";
    up_img.onchange = evt => {
        const [file] = up_img.files
        if (file) {
            load_img.style.display="block";
            load_img.src = URL.createObjectURL(file)
        }
    }
    user_profile_img.src="<?php echo  "../images/stu_images/".$_SESSION['stu']['stu_img'] ?>";
</script>
<?php require './student_footer_script.php'; ?>