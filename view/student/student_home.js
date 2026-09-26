/* =========================================
   CHECKMATE STUDENT HOME JAVASCRIPT
========================================= */


/* =========================================
   GET ELEMENTS
========================================= */

const newQuestionButton =
    document.getElementById("newQuestionButton");

const questionInput =
    document.getElementById("questionInput");

const askBox =
    document.getElementById("askBox");

const askButton =
    document.getElementById("askButton");

const attachmentButton =
    document.getElementById("attachmentButton");

const subjectButton =
    document.getElementById("subjectButton");

const typeButton =
    document.getElementById("typeButton");

const helpButton =
    document.getElementById("helpButton");

const userMore =
    document.getElementById("userMore");

const viewQuestions =
    document.getElementById("viewQuestions");

const toast =
    document.getElementById("toast");


/* =========================================
   TOAST MESSAGE
========================================= */

function showToast(message) {

    toast.textContent = message;

    toast.classList.add("show");


    setTimeout(function() {

        toast.classList.remove("show");

    }, 2300);

}


/* =========================================
   NEW QUESTION BUTTON
========================================= */

newQuestionButton.addEventListener("click", function() {


    /* Scroll to question area */

    askBox.scrollIntoView({
        behavior: "smooth",
        block: "center"
    });


    /* Focus textarea */

    setTimeout(function() {

        questionInput.focus();

    }, 450);


    showToast("Ready for your next move.");

});


/* =========================================
   TEXTAREA FOCUS
========================================= */

questionInput.addEventListener("focus", function() {

    askBox.classList.add("focused");

});


questionInput.addEventListener("blur", function() {

    askBox.classList.remove("focused");

});


/* =========================================
   MAKE A MOVE
========================================= */

askButton.addEventListener("click", function() {


    const question =
        questionInput.value.trim();


    /* Check empty question */

    if (question === "") {

        showToast(
            "Write your question before making a move."
        );

        questionInput.focus();

        return;

    }


    /* Temporary front-end behavior */

    showToast(
        "Your question is ready to be posted."
    );


    /*
    Later:

    window.location.href =
        "post_question.php";
    */

});


/* =========================================
   ATTACHMENT BUTTON
========================================= */

attachmentButton.addEventListener("click", function() {

    showToast(
        "Attachment feature will open here."
    );

});


/* =========================================
   SUBJECT BUTTON
========================================= */

subjectButton.addEventListener("click", function() {

    showToast(
        "Choose a subject here."
    );

});


/* =========================================
   QUESTION TYPE BUTTON
========================================= */

typeButton.addEventListener("click", function() {

    showToast(
        "Choose your question type here."
    );

});


/* =========================================
   HELP BUTTON
========================================= */

helpButton.addEventListener("click", function() {

    showToast(
        "Need help? Check the system guide."
    );

});


/* =========================================
   USER MORE BUTTON
========================================= */

userMore.addEventListener("click", function() {

    showToast(
        "Account options will appear here."
    );

});


/* =========================================
   SIDEBAR MENU
========================================= */

const menuItems =
    document.querySelectorAll(".menu-item");


menuItems.forEach(function(item) {

    item.addEventListener("click", function(event) {

        event.preventDefault();


        /* Remove active */

        menuItems.forEach(function(menu) {

            menu.classList.remove("active");

        });


        /* Add active to selected */

        item.classList.add("active");


        const page =
            item.dataset.page;


        /* Temporary feedback */

        if (page === "home") {

            showToast("Home");

        } else if (page === "questions") {

            showToast("Questions");

        } else if (page === "my-questions") {

            showToast("My Questions");

        } else if (page === "collaboration") {

            showToast("Collaboration");

        } else if (page === "messages") {

            showToast("Messages");

        } else if (page === "profile") {

            showToast("Profile");

        } else if (page === "settings") {

            showToast("Settings");

        }

    });

});


/* =========================================
   QUICK MOVE CARDS
========================================= */

const quickCards =
    document.querySelectorAll(".quick-card");


quickCards.forEach(function(card) {

    card.addEventListener("click", function() {


        const action =
            card.dataset.action;


        if (action === "ask") {

            askBox.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });


            setTimeout(function() {

                questionInput.focus();

            }, 450);


            showToast(
                "Start your question."
            );


        } else if (action === "browse") {

            showToast(
                "Opening questions from students."
            );


        } else if (action === "collaborate") {

            showToast(
                "Opening your collaborations."
            );

        }

    });

});


/* =========================================
   RECENT QUESTIONS
========================================= */

const questionItems =
    document.querySelectorAll(".question-item");


questionItems.forEach(function(item) {

    item.addEventListener("click", function() {


        const question =
            item.dataset.question;


        showToast(
            "Opening: " + question
        );


    });

});


/* =========================================
   VIEW ALL QUESTIONS
========================================= */

viewQuestions.addEventListener("click", function() {

    showToast(
        "Showing all questions."
    );

});


/* =========================================
   COLLABORATION BUTTONS
========================================= */

const openButtons =
    document.querySelectorAll(".open-button");


openButtons.forEach(function(button) {

    button.addEventListener("click", function() {


        const person =
            button.dataset.person;


        showToast(
            "Opening collaboration with " + person
        );


    });

});


/* =========================================
   SIMPLE KEYBOARD SHORTCUT
========================================= */

document.addEventListener("keydown", function(event) {


    /* Press "/" to focus question box */

    if (
        event.key === "/" &&
        document.activeElement !== questionInput
    ) {

        event.preventDefault();

        questionInput.focus();

    }

});