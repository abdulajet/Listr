<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/account/AccountManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/login_check.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
?>
<title>Listr - Edit account</title>
</head>

<body>
    <?php
    if ($loggedIn == true) :
        $user = AccountManagement::actionIndex();

        if (is_array($user)) {
            foreach ($user as $user) {
                $rQuestion = $user->getR_question();
            }
        } else {
            echo 'No user';
        }
        require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");
        ?>

    
    <body>

        <div class="container">
            <h1>Make changes to your account:</h1>

            <div>
                <h3>&nbsp Password:</h3>
                <div class="front-page-form">
                    <form id="password_form" class="login" name="password_form" action="../account/process_update.php" method="post" >
                        <div class="field">
                            <input type="password" class="form-control" id="current_pass" name="current_pass" placeholder="Current password">
                        </div>

                        <div class="field">
                            <input type="password" class="form-control" id="new_pass" name="new_pass" placeholder="New password">
                        </div>
                        <div class="field">
                            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" placeholder="Confirm new password">
                        </div>
                        <br>
                        <input type="button" class="btn btn-success" value="Save changes" onclick="return updatePass(
                                           document.getElementById('password_form'),
                                                document.getElementById('current_pass'),
                                                document.getElementById('new_pass'), 
                                                document.getElementById('confirm_new_password'));" />
                    </form>
                </div>
            </div>


            <div>
                <h3>&nbsp Email:</h3>
                <div class="front-page-form">
                    <form id="email_form" class="login" name="email_form" action="../account/process_update.php" method="post" >
                        <div class="field">
                            <input type="text" class="form-control" id="current_email" name="current_email" placeholder="Current email">
                        </div>

                        <div class="field">
                            <input type="text" class="form-control" id="new_email" name="new_email" placeholder="New email">
                        </div>
                        <div class="field">
                            <input type="text" class="form-control" id="confirm_new_email" name="confirm_new_email" placeholder="Confirm new email">
                        </div>
                        <br>
                        <input type="button" class="btn btn-success" value="Save changes" onclick="return updateEmail(
                                            document.getElementById('email_form'),
                                                document.getElementById('current_email'),
                                                document.getElementById('new_email'), 
                                                document.getElementById('confirm_new_email'));" />
                    </form>
                </div>
            </div>


            <div>
                <h3>&nbsp Recovery Question:</h3>
                <h4>&nbsp Current question is: <?php echo $rQuestion; ?>?</h4>
                <div class="front-page-form">
                    <form id="recovery_form" class="login" name="recovery_form" action="../account/process_update.php" method="post" >
                        <div class="field">
                            <input type="text" class="form-control" id="current_answer" name="current_answer" placeholder="Current answer">
                        </div>

                        <div class="field">
                            <input type="text" class="form-control" id="new_question" name="new_question" placeholder="New question">
                        </div>
                        <div class="field">
                            <input type="text" class="form-control" id="new_answer" name="new_answer" placeholder="New answer">
                        </div>
                        <br>
                        <input type="button" class="btn btn-success" value="Save changes" onclick="return updateRecovery(
                                            document.getElementById('recovery_form'),
                                                document.getElementById('current_answer'),
                                                document.getElementById('new_question'), 
                                                document.getElementById('new_answer'));" />
                    </form>
                </div>
            </div>
        </div>
        <!--Footer-->
    <div id=footer style="position: static" >
        © 5to9 Studios Made with Bootstrap
    </div>
    </body>

    

<?php else : ?>
    <p class="returnLogBlue">
        <span >You are not authorized to access this page.</span> Please <a href="../index.php">login</a>.
    </p>

                                    <?php
    endif;
