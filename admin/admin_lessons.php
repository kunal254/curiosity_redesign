<?php
require './admin_header.php';
$info = "";
?>
<main>
    <?php
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        $sql = "DELETE FROM lesson WHERE lesson_id=$id";
        if ($conn->query($sql))
            $info = "<span class='text-success'>lesson with id {$id} deleted successfully!</span><br>";
        else
            $info = "<span class='text-danger'>can't delete lesson with id {$id} right now :(</span><br>";
    }
    // LESSON ADD
    if (isset($_GET['add']) || isset($_POST['add'])) {
        $c_id = $_GET['add'];
        if (isset($_POST['add'])) {
            $c_id = $_POST['course_id'];
            $name = sanitize_data($_POST['lesson_name'], $conn);
            $url = sanitize_data($_POST['lesson_url'], $conn);

            $sql = "INSERT INTO lesson(lesson_name,lesson_yt_url,course_id) VALUES('$name','$url',$c_id)";
            if ($conn->query($sql))
                $info = "<span class='text-success'>lesson added successfully ! </span><br>";
            else
                $info = "<span class='text-danger'>An error occured :(</span><br>";
        }
    ?>
        <h3>Add New Lesson</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label>Course ID</label><br>
                <input type="number" name="course_id" value="<?php echo $c_id; ?>" readonly><br>
            </div>

            <div class="form-group">
                <label for="lesson_name">Lesson Name</label><br>
                <input type="text" name="lesson_name" id="lesson_name" placeholder="name"><br>
            </div>

            <div class="form-group">
                <label for="url">Lesson url(https://youtu.be/<b style="color: blue">zFZrkCIc2Oc</b>)</label><br>
                <input type="text" name="lesson_url" id="url" placeholder="zFZrkCIc2Oc">
            </div>
            <?php echo $info ?>
            <button class="btn btn-primary" type="submit" name="add">Submit</button>
            <a href="admin_lessons.php?checkid=<?php echo $c_id; ?>">Close</a>
        </form>
    <?php
    } else if (isset($_GET['edit']) || isset($_POST['edit'])) {

        if (isset($_POST['edit'])) {
            $l_id = $_POST['lesson_id'];
            $c_id = $_POST['course_id'];
            $name = sanitize_data($_POST['lesson_name'], $conn);
            $url = sanitize_data($_POST['lesson_url'], $conn);

            $sql = "UPDATE lesson SET lesson_name='$name', lesson_yt_url='$url' WHERE lesson_id=$l_id";
            if ($conn->query($sql))
                $info = "<span class='text-success'>lesson details updated !</span><br>";
            else
                $info = "<span class='text-danger'>an error occured :(</span><br>";
        } else {
            $l_id = $_GET['edit'];
            $c_id = $_GET['checkid'];
        }
        $sql = "SELECT * FROM lesson WHERE lesson_id=$l_id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1)
            $row = $result->fetch_assoc();
        else {
            echo "ERROR !!!!!!";
            goto footer;
        }
    ?>
        <h3>Update Lesson Details</h3>
        <form action="" method="POST">
            <input type="number" name="course_id" value="<?php echo $c_id; ?>" hidden>
            <div class="form-group">
                <label>lesson id</label><br>
                <input name="lesson_id" value="<?php echo $row['lesson_id']; ?>" readonly><br>
            </div>
            <div class="form-group">
                <label for="name">lesson Name</label><br>
                <input type="text" name="lesson_name" id="name" value="<?php echo $row['lesson_name']; ?>"><br>
            </div>
            <div class="form-group">
                <label for="url">Lesson url(https://youtu.be/<b style="color: blue">zFZrkCIc2Oc</b>)</label><br>
                <input type="text" name="lesson_url" id="url" value="<?php echo $row['lesson_yt_url']; ?>">
                <span class="text-primary" style="cursor: pointer;">preview</span>
            </div>

            <iframe id="youtube" width="420px" height="200px" src="https://www.youtube.com/embed/<?php echo $row['lesson_yt_url']; ?>" frameborder="0">
            </iframe> <br>

            <?php echo $info; ?>
            <button class="btn btn-primary" type="submit" name="edit">Submit</button>
            <a href="admin_lessons.php?checkid=<?php echo $c_id; ?>">Close</a>

        </form>
        <script>
            url.onchange = evt => {
                let src = evt.target.value;
                youtube.src = `https://www.youtube.com/embed/${src}`;
            }
        </script>
    <?php
    } else {
    ?>
        <form action="" method="get">
            <div class="input-group mb-3">
                <input name="checkid" type="text" placeholder="course id">
                <button class="btn btn-success input-group-append" type="submit">Search</button>
            </div>
        </form>
        <?php
        if (isset($_GET['checkid'])) {
            $c_id = $_GET['checkid'];
            $result = $conn->query("SELECT course_id,course_name FROM course WHERE course_id='$c_id'");
            if ($result->num_rows != 1) {
                echo "<span class='text-danger'>Course doesn't exit</span>";
            } else {
                $row = $result->fetch_assoc();
        ?>

                <h3>Course ID: <?php echo $row['course_id'] . " | Course Name: " . $row['course_name']; ?></h2>
                    <div style="overflow-x: auto;" class="table">
                        <table class="table table-bordered">
                            <tr>
                                <th>Lesson ID</th>
                                <th>Lesson Name</th>
                                <th>Lesson URL</th>
                                <th colspan="2">Action</th>
                            </tr>
                            <?php
                            $sql = "SELECT lesson_id,lesson_name,lesson_yt_url FROM lesson WHERE course_id='$c_id'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                <td>{$row['lesson_id']}</td>
                                <td>{$row['lesson_name']}</td>
                                <td>{$row['lesson_yt_url']}</td>
                                <td class='svg'><a href='?delete={$row['lesson_id']}&checkid={$c_id}'><i class='material-icons'>delete_outline</i></a></td>
                                <td class='svg'><a href='?edit={$row['lesson_id']}&checkid={$c_id}'><i class='material-icons'>edit</i></a></td>
                            </tr>";
                                }
                            } else
                                echo "<tr><td colspan='5'>NO LESSON YET :(</td></tr>";

                            ?>
                        </table>
                    </div>
                    <?php echo $info; ?>
                    <div class="add_btn">
                        <a href="?add=<?php echo $c_id; ?>" class="material-icons">add_circle</a>
                    </div>
        <?php
            }
        }
    }
        ?>

</main>
<?php
footer: ;
require './admin_footer_script.php'
?>