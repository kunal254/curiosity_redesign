<?php 
    require './student_header.php';
    echo "<main>";
    $err_message="<p style='text-align:center' class='text-danger'>An error occured :(</p>";
    $err=1;

    if(isset($_GET['id']) && is_numeric($_GET['id']))
    {
        require '../db.php';

        $c_id=$_GET['id'];
        $id=$_SESSION['stu']['stu_id'];
        $result=$conn->query("SELECT course_id FROM course_enroll WHERE course_id=$c_id AND stu_id=$id");

        //if course exit with that id and current loged in user is enrolled into that course
        if($result->num_rows == 1)
        {
            $result=$conn->query("SELECT lesson_name,lesson_yt_url FROM lesson WHERE course_id=$c_id");
            if($result->num_rows > 0)
            {
                //everything is ok
                $err=0;
                $data=array();
                while($row = $result->fetch_assoc())
                {
                    array_push($data,$row);
                }
            }
            else
            $err_message="<p style='text-align:center' class='text-danger'>There is no lesson in this course right now, <a href='../courses.php'>TRY ANOTHER</a></p>";

        }
    }
    if($err)
    {
        echo $err_message;
        goto footer;

    }
        
?>
   <!--youtube player inside iframe-->
    <div class="videoWrapper">
        <iframe id="video" frameborder="0"></iframe>
    </div>
    <h3 id="lesson" style="text-align: center; color:black;" class="p-2"></h3>
    <!-- pagination -->
    <ul class="mt-2 pagination justify-content-center">
    </ul>
</main>
<script>
    //intial data
    const embed="https://www.youtube.com/embed/";
    const rows=<?php echo json_encode($data); ?>;
    
    // constructing pagination
    const parent=document.getElementsByClassName('pagination')[0];
    let ele_to_insert="";
    let i=0;
    while(rows[i++]){
        ele_to_insert += "<li class='page-item'><a class='page-link' href='#'>"+i+"</a></li>";
    }
    parent.innerHTML=ele_to_insert;
    
    //intializing the first lesson
    let lists=document.getElementsByClassName('page-item');
    updateLesson(0);

    parent.addEventListener('click',function(event){
        let item=event.target;
    
        if(item.tagName == 'UL') 
            return;

        let num = item.innerHTML;
           
        for(const element of lists)
         element.classList.toggle('active',false);

        updateLesson(num-1);
    });

    function updateLesson(index)
    {
        video.src = embed + rows[index]['lesson_yt_url'];
        lesson.innerHTML= rows[index]['lesson_name'];
        lists[index].classList.add('active');
    }
    
</script>
<?php 
footer: ;
require './student_footer_script.php';
?>
