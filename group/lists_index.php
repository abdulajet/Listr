<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/login_check.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/GroupListManagement.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/GroupDAO.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/model/GroupUser.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/listr/model/Group.php';

if (isset($_POST['group_id'])) {
    ?>
    <title> Lists</title>
    </head>
    <body>
        <?php
        if ($loggedIn == true) :
            require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");


            $groupUser = GroupDAO::findGroupUsers(array("group_user.user_id" => $_SESSION['user_id']));

            if (is_array($groupUser)) {
                foreach ($groupUser as $permission) {
                    $createP = $permission->getCreate_list();
                    $deleteP = $permission->getDelete_list();
                }
            } else {
                $createP = 0;
                $deleteP = 0;
            }

            $groupId = $_POST['group_id'];
            $groupList = GroupListManagement::actionList($groupId);

            if (is_array($groupList)) {
                foreach ($groupList as $list) {
                    $listName = $list->getList_name();
                    $listId = $list->getList_id();
                    ?>
                    <br>
                    &nbsp;<span><?php echo 'List - ' . $listName; ?></span>
                    <button class="btn btn-primary" onclick="editLoad(<?php echo $listId ?>);">View/Edit</button>
                    <button class="btn btn-danger" onclick="deleteLoad(<?php echo $listId ?>);" >Delete</button>
                    <br>
                    <?php
                }
            } else {
                echo 'No group List';
            }
            ?>
            <br>
            <hr>
            <div>
                <a href="#cGroupListModal" data-toggle="modal" data-target="#cGroupListModal"><button class="btn btn-primary">Create group list</button></a>
            </div>


            <!-- /.modal group create list -->
            <div class="modal fade" id="cGroupListModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Enter list name</h4>

                        </div>
                        <div class="modal-body">
                            <div class="front-page-form">
                                <form class="login" name="cGroupList_form" id="cGroupList_form" action="/listr/group/lists/create.php" method="post" >
                                    <div class="field">
                                        <input type="text" class="form-control" name="group_list_name" id="group_list_name" maxlength="15" placeholder="List Name">
                                    </div>
                                    <div class="field">
                                        <input type="hidden" id="group_id" name="group_id"  value=<?php echo $groupId; ?> /> 
                                    </div>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="return groupListCreate(document.getElementById('cGroupList_form'),
                                                document.getElementById('group_list_name'));">Create list!</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>








            <script>

                function editLoad(listId) {
                    $(document).ready(function () {
                        $('<form action="/listr/group/items/index.php" method="POST">' +
                                '<input type="hidden" name="var" value="' + listId + '">' +
                                '<input type="hidden" name="group_id" value="' + <?php echo $groupId ?> + '">' +
                                '</form>').submit();
                    });
                }

                function deleteLoad(listId) {

        <?php
        if ($deleteP == 1) {
            ?>
                        if (confirm('Are you sure you want to delete this list?')) {
                            $(document).ready(function () {
                                $('<form action="/listr/group/lists/delete.php" method="POST">' +
                                        '<input type="hidden" name="var" value="' + listId + '">' +
                                        '</form>').submit();
                            });
                        }
            <?php
        } else {
            ?>
                        alert('You do not have the required permissions');

            <?php
        }
        ?>

                }


                function groupListCreate(form, listName) {

        <?php
        if ($createP == 1) {
            ?>

                        if (listName.value == '') {

                            alert('You must provide a list name.');
                            return false;
                        }

                        form.submit();
                        return true;

            <?php
        } else {
            ?>
                        alert('You do not have the required permissions');
                        return false;
            <?php
        }
        ?>
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

        <?php
        endif;
    }