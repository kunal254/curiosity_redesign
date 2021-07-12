
/* ======
    drawer
    ====== */
$('.menu').first().click(function () {
    $('.nav_list').first().toggleClass('open');
});
/* ======
    modal
    ===== */



$('#get_login').click(function(){
    launch(this);
    if($('.nav_list').hasClass('open'))
    {
        $('.menu').first().children('.ham').removeClass('active');
        $('.nav_list').removeClass('open');
    }
    
});



function launch($context){
    $('#modal').show();
    $('#stu_modal').show();
    $('#form1').show();
    $('#form2').hide();
    if($context.id == 'get_login')
    {
        $('#log_in').click();
    }
}

$('#log_in').click(function () {
    $('#form1').hide();
    $('#form2').show();
});

$('#regis').click(function () {
    $('#form2').hide();
    $('#form1').show();
})

$('#close').click(function () {
    $('#modal_content').find(".modal_child").hide();
    $('#modal').hide();
});

/* ======
    modal
    ===== */

/* ======
    ajax requests
    ===== */


// student registration
$('#stu_regis').click(function(event){
    event.preventDefault();
    $.ajax(
        {
            url: "student/auth.php",
            method: "POST",
            data: $('#stu_regis_form').serialize(),
            success: function(data){
                data=JSON.parse(data);
                $('#regis_span').text(data['details']);
            }
        }
    )
});
// student login
$('#stu_login').click(function(event){
    event.preventDefault();
    $.ajax(
        {
            url: "student/auth.php",
            method: "POST",
            data: $('#stu_login_form').serialize(),
            success: function(data){
                data=JSON.parse(data);
                console.log(data);
                $('#login_span').text(data['details']);
                if (data['status'] == 'success') {
                    if(window.location.pathname.split('/').pop() == 'index.php')
                    window.location.href = './student/studentProfile.php';
                    else
                    location.reload();
               }
            }
        }
    )
});