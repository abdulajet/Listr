<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/login_check.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/account/AccountManagement.php");

$a = new AccountManagement();

if (count($_POST) >= 2) {
    if ($a::actionLogin()) {
        ?>
   <title>Listr!</title>
    </head>
        <meta http-equiv="refresh" content="0;URL='http://localhost/listr/home.php'" />
        <?php
    } else {
        ?>
        <!-- error emssage + login form-->
        <div id='error' class="returnLog">
            log in failed
        </div>
        
       <body class="front-page"> 
        <div class="front-card">
            <div class="front-welcome">
                <h1>Welcome to Listr.</h1>
                <p>A new platform that allows for easy
                    sharing of list with your friends and colleagues.</p>
            </div>

            <div class="front-page-form">
                <form id="login_form" class="login" name="login_form" action="login.php" method="post" >
                    <div class="field">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="field">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <button type="button" class="btn btn-default" onclick="location.href = 'create.php'"> 
                        New User? </button>  
                    <input type="button" class="btn btn-primary" value="Login" onclick="formhash(this.form, this.form.email, this.form.password);" />
                    <a href="recover.php">Forgot password?</a><br>
                </form>
            </div>  
        </div>


        <footer>
            © 5to9 Studios      Made with Bootstrap
        </footer>


    </body>
        <?php
    }
} else {
    ?>
      <body class="front-page"> 
        <div class="front-card">
            <div class="front-welcome">
                <h1>Welcome to Listr.</h1>
                <p>A new platform that allows for easy
                    sharing of list with your friends and colleagues.</p>
            </div>

            <div class="front-page-form">
                <form id="login_form" class="login" name="login_form" action="account/login.php" method="post" >
                    <div class="field">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="field">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <button type="button" class="btn btn-default" onclick="location.href = 'create.php'"> 
                        New User? </button>  
                    <input type="button" class="btn btn-primary" value="Login" onclick="formhash(this.form, this.form.email, this.form.password);" />
                <a href="recover.php">Forgot password?</a><br>
                </form>
            </div>  
        </div>
<?php } ?>