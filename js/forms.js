//login form
function formhash(form, email, password) {

    if (email.value == '' || password.value == '') {

        alert('You must provide all the requested details. Please try again');
        return false;
    }

    var p = document.createElement("input");
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    password.value = "";
    form.submit();
    return true;
}

//reg form
function regformhash(form, uid, password, conf, email, rQ, rA) {
// Check each field has a value
    if (uid.value == '' || email.value == '' || password.value == '' || conf.value == '' || rQ.value == '' || rA.value == '') {

        alert('You must provide all the requested details. Please try again');
        return false;
    }

// Check the username
    re = /^\w+$/;
    if (!re.test(form.username.value)) {
        alert("Username must contain only letters, numbers and underscores. Please try again");
        form.username.focus();
        return false;
    }


    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }


// Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }

//email 
    var x = email.value;
    var atPos = x.lastIndexOf("@");
    var dotPos = x.lastIndexOf(".");
    if (atPos < 1 || dotPos < atPos + 2 || dotPos + 2 >= x.length) {
        alert('Not a valid e-mail address');
        form.email.focus();
        return false;
    }

//hash pass
    var p = document.createElement("input");
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    password.value = "";
    conf.value = "";
    // Finally submit the form. 
    form.submit();
    return true;
}

// create list form
function vListName(form, lName) {

    if (lName.value == '') {

        alert('You must provide a list name.');
        return false;
    }

    form.submit();
    return true;
}

// create group form 
function vGroup(form, gName, gPass, gPassCon) {

    if (gName.value == '') {

        alert('You must provide a group name.');
        return false;
    }

    if(gPass.value != gPassCon.value){
        alert('Your password and confirmation do not match. Please try again');
        return false;
    }



    if (gPass.value == '') {

        alert('You must provide a group password.');
        return false;
    } else if (gPass.value.length < 6) {
        alert('Password must be at least 6 characters long.  Please try again');
        return false;
    }


//hash pass
    var p = document.createElement("input");
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(gPass.value);
    gPass.value = "";
    gPassCon.value ="";
    form.submit();
    return true;
}

//change pass
function updatePass(form, currentPass, pass, cPass) {

    if (pass.value.length == '' || currentPass.value.length == '' || cPass.value.length == '') {
        alert('Please fill in the passsword fields');
        form.pass.focus();
        return false;
    }


    if (pass.value.length < 6 || currentPass.value.length < 6 || cPass.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.pass.focus();
        return false;
    }

// Check password and confirmation are the same
    if (pass.value != cPass.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }

//hash old pass
    var pCurrent = document.createElement("input");
    form.appendChild(pCurrent);
    pCurrent.name = "p_current";
    pCurrent.type = "hidden";
    pCurrent.value = hex_sha512(currentPass.value);
    //hash new pass
    var pNew = document.createElement("input");
    form.appendChild(pNew);
    pNew.name = "p_new";
    pNew.type = "hidden";
    pNew.value = hex_sha512(pass.value);
    currentPass.value = "";
    pass.value = "";
    cPass.value = "";
    // Finally submit the form. 
    form.submit();
    return true;
}

//change email
function updateEmail(form, currentEmail, email, cEmail) {

    if (email.value == '' || cEmail.value == '' || currentEmail.value == '') {
        alert('Please fill in the email fields');
        return false;
    }

    if (email.value != cEmail.value) {
        alert('Emails do not match');
        return false;
    }

    var x = email.value;
    var atPos = x.lastIndexOf("@");
    var dotPos = x.lastIndexOf(".");
    if (atPos < 1 || dotPos < atPos + 2 || dotPos + 2 >= x.length) {
        alert('Not a valid e-mail address');
        form.email.focus();
        return false;
    }

    form.submit();
    return true;
}


//change recovery
function updateRecovery(form, currentAnswer, answer, cAnswer) {

    if (currentAnswer.value == '' || answer.value == '' || cAnswer.value == '') {
        alert('Please fill in the recovery fields');
        return false;
    }
    form.submit();
    return true;

}

function checkRA(form, ra) {
    if (ra.value == '') {
        alert('Please provide a recovery answer');
        return false;
    }
    form.submit();
    return true;

}

function recoverPass(form, password, conf) {

    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }


// Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }


//hash pass
    var p = document.createElement("input");
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    password.value = "";
    conf.value = "";
    // Finally submit the form. 
    form.submit();
    return true;
}


function inviteCheck(form, email) {

    if (email.value == '') {
        alert('Please enter an email');
        return false;
    }

    var x = email.value;
    var atPos = x.lastIndexOf("@");
    var dotPos = x.lastIndexOf(".");
    if (atPos < 1 || dotPos < atPos + 2 || dotPos + 2 >= x.length) {
        alert('Not a valid e-mail address');
        form.email.focus();
        return false;
    }
    
    form.submit();
    return true;

}

//update group pass
function updateGroupPass(form, gname, currentPass, pass, cPass) {

    if (gname.value.length == '' ||pass.value.length == '' || currentPass.value.length == '' || cPass.value.length == '') {
        alert('Please fill in the fields');
        return false;
    }


    if (pass.value.length < 6 || currentPass.value.length < 6 || cPass.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        return false;
    }

// Check password and confirmation are the same
    if (pass.value != cPass.value) {
        alert('Your password and confirmation do not match. Please try again');
        return false;
    }

//hash old pass
    var pCurrent = document.createElement("input");
    form.appendChild(pCurrent);
    pCurrent.name = "p_current";
    pCurrent.type = "hidden";
    pCurrent.value = hex_sha512(currentPass.value);
    
    //hash new pass
    var pNew = document.createElement("input");
    form.appendChild(pNew);
    pNew.name = "p_new";
    pNew.type = "hidden";
    pNew.value = hex_sha512(pass.value);
    
    currentPass.value = "";
    pass.value = "";
    cPass.value = "";
    // Finally submit the form. 
    form.submit();
    return true;
}

function vJoinGroup(form, gName, gPass){
     if (gName.value == '') {

        alert('You must provide a group name.');
        return false;
    }


    if (gPass.value == '') {

        alert('You must provide a group password.');
        return false;
    } 


//hash pass
    var p = document.createElement("input");
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(gPass.value);
    gPass.value = "";
    form.submit();
    return true;
}