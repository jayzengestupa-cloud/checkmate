// get the form and the error message paragraph
var form = document.getElementById("signupForm");
var errorMsg = document.getElementById("errorMsg");

// ----- show / hide password -----
// the two icons: a normal eye (password is showing) and a crossed-out eye (password is hidden)
var eyeOpen = '<svg viewBox="0 0 24 24"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>';
var eyeClosed = '<svg viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-10-8-10-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 10 8 10 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><path d="M1 1l22 22"/></svg>';

// loop through every eye button
var eyeButtons = document.querySelectorAll(".eye-btn");
for (var i = 0; i < eyeButtons.length; i++) {
  eyeButtons[i].addEventListener("click", function () {
    // data-target tells us which input this button controls
    var inputId = this.getAttribute("data-target");
    var input = document.getElementById(inputId);

    if (input.type === "password") {
      input.type = "text";            // show the password
      this.innerHTML = eyeOpen;       // change to the normal eye
      this.setAttribute("aria-label", "Hide password");
    } else {
      input.type = "password";        // hide the password again
      this.innerHTML = eyeClosed;     // change back to the crossed-out eye
      this.setAttribute("aria-label", "Show password");
    }
  });
}

// ----- when the form is submitted -----
form.addEventListener("submit", function (event) {
  event.preventDefault(); // stop the page from reloading

  // get what the user typed
  var fullName = document.getElementById("fullName").value;
  var studentId = document.getElementById("studentId").value;
  var email = document.getElementById("email").value;
  var course = document.getElementById("course").value;
  var year = document.getElementById("year").value;
  var role = document.getElementById("role").value;
  var password = document.getElementById("password").value;
  var confirm = document.getElementById("confirm").value;
  var agree = document.getElementById("agree").checked;

  // check if anything is empty
  if (fullName === "" || studentId === "" || email === "" || course === "" || year === "" || role === "" || password === "" || confirm === "") {
    errorMsg.textContent = "Please fill out all fields.";
    return;
  }

  // role can only be student or admin
  if (role !== "student" && role !== "admin") {
    errorMsg.textContent = "Role must be Student or Admin.";
    return;
  }

  // check the student ID format: 4 digits, a dash, then 5 digits (example: 2025-62390)
  // \d means a digit, {4} means exactly 4 of them
  var idPattern = /^\d{4}-\d{5}$/;
  if (idPattern.test(studentId) === false) {
    errorMsg.textContent = "Student ID must look like 2025-62390.";
    return;
  }

  // check that the email is an NCST email (example: lastname.firstname@ncst.edu.ph)
  // the "i" at the end makes it not care about capital letters
  var emailPattern = /^[a-z0-9._-]+@ncst\.edu\.ph$/i;
  if (emailPattern.test(email) === false) {
    errorMsg.textContent = "Please use your NCST email (example: lastname.firstname@ncst.edu.ph).";
    return;
  }

  // check password length
  if (password.length < 8) {
    errorMsg.textContent = "Password must be at least 8 characters.";
    return;
  }

  // check if both passwords are the same
  if (password !== confirm) {
    errorMsg.textContent = "Passwords do not match.";
    return;
  }

  // check if the checkbox is ticked
  if (agree === false) {
    errorMsg.textContent = "You must agree to the Terms and Privacy Policy.";
    return;
  }

  // everything is okay, so send the data to PHP
  errorMsg.textContent = "";

  // put all the values in a FormData object so PHP can read them
  var formData = new FormData();
  formData.append("fullName", fullName);
  formData.append("studentId", studentId);
  formData.append("email", email);
  formData.append("course", course);
  formData.append("year", year);
  formData.append("role", role);
  formData.append("password", password);
  formData.append("confirm", confirm);

  fetch("/checkmate/authentication/register_process.php", {
    method: "POST",
    body: formData
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (result) {
      if (result === "success") {
        // account saved, go to the login page
        window.location.href = "/checkmate/authentication/Login/login.php";
      } else {
        // show the error from PHP (like "already registered")
        errorMsg.textContent = result;
      }
    });
});