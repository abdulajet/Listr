<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/ListItemManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/dao/List_ItemDAO.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/login_check.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
?>

<title>Listr - View/Edit List</title>
</head>

<body>

    <?php
    if ($loggedIn == true) :
        require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");
        $list_id = $_POST['list_id'];
        $item_id = $_POST['item_id'];

        $item = ListItemManagement::actionItem($item_id);

        if (is_array($item)) {
            foreach ($item as $item) {
                $item_name = $item->getitem_name();
                $item_details = $item->getItem_details();
                $due_date = substr($item->getDue_date(), 0, -9);
                $att = $item->getAttachments();
                $priority = $item->getPriority();
            }
        } else {
            echo 'No item';
        }
        ?>

        <div class="front-page-form" >
            <form class="login" >
                <div class="field">
                    <input type="text" class="form-control" id="item_name" name="item_name" <?php echo 'Value=' . '"' . $item_name . '"'; ?>/>
                </div>

                <div class="field">
                    <textarea name="item_details" id="item_details" maxlength="100" cols="20" rows="5"><?php echo $item_details; ?></textarea>
                </div>

                Priority: <select name="priority" id="priority">
                    <option value="0" <?php if($priority == 0){echo 'selected="selected"';} ?>>Low</option>
                    <option value="1" <?php if($priority == 1){echo 'selected="selected"';} ?>>Medium</option>
                    <option value="2" <?php if($priority == 2){echo 'selected="selected"';} ?>>High</option>
                </select>

                <div class="field">
                    <input id="due_date" class="form-control" placeholder="Due Date (Optional)" <?php echo 'Value=' . '"' . $due_date . '"'; ?> />
                </div>

                <div class="field">
                    <input type="checkbox" id="is_att" name="is_att" <?php
                    if ($att == 1) {
                        echo 'checked';
                    }
                    ?>/> Upload Attachment?
                </div>

                <div class="field">
                    <input type="hidden" id="list_id" name="list_id"  value=<?php echo $list_id; ?> /> 
                </div>

                <div class="field">
                    <input type="hidden" id="list_item_id" name="list_item_id"  value=<?php echo $item_id; ?> /> 
                </div>

                <div class="field">
                    <input type="file" id="att" name="att" /> 
                </div>

                <input type="button" id="submit" class="btn btn-success" value="Save changes" />
                <input type="button" id="return" class="btn btn-primary" value="Go back" />

            </form>


        </div>


        <script>

            $(document).ready(function () {

                $('input#return').click(function () {
                    $('<form action="/listr/items/index.php" method="POST">' +
                            '<input type="hidden" name="var" value="' + <?php echo $list_id ?> + '">' +
                            '</form>').submit();
                    return false;
                });


                if ($("#is_att").is(":checked")) {
                    $("#att").show();
                } else {
                    $("#att").hide();
                }


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
                    var file = $('input#att').val();
                    var listId = $('input#list_id').val();
                    var listItemId = $('input#list_item_id').val();
                    var priority = $('select#priority').val();


                    if (itemName != '' || itemDetails != '') {

                        $.post('process_edit.php', {item_name: itemName, item_details: itemDetails, priority: priority, due_date: due, file: file, list_id: listId, list_item_id: listItemId}, function (data) {
                            alert(data);
                            $('<form action="/listr/items/index.php" method="POST">' +
                                    '<input type="hidden" name="var" value="' + <?php echo $list_id ?> + '">' +
                                    '</form>').submit();
                        });
                    } else {
                        alert('Please enter an item name and item details');
                    }
                });


            });

        </script>















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