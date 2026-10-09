document.addEventListener("DOMContentLoaded", function () {
    const questionInput = document.getElementById("questionInput");
    const askBox = document.getElementById("askBox");
    const askButton = document.getElementById("askButton");

    const attachmentButton = document.getElementById("attachmentButton");
    const subjectButton = document.getElementById("subjectButton");
    const typeButton = document.getElementById("typeButton");

    const helpButton = document.getElementById("helpButton");
    const userMore = document.getElementById("userMore");
    const viewQuestions = document.getElementById("viewQuestions");

    const toast = document.getElementById("toast");

    function showToast(message) {
        if (!toast) {
            return;
        }

        toast.textContent = message;
        toast.classList.add("show");

        clearTimeout(toast.timeoutId);

        toast.timeoutId = setTimeout(function () {
            toast.classList.remove("show");
        }, 2300);
    }

    function openQuestionsPage() {
        window.location.href = "questions.php";
    }

    function focusQuestionBox() {
        if (!askBox || !questionInput) {
            return;
        }

        askBox.scrollIntoView({
            behavior: "smooth",
            block: "center"
        });

        setTimeout(function () {
            questionInput.focus();
        }, 450);
    }

    const newQuestionButton = document.getElementById("newQuestionButton");

    if (newQuestionButton) {
        newQuestionButton.addEventListener("click", function (event) {
            event.preventDefault();
            focusQuestionBox();
            showToast("Ready for your next move.");
        });
    }

    if (questionInput && askBox) {
        questionInput.addEventListener("focus", function () {
            askBox.classList.add("focused");
        });

        questionInput.addEventListener("blur", function () {
            askBox.classList.remove("focused");
        });
    }

    if (askButton) {
        askButton.addEventListener("click", function () {
            openQuestionsPage();
        });
    }

    if (attachmentButton) {
        attachmentButton.addEventListener("click", function () {
            showToast("Attachment feature will open here.");
        });
    }

    if (subjectButton) {
        subjectButton.addEventListener("click", function () {
            showToast("Choose a subject here.");
        });
    }

    if (typeButton) {
        typeButton.addEventListener("click", function () {
            showToast("Choose your question type here.");
        });
    }

    if (helpButton) {
        helpButton.addEventListener("click", function () {
            showToast("Need help? Check the system guide.");
        });
    }

    if (userMore) {
        userMore.addEventListener("click", function () {
            showToast("Account options will appear here.");
        });
    }

    if (viewQuestions) {
        viewQuestions.addEventListener("click", function (event) {
            event.preventDefault();
            openQuestionsPage();
        });
    }

    const quickCards = document.querySelectorAll(".quick-card");

    quickCards.forEach(function (card) {
        function handleCardAction() {
            const action = card.dataset.action;

            if (action === "browse") {
                openQuestionsPage();
            } else if (action === "collaborate") {
                showToast("Opening your collaborations.");
            } else if (action === "ask") {
                focusQuestionBox();
                showToast("Start your question.");
            }
        }

        card.addEventListener("click", handleCardAction);

        card.addEventListener("keydown", function (event) {
            if (
                event.key === "Enter" ||
                event.key === " "
            ) {
                event.preventDefault();
                handleCardAction();
            }
        });
    });

    const questionItems = document.querySelectorAll(".question-item");

    questionItems.forEach(function (item) {
        item.addEventListener("click", function () {
            const question = item.dataset.question;

            if (question) {
                showToast("Opening: " + question);
            } else {
                showToast("Opening question details.");
            }
        });
    });

    const openButtons = document.querySelectorAll(".open-button");

    openButtons.forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.stopPropagation();

            const person = button.dataset.person;

            if (person) {
                showToast("Opening collaboration with " + person);
            } else {
                showToast("Opening collaboration details.");
            }
        });
    });

    document.addEventListener("keydown", function (event) {
        if (
            event.key === "/" &&
            questionInput &&
            document.activeElement !== questionInput &&
            !event.ctrlKey &&
            !event.altKey &&
            !event.metaKey
        ) {
            event.preventDefault();
            focusQuestionBox();
        }
    });
});