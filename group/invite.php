<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/login_check.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/doctype_includes.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/functions.php';
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/account/AccountManagement.php");

$groupID = $_POST['group_id'];
if (count($_POST) == 2) {

    //get user's email
    $user = AccountManagement::actionIndex();

    if (is_array($user)) {
        foreach ($user as $user) {
            $from = $user->getEmail();
        }
    } else {
        echo 'No user';
    }

    //send email
    if (isset($_POST['invite_email'])) {
        $to = $_POST['invite_email'];

        //send email
        $subject = 'Listr invite';

        $body = $from . ' has invited you to join Listr. A platform where you can share lists with friends and collegues. '
                . "\n" . "Head to: http://www.listr.esy.es" .
                "\n" . ' Sign up and get sharing! '
                . "\n\n" . 'The Listr Team';

        //mailUser($to, $subject, $body);

        echo 'Email sent, redirecting...';
        ?>


        <script>
            $('<form action="/listr/group/members.php" method="POST">' +
                    '<input type="hidden" name="group_id" value="' + <?php echo $groupID; ?> + '">' +
                    '</form>').submit();
        </script>
        <?php
    }
} else {
    ?> 



    <title>Listr - Invite</title>
    </head>

    <body>
        <?php
        if ($loggedIn == true) :
            require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");
            ?>


            <div class="container">
                <h1>Invite a friend to Listr:</h1>

                <div>
                    <h3>Email:</h3>
                    <div class="front-page-form">
                        <form id="invite_form" class="login" name="invite_form" action="invite.php" method="post" >
                            <div class="field">
                                <input type="text" class="form-control" id="invite_email" name="invite_email" placeholder="Friend's email">
                            </div>

                            <div class="field">
                                <input type="hidden" id="group_id" name="group_id" value=<?php echo $groupID ?>>
                            </div>
                            <br>
                            <input type="button" class="btn btn-success" value="Invite" onclick="return inviteCheck(this.form, this.form.invite_email)" />
                        </form>
                    </div>
                </div>

            </div>

            <!--Footer-->
            <footer>
                © 5to9 Studios Made with Bootstrap
            </footer>

        <?php else : ?>
            <p class="returnLogBlue">
                <span >You are not authorized to access this page.</span> Please <a href="../index.php">login</a>.
            </p>

        <?php
        endif;
    }
    ?>

</body>
</html>
