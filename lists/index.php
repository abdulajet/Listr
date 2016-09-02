<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/ListManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/list/ListItemManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/login_check.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
?>

<title>Listr - My Lists</title>
</head>
<body>
    <?php
    if ($loggedIn == true) :
        require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");
        $lists = ListManagement::actionList();

        if (is_array($lists)) {
            foreach ($lists as $lists) {
                $listid = $lists->getListId();
                $listname = $lists->getList_name();
                ?>
                <div>
                    <br>
                    &nbsp;<span><?php echo 'List - ' . $listname; ?></span>
                    <button class="btn btn-primary" onclick="editLoad(<?php echo $listid ?>);">View/Edit</button>
                    <button class="btn btn-danger" onclick="deleteLoad(<?php echo $listid ?>);" >Delete</button>
                    <?php
                }
            } else {
                echo 'no lists';
            }
            ?>

            <br>
            <hr>
            <div>
                <a href="#cListModal" data-toggle="modal" data-target="#cListModal"><button class="btn btn-primary">Create a new list</button></a>
            </div>




        </div>
    </body>

    <!--Footer-->
    <footer>
        © 5to9 Studios      Made with Bootstrap
    </footer>


    <script>

        function editLoad(listId) {
            $(document).ready(function () {
                $('<form action="/listr/items/index.php" method="POST">' +
                        '<input type="hidden" name="var" value="' + listId + '">' +
                        '</form>').submit();
            });
        }

        function deleteLoad(listId) {
            $(document).ready(function () {

                if (confirm('Are you sure you want to delete this list?')) {
                    $('<form action="delete.php" method="POST">' +
                            '<input type="hidden" name="var" value="' + listId + '">' +
                            '</form>').submit();
                }


            });
        }



    </script>

<?php else : ?>
    <p class="returnLogBlue">
        <span >You are not authorized to access this page.</span> Please <a href="../index.php">login</a>.
    </p>

<?php endif;