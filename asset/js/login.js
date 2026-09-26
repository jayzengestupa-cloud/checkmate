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

let accountType = "student";


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


    /* Prevent page refresh */
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
       TEMPORARY LOGIN

       This will later connect to PHP
       and MySQL.
    ====================================== */

    if (accountType === "student") {

        showToast(
            "Student login selected."
        );


        /*
        Later:

        window.location.href =
            "student.html";
        */

    } else {

        showToast(
            "Admin login selected."
        );


        /*
        Later:

        window.location.href =
            "admin.html";
        */

    }

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