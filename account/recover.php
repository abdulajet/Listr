<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/controller/account/AccountManagement.php");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/doctype_includes.php");
?>


<title>Listr - Forgot password</title>
</head>

<body>

    <div class="container">
        <h1>Recover your account:</h1>

        <div>
            <h3>&nbsp Enter your email to get your recovery question:</h3>
            <div class="front-page-form" >
                <form id="rEmail_form" class="login" name="rEmail_form">
                    <div class="field">
                        <input type="text" class="form-control" id="rEmail" name="rEmail" placeholder="Email"/>
                    </div>

                    <input type="button" id="submit" class="btn btn-primary" value="Recover" />
                </form>
            </div>
        </div>



    </div>

    <script>

        $(document).ready(function () {

            $('input#submit').on('click', function () {

                var email = $('input#rEmail').val();

                if ($.trim(email) == '') {
                    alert('Please enter an email address');
                } else {
                    var x = email;
                    var atPos = x.lastIndexOf("@");
                    var dotPos = x.lastIndexOf(".");
                    if (atPos < 1 || dotPos < atPos + 2 || dotPos + 2 >= x.length) {
                        alert('Not a valid e-mail address');
                    } else {
                        $.post('recovery_ajax.php', {email: email}, function (data) {

                            if (data.length < 30) {
                                $("h1").remove();
                                $("h3").remove();
                                $(".container").prepend("<h3> Your recovery question is: " + data + "</h3>");
                                $(".container").prepend("<h1> Recover your account:</h1>");
                                $(".front-page-form").empty();
                                $(".front-page-form").prepend("<form id='rAnswer_form' class='login' name='rAnswer_form' action='process_recovery.php' method='post'></form>");
                                $(".login").append("<div class='field'></div>");
                                $(".field").append("<input type='text' class='form-control' id='rAnswer' name='rAnswer' placeholder='Recovery answer'/> ");
                                $(".login").append("<input type='button' id='submitRA' class='btn btn-success' value='Recover' onclick='checkRA(this.form, this.form.rAnswer);'/>");
                            } else {
                                alert("This email is not registered on Listr.");
                            }

                        });
                    }
                }
            });

        });

    </script>



    <footer>
        © 5to9 Studios      Made with Bootstrap
    </footer>
</body>
