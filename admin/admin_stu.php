<?php
require './admin_header.php';
$info = "";
?>
<main>
    <?php
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $img = $_GET['img'];

        $result = $conn->query("DELETE FROM student WHERE stu_id=$id");
        if ($result) {
            if ($img != 'stu_default.png')
                unlink("../images/stu_images/" . $img);

            $info = "<span class='text-success'>student with id {$id} deleted successfully!</span><br>";
        } else {
            $info = "<span class='text-danger'>can't delete student with id {$id} right now :(</span><br>";
        }
    }

    if (isset($_GET['add']) || isset($_POST['add'])) {
        if (isset($_POST['add'])) {
            $MYSQLI_ERROR_DUPLICATE_KEY = 1062;
            //getting and sanitizing data
            $name = sanitize_data($_POST['stu_name'], $conn);
            $email = sanitize_data($_POST['stu_email'], $conn);
            $pass = sanitize_data($_POST['stu_pass'], $conn);


            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $info = "<span class='text-danger'>invalid email format</span><br>";
            } else {
                $sql = "INSERT INTO student(stu_name,stu_email,stu_pass) VALUES('$name','$email','$pass')";
                if ($conn->query($sql)) {
                    $info = "<span class='text-success'>student inserted !</span><br>";
                } else {
                    if ($conn->errno == $MYSQLI_ERROR_DUPLICATE_KEY)
                        $info = "<span class='text-danger'>email already exits</span><br>";
                    else
                        $info = "<span class='text-danger'>an error occured :(</span><br>";
                }
            }
        }
    ?>
        <h3>Add New Student</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Name</label><br>
                <input type="text" name="stu_name" id="name"><br>
            </div>

            <div class="form-group">
                <label for="email">Email</label><br>
                <input type="email" name="stu_email" id="email"><br>
            </div>

            <div class="form-group">
                <label for="pass">Password</label><br>
                <input type="text" name="stu_pass" id="pass"><br>
            </div>
            <?php echo $info ?>
            <button class="btn btn-primary" type="submit" name="add">Submit</button>
            <a href="admin_stu.php">Close</a>

        </form>
    <?php
    } else if (isset($_GET['edit']) || isset($_POST['edit'])) {
        if (isset($_GET['edit']))
            $id = $_GET['edit'];

        if (isset($_POST['edit'])) {
            $MYSQLI_ERROR_DUPLICATE_KEY = 1062;

            $id = $_POST['stu_id'];
            $name = sanitize_data($_POST['stu_name'], $conn);
            $email = sanitize_data($_POST['stu_email'], $conn);
            $occ = sanitize_data($_POST['stu_occ'], $conn);
            $pass = sanitize_data($_POST['stu_pass'], $conn);
            $img = sanitize_data($_POST['stu_img'], $conn);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $info = "<span class='text-danger'>invalid email format</span><br>";
            } else {
                $update_img = "";
                if (isset($_POST['reset_image'])) {
                    if ($img != 'stu_default.png')
                        unlink("../images/stu_images/" . $img);
                    $update_img = ", stu_img='stu_default.png'";
                }

                $sql = "UPDATE student SET stu_name='$name', stu_email='$email', stu_occupation='$occ', stu_pass='$pass'" . $update_img . " WHERE stu_id=$id";
                if ($conn->query($sql)) {
                    $info = "<span class='text-success'>student details updated !</span><br>";
                } else {
                    if ($conn->errno == $MYSQLI_ERROR_DUPLICATE_KEY)
                        $info = "<span class='text-danger'>email already exits</span><br>";
                    else
                        $info = "<span class='text-danger'>an error occured :(</span><br>";
                }
            }
        }
        $sql = "SELECT * FROM student WHERE stu_id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        } else {
            echo "ERROR !!!!!!";
            goto footer;
        }

    ?>
        <h3>Update Student Details</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label>student id</label><br>
                <input name="stu_id" value="<?php echo $row['stu_id']; ?>" readonly><br>
            </div>
            <div class="form-group">
                <label for="name">Name</label><br>
                <input type="text" name="stu_name" id="name" value="<?php echo $row['stu_name']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="email">student email</label><br>
                <input type="email" name="stu_email" id="email" value="<?php echo $row['stu_email']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="pass">Password</label><br>
                <input type="text" name="stu_pass" id="pass" value="<?php echo $row['stu_pass']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="occ">Occupation</label><br>
                <input type="text" name="stu_occ" id="occ" value="<?php echo $row['stu_occupation']; ?>"><br>
            </div>
            <div class="form-check mb-1">
                <input type="hidden" name="stu_img" value="<?php echo $row['stu_img']; ?>">
                <input type="checkbox" name="reset_image" class="form-check-input" id="reset_image">
                <label class="form-check-label" for="reset_image">reset image</label><br>
            </div>
            <?php echo $info ?>
            <button class="btn btn-primary" type="submit" name="edit">Submit</button>
            <a href="admin_stu.php">Close</a>

        </form>

    <?php
    } else {
    ?>
        <h2>List of Students</h2>
        <div style="overflow-x: auto;" class="table">
            <table class="table table-bordered">
                <tr>
                    <th>Students ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th colspan="2">Action</th>
                </tr>
                <?php
                $sql = "SELECT stu_id,stu_name,stu_email,stu_img FROM student";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['stu_id']}</td>
                            <td>{$row['stu_name']}</td>
                            <td>{$row['stu_email']}</td>
                            <td class='svg'><a href='?delete={$row['stu_id']}&img={$row['stu_img']}'><i class='material-icons'>delete_outline</i></a></td>
                            <td class='svg'><a href='?edit={$row['stu_id']}'><i class='material-icons'>edit</i></a></td>
                        </tr>";
                    }
                } else {

                    echo "<tr>
                        <td colspan='5'>
                            NO STUDENT YET :(
                        </td>
                    </tr>";
                }

                ?>
            </table>
        </div>
        <?php echo $info; ?>
        <div class="add_btn">
            <a href="?add" class="material-icons">add_circle</a>
        </div>
    <?php
    }
    ?>


</main>
<?php
footer:;
require './admin_footer_script.php'
?>