const myQuestionCards = document.querySelectorAll(".my-question");
const filterTabs = document.querySelectorAll(".filter-tab");
const myQuestionSearch = document.getElementById("searchMyQuestions");
const filterEmpty = document.getElementById("filterEmpty");

let activeFilter = "all";


/* Show or hide questions based on the tab and the search box */

function applyFilters() {
    const term = myQuestionSearch
        ? myQuestionSearch.value.toLowerCase().trim()
        : "";

    let visible = 0;

    myQuestionCards.forEach(function (card) {
        const matchesTab =
            activeFilter === "all" || card.dataset.status === activeFilter;

        const matchesSearch =
            term === "" || card.textContent.toLowerCase().includes(term);

        const show = matchesTab && matchesSearch;

        card.hidden = !show;

        if (show) {
            visible++;
        }
    });

    if (filterEmpty) {
        filterEmpty.hidden = visible !== 0;
    }
}

filterTabs.forEach(function (tab) {
    tab.addEventListener("click", function () {
        filterTabs.forEach(function (item) {
            item.classList.remove("active");
        });

        this.classList.add("active");
        activeFilter = this.dataset.filter;

        applyFilters();
    });
});

if (myQuestionSearch) {
    myQuestionSearch.addEventListener("input", applyFilters);
}


/* Open and close the answers under a question */

function toggleQuestion(header) {
    const card = header.closest(".my-question");
    const panel = document.getElementById(
        header.getAttribute("aria-controls")
    );

    if (!card || !panel) {
        return;
    }

    const willOpen = panel.hidden;

    panel.hidden = !willOpen;
    card.classList.toggle("open", willOpen);
    header.setAttribute("aria-expanded", String(willOpen));
}

document.querySelectorAll(".my-question-header").forEach(function (header) {

    header.addEventListener("click", function () {
        toggleQuestion(this);
    });

    header.addEventListener("keydown", function (event) {
        if (event.key === "Enter" || event.key === " ") {
            event.preventDefault();
            toggleQuestion(this);
        }
    });

});