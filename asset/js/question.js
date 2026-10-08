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