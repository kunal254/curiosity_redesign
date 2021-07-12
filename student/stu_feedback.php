<?php 
    require './student_header.php'; 
    $message="";
    $id=$_SESSION['stu']['stu_id'];

    if(isset($_POST['submit']))
    {
        
        $content=sanitize_data($_POST['feedback'], $conn);
        if(empty($content))
        {
            $message="<span class='text-danger'>Please complete the form</span><br>";
        }
        else
        {
            $sql="INSERT INTO feedback(content,stu_id) VALUES('$content',$id) ON DUPLICATE KEY UPDATE content='$content'";

            $result=$conn->query($sql);
            
            if($result == TRUE)
            {
                if($conn->affected_rows == 1)
                {
                    $message="<span class='text-success'>feedback Submitted !</span><br>";
                }
                else
                {
                    $message="<span class='text-success'>Feedback updated !</span><br>";
                }
            }
            else
            {
                $message="<span class='text-success'>An error occured :(</span><br>";
            }

        }

    }
    $sql="SELECT content FROM feedback WHERE stu_id='$id'";
    $result=$conn->query($sql);
    if($result->num_rows == 1)
    {
        $content=$result->fetch_assoc()['content'];
    }
    else
    {
        $content="";
    }

?>
<main>
<form action="" method="post"  autocomplete="off">
    <div class="form-group">
        <label>Student ID</label><br>
        <input type="text" value="<?php echo  $id ?>" disabled><br>
    </div>
    <div class="form-group">
        <label for="feedback">Write Feddback</label><br>
        <textarea style="resize: vertical;max-width:100%" name="feedback" id="feedback" rows="7"><?php echo  $content ?></textarea>
    </div>
    <?php echo  $message ?>
    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
    </form> 
</main>
<?php require './student_footer_script.php'; ?>
