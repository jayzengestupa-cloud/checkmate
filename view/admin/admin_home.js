/* =========================================
   CHECKMATE ADMIN HOME
   admin_home.js
   ========================================= */


/* =========================================
   1. GET ELEMENTS
   ========================================= */

const toast = document.getElementById("toast");

const sidebarLinks = document.querySelectorAll(".sidebar-menu a");

const quickCards = document.querySelectorAll(".quick-card");

const verifyButton = document.getElementById("verifyButton");

const notificationButton = document.getElementById("notificationButton");

const userMore = document.getElementById("userMore");

const viewStudents = document.getElementById("viewStudents");

const viewReports = document.getElementById("viewReports");


/* =========================================
   2. TOAST FUNCTION
   ========================================= */

function showToast(message) {

    toast.textContent = message;

    toast.classList.add("show");

    setTimeout(function () {

        toast.classList.remove("show");

    }, 2500);
}


/* =========================================
   3. SIDEBAR MENU
   ========================================= */

sidebarLinks.forEach(function(link) {

    link.addEventListener("click", function(event) {

        event.preventDefault();


        /* Remove active from all links */

        sidebarLinks.forEach(function(item) {

            item.classList.remove("active");

        });


        /* Add active to selected link */

        this.classList.add("active");


        /* Get selected page */

        const page = this.getAttribute("data-page");


        /* Temporary front-end message */

        if (page === "dashboard") {

            showToast("Dashboard selected.");

        }

        else if (page === "students") {

            showToast("Student management selected.");

        }

        else if (page === "questions") {

            showToast("Question management selected.");

        }

        else if (page === "collaborations") {

            showToast("Collaboration management selected.");

        }

        else if (page === "messages") {

            showToast("Messages selected.");

        }

        else if (page === "enrollment") {

            showToast("Enrollment selected.");

        }

        else if (page === "subjects") {

            showToast("Subjects & Courses selected.");

        }

        else if (page === "types") {

            showToast("Question Types selected.");

        }

        else if (page === "reports") {

            showToast("Reports selected.");

        }

        else if (page === "profile") {

            showToast("Admin Profile selected.");

        }

        else if (page === "settings") {

            showToast("Settings selected.");

        }

    });

});


/* =========================================
   4. VERIFY STUDENTS BUTTON
   ========================================= */

if (verifyButton) {

    verifyButton.addEventListener("click", function() {

        showToast("Opening student verification...");

    });

}


/* =========================================
   5. NOTIFICATION BUTTON
   ========================================= */

if (notificationButton) {

    notificationButton.addEventListener("click", function() {

        showToast("You have 3 new notifications.");

    });

}


/* =========================================
   6. ADMIN PROFILE BUTTON
   ========================================= */

if (userMore) {

    userMore.addEventListener("click", function() {

        showToast("Administrator account selected.");

    });

}


/* =========================================
   7. VIEW STUDENTS
   ========================================= */

if (viewStudents) {

    viewStudents.addEventListener("click", function(event) {

        event.preventDefault();

        showToast("Opening student registrations...");

    });

}


/* =========================================
   8. VIEW REPORTS
   ========================================= */

if (viewReports) {

    viewReports.addEventListener("click", function(event) {

        event.preventDefault();

        showToast("Opening reports...");

    });

}


/* =========================================
   9. QUICK ACCESS CARDS
   ========================================= */

quickCards.forEach(function(card) {

    card.addEventListener("click", function() {

        const action = this.getAttribute("data-action");


        if (action === "enrollment") {

            showToast("Enrollment management selected.");

        }

        else if (action === "subjects") {

            showToast("Subjects & Courses selected.");

        }

        else if (action === "types") {

            showToast("Question Types selected.");

        }

        else if (action === "reports") {

            showToast("Reports management selected.");

        }

    });

});


/* =========================================
   10. PAGE LOAD
   ========================================= */

window.addEventListener("load", function() {

    console.log("CHECKMATE Admin Dashboard loaded.");

});