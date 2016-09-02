<form id="popup_login" class="login" name="login_form" action="includes/process_login.php" method="post" >
    <div class="field">
        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
    </div>
    <div class="field">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
    <button type="button" class="btn btn-default" onclick="/account/create"> 
        New User? </button>  
    <input type="button" class="btn btn-primary" value="Login" onclick="formhash(this.form, this.form.email, this.form.password);" />
</form>