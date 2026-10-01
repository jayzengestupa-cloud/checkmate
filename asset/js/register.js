/* =========================================
   CHECKMATE REGISTER JAVASCRIPT
========================================= */


/* =========================================
   GET ELEMENTS
========================================= */

const registerForm =
    document.getElementById("registerForm");

const firstNameInput =
    document.getElementById("firstName");

const lastNameInput =
    document.getElementById("lastName");

const usernameInput =
    document.getElementById("username");

const emailInput =
    document.getElementById("email");

const studentNumberInput =
    document.getElementById("studentNumber");

const courseInput =
    document.getElementById("course");

const passwordInput =
    document.getElementById("password");

const confirmPasswordInput =
    document.getElementById("confirmPassword");

const passwordToggle =
    document.getElementById("passwordToggle");

const confirmPasswordToggle =
    document.getElementById("confirmPasswordToggle");

const eye =
    document.getElementById("eye");

const eyeSlash =
    document.getElementById("eyeSlash");

const confirmEye =
    document.getElementById("confirmEye");

const confirmEyeSlash =
    document.getElementById("confirmEyeSlash");

const termsCheckbox =
    document.getElementById("terms");

const loginLink =
    document.getElementById("loginLink");

const toast =
    document.getElementById("toast");


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
   CONFIRM PASSWORD SHOW / HIDE
========================================= */

confirmPasswordToggle.addEventListener(
    "click",
    function() {


        if (confirmPasswordInput.type === "password") {


            /* Show confirm password */

            confirmPasswordInput.type = "text";


            confirmEye.classList.remove("hidden");

            confirmEyeSlash.classList.add("hidden");


            confirmPasswordToggle.setAttribute(
                "aria-label",
                "Hide password"
            );


        } else {


            /* Hide confirm password */

            confirmPasswordInput.type = "password";


            confirmEye.classList.add("hidden");

            confirmEyeSlash.classList.remove("hidden");


            confirmPasswordToggle.setAttribute(
                "aria-label",
                "Show password"
            );

        }

    }
);


/* =========================================
   REGISTER FORM
========================================= */

registerForm.addEventListener(
    "submit",
    function(event) {


        /* Prevent page refresh */

        event.preventDefault();


        /* =====================================
           GET INPUT VALUES
        ====================================== */

        const firstName =
            firstNameInput.value.trim();

        const lastName =
            lastNameInput.value.trim();

        const username =
            usernameInput.value.trim();

        const email =
            emailInput.value.trim();

        const studentNumber =
            studentNumberInput.value.trim();

        const course =
            courseInput.value.trim();

        const password =
            passwordInput.value.trim();

        const confirmPassword =
            confirmPasswordInput.value.trim();


        /* =====================================
           CHECK FIRST NAME
        ====================================== */

        if (firstName === "") {

            showToast(
                "Please enter your first name."
            );

            firstNameInput.focus();

            return;
        }


        /* =====================================
           CHECK LAST NAME
        ====================================== */

        if (lastName === "") {

            showToast(
                "Please enter your last name."
            );

            lastNameInput.focus();

            return;
        }


        /* =====================================
           CHECK USERNAME
        ====================================== */

        if (username === "") {

            showToast(
                "Please enter a username."
            );

            usernameInput.focus();

            return;
        }


        /* =====================================
           CHECK EMAIL
        ====================================== */

        if (email === "") {

            showToast(
                "Please enter your email."
            );

            emailInput.focus();

            return;
        }


        /* =====================================
           BASIC EMAIL CHECK
        ====================================== */

        if (
            !email.includes("@") ||
            !email.includes(".")
        ) {

            showToast(
                "Please enter a valid email."
            );

            emailInput.focus();

            return;
        }


        /* =====================================
           CHECK STUDENT NUMBER
        ====================================== */

        if (studentNumber === "") {

            showToast(
                "Please enter your student number."
            );

            studentNumberInput.focus();

            return;
        }


        /* =====================================
           CHECK COURSE
        ====================================== */

        if (course === "") {

            showToast(
                "Please enter your course."
            );

            courseInput.focus();

            return;
        }


        /* =====================================
           CHECK PASSWORD
        ====================================== */

        if (password === "") {

            showToast(
                "Please enter a password."
            );

            passwordInput.focus();

            return;
        }


        /* =====================================
           PASSWORD LENGTH
        ====================================== */

        if (password.length < 8) {

            showToast(
                "Password must be at least 8 characters."
            );

            passwordInput.focus();

            return;
        }


        /* =====================================
           CHECK CONFIRM PASSWORD
        ====================================== */

        if (confirmPassword === "") {

            showToast(
                "Please confirm your password."
            );

            confirmPasswordInput.focus();

            return;
        }


        /* =====================================
           CHECK PASSWORD MATCH
        ====================================== */

        if (password !== confirmPassword) {

            showToast(
                "Passwords do not match."
            );

            confirmPasswordInput.focus();

            return;
        }


        /* =====================================
           CHECK TERMS
        ====================================== */

        if (!termsCheckbox.checked) {

            showToast(
                "Please agree to the terms."
            );

            return;
        }


        /* =====================================
           TEMPORARY REGISTRATION
           
           This will later connect to PHP
           and MySQL.
        ====================================== */

        showToast(
            "Registration submitted successfully."
        );


        /*
        Later:

        window.location.href =
            "login.php";
        */

    }
);


/* =========================================
   LOGIN LINK
========================================= */

loginLink.addEventListener(
    "click",
    function(event) {

        event.preventDefault();


        /*
        Later:

        window.location.href =
            "login.html";
        */


        showToast(
            "Returning to login..."
        );

    }
);