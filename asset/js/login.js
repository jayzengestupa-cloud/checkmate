/* =========================================
   CHECKMATE LOGIN JAVASCRIPT
========================================= */


/* =========================================
   GET ELEMENTS
========================================= */

const accountOptions =
    document.querySelectorAll(".account-option");

const passwordInput =
    document.getElementById("password");

const passwordToggle =
    document.getElementById("passwordToggle");

const eye =
    document.getElementById("eye");

const eyeSlash =
    document.getElementById("eyeSlash");

const loginForm =
    document.getElementById("loginForm");

const usernameInput =
    document.getElementById("username");

const forgotPassword =
    document.getElementById("forgotPassword");

const registerLink =
    document.getElementById("registerLink");

const toast =
    document.getElementById("toast");


/* =========================================
   DEFAULT ACCOUNT TYPE
========================================= */

// the hidden input that gets sent to PHP
const accountTypeInput =
    document.getElementById("accountType");

// start with whatever PHP put in the hidden input (student or admin)
let accountType = accountTypeInput.value;


/* =========================================
   ACCOUNT TYPE SELECTION
========================================= */

accountOptions.forEach(function(option) {

    option.addEventListener("click", function() {


        /* Remove active from all */
        accountOptions.forEach(function(item) {

            item.classList.remove("active");

        });


        /* Add active to clicked option */
        option.classList.add("active");


        /* Save account type */
        accountType = option.dataset.type;


        /* Also save it in the hidden input so PHP receives it */
        accountTypeInput.value = accountType;


        /* Small feedback */
        if (accountType === "student") {

            showToast("Student account selected.");

        } else {

            showToast("Admin account selected.");

        }

    });

});


/* =========================================
   PASSWORD SHOW / HIDE
========================================= */

passwordToggle.addEventListener("click", function() {


    if (passwordInput.type === "password") {


        /* Show password */

        passwordInput.type = "text";


        eye.classList.remove("hidden");

        eyeSlash.classList.add("hidden");


        passwordToggle.setAttribute(
            "aria-label",
            "Hide password"
        );


    } else {


        /* Hide password */

        passwordInput.type = "password";


        eye.classList.add("hidden");

        eyeSlash.classList.remove("hidden");


        passwordToggle.setAttribute(
            "aria-label",
            "Show password"
        );

    }

});


/* =========================================
   TOAST FUNCTION
========================================= */

function showToast(message) {

    toast.textContent = message;

    toast.classList.add("show");


    setTimeout(function() {

        toast.classList.remove("show");

    }, 2300);

}


/* =========================================
   LOGIN FORM
========================================= */

loginForm.addEventListener("submit", function(event) {


    /* Stop the form from sending for now.
       We check the inputs first, then send it with loginForm.submit() below. */
    event.preventDefault();


    /* Get input values */
    const username =
        usernameInput.value.trim();

    const password =
        passwordInput.value.trim();


    /* =====================================
       CHECK USERNAME
    ====================================== */

    if (username === "") {

        showToast(
            "Please enter your username or email."
        );

        usernameInput.focus();

        return;
    }


    /* =====================================
       CHECK PASSWORD
    ====================================== */

    if (password === "") {

        showToast(
            "Please enter your password."
        );

        passwordInput.focus();

        return;
    }


    /* =====================================
       SEND TO PHP

       Both fields are filled in, so we
       submit the form to login.php.
       PHP checks the username, password
       and account type, then redirects
       to student_home.php or admin_home.php.
    ====================================== */

    loginForm.submit();

});


/* =========================================
   FORGOT PASSWORD
========================================= */

forgotPassword.addEventListener("click", function(event) {

    event.preventDefault();


    showToast(
        "Password recovery will be available soon."
    );

});


/* =========================================
   REGISTER
========================================= */

registerLink.addEventListener("click", function(event) {

    event.preventDefault();


    showToast(
        "Registration page will open here."
    );


    /*
    Later:

    window.location.href =
        "register.html";
    */

});


/* =========================================
   SHOW ERROR FROM PHP

   If login.php found a problem (wrong
   password, wrong account type, etc.)
   it puts the message in data-message.
========================================= */

if (toast.dataset.message !== "") {

    showToast(toast.dataset.message);

}