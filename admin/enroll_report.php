<?php require './admin_header.php' ?>
<main>
    <form class="d-print-none mb-3" action="" method="get">
            <input type="date" name="from"><br>
            <span class="m-1 align-self-center">TO</span><br>
            <input type="date" name="to"><br>
            <button class="btn btn-success mt-2" name="submit" type="submit">Search</button>
    </form>

    <?php
    if (isset($_GET['submit'])) {
        $from = $_GET['from'];
        $to = $_GET['to'];
        $sql = "SELECT * FROM course_enroll WHERE enroll_date BETWEEN '$from' AND '$to'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h3>Enroll Details</h3>
            <div style='overflow-x: auto;' class='table'>
                <table class='table table-bordered'>
                    <tr>
                        <th>Enroll ID</th>
                        <th>Course ID</th>
                        <th>Student ID</th>
                        <th>Enroll Date</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>{$row['enroll_id']}</td>
                <td>{$row['course_id']}</td>
                <td>{$row['stu_id']}</td>
                <td>{$row['enroll_date']}</td>
                </tr>";
            }
            echo "</table>
                    </div>
            <button title='print report' class='d-print-none material-icons btn-primary' onclick='window.print()'>print</button>";
        } else {
            echo "<p class='text-danger'>No course enrolled between these dates !</p>";
            goto footer;
        }
    }
    ?>
</main>
<?php
footer:;
require './admin_footer_script.php'
?>