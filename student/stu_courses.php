<?php
 require './student_header.php';
 $id=$_SESSION['stu']['stu_id'];

 echo "<main>";

 if(isset($_GET['delete']))
 {
     $c_id=$_GET['delete'];
     $sql="DELETE FROM course_enroll WHERE stu_id=$id AND course_id=$c_id";
     if($conn->query($sql))
        echo "<p style='text-align:center' class='text-success'>COURSE REMOVED !</p>";
        else
        echo "<p style='text-align:center' class='text-danger'>AN ERROR OCCURED !</p>";
 }

 $sql="SELECT * FROM course JOIN course_enroll USING(course_id) WHERE course_enroll.stu_id=$id";
 $result=$conn->query($sql);

    if($result->num_rows > 0 )
    {
        echo "<div class='flex-card'>";
        while($row = $result->fetch_assoc()){
            echo "<div class='mb-4' style='text-align:center;'>
            <img style='width: 260px; height:180px;object-fit:cover' src='../images/course_img/{$row['course_img']}' alt='course_img'>
            <div>
                <h4 class='mt-2'>{$row['course_name']}</h4>
                <p>{$row['course_desc']}</p>
                <p>Duration: {$row['course_dur']}</p>
                <p>Enroll Date: {$row['enroll_date']}</p>
                <p>Author : {$row['course_author']}</p>
                <div>
                <a class='btn btn-primary btn-sm' href='./watchcourse.php?id={$row['course_id']}' class='card-link'>Watch Course</a>
                <a class='btn btn-danger btn-sm' href='?delete={$row['course_id']}' class='card-link'>Remove Course</a>
                </div>
            </div>
        </div>";
        }
        echo "</div>";
    }
    else
    echo "<p style='text-align:center' class='text-danger'>you are not enrolled in any course, <a href='../courses.php'>enroll now !</a></p><br>";
?>
</main>
<?php require './student_footer_script.php'; ?>
