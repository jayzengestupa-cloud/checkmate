/* =========================================================
   Collaboration page: filter tabs, search, expand/collapse
   ========================================================= */

const collabCards = document.querySelectorAll(".my-question");
const collabTabs = document.querySelectorAll(".filter-tab");
const collabSearch = document.getElementById("searchCollaborations");
const collabEmpty = document.getElementById("filterEmpty");

let collabFilter = "all";


/* Show or hide collaborations based on the tab and the search box */

function applyCollabFilters() {
    const term = collabSearch
        ? collabSearch.value.toLowerCase().trim()
        : "";

    let visible = 0;

    collabCards.forEach(function (card) {
        const groups = (card.dataset.groups || "").split(" ");

        const matchesTab =
            collabFilter === "all" || groups.includes(collabFilter);

        const matchesSearch =
            term === "" || card.textContent.toLowerCase().includes(term);

        const show = matchesTab && matchesSearch;

        card.hidden = !show;

        if (show) {
            visible++;
        }
    });

    if (collabEmpty) {
        collabEmpty.hidden = visible !== 0;
    }
}

collabTabs.forEach(function (tab) {
    tab.addEventListener("click", function () {
        collabTabs.forEach(function (item) {
            item.classList.remove("active");
        });

        this.classList.add("active");
        collabFilter = this.dataset.filter;

        applyCollabFilters();
    });
});

if (collabSearch) {
    collabSearch.addEventListener("input", applyCollabFilters);
}


/* Open and close the details under a collaboration */

function toggleCollab(header) {
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

    header.addEventListener("click", function (event) {
        // Accept / Reject buttons should not open or close the row
        if (event.target.closest("button, a, form")) {
            return;
        }

        toggleCollab(this);
    });

    header.addEventListener("keydown", function (event) {
        if (event.target !== this) {
            return;
        }

        if (event.key === "Enter" || event.key === " ") {
            event.preventDefault();
            toggleCollab(this);
        }
    });

});