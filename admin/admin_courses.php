<?php
require './admin_header.php';
$info = "";

//image uploader
function upload_img()
{

    $file_name = rand(10, 1000) . basename($_FILES['fileToUpload']['name']);
    $target_location = "../images/course_img/" . $file_name;

    if (getimagesize($_FILES['fileToUpload']['tmp_name']) === false) {
        return false;
    }

    if ($_FILES['fileToUpload']['size'] > 1000000) {
        echo "<span class='text-danger'>CAN'T UPLOAD IMAGE BECAUSE SIZE IS TOO LARGE</span><br>";
        return false;
    }
    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_location)) {
        return $file_name;
    } else return false;
}
?>
<main>
    <?php
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $img = $_GET['img'];

        $result = $conn->query("DELETE FROM course WHERE course_id=$id");
        if ($result) {
            unlink("../images/course_img/" . $img);

            $info = "<span class='text-success'>course with id {$id} deleted successfully!</span><br>";
        } else {
            $info = "<span class='text-danger'>can't delete course with id {$id} right now :(</span><br>";
        }
    }
    // COURSE ADD
    if (isset($_GET['add']) || isset($_POST['add'])) {
        if (isset($_POST['add'])) {

            $name = sanitize_data($_POST['name'], $conn);
            $author = sanitize_data($_POST['author'], $conn);
            $desc = sanitize_data($_POST['desc'], $conn);
            $dur = sanitize_data($_POST['dur'], $conn);

            if (empty($_FILES['fileToUpload']['name'])) {
                $info = "<span class='text-danger'>please select an image</spna><br>";
            } else {
                $img = upload_img();
                if ($img !== FALSE) {
                    $sql = "INSERT INTO course(course_name,course_author,course_desc,course_dur,course_img)  VALUES ('$name','$author','$desc','$dur','$img')";
                    if ($conn->query($sql))

                        $info = "<span class='text-success'>course added successfully !</spna><br>";

                    else
                        $info = "<span class='text-danger'>An error occured :(</spna><br>";
                } else

                    $info = "<span class='text-danger'>problem while uploading image</spna><br>";
            }
        }

    ?>
        <h3>Add New Course</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Course Name</label><br>
                <input type="text" name="name" id="name"><br>
            </div>

            <div class="form-group">
                <label for="auth">Author</label><br>
                <input type="text" name="author" id="auth"><br>
            </div>

            <div class="form-group">
                <label for="desc">Course Description</label><br>
                <textarea name="desc" id="desc" cols="40" rows="5"></textarea><br>
            </div>

            <div class="form-group">
                <label for="dur">Course Duration</label><br>
                <input type="text" name="dur" id="dur"><br>
            </div>

            <div class="form-group">
                <label for="up_img">Course Image</label><br>
                <input type="file" name="fileToUpload" id="up_img"><br>
                <img class="mt-2" id="load" src="#" style="display:none;">
            </div>
            <?php echo $info ?>
            <button class="btn btn-primary" type="submit" name="add">Submit</button>
            <a href="admin_courses.php">Close</a>

        </form>
        <script>
            up_img.onchange = evt => {
                const [file] = up_img.files
                if (file) {
                    load.style.display = "block";
                    load.style.width = "50%";
                    load.src = URL.createObjectURL(file)
                }
            }
        </script>
    <?php
    } else if (isset($_GET['edit']) || isset($_POST['edit'])) {
        if (isset($_GET['edit']))
            $id = $_GET['edit'];

        if (isset($_POST['edit'])) {

            $id = $_POST['course_id'];
            $name = sanitize_data($_POST['name'], $conn);
            $author = sanitize_data($_POST['author'], $conn);
            $desc = sanitize_data($_POST['desc'], $conn);
            $dur = sanitize_data($_POST['dur'], $conn);
            $img = "";

            if (!empty($_FILES['fileToUpload']['name'])) {
                $pre_img = $_POST['course_img'];
                $get_img = upload_img();
                if ($get_img !== FALSE) {
                    $img = ", course_img='" . $get_img . "'";
                    unlink("../images/course_img/" . $pre_img);
                } else {
                    $info = "<span class='text-danger'>problem while uploading image</spna><br>";
                }
            }

                $sql = "UPDATE course SET course_name='$name', course_author='$author', course_desc='$desc', course_dur='$dur'" . $img . " WHERE course_id=$id";
                if ($conn->query($sql)) {
                    $info = "<span class='text-success'>course details updated !</span><br>";
                } else {
                    $info = "<span class='text-danger'>an error occured :(</span><br>";
                }
            }
        $sql = "SELECT * FROM course WHERE course_id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        } else {
            echo "ERROR !!!!!!";
            goto footer;
        }

    ?>
        <h3>Update Student Details</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>course id</label><br>
                <input name="course_id" value="<?php echo $row['course_id']; ?>" readonly><br>
            </div>
            <div class="form-group">
                <label for="name">Course Name</label><br>
                <input type="text" name="name" id="name" value="<?php echo $row['course_name']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="author">author</label><br>
                <input type="text" name="author" id="author" value="<?php echo $row['course_author']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="desc">Description</label><br>
                <textarea name="desc" id="desc" cols="30" rows="10"><?php echo $row['course_desc']; ?></textarea><br>
            </div>
            <div class="form-group">
                <label for="dur">Duration</label><br>
                <input type="text" name="dur" id="dur" value="<?php echo $row['course_dur']; ?>"><br>
            </div>

            <div class="form-group">
                <input type="hidden" name="course_img" value="<?php echo $row['course_img']; ?>">
                <label for="up_img">Course Image</label><br>
                <img style="width: 50%;" id="load" src="<?php echo "../images/course_img/" . $row['course_img']; ?>"><br>
                <input class="mt-2" type="file" name="fileToUpload" id="up_img"><br>
            </div>

            <?php echo $info; ?>
            <button class="btn btn-primary" type="submit" name="edit">Submit</button>
            <a href="admin_courses.php">Close</a>

        </form>
        <script>
            up_img.onchange = evt => {
                const [file] = up_img.files
                if (file) {
                    load.src = URL.createObjectURL(file)
                }
            }
        </script>

    <?php
    } else {
    ?>
        <h2>List of Courses</h2>
        <div style="overflow-x: auto;" class="table">
            <table class="table table-bordered">
                <tr>
                    <th>Course ID</th>
                    <th>Name</th>
                    <th>Author</th>
                    <th colspan="2">Action</th>
                </tr>
                <?php
                $sql = "SELECT course_id,course_name,course_author,course_img FROM course";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['course_id']}</td>
                            <td>{$row['course_name']}</td>
                            <td>{$row['course_author']}</td>
                            <td class='svg'><a href='?delete={$row['course_id']}&img={$row['course_img']}'><i class='material-icons'>delete_outline</i></a></td>
                            <td class='svg'><a href='?edit={$row['course_id']}'><i class='material-icons'>edit</i></a></td>
                        </tr>";
                    }
                } else {
                   echo "<tr>
                        <td colspan='5'>
                            NO COURSE YET :(
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
footer: ;
require './admin_footer_script.php' 
?>