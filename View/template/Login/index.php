<?php /*if ($this->flash): */ ?><!--
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <h4><? /*= $this->title */ ?></h4><br>
        <p><? /*= $this->flash */ ?><p>
    </div>
--><?php /*endif; */ ?>

<div class="row">
    <h2>Login or Register</h2>
    <div class="col m6 s12">
        <div class="card col m11 s10 offset-s1 z-depth-1-half">
            <div class="card-content">
                <h3>Login<i class="material-icons right cursor-pointer" onclick="Materialize.toast('Fill the input fields to login!', 4000)">info_outline</i></h3>
                <form action="<?= ROOT ?>/login/login" method="post">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="login_email">E-Mail</label>
                            <input type="text" name="login_email" id="login_email" placeholder="Enter your e-mail address">
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
                <form action="<?= ROOT ?>/login/add" method="post">
                    <div class="row">
                        <div class="input-field col s12"><label for="email">E-Mail</label>
                            <input type="email" class="tooltip-toggle" name="email" id="email"
                                   placeholder="Enter your e-mail address" required="" maxlength="45"
                                   data-content="Please enter a valid E-Mail address. Example: Michael.Townley@example.com.">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12"><label for="username">Username</label>
                            <input type="text" class="" name="username" id="username"
                                   placeholder="Enter a username" required="" maxlength="30" data-container="body"
                                   data-toggle="popover" data-placement="left" data-trigger="focus"
                                   data-content="The username must be at least 4 characters long."
                                   data-original-title="Username"></div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12"><label for="password">Password</label>
                            <input type="password" class="" name="password" id="password"
                                   placeholder="Password"
                                   required="" data-container="body" data-toggle="popover" data-placement="left"
                                   data-trigger="focus"
                                   data-content="at least eight symbols containing, at least one number, one lower and one upper letter"
                                   data-original-title="Password"></div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12"><label for="password">Repeat Password</label>
                            <input type="password" class="" id="password_confirmed"
                                   name="password_confirmed"
                                   placeholder="Repeat your password" required=""></div>
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
<!--
<div class="col-lg-5 panel panel-primary" id="login-panel">
    <div class="panel-heading" id="lnormalheading"><h1>Log In</h1></div>
        <form action="<?= ROOT ?>/login/login" method="post">
            <div class="form-group panel-body">
                <div class="form-group"><label for="login_username">E-Mail</label>
                    <input type="text" class="form-control" name="login_email" id="login_email" placeholder="Enter your e-mail"></div>

                <div class="form-group"><label for="login_pasword">Password</label>
                    <input type="password" class="form-control" name="login_password" id="login_password" placeholder="Enter your password"></div>

                <div class="form-group">
                    <button type="submit" name="login_button" class="btn btn-primary" id="login_button">Log In</button>
                </div>

            </div>
        </form>
</div>
    <div class="col-lg-5 col-lg-offset-2 panel panel-primary" id="register-panel">
        <div class="panel-heading" id="rnormalheading"><h1>Sign Up</h1></div>
        <form action="<?= ROOT ?>/login/add" method="post">
            <div class="panel-body">
                <div class="form-group"><label for="email">E-Mail</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your e-mail address" required="" maxlength="45" data-container="body" data-toggle="popover" data-placement="left" data-trigger="focus" data-content="Please enter a valid E-Mail address. Example: Michael.Townley@example.com." data-original-title="E-Mail"></div>

                <div class="form-group"><label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter a username" required="" maxlength="30" data-container="body" data-toggle="popover" data-placement="left" data-trigger="focus" data-content="The username must be at least 4 characters long." data-original-title="Username"></div>

                <div class="form-group"><label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required="" data-container="body" data-toggle="popover" data-placement="left" data-trigger="focus" data-content="at least eight symbols containing, at least one number, one lower and one upper letter" data-original-title="Password"></div>

                <div class="form-group"><label for="password">Repeat Password</label>
                    <input type="password" class="form-control" id="password_confirmed" name="password_confirmed" placeholder="Repeat your password" required=""></div>

                <div class="form-group">
                    <button type="submit" name="register_button" class="btn btn-primary" id="register_button">Submit
                    </button>
                </div>

            </div>
        </form>
    </div>
-->