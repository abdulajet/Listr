<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/account/AccountManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/login_check.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
?>

<title>Listr - My account</title>
</head>

<body>
    <?php
    if ($loggedIn == true) :
        require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");
        $user = AccountManagement::actionIndex();
        $stats = AccountManagement::actionStats();

        if (is_array($user)) {
            foreach ($user as $user) {
                $username = $user->getUsername();
                $email = $user->getEmail();
                $rQuestion = $user->getR_question();
            }
        } else {
            echo 'No user';
        }
        ?>

        <div class="container">  
            
            <div>
                <h1> Your account details:</h1>
                
                <h3>Number of personal lists: <?php echo $stats; ?> </h3>

                <br>
                <h4>Username: <?php echo $username; ?></h4>

                <br>
                <h4><u>Password:</u> *********** </h4>

                <br>
                <h4><u>Email:</u> <?php echo $email; ?></h4>

                <br>
                <h4><u>Recovery Question:</u> <?php echo $rQuestion; ?> </h4>

            </div>
            <br>
            <a href="update.php" class="btn btn-primary">Edit Account</a>
            <a href="delete.php" class="btn btn-danger">Delete Account</a>
        </div>


    </body>

    <!--Footer-->
    <footer>
        © 5to9 Studios      Made with Bootstrap
    </footer>
<?php else : ?>
    <p class="returnLogBlue">
        <span >You are not authorized to access this page.</span> Please <a href="../index.php">login</a>.
    </p>

<?php
endif;
?>

