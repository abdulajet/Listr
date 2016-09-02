<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/listr/includes/db_connect.php';
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/login_check.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
?>





<title>Listr</title>
</head>

<body>

    <?php if ($loggedIn == true) :
        require_once ( $_SERVER['DOCUMENT_ROOT'] . "/listr/includes/nav_bar.php");?>

     

    
        <div class="front-welcome">
            <h1>Welcome to the Listr Beta.</h1>
            <h4>A new platform that allows for easy
                sharing of list with your friends and colleagues.</h4>
            
            <br>
            <hr>
            
            <h2>Known bugs: </h2>
            <h4>. File upload not functioning</h4>
            
            
            <br>
            <hr>
            
            <h2>For support:  </h2>
            <h4>. Email: abdulhakim@5to9studios.com</h4>
            <h4>. Website: <a href="http://5to9studios.com" target="_blank">5to9studios.com</a></h4>
            
        </div>
        
   
    



    <!--Footer-->
    <footer>
        © 5to9 Studios      Made with Bootstrap
    </footer>


<?php else : ?>
    <p class="returnLogBlue">
        <span >You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
    </p>

<?php endif; ?>

</body>
</html>
