<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/account/AccountManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/login_check.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
?>

<title>Listr - Delete account</title>
</head>

<body>
    <?php
    if ($loggedIn == true) :
        require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");
        ?>

        <div class="container">  
            <div>
                <h1> Are you sure you want to delete your account? <br>This process cannot be reversed!</h1>
                <h3>Please leave all groups before deleting!</h3>
            </div>
            
            <br>
            <a href = "/listr/account/process_delete.php" class = "btn btn-danger">Delete Account Forever :(</a>
        </div>

    </body>

    <!--Footer-->
    <footer>
        © 5to9 Studios Made with Bootstrap
    </footer>
<?php else :
    ?>
    <p class="returnLogBlue">
        <span >You are not authorized to access this page.</span> Please <a href="../index.php">login</a>.
    </p>

<?php
endif;
?>