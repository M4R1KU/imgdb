<?php include '../View/layout/flash.php' ?>
<div class="row">
    <h2>Login or Register</h2>
    <div class="col m6 s12">
        <div class="card col m11 s10 offset-s1 z-depth-1-half">
            <div class="card-content">
                <h3>Login<i class="material-icons right cursor-pointer" onclick="Materialize.toast('Fill the input fields to login!', 4000)">info_outline</i></h3>
                <form action="/login/login" method="post">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="login_email">E-Mail</label>
                            <input type="email" name="login_email" id="login_email" placeholder="Enter your e-mail address">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="login_pasword">Password</label>
                            <input type="password" name="login_password" id="login_password" placeholder="Enter your password"></div>
                    </div>

                    <div class="input-field">
                        <button type="submit" name="login_button" class="btn btn-primary" id="login_button">Log In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col m6 s12">
        <div class="card col m11 s10 offset-m1 offset-s1 z-depth-1-half">
            <div class="card-content">
                <h3>Register<i class="material-icons right cursor-pointer"
                               onclick="Materialize.toast('Fill the input fields to register!', 500000)">info_outline</i>
                </h3>
                <form action="/login/add" method="post">
                    <div class="row">
                        <div class="input-field col s12"><label for="email">E-Mail</label>
                            <input type="email" class="tooltip-toggle" name="email" id="email"
                                   placeholder="Enter your e-mail address" required="" maxlength="45"
                                   data-content="Please enter a valid E-Mail address. Example: Michael.Townley@example.com.">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12"><label for="username">Username</label>
                            <input type="text" class="tooltip-toggle" name="username" id="username"
                                   placeholder="Enter a username" required="" maxlength="30" data-container="body"
                                   data-content="The username must be at least 4 characters long."></div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12"><label for="password">Password</label>
                            <input type="password" class="tooltip-toggle" name="password" id="password"
                                   placeholder="Password" required=""
                                   data-content="at least eight symbols containing, at least one number, one lower and one upper letter"></div>
                   </div>
                    <div class="row">
                        <div class="input-field col s12"><label for="password">Repeat Password</label>
                            <input type="password" class="tooltip-toggle" id="password_confirmed"
                                   name="password_confirmed" placeholder="Repeat your password" required=""
                                   data-content="repeat password from above"></div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button type="submit" name="register_button" class="btn btn-primary" id="register_button">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>