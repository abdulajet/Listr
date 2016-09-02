<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/login_check.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/model/GroupUser.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/model/Group.php';
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/GroupDAO.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/account/AccountManagement.php");

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $groupID = $_POST['group_id'];
    $admin_id = $_SESSION['user_id'];
    ?>

    <title> Edit permissions</title>
    </head>
    <body>
        <?php
        if ($loggedIn == true) {
            require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");

            $user = UserDAO::findUser(array("user_id" => $user_id));

            if (is_array($user)) {
                foreach ($user as $userDetails) {
                    $username = $userDetails->getUsername();
                }
            }

            $groupUser = GroupDAO::findGroupUsers(array("group_user.user_id" => $user_id));

            if (is_array($groupUser)) {
                foreach ($groupUser as $permission) {
                    $createP = $permission->getCreate_list();
                    $deleteP = $permission->getDelete_list();
                }
            } else {
                $createP = 0;
                $deleteP = 0;
            }
            ?>

            <h1><?php echo 'Edit permissions for: ' . $username; ?></h1>


            <table>
                <tr>
                    <th>Create List</th>
                    <th>Delete List</th>
                </tr>
                <tr>
                    <td><input type="checkbox" id="createP" name="createP" <?php
                        if ($createP == 1) {
                            echo 'checked';
                        }
                        ?> /></td>

                    <td><input type="checkbox" id="deleteP" name="deleteP" <?php
                        if ($deleteP == 1) {
                            echo 'checked';
                        }
                        ?>/></td>

                    <td>
                        <input type="button" id="promote" class="btn btn-warning" value="Promote to admin" />
                    </td>
                </tr>
            </table>

            <hr>
            <input type="button" id="submit" class="btn btn-success" value="Save changes" />
            <input type="button" id="return" class="btn btn-primary" value="Go back" />


            <script>
                $(document).ready(function () {

                    $('input#return').click(function () {
                        $('<form action="/listr/group/admin.php" method="POST">' +
                                '<input type="hidden" name="group_id" value="' + <?php echo $groupID; ?> + '">' +
                                '</form>').submit();
                        return false;
                    });


                    $('input#submit').on('click', function () {
                        var deleteP = 0;
                        var createP = 0;


                        if ($("#createP").is(":checked")) {
                            createP = 1;
                        }

                        if ($("#deleteP").is(":checked")) {
                            deleteP = 1;
                        }

                        $.post('process_permissions.php', {deleteP: deleteP, createP: createP, user_id: <?php echo $user_id ?>}, function (data) {
                            alert(data);

                            $('<form action="/listr/group/admin.php" method="POST">' +
                                    '<input type="hidden" name="group_id" value="' + <?php echo $groupID; ?> + '">' +
                                    '</form>').submit();
                        });


                    });


                    $('#promote').on('click', function () {
                    
                     if (confirm('Are you sure you want to promote this user? You will no longer be the group admin')) {
                         
                         $('<form action="/listr/group/promote.php" method="POST">' +
                                    '<input type="hidden" name="group_id" value="' + <?php echo $groupID; ?> + '">' +
                                    '<input type="hidden" name="user_id" value="' + <?php echo $user_id; ?> + '">' +
                                    '</form>').submit();
                         
                     }

                    });

                });


            </script>








            <!--Footer-->
            <footer>
                © 5to9 Studios      Made with Bootstrap
            </footer>
            <?php
        } else {
            ?>
            <p class="returnLogBlue">
                <span >You are not authorized to access this page.</span> Please <a href="../index.php">login</a>.
            </p>
            <?php
        }
    }


