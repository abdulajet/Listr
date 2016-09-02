<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/login_check.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/doctype_includes.php';
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/group/GroupManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/model/GroupUser.php");
?>
<title>Listr - My groups</title>
</head>
<body>


    <?php
    if ($loggedIn == true) :
        require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");
        ?>
        <div class="container">
            <div>
                <table>
                    <?php
                    $groups = GroupManagement::actionIndex();

                    if (is_array($groups)) {
                        foreach ($groups as $GroupUser) {
                            $groupName = $GroupUser->getGroupName();
                            $groupID = $GroupUser->getGroupId();
                            $admin = $GroupUser->getCreatorId();
                            ?>

                            <tr>
                                <td> <br>&nbsp;&nbsp;&nbsp; <?php echo $groupName . ':'; ?></td>
                                <td> <br>&nbsp;&nbsp;&nbsp;<button class="btn btn-primary" id="<?php echo 'lists_' . $groupID; ?>" name="<?php echo 'lists_' . $groupID; ?>" onclick="showLists(<?php echo $groupID ?>);">Lists</button></td>
                                <td> <br>&nbsp;&nbsp;&nbsp;<button class="btn btn-primary" id="<?php echo 'members_' . $groupID; ?>" name="<?php echo 'members_' . $groupID; ?>"onclick="showMembers(<?php echo $groupID ?>);">Members</button></td>
                                <td> <br>&nbsp;&nbsp;&nbsp;<button class="btn btn-warning" id="<?php echo 'admin_' . $groupID; ?>"name="<?php echo 'admin_' . $groupID; ?>" onclick="showAdmin(<?php echo $groupID . ',' . $admin ?>);">Admin</button></td>
                            </tr>

                            <?php
                        }
                    } else {
                        echo 'No groups';
                    }
                    ?>
                </table>
            </div>
            <br>
            <hr>
            <div>
                <a href="#cGroupModal" data-toggle="modal" data-target="#cGroupModal"><button class="btn btn-primary">Create group</button></a>
                <a href="#jGroupModal" data-toggle="modal" data-target="#jGroupModal"><button class="btn btn-primary">Join group</button></a>

            </div>
        </div>

        <script>

            function showLists(groupId) {
                $(document).ready(function () {

                    $('<form action="lists_index.php" method="POST">' +
                            '<input type="hidden" name="group_id" value="' + groupId + '">' +
                            '</form>').submit();
                });
            }

            function showMembers(groupId) {
                $(document).ready(function () {

                    $('<form action="members.php" method="POST">' +
                            '<input type="hidden" name="group_id" value="' + groupId + '">' +
                            '</form>').submit();
                });
            }

            function showAdmin(groupId, admin) {
                $(document).ready(function () {


                    if (admin == <?php echo $_SESSION['user_id']; ?>) {


                        $('<form action="admin.php" method="POST">' +
                                '<input type="hidden" name="group_id" value="' + groupId + '">' +
                                '</form>').submit();


                    } else {

                        alert('You do not have the required permissions');


                    }

                });
            }


        </script>




        <!--Footer-->
        <footer>
            © 5to9 Studios      Made with Bootstrap
        </footer>

    <?php else : ?>
        <p class="returnLogBlue">
            <span >You are not authorized to access this page.</span> Please <a href="../index.php">login</a>.
        </p>

    <?php endif; ?>

</body>
</html>