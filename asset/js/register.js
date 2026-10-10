
"use strict";

// ========================================
// GET ELEMENTS
// ========================================

var form = document.getElementById("signupForm");
var errorMsg = document.getElementById("errorMsg");

// ========================================
// SHOW / HIDE PASSWORD
// ========================================

var eyeButtons = document.querySelectorAll(".eye-btn");

for (var i = 0; i < eyeButtons.length; i++) {

    eyeButtons[i].addEventListener("click", function () {

        var inputId = this.getAttribute("data-target");
        var input = document.getElementById(inputId);

        if (input.type === "password") {

            input.type = "text";

            this.setAttribute(
                "aria-label",
                "Hide password"
            );

        } else {

            input.type = "password";

            this.setAttribute(
                "aria-label",
                "Show password"
            );

        }

    });

}

// ========================================
// FORM SUBMIT
// ========================================

form.addEventListener("submit", function (event) {

    // Stop submission until validation passes
    event.preventDefault();

    // ========================================
    // GET VALUES
    // ========================================

    var firstName =
        document.getElementById("firstName").value.trim();

    var lastName =
        document.getElementById("lastName").value.trim();

    var studentId =
        document.getElementById("studentId").value.trim();

    var email =
        document.getElementById("email").value.trim();

    var course =
        document.getElementById("course").value;

    var year =
        document.getElementById("year").value;

    var password =
        document.getElementById("password").value;

    var confirm =
        document.getElementById("confirm").value;

    var agree =
        document.getElementById("agree").checked;

    // ========================================
    // CLEAR OLD ERROR
    // ========================================

    errorMsg.textContent = "";

    // ========================================
    // CHECK EMPTY FIELDS
    // ========================================

    if (
        firstName === "" ||
        lastName === "" ||
        studentId === "" ||
        email === "" ||
        course === "" ||
        year === "" ||
        password === "" ||
        confirm === ""
    ) {

        errorMsg.textContent =
            "Please fill out all fields.";

        return;
    }

    // ========================================
    // CHECK STUDENT ID
    // Example: 2025-62390
    // ========================================

    var idPattern = /^\d{4}-\d{5}$/;

    if (!idPattern.test(studentId)) {

        errorMsg.textContent =
            "Student ID must look like 2025-62390.";

        return;
    }

    // ========================================
    // CHECK NCST EMAIL
    // ========================================

    var emailPattern =
        /^[a-z0-9._-]+@ncst\.edu\.ph$/i;

    if (!emailPattern.test(email)) {

        errorMsg.textContent =
            "Please use your NCST email.";

        return;
    }

    // ========================================
    // CHECK PASSWORD LENGTH
    // ========================================

    if (password.length < 8) {

        errorMsg.textContent =
            "Password must be at least 8 characters.";

        return;
    }

    // ========================================
    // CHECK PASSWORD MATCH
    // ========================================

    if (password !== confirm) {

        errorMsg.textContent =
            "Passwords do not match.";

        return;
    }

    // ========================================
    // CHECK TERMS
    // ========================================

    if (!agree) {

        errorMsg.textContent =
            "You must agree to the Terms and Privacy Policy.";

        return;
    }

    // ========================================
    // SUBMIT TO register.php
    // ========================================

    HTMLFormElement.prototype.submit.call(form);

});
