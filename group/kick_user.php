<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/group/GroupManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");


if (GroupManagement::actionRemoveUser() == true) {
    echo 'User deleted, redirecting...';
} else {
    echo 'Error deleting user, redirecting...';
}
?>

<script>

    $('<form action="/listr/group/admin.php" method="POST">' +
            '<input type="hidden" name="group_id" value="' + <?php echo $_POST['group_id'] ?> + '">' +
            '</form>').submit();
</script>
