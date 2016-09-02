<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/login_check.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
?>
<title>Listr!</title>
</head>

<body class="front-page"> 



    <?php
    if (isset($_GET['error'])) {
        echo '<p class="returnLog">Error Logging In!</p>';
    }
    ?> 


    <div class="front-card">
        <div class="front-welcome">
            <h1>Welcome to Listr.</h1>
            <p>A new platform that allows for easy
                sharing of list with your friends and colleagues.</p>
        </div>

        <div class="front-page-form">
            <form id="login_form" class="login" name="login_form" action="account/login.php" method="post" >
                <div class="field">
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="field">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <button type="button" class="btn btn-default" onclick="location.href = 'account/create.php'"> 
                    New User? </button> 
                <input type="button" class="btn btn-primary" value="Login" onclick="formhash(this.form, this.form.email, this.form.password);" />
                <a href="/listr/account/recover.php">Forgot password?</a><br>
            </form>
        </div> 
    </div>



    <footer>
        © 5to9 Studios      Made with Bootstrap
    </footer>


</body>
</html>