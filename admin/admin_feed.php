<?php
require './admin_header.php';
$info="";

if (isset($_GET['delete'])) {
    $f_id = $_GET['delete'];
    if (is_numeric($f_id)) {
        $sql="DELETE FROM feedback WHERE feedback_id=$f_id";
        if($conn->query($sql))
        {
            $info = "<span class='text-success'>feedback with id ".$f_id." deleted successfully !</span><br>";
        }
    } else {
        $info = "<span class='text-warning'>An error occured with this feedback :(</span><br>";
    }
}
?>
<main>
    <h2>List of Feedbacks</h2>
    <div style="overflow-x: auto;" class="table">
        <table class="table table-bordered">
            <tr>
                <th>FeedBack ID</th>
                <th>FeedBack</th>
                <th>Student ID</th>
                <th>Action</th>
            </tr>
            <?php
            $sql = "SELECT * FROM feedback";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
               echo "<tr>
                <td>{$row['feedback_id']}</td>
                <td>{$row['content']}</td>
                <td>{$row['stu_id']}</td>
                <td class='svg'><a href=?delete={$row['feedback_id']}><i class='material-icons'>delete_outline</i></a></td>
            </tr>";
                }
            }
            else
            {
                ?>
                <tr>
                    <td colspan="4">
                        NO FEEDBACK YET :(
                    </td>
                </tr>
                <?php
            }

            ?>
            
        </table>
    </div>
    <?php echo $info ?>
</main>
<?php require './admin_footer_script.php' ?>