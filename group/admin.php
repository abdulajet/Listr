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
        }
    } else {
        echo 'No group';
    }
    ?>
    <title> <?php echo $groupName . ' - Admin'; ?> </title>
    </head>
    <?php
    if ($loggedIn == true) {
        require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");
        ?>
        <style>
            h1{
                text-align: center;
            }

            .btn_align{
                text-align: center;
            }
        </style>

        <h1> <?php echo $groupName . ' - admin page:'; ?></h1>

        <h2> Members: </h2>

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
                    $id = $user->getUser_id();
                    ?>

                    <br>
                    &nbsp;<span><?php echo $username; ?></span> 
                    <?php
                    if ($id != $_SESSION['user_id']) {
                        ?>
                        <button class="btn btn-primary" onclick="permissions(<?php echo $id ?>);">Edit permissions</button>
                        <button class="btn btn-danger" onclick="kick(<?php echo $id ?>);" >Kick User</button>
                        <br>


                        <?php
                    }
                }
            } else {
                echo 'No user 1';
            }
        } else {
            echo 'No user 2';
        }
        ?>

        <br>
        <hr>

        <div class="btn_align">
            <button class="btn btn-primary" onclick="editGroup(<?php echo $groupID ?>);">Edit Group Password</button>
            <button class="btn btn-danger" onclick="deleteGroup(<?php echo $groupID ?>);">Delete Group</button>
        </div>


        <script>


            function deleteGroup(groupId) {
                if (confirm('Are you sure you want to delete this group?')) {
                    $(document).ready(function () {
                        $('<form action="/listr/group/delete.php" method="POST">' +
                                '<input type="hidden" name="group_id" value="' + groupId + '">' +
                                '</form>').submit();
                    });
                }

            }

            function editGroup(groupId) {
                $(document).ready(function () {
                    $('<form action="/listr/group/update.php" method="POST">' +
                            '<input type="hidden" name="group_id" value="' + groupId + '">' +
                            '</form>').submit();
                });

            }

            function kick(userId) {
                if (confirm('Are you sure you want to kick this user?')) {
                    $(document).ready(function () {
                        $('<form action="/listr/group/kick_user.php" method="POST">' +
                                '<input type="hidden" name="user_id" value="' + userId + '">' +
                                 '<input type="hidden" name="group_id" value="' + <?php echo $groupID; ?> + '">' +
                                '</form>').submit();
                    });
                }

            }

            function permissions(userId) {
                $(document).ready(function () {
                    $('<form action="/listr/group/permissions.php" method="POST">' +
                            '<input type="hidden" name="user_id" value="' + userId + '">' +
                            '<input type="hidden" name="group_id" value="' + <?php echo $groupID; ?> + '">' +
                            '</form>').submit();
                });

            }


        </script>




        <!--Footer-->
        <footer>
            © 5to9 Studios Made with Bootstrap
        </footer>

    <?php } else { ?>
        <p class="returnLogBlue">
            <span >You are not authorized to access this page.</span> Please <a href="../index.php">login</a>.
        </p>

        <?php
    }
}
?>



</body>
</html>