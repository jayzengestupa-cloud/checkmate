/* =========================================
   CHECKMATE COLLABORATION JAVASCRIPT
========================================= */


/* =========================================
   GET ELEMENTS
========================================= */

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

const searchInput =
    document.getElementById("searchInput");

const collaborationItems =
    document.querySelectorAll(".collaboration-item");

const acceptButtons =
    document.querySelectorAll(".accept-button");

const rejectButtons =
    document.querySelectorAll(".reject-button");

const openButtons =
    document.querySelectorAll(".open-button");

const filterButtons =
    document.querySelectorAll(".filter-button");


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
   COLLABORATION FILTER
========================================= */

filterButtons.forEach(function(button) {

    button.addEventListener(
        "click",
        function() {


            /* Remove active from all buttons */

            filterButtons.forEach(function(item) {

                item.classList.remove("active");

            });


            /* Add active to clicked button */

            button.classList.add("active");


            /* Get selected filter */

            const filter =
                button.dataset.filter;


            /* Check every collaboration */

            collaborationItems.forEach(
                function(item) {


                    const status =
                        item.dataset.status;


                    /* Show all */

                    if (
                        filter === "all" ||
                        filter === status
                    ) {

                        item.style.display = "";


                    } else {

                        item.style.display = "none";

                    }

                }
            );

        }
    );

});


/* =========================================
   SEARCH COLLABORATIONS
========================================= */

if (searchInput) {

    searchInput.addEventListener(
        "input",
        function() {


            /* Get search text */

            const searchValue =
                searchInput.value
                    .toLowerCase()
                    .trim();


            /* Search every collaboration */

            collaborationItems.forEach(
                function(item) {


                    const collaborationText =
                        item.textContent.toLowerCase();


                    if (
                        collaborationText.includes(
                            searchValue
                        )
                    ) {

                        item.style.display = "";


                    } else {

                        item.style.display = "none";

                    }

                }
            );

        }
    );

}


/* =========================================
   ACCEPT COLLABORATION
========================================= */

acceptButtons.forEach(function(button) {

    button.addEventListener(
        "click",
        function() {


            /* Get person's name */

            const person =
                button.dataset.person ||
                "student";


            showToast(
                "Collaboration with " +
                person +
                " accepted."
            );


            /*
            Later:

            This will connect to PHP
            and update the collaboration
            status in MySQL.

            Example:

            window.location.href =
                "collaboration.php";
            */

        }
    );

});


/* =========================================
   REJECT COLLABORATION
========================================= */

rejectButtons.forEach(function(button) {

    button.addEventListener(
        "click",
        function() {


            /* Get person's name */

            const person =
                button.dataset.person ||
                "student";


            showToast(
                "Collaboration request rejected."
            );


            /*
            Later:

            This will connect to PHP
            and update the collaboration
            status in MySQL.
            */

        }
    );

});


/* =========================================
   OPEN COLLABORATION
========================================= */

openButtons.forEach(function(button) {

    button.addEventListener(
        "click",
        function() {


            /* Get person's name */

            const person =
                button.dataset.person ||
                "student";


            showToast(
                "Opening " +
                person +
                "'s collaboration..."
            );


            /*
            Later:

            window.location.href =
                "messages.php";
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


            /* Get selected page */

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


                /*
                Later:

                window.location.href =
                    "questions.php";
                */

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


                /*
                Later:

                window.location.href =
                    "messages.php";
                */

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