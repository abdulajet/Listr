<!DOCTYPE html>
<!Nav bar>
    <div class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/listr/home.php"> Listr!</a>
        </div>
        <div class="navbar-collapse collapse navbar-responsive-collapse">

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Lists <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/listr/lists/index.php"> My Lists </a></li>
                        <li><a href="#cListModal" data-toggle="modal" data-target="#cListModal"> New Personal List</a></li>
                        
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Group <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/listr/group/index.php"> My groups </a></li>
                        <li><a href="#cGroupModal" data-toggle="modal" data-target="#cGroupModal"> Create group </a></li>
                        <li><a href="#jGroupModal" data-toggle="modal" data-target="#jGroupModal"> Join group </a></li>
                    </ul>
                </li>

                <li><a href="/listr/account/index.php">My Account</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/listr/includes/logout.php">Logout</a></li>

            </ul>
        </div>
    </div>

<!-- /.modal create list -->
    <div class="modal fade" id="cListModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Enter list name</h4>

                </div>


                <div class="modal-body">

                    <div class="front-page-form">
                        <form class="login" name="cList_form" id="cList_form" action="/listr/lists/create.php" method="post" >
                            <div class="field">
                                <input type="text" class="form-control" name="list_name" id="list_name" maxlength="15" placeholder="List Name">
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="return vListName(document.getElementById('cList_form'),
                                                    document.getElementById('list_name'));">Create list!</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

    <!-- /.modal create group -->
    <div class="modal fade" id="cGroupModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Create a Listr group:</h4>

                </div>

                <div class="modal-body">

                    <div class="front-page-form">
                        <form class="login" name="cGroup_form" id="cGroup_form" action="/listr/group/create.php" method="post" >
                            <div class="field">
                                <input type="text" class="form-control" name="group_name" id="group_name" maxlength="30" placeholder="Group Name">
                            </div>

                            <div class="field">
                                <input type="password" class="form-control" name="group_passsword" id="group_passsword" maxlength="15" placeholder="Password">
                            </div>
                            
                            <div class="field">
                                <input type="password" class="form-control" name="group_passsword_c" id="group_passsword_c" maxlength="15" placeholder="Confirm password">
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="return vGroup(document.getElementById('cGroup_form'),
                                                document.getElementById('group_name'),
                                                document.getElementById('group_passsword'),
                                                document.getElementById('group_passsword_c'));">
                            Create group!</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>



    <!-- /.modal join group -->
    <div class="modal fade" id="jGroupModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Join a Listr group:</h4>

                </div>

                <div class="modal-body">

                    <div class="front-page-form">
                        <form class="login" name="jGroup_form" id="form" action="/listr/group/join.php" method="post" >
                            <div class="field">
                                <input type="text" class="form-control" name="name" id="name" maxlength="30" placeholder="Group Name">
                            </div>

                            <div class="field">
                                <input type="password" class="form-control" name="password" id="password" maxlength="15" placeholder="Password">
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="return vJoinGroup(document.getElementById('form'),
                                                document.getElementById('name'),
                                                document.getElementById('password'));">
                            Join group!</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>