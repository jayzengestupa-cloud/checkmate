/* =========================================
   CHECKMATE ADMIN HOME
   index.js
   ========================================= */


/* =========================================
   1. GET ELEMENTS
   ========================================= */

const toast = document.getElementById("toast");

const sidebarLinks = document.querySelectorAll(".sidebar-menu a");

const quickCards = document.querySelectorAll(".quick-card");

const verifyButton = document.getElementById("verifyButton");

const notificationButton = document.getElementById("notificationButton");

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

sidebarLinks.forEach(function (link) {

    link.addEventListener("click", function (event) {

        // CHANGED: links that go to a real page (like students.html)
        // should just open normally, so we stop here for them
        if (this.getAttribute("href") !== "#") {
            return;
        }

        // the pages that are not built yet only show a message
        event.preventDefault();

        // TODO: remove this message when the other pages exist
        showToast("That page is not built yet.");

    });

});


/* =========================================
   4. VERIFY STUDENTS BUTTON
   ========================================= */

if (verifyButton) {

    verifyButton.addEventListener("click", function () {

        // CHANGED: goes to the students page now
        // TODO: later filter the students page to Pending only
        window.location.href = "students.html";

    });

}


/* =========================================
   5. NOTIFICATION BUTTON
   ========================================= */

if (notificationButton) {

    notificationButton.addEventListener("click", function () {

        showToast("You have 3 new notifications.");

    });

}


/* =========================================
   6. VIEW REPORTS
   ========================================= */

if (viewReports) {

    viewReports.addEventListener("click", function (event) {

        event.preventDefault();

        showToast("Opening reports...");

    });

}

/* NOTE: the "View all" link for students is a normal link
   to students.html now, so it does not need any JavaScript. */


/* =========================================
   7. QUICK ACCESS CARDS
   ========================================= */

quickCards.forEach(function (card) {

    card.addEventListener("click", function () {

        const action = this.getAttribute("data-action");

        if (action === "enrollment") {

            // enrollment is adding students, which is on the students page
            window.location.href = "students.html";

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
   8. PAGE LOAD
   ========================================= */

window.addEventListener("load", function () {

    console.log("CHECKMATE Admin Dashboard loaded.");

});

// ---------- ACCOUNT MENU (3 dots) ----------
var accountButton = document.getElementById("accountMenuButton");
var accountMenu = document.getElementById("accountMenu");

accountButton.addEventListener("click", function (event) {
    event.stopPropagation();
    accountMenu.classList.toggle("show");
    accountButton.classList.toggle("open");
});

// clicking anywhere else (or pressing Esc) closes it
document.addEventListener("click", function () {
    accountMenu.classList.remove("show");
    accountButton.classList.remove("open");
});

document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        accountMenu.classList.remove("show");
        accountButton.classList.remove("open");
    }
});