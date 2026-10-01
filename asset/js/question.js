/* =========================================
   CHECKMATE QUESTIONS JAVASCRIPT
========================================= */


/* =========================================
   GET ELEMENTS
========================================= */

const searchInput =
    document.getElementById("searchInput");

const subjectFilter =
    document.getElementById("subjectFilter");

const courseFilter =
    document.getElementById("courseFilter");

const typeFilter =
    document.getElementById("typeFilter");

const clearFilters =
    document.getElementById("clearFilters");

const questionItems =
    document.querySelectorAll(".question-item");

const viewButtons =
    document.querySelectorAll(".view-question");

const menuItems =
    document.querySelectorAll(".menu-item");

const newQuestionButton =
    document.getElementById("newQuestionButton");

const userMore =
    document.getElementById("userMore");

const helpButton =
    document.getElementById("helpButton");

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
   FILTER QUESTIONS
========================================= */

function filterQuestions() {


    /* Get search value */

    const searchValue =
        searchInput.value.toLowerCase().trim();


    /* Get filter values */

    const subjectValue =
        subjectFilter.value.toLowerCase();

    const courseValue =
        courseFilter.value.toLowerCase();

    const typeValue =
        typeFilter.value.toLowerCase();


    /* Check every question */

    questionItems.forEach(function(item) {


        /* Get question information */

        const questionText =
            item.textContent.toLowerCase();


        const questionSubject =
            item.dataset.subject
                ? item.dataset.subject.toLowerCase()
                : "";


        const questionCourse =
            item.dataset.course
                ? item.dataset.course.toLowerCase()
                : "";


        const questionType =
            item.dataset.type
                ? item.dataset.type.toLowerCase()
                : "";


        /* =====================================
           SEARCH CHECK
        ====================================== */

        const matchesSearch =
            searchValue === "" ||
            questionText.includes(searchValue);


        /* =====================================
           SUBJECT CHECK
        ====================================== */

        const matchesSubject =
            subjectValue === "all" ||
            subjectValue === "" ||
            questionSubject === subjectValue;


        /* =====================================
           COURSE CHECK
        ====================================== */

        const matchesCourse =
            courseValue === "all" ||
            courseValue === "" ||
            questionCourse === courseValue;


        /* =====================================
           TYPE CHECK
        ====================================== */

        const matchesType =
            typeValue === "all" ||
            typeValue === "" ||
            questionType === typeValue;


        /* =====================================
           SHOW OR HIDE
        ====================================== */

        if (
            matchesSearch &&
            matchesSubject &&
            matchesCourse &&
            matchesType
        ) {

            item.style.display = "";


        } else {

            item.style.display = "none";

        }

    });

}


/* =========================================
   SEARCH QUESTIONS
========================================= */

searchInput.addEventListener(
    "input",
    function() {

        filterQuestions();

    }
);


/* =========================================
   SUBJECT FILTER
========================================= */

subjectFilter.addEventListener(
    "change",
    function() {

        filterQuestions();

    }
);


/* =========================================
   COURSE FILTER
========================================= */

courseFilter.addEventListener(
    "change",
    function() {

        filterQuestions();

    }
);


/* =========================================
   QUESTION TYPE FILTER
========================================= */

typeFilter.addEventListener(
    "change",
    function() {

        filterQuestions();

    }
);


/* =========================================
   CLEAR FILTERS
========================================= */

clearFilters.addEventListener(
    "click",
    function() {


        /* Clear search */

        searchInput.value = "";


        /* Reset filters */

        subjectFilter.value = "all";

        courseFilter.value = "all";

        typeFilter.value = "all";


        /* Show all questions */

        filterQuestions();


        showToast(
            "Filters cleared."
        );

    }
);


/* =========================================
   VIEW QUESTION
========================================= */

viewButtons.forEach(function(button) {

    button.addEventListener(
        "click",
        function() {


            /* Get question */

            const question =
                button.dataset.question;


            showToast(
                "Opening question..."
            );


            /*
            Later:

            window.location.href =
                "question.php?id=" +
                question;
            */

        }
    );

});


/* =========================================
   SIDEBAR MENU
========================================= */

menuItems.forEach(function(item) {

    item.addEventListener(
        "click",
        function(event) {

            event.preventDefault();


            /* Remove active */

            menuItems.forEach(function(menu) {

                menu.classList.remove("active");

            });


            /* Add active */

            item.classList.add("active");


            /* Get page */

            const page =
                item.dataset.page;


            /* =================================
               TEMPORARY NAVIGATION
            ================================= */

            if (page === "home") {

                showToast(
                    "Home selected."
                );


                /*
                Later:

                window.location.href =
                    "student_home.php";
                */

            } else if (page === "questions") {

                showToast(
                    "Questions selected."
                );

            } else if (page === "my-questions") {

                showToast(
                    "My Questions selected."
                );


            } else if (page === "collaboration") {

                showToast(
                    "Collaboration selected."
                );


            } else if (page === "messages") {

                showToast(
                    "Messages selected."
                );


            } else if (page === "profile") {

                showToast(
                    "Profile selected."
                );


            } else if (page === "settings") {

                showToast(
                    "Settings selected."
                );

            }

        }
    );

});


/* =========================================
   NEW QUESTION BUTTON
========================================= */

newQuestionButton.addEventListener(
    "click",
    function() {


        showToast(
            "Opening new question..."
        );


        /*
        Later:

        window.location.href =
            "student_home.php";
        */

    }
);


/* =========================================
   USER MORE BUTTON
========================================= */

userMore.addEventListener(
    "click",
    function() {

        showToast(
            "Account options selected."
        );

    }
);


/* =========================================
   HELP BUTTON
========================================= */

helpButton.addEventListener(
    "click",
    function() {

        showToast(
            "Help section will be available soon."
        );

    }
);