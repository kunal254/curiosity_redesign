<?php require './admin_header.php' ?>
        <main>
            <div class="report">
                <div class="c_report">
                    <p>Courses</p>
                    <p><?php echo $conn->query("SELECT course_id FROM course")->num_rows ?></p>
                    <a href="./admin_courses.php">View</a>
                </div>
                <div class="s_report">
                <p>Students</p>
                    <p><?php echo $conn->query("SELECT stu_id FROM student")->num_rows ?></p>
                    <a href="./admin_stu.php">View</a>
                </div>
                <div class="e_report">
                <p>Enrolls</p>
                    <p><?php echo $conn->query("SELECT enroll_id FROM course_enroll")->num_rows ?></p>
                    <a href="./enroll_report.php">View</a>
                </div>
            </div>
            <h2 class="mt-5">Course Enrolled</h2>
            <div style="overflow-x: auto;" class="table">
                <table class="table table-bordered">
                    <tr>
                        <th>Enroll ID</th>
                        <th>Course ID</th>
                        <th>Student Email</th>
                        <th>Enroll Date</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $info="";
                    if(isset($_GET['delete']))
                    {
                        $id=$_GET['delete'];
                        $sql="DELETE FROM course_enroll WHERE enroll_id=$id";
                        if($conn->query($sql) && $conn->affected_rows == 1)
                            $info="<span class='text-success'>Removed !</span><br>";
                        else
                            $info="<span class='text-danger'>can't removed</span><br>";
                    }
                    $sql="SELECT enroll_id,course_id,stu_email,enroll_date FROM course_enroll JOIN student USING(stu_id)";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0)
                    {
                        while($row = $result->fetch_assoc())
                        echo "<tr>
                        <td>{$row['enroll_id']}</td>
                        <td>{$row['course_id']}</td>
                        <td>{$row['stu_email']}</td>
                        <td>{$row['enroll_date']}</td>
                        <td class='svg'><a href='?delete={$row['enroll_id']}'><i class='material-icons'>delete_outline</i></a></td>
                        </tr>";
                    }
                    else
                        echo "<tr><td colspan='5'>NO ENROLLS YET :(</td></tr>"
                    ?>
                </table>
            </div>
            <?php echo $info ?>
        </main>
<?php require './admin_footer_script.php' ?>