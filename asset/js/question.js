const searchInput = document.getElementById("searchQuestions");

if (searchInput) {
    searchInput.addEventListener("input", function () {
        const search = this.value.toLowerCase();
        const questions = document.querySelectorAll(".question-card");

        questions.forEach(function (question) {
            const text = question.textContent.toLowerCase();

            if (text.includes(search)) {
                question.style.display = "flex";
            } else {
                question.style.display = "none";
            }
        });
    });
}


/* Attachment menu */

const attachmentPlus = document.getElementById("attachmentPlus");
const attachmentMenu = document.getElementById("attachmentMenu");
const attachmentInput = document.getElementById("attachment");
const attachmentSelected = document.getElementById("attachmentSelected");

if (attachmentPlus && attachmentMenu && attachmentInput) {

    attachmentPlus.addEventListener("click", function () {
        const isOpen = !attachmentMenu.hidden;

        attachmentMenu.hidden = isOpen;
        attachmentPlus.setAttribute("aria-expanded", String(!isOpen));
    });

    document.querySelectorAll(".attachment-option").forEach(function (option) {

        option.addEventListener("click", function () {
            const choice = this.dataset.attachment;

            attachmentInput.value = "";

            if (choice === "photos") {
                attachmentInput.accept = ".jpg,.jpeg,.png";
            } else {
                attachmentInput.accept =
                    ".pdf,.doc,.docx,.ppt,.pptx,.txt,.jpg,.jpeg,.png,.xls,.xlsx,.csv";
            }

            attachmentMenu.hidden = true;
            attachmentPlus.setAttribute("aria-expanded", "false");

            attachmentInput.click();
        });

    });

    attachmentInput.addEventListener("change", function () {
        if (this.files.length > 0) {
            attachmentSelected.textContent = this.files[0].name;
        } else {
            attachmentSelected.textContent = "Add attachment (optional)";
        }
    });

    document.addEventListener("click", function (event) {
        if (
            !attachmentMenu.contains(event.target) &&
            !attachmentPlus.contains(event.target)
        ) {
            attachmentMenu.hidden = true;
            attachmentPlus.setAttribute("aria-expanded", "false");
        }
    });

}


/* Answer form: open and close under each question */

document.querySelectorAll(".question-card").forEach(function (card) {
    const form = card.querySelector(".answer-form");

    if (!form) {
        return;
    }

    const toggles = card.querySelectorAll(".answer-toggle");
    const button = card.querySelector(".answer-toggle-btn");
    const textarea = form.querySelector("textarea");
    const cancel = form.querySelector(".answer-cancel");
    const submit = form.querySelector(".answer-submit");

    function setOpen(open) {
        form.hidden = !open;
        card.classList.toggle("answering", open);

        if (button) {
            button.setAttribute("aria-expanded", String(open));
        }

        if (open && textarea) {
            textarea.focus();
        }
    }

    toggles.forEach(function (toggle) {
        toggle.addEventListener("click", function () {
            setOpen(form.hidden);
        });

        toggle.addEventListener("keydown", function (event) {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                setOpen(form.hidden);
            }
        });
    });

    if (cancel) {
        cancel.addEventListener("click", function () {
            if (textarea) {
                textarea.value = "";
            }

            setOpen(false);
        });
    }

    // Prevent double posting
    form.addEventListener("submit", function () {
        if (submit) {
            submit.disabled = true;
            submit.textContent = "Posting...";
        }
    });
});


/* Pop-up message (for example "Your question has been posted.") */

function showFlash(type, message) {
    let box = document.getElementById("cmFlash");

    if (!box) {
        box = document.createElement("div");
        box.id = "cmFlash";
        box.setAttribute("role", "status");
        box.setAttribute("aria-live", "polite");
        document.body.appendChild(box);
    }

    const toast = document.createElement("div");
    toast.className = "cm-flash" + (type === "error" ? " error" : "");

    const text = document.createElement("span");
    text.textContent = message;

    const close = document.createElement("button");
    close.type = "button";
    close.className = "cm-flash-close";
    close.setAttribute("aria-label", "Close");
    close.textContent = "×";

    function remove() {
        toast.classList.add("hide");
        setTimeout(function () {
            toast.remove();
        }, 250);
    }

    close.addEventListener("click", remove);

    toast.append(text, close);
    box.appendChild(toast);

    setTimeout(remove, 5000);
}

const flashData = document.getElementById("flashData");

if (flashData) {
    showFlash(flashData.dataset.type, flashData.dataset.message);

    // Remove ?notice=... so the message does not show again on refresh
    if (window.history && window.history.replaceState) {
        window.history.replaceState(
            null,
            "",
            window.location.pathname + window.location.hash
        );
    }
}