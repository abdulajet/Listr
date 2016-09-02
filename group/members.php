<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/login_check.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/doctype_includes.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/model/group.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/model/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/model/GroupUser.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/dao/GroupDAO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/dao/UserDAO.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/functions.php';

if (isset($_POST['group_id'])) {

    $groupID = $_POST['group_id'];
    $group = GroupDAO::findGroup(array("group_id" => $groupID));

    if (is_array($group)) {
        foreach ($group as $group) {
            $groupName = $group->getGroupName();
            $creator_id = $group->getCreatorId();
        }
    } else {
        echo 'No group';
    }
    ?>
    <title> <?php echo $groupName . ' - members'; ?> </title>
    </head>
    <?php
    if ($loggedIn == true) :
        require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");
        ?>

        <h2> <?php echo $groupName . ' members:'; ?></h2>

        <?php
        $users = GroupDAO::findGroupUsers(array("group_user.group_id" => $groupID));

        if (is_array($users)) {

            foreach ($users as $user) {
                $user_ids[] = $user->getUserId();
            }

            $groupUser = UserDAO::findUserOr($user_ids);
            if (is_array($groupUser)) {
                foreach ($groupUser as $user) {
                    $username = $user->getUsername();
                    echo $username;
                    ?>
                    <br>
                    <?php
                }
            } else {
                echo 'No user 1';
            }
        } else {
            echo 'No user 2';
        }

        $current_user_id = $_SESSION['user_id'];
        ?>


        <br>
        <hr>
        <div>
            <button class="btn btn-primary" id="submit">Invite a friend/colleague to Listr</button>
            <button class="btn btn-danger" id="leave">Leave this group</button>
        </div>

        


        <script>

            $(document).ready(function () {

                $('#submit').click(function () {

                    $('<form action="/listr/group/invite.php" method="POST">' +
                            '<input type="hidden" name="group_id" value="' + <?php echo $groupID; ?> + '">' +
                            '</form>').submit();
                });


                $('#leave').click(function () {

        <?php
        if ($current_user_id == $creator_id) {
            ?>
                        
            alert('You must promote a member to group admin');
            return false;
            <?php
        } else {
            ?>

                        if (confirm('Are you sure you want to leave this group?')) {
                            $('<form action="/listr/group/leave.php" method="POST">' +
                                    '<input type="hidden" name="user_id" value="' + <?php echo $current_user_id ; ?> + '">' +
                                    '<input type="hidden" name="group_id" value="' + <?php echo $current_user_id ; ?> + '">' +
                                    '</form>').submit();
                        }
        <?php } ?>
                });


            });


        </script>



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
