<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/ListItemManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/Listr_ListDAO.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/List_ItemDAO.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/login_check.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");

if ($loggedIn == true) {
    require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");
    if (isset($_POST['var'])) {
        $list_id = $_POST['var'];

        $list = Listr_ListDAO::findList(array("list_id" => $list_id));

        foreach ($list as $list) {
            $list_name = $list->getList_name();
            $db_id = $list->getUser_id();
        }

        if ($_SESSION['user_id'] != $db_id) {
            ?>
            <p class="returnLogBlue">
                <span >You are not authorized to access this page.</span> Please <a href="../lists/index.php">return</a>.
            </p>
            <?php
        } else {
            ?>

            <title> <?php echo 'Listr - ' . $list_name; ?> </title>
            </head>

            <body>
                <?php
                $list_items = ListItemManagement::actionList($list_id);

                if (is_array($list_items)) {

                    foreach ($list_items as $list_items) {
                        $list_item_id = $list_items->getList_item_id();
                        $item_name = $list_items->getitem_name();
                        $item_details = $list_items->getItem_details();
                        $status = $list_items->getStatus();
                        $priority = $list_items->getPriority();
                        $due_date = $list_items->getDue_date();
                        $completion_date = $list_items->getCompletion_date();

                        $due_date = substr($due_date, 0, -9);
                        $completion_date = substr($completion_date, 0, -9);

                        switch ($priority) {
                            case 0:
                                $priority = "Low";
                                break;
                            case 1:
                                $priority = "Medium";
                                break;
                            case 2:
                                $priority = "High";
                                break;
                        }
                        ?>

                        <div>
                            <br>
                            &nbsp;<span><?php echo 'Item: ' . $item_name ?></span><br>
                    <?php echo 'Details: ' . $item_details ?> <br>
                            <?php echo 'Priority: ' . $priority ?> <br>
                            <?php echo 'Status: ' . $status ?> 
                            <?php
                            if ($status != 'completed') {
                                if ($due_date != '0000-00-00') {
                                    echo 'Due date: ' . $due_date;
                                }
                            } else {
                                echo 'Comepletion date: ' . $completion_date;
                            }
                            ?>
                            <button class="btn btn-primary" onclick="editLoad(<?php echo $list_item_id . ',' . $list_id ?>)">View more/Edit</button>
                            <button class="btn btn-danger" onclick="deleteLoad(<?php echo $list_item_id . ',' . $list_id ?>)">Delete</button>
                            <?php
                            if ($status != 'completed') {
                                ?>
                                <button class="btn btn-success" onclick="complete(<?php echo $list_item_id . ',' . $list_id ?>)">DONE?</button>
                                <?php
                            }
                        }
                        ?>
                    </div>
                        <?php
                    } else {
                        echo 'No items!';
                    }
                    ?>
                <br>
                <hr>
                <div>
                    <a href="#cItemModal" data-toggle="modal" data-target="#cItemModal"><button class="btn btn-primary">create item</button></a>
                </div>

                <!-- /.modal create list item -->
                <div class="modal fade" id="cItemModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Add list item:</h4>

                            </div>

                            <div class="modal-body">
                                <div class="front-page-form" >
                                    <form class="login" >
                                        <div class="field">
                                            <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Item name" maxlength="10"x />
                                        </div>

                                        <div class="field">
                                            <textarea name="item_details" id="item_details" maxlength="100" cols="20" rows="5" placeholder="Item Details"></textarea>
                                        </div>


                                        Priority: <select name="priority" id="priority">
                                            <option value="0">Low</option>
                                            <option value="1">Medium</option>
                                            <option value="2">High</option>
                                        </select>



                                        <div class="field">
                                            <input id="due_date" class="form-control" placeholder="Due Date (Optional)"/>
                                        </div>

                                        <div class="field">
                                            <input type="checkbox" id="is_att" name="is_att"/> Upload Attachment?
                                        </div>

                                        <div class="field">
                                            <input type="file" id="att" name="att" /> 
                                        </div>

                                        <div class="field">
                                            <input type="hidden" id="list_id" name="list_id"  value=<?php echo $list_id; ?> /> 
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" id="submit" class="btn btn-success" value="Add item" />
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>



                <script>
                    $(document).ready(function () {
                        $("#att").hide();

                        $("#due_date").datepicker({
                            dateFormat: "yy/mm/dd"
                        });


                        $("#is_att").click(function () {
                            $("#att").toggle(this.checked);
                        });


                        $('input#submit').on('click', function () {

                            var itemName = $('input#item_name').val();
                            var itemDetails = $('textarea#item_details').val();
                            var due = $('input#due_date').val();
                            var current = getDateTime();
                            var file = $('input#att').val();
                            var listId = $('input#list_id').val();
                            var priority = $('select#priority').val();

                            if ($("#is_att").is(":checked") && file == '') {
                                alert('You must choose a file to upload');
                                return false;
                            }


                            if (itemName != '' || itemDetails != '') {

                                $.post('create.php', {item_name: itemName, item_details: itemDetails, priority: priority, due_date: due, current_date: current, file: file, list_id: listId}, function (data) {
                                    alert(data);
                                    location.reload();
                                });


                            } else {
                                alert('Please enter an item name and item details');
                            }
                        });



                    });

                    function getDateTime() {
                        var now = new Date();
                        var year = now.getFullYear();
                        var month = now.getMonth() + 1;
                        var day = now.getDate();
                        var hour = now.getHours();
                        var minute = now.getMinutes();
                        var second = now.getSeconds();
                        if (month.toString().length == 1) {
                            var month = '0' + month;
                        }
                        if (day.toString().length == 1) {
                            var day = '0' + day;
                        }
                        if (hour.toString().length == 1) {
                            var hour = '0' + hour;
                        }
                        if (minute.toString().length == 1) {
                            var minute = '0' + minute;
                        }
                        if (second.toString().length == 1) {
                            var second = '0' + second;
                        }
                        var dateTime = year + '/' + month + '/' + day + ' ' + hour + ':' + minute + ':' + second;
                        return dateTime;
                    }


                    function editLoad(itemId, listId) {
                        $('<form action="edit.php" method="POST">' +
                                '<input type="hidden" name="item_id" value="' + itemId + '">' +
                                '<input type="hidden" name="list_id" value="' + listId + '">' +
                                '</form>').submit();
                    }

                    function deleteLoad(itemId, listId) {
                        if (confirm('Are you sure you want to delete this item?')) {
                            $('<form action="delete.php" method="POST">' +
                                    '<input type="hidden" name="item_id" value="' + itemId + '">' +
                                    '<input type="hidden" name="list_id" value="' + listId + '">' +
                                    '</form>').submit();
                        }
                    }

                    function complete(itemId, listId) {
                        $('<form action="complete.php" method="POST">' +
                                '<input type="hidden" name="item_id" value="' + itemId + '">' +
                                '<input type="hidden" name="list_id" value="' + listId + '">' +
                                '</form>').submit();
                    }

                </script>




            <?php
        }
    } else {
        echo 'error, list id not sent';
    }
    ?>
    </body>

    <!--Footer-->
    <footer>
        © 5to9 Studios Made with Bootstrap
    </footer>
<?php } else {
    ?>
    <p class="returnLogBlue">
        <span >You are not authorized to access this page.</span> Please <a href="../index.php">login</a>.
    </p>

    <?php
}

