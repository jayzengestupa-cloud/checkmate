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