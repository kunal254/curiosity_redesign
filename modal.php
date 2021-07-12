<!-- MODAL -->
<div class="modal_child" style="display: none;" id="stu_modal">
    <div class="mb-1" id="sign_log">
        <button class="btn btn-info btn-sm" id="regis">Registration</button>
        <button class="btn btn-info btn-sm" id="log_in">Log In</button>
    </div>
    <div id="forms">
        <div id="form1">
            <h3>Student Registration</h3>
            <form id="stu_regis_form" action="" autocomplete="off">
                <div class="group">
                    <label for="name"><i class="material-icons">badge</i>Name</label>
                    <input id="name" type="text" name="name" placeholder="Name" required><br>
                </div>

                <div class="group">
                    <label for="email"><i class="material-icons">email</i>Email</label>
                    <input id="email" type="email" name="email" placeholder="email@example.com" required><br>
                </div>

                <div class="group">
                    <label for="pass"><i class="material-icons">lock</i>New Password</label>
                    <input id="pass" type="text" name="pass" placeholder="password" required><br>
                </div>
            </form>
            <span id="regis_span" class="info"></span>
            <button id="stu_regis" class="btn btn-primary go">Sign up</button>
        </div>
        <div id="form2">
            <h3>Student Login</h3>
            <form id="stu_login_form" action="" autocomplete="off">
                <div class="group">
                    <label for="stuemail"><i class="material-icons">email</i>Email</label>
                    <input id="stuemail" type="email" name="stu_email" placeholder="email@example.com" required><br>
                </div>

                <div class="group">
                    <label for="stupass"><i class="material-icons">lock</i>Password</label>
                    <input id="stupass" type="password" name="stu_pass" placeholder="password" required><br>
                </div>
            </form>
            <span id="login_span" class="info"></span>
            <button id="stu_login" class="btn btn-primary go">Log in</button>
        </div>
    </div>
</div>

<!-- MODAL -->