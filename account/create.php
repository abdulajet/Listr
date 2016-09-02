<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/login_check.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/account/AccountManagement.php");
?>
<title>Listr - log in</title>
</head>

<?php
$a = new AccountManagement();
if (count($_POST) >= 5) {

   if($a::actionCreate()){
       ?>
    <meta http-equiv="refresh" content="0;URL='http://localhost/listr/index.php'" />

    <?php } else{ ?>
    
        <meta http-equiv="refresh" content="0;URL='http://localhost/listr/account/create.php'" />
    <?php }
} else {
    ?>
    <body>
    <body class="front-page">  
        <div class="front-card">
            <?php if (!empty($error_msg)) { ?>
                <div id="error"></div>
            <?php }
            ?>

            <div class="front-welcome">
                <h1>Welcome to Listr.</h1>
                <p>Please enter your information to start sharing your lists!</p>
            </div>

            <div class="front-page-form">
                <form class="login" name="registration_form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" >
                    <div class="field">
                        <input type="text" class="form-control" name="username" id="username" maxlength="15" placeholder="Username">
                    </div>
                    <div class="field">
                        <input type="password" class="form-control" name="password" id="password" maxlength="15" placeholder="Password">
                    </div>
                    <div class="field">
                        <input type="password" class="form-control" name="cPassword" id="cPassword" maxlength="15" placeholder="Confirm Password">
                    </div>
                    <div class="field">
                        <input type="text" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
                    </div>
                    <div class="field">
                        <input type="text" class="form-control" name="rQuestion" id="rQuestion" maxlength="30" placeholder="Recovery Question">
                    </div>
                    <div class="field">
                        <input type="text" class="form-control" name="rAnswer" id="rAnswer" maxlength="30" placeholder="Recovery Answer">
                    </div>
                    <input type="button" class="btn btn-primary" value="Submit" 
                           onclick="return regformhash(this.form,
                                           this.form.username,
                                           this.form.password,
                                           this.form.cPassword,
                                           this.form.email,
                                           this.form.rQuestion,
                                           this.form.rAnswer);" />
                </form>
            </div>  
        </div>



        <div class="returnLog">
            <p>Return to the <a href="../index.php">login page</a>.</p>
        </div>



        <footer>
            © 5to9 Studios Made with Bootstrap
        </footer>
        <?php
    }
    ?>
</body>
</html>