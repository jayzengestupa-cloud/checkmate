/* =========================================
   CHECKMATE MESSAGES JAVASCRIPT
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

const messageSearch =
    document.getElementById("messageSearch");

const conversationItems =
    document.querySelectorAll(".conversation-item");

const messageInput =
    document.getElementById("messageInput");

const sendMessageButton =
    document.getElementById("sendMessageButton");

const attachmentButton =
    document.getElementById("attachmentButton");

const chatMessages =
    document.getElementById("chatMessages");


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
   SEARCH CONVERSATIONS
========================================= */

if (messageSearch) {

    messageSearch.addEventListener(
        "input",
        function() {


            /* Get search text */

            const searchValue =
                messageSearch.value
                    .toLowerCase()
                    .trim();


            /* Check every conversation */

            conversationItems.forEach(
                function(item) {


                    const conversationText =
                        item.textContent.toLowerCase();


                    if (
                        conversationText.includes(
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
   SELECT CONVERSATION
========================================= */

conversationItems.forEach(function(item) {

    item.addEventListener(
        "click",
        function() {


            /* Remove active */

            conversationItems.forEach(
                function(conversation) {

                    conversation.classList.remove(
                        "active"
                    );

                }
            );


            /* Add active */

            item.classList.add("active");


            /* Get person's name */

            const person =
                item.dataset.person ||
                "student";


            showToast(
                "Conversation with " +
                person +
                " opened."
            );


            /*
            Later:

            The selected conversation
            will be loaded from MySQL
            using PHP.

            Example:

            window.location.href =
                "messages.php?id=" +
                item.dataset.id;
            */

        }
    );

});


/* =========================================
   SEND MESSAGE
========================================= */

function sendMessage() {

    if (!messageInput) {
        return;
    }


    /* Get message */

    const message =
        messageInput.value.trim();


    /* Check if empty */

    if (message === "") {

        showToast(
            "Please enter a message."
        );

        messageInput.focus();

        return;

    }


    /* =================================
       CREATE MESSAGE
    ================================= */

    if (chatMessages) {

        const messageRow =
            document.createElement("div");

        messageRow.classList.add(
            "message-row",
            "sent"
        );


        const messageBubble =
            document.createElement("div");

        messageBubble.classList.add(
            "message-bubble"
        );


        messageBubble.textContent =
            message;


        messageRow.appendChild(
            messageBubble
        );


        chatMessages.appendChild(
            messageRow
        );


        /* Scroll to newest message */

        chatMessages.scrollTop =
            chatMessages.scrollHeight;

    }


    /* Clear input */

    messageInput.value = "";


    /*
    Later:

    The message will be sent
    to PHP and saved in MySQL.

    Example:

    fetch("send_message.php", {
        method: "POST",
        body: formData
    });
    */


}


/* =========================================
   SEND BUTTON
========================================= */

if (sendMessageButton) {

    sendMessageButton.addEventListener(
        "click",
        function() {

            sendMessage();

        }
    );

}


/* =========================================
   ENTER KEY
========================================= */

if (messageInput) {

    messageInput.addEventListener(
        "keydown",
        function(event) {


            if (
                event.key === "Enter" &&
                !event.shiftKey
            ) {

                event.preventDefault();

                sendMessage();

            }

        }
    );

}


/* =========================================
   ATTACHMENT BUTTON
========================================= */

if (attachmentButton) {

    attachmentButton.addEventListener(
        "click",
        function() {

            showToast(
                "Attachment option selected."
            );


            /*
            Later:

            This can open a file input
            and upload an attachment
            through PHP.

            Example:

            document.getElementById(
                "fileInput"
            ).click();
            */

        }
    );

}


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


                /*
                Later:

                window.location.href =
                    "collaboration.php";
                */

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

if (newQuestionButton) {

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

}


/* =========================================
   USER MORE BUTTON
========================================= */

if (userMore) {

    userMore.addEventListener(
        "click",
        function() {

            showToast(
                "Account options selected."
            );

        }
    );

}


/* =========================================
   HELP BUTTON
========================================= */

if (helpButton) {

    helpButton.addEventListener(
        "click",
        function() {

            showToast(
                "Help section will be available soon."
            );

        }
    );

}