const f_name = document.querySelector('#f_name');
const l_name = document.querySelector('#l_name');
const email = document.querySelector('#email');
const password = document.querySelector('#psw');
const cpassword = document.querySelector('#psw-repeat');
const username = document.querySelector('#username');
const togglePassword = document.querySelector('#togglePassword');
//getting the form elements
var loader = document.getElementById("preloader");
window.addEventListener("load", function () { loader.classList.add("inv"); });
document.getElementById("general-placeholder").style.width = document.width;
document.querySelector('#button_holder').addEventListener('mousedown', function (e) {
    // toggle the type attribute
    const type1 = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type1);
    const type2 = cpassword.getAttribute('type') === 'password' ? 'text' : 'password';
    cpassword.setAttribute('type', type2);
    // toggle the eye slash icon
    togglePassword.classList.toggle('fa-eye-slash');
});
document.querySelector('#button_holder').addEventListener('mouseup', function (e) {
    // toggle the type attribute
    const type1 = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type1);
    const type2 = cpassword.getAttribute('type') === 'password' ? 'text' : 'password';
    cpassword.setAttribute('type', type2);
    // toggle the eye slash icon
    togglePassword.classList.toggle('fa-eye-slash');
});

cpassword.addEventListener('focusout', function () {
    shakereset(cpassword, 'psw-repeat', 'spassword');
    if (!checkPassword(cpassword.value)) {
        shakechange(cpassword, "Password Should contain at least one number,one special character, one UpperCase & one LowerCase Letter", 'spassword');
    }
    else {
        if (password.value == cpassword.value) {
            shakereset(cpassword, 'psw-repeat', 'spassword');
        }
        else {
            shakechange(cpassword, "Password and Confirm Password Should match", 'spassword');
        }
    }
});

password.addEventListener('focusout', function () {
    shakereset(password, 'psw', 'spassword');
    if (!checkPassword(password.value)) {
        shakechange(password, "Password Should contain at least one number,one special character, one UpperCase & one LowerCase Letter", 'spassword');
    }
    else {
        shakereset(password, 'psw', 'spassword');
    }
});

f_name.addEventListener('focusout', function () {
    shakereset(f_name, 'f_name', 'sname');
    if (f_name.value.length <= 2) {
        shakechange(f_name, "Name Should contain atleast 2 letters", 'sname');
    }
    else {
        shakereset(f_name, 'f_name', 'sname');
    }
});
l_name.addEventListener('focusout', function () {
    shakereset(l_name, "l_name", 'sname');
    if (l_name.value.length <= 2) {
        shakechange(l_name, "Name Should contain atleast 2 letters ", 'sname');
    }
    else {
        shakereset(l_name, "l_name", 'sname');
    }
});
email.addEventListener('focusout', function () {
    shakereset(email, 'email', 'semail');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var resp = this.responseText;
            if (resp == "1") {
                shakereset(email, 'email', 'semail');
            }
            else {
                shakechange(email, "enter a valid mail id", 'semail');
            }
        }
    };
    xmlhttp.open("GET", "/register/php/email_validator.php?email=" + email.value, true);
    xmlhttp.send();
});

username.addEventListener('focusout', function () {
    shakereset(username, 'username', 'susername');
    if (validateUserName(username.value)) {
        shakereset(username, "username", 'susername');
        var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var resp = this.responseText;
            if (resp=="1") {
               shakereset(username, "username", 'susername');
            }
            else {
                shakechange(username, "UserName is already taken", 'susername');
            }
        }
    };
    xmlhttp.open("GET", "/register/php/username_validator.php?username=" + username.value, true);
    xmlhttp.send();
    }
    else {
        shakechange(username, "UserName must be greater than 3 characters and can only contain letters and numbers", 'susername');
    }


});


function register_call() {
    loader.classList.remove("inv");
}

function validateUserName(usernamet) {
    var usernameRegex = /^[a-zA-Z0-9]+$/;
    return usernameRegex.test(usernamet);
}
function shakereset(temp, animated, id) {

    temp.style.border = "";
    temp.setCustomValidity('');
    temp.classList.remove("apply-shake");
    document.getElementById("d" + id).style.display = "none";
    reset_animation(animated)
}
function shakechange(temp, message, id) {
    temp.style.border = "thin solid  red";
    temp.setCustomValidity(message);
    temp.classList.add("apply-shake");
    document.getElementById(id).textContent = message;
    document.getElementById("d" + id).style.display = "block";

}
function reset_animation(animated) {
    var el = document.getElementById(animated);
    el.style.animation = 'none';
    el.offsetHeight; /* trigger reflow */
    el.style.animation = null;
}
function checkPassword(str) {
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
    return re.test(str);
}
function insert_error(error_message,id){
    document.getElementById(id).textContent = error_message;
    document.getElementById("d" + id).style.display = "block";
}
function insert_value(postval,id){
    document.getElementById(id).value = postval;
}