
        // ---------- 1. DATA ----------
        // TODO: later get this list from the database with PHP
        var types = [
            { id: 1, name: "Multiple Choice", description: "Choose the correct answer from options.", status: "Active" },
            { id: 2, name: "True or False",   description: "Select True or False.",                   status: "Active" },
            { id: 3, name: "Short Answer",    description: "Write a short answer.",                   status: "Active" },
            { id: 4, name: "Long Answer",     description: "Write a detailed explanation.",           status: "Active" },
            { id: 5, name: "Programming",     description: "Write and run a code.",                   status: "Active" },
            { id: 6, name: "Designing",       description: "Create a design or diagram.",             status: "Active" }
        ];

        // the id the next new type will get
        var nextId = 7;

        // when editing, this holds the id being edited (null = adding new)
        var editingId = null;


        // ---------- 2. GET ELEMENTS ----------
        var toast = document.getElementById("toast");
        var tableBody = document.getElementById("tableBody");
        var showingText = document.getElementById("showingText");

        var searchInput = document.getElementById("searchInput");
        var statusFilter = document.getElementById("statusFilter");

        var formModal = document.getElementById("formModal");
        var formError = document.getElementById("formError");
        var formName = document.getElementById("formName");
        var formDesc = document.getElementById("formDesc");
        var formStatus = document.getElementById("formStatus");


        // ---------- 3. TOAST ----------
        function showToast(message) {
            toast.textContent = message;
            toast.classList.add("show");

            setTimeout(function () {
                toast.classList.remove("show");
            }, 2500);
        }


        // ---------- 4. SMALL HELPERS ----------

        // so someone can't type html into the name or description box
        function makeSafe(text) {
            text = text.replace(/&/g, "&amp;");
            text = text.replace(/</g, "&lt;");
            text = text.replace(/>/g, "&gt;");
            text = text.replace(/"/g, "&quot;");
            return text;
        }

        // 1 becomes #001
        function formatId(number) {
            if (number >= 100) {
                return "#" + number;
            }
            return "#" + ("00" + number).slice(-3);
        }

        function findType(id) {
            for (var i = 0; i < types.length; i++) {
                if (types[i].id === id) {
                    return types[i];
                }
            }
            return null;
        }


        // ---------- 5. SUMMARY CARDS ----------
        function updateStats() {

            var active = 0;
            var inactive = 0;

            for (var i = 0; i < types.length; i++) {
                if (types[i].status === "Active") { active++; }
                if (types[i].status === "Inactive") { inactive++; }
            }

            document.getElementById("statTotal").textContent = types.length;
            document.getElementById("statActive").textContent = active;
            document.getElementById("statInactive").textContent = inactive;
        }

        // clicking a summary card sets the status filter
        var statCards = document.querySelectorAll(".stat-card");
        for (var s = 0; s < statCards.length; s++) {
            statCards[s].addEventListener("click", function () {
                statusFilter.value = this.getAttribute("data-jump");
                showTable();
            });
        }


        // ---------- 6. SHOW THE TABLE ----------
        function showTable() {

            var searchText = searchInput.value.toLowerCase().trim();
            var status = statusFilter.value;
            var result = [];

            for (var i = 0; i < types.length; i++) {

                var t = types[i];

                // check the search box (name or description)
                var matchesSearch = true;
                if (searchText !== "") {
                    matchesSearch = t.name.toLowerCase().indexOf(searchText) !== -1 ||
                                    t.description.toLowerCase().indexOf(searchText) !== -1;
                }

                var matchesStatus = (status === "all" || t.status === status);

                if (matchesSearch && matchesStatus) {
                    result.push(t);
                }
            }

            var html = "";

            for (var j = 0; j < result.length; j++) {

                var r = result[j];

                html += "<tr>";
                html += "<td class='cell-id'>" + formatId(r.id) + "</td>";
                html += "<td>" + makeSafe(r.name) + "</td>";
                html += "<td class='cell-muted'><div class='desc-cell'>" + makeSafe(r.description) + "</div></td>";
                html += "<td><span class='status " + r.status.toLowerCase() + "'>" + r.status + "</span></td>";
                html += "<td>";
                html += "<button class='action-btn' onclick='openForm(" + r.id + ")'>Edit</button>";
                html += "<button class='action-btn delete' onclick='deleteType(" + r.id + ")'>Delete</button>";
                html += "</td>";
                html += "</tr>";
            }

            if (result.length === 0) {
                html = "<tr class='empty-row'><td colspan='5'>No question types found. Try a different search or filter.</td></tr>";
                showingText.textContent = "Showing 0 of " + types.length + " types";
            } else {
                showingText.textContent = "Showing 1–" + result.length + " of " + result.length + " types";
            }

            tableBody.innerHTML = html;
        }

        searchInput.addEventListener("input", showTable);
        statusFilter.addEventListener("change", showTable);


        // ---------- 7. DELETE ----------
        function deleteType(id) {
            var t = findType(id);

            // ask first so nothing gets deleted by accident
            var sure = confirm("Delete question type " + formatId(t.id) + "?\n\n" + t.name);

            if (sure === false) {
                return;
            }

            var newList = [];
            for (var i = 0; i < types.length; i++) {
                if (types[i].id !== id) {
                    newList.push(types[i]);
                }
            }
            types = newList;

            // TODO: also delete it from the database with PHP

            updateStats();
            showTable();
            showToast(formatId(id) + " was deleted.");
        }


        // ---------- 8. ADD / EDIT POPUP ----------
        // openForm() with no id = add new, openForm(id) = edit that one
        function openForm(id) {

            editingId = (id === undefined) ? null : id;
            formError.textContent = "";

            if (editingId === null) {
                document.getElementById("modalTitle").textContent = "Add type";
                document.getElementById("saveForm").textContent = "Add Type";
                formName.value = "";
                formDesc.value = "";
                formStatus.value = "Active";
            } else {
                var t = findType(editingId);
                document.getElementById("modalTitle").textContent = "Edit type";
                document.getElementById("saveForm").textContent = "Save Changes";
                formName.value = t.name;
                formDesc.value = t.description;
                formStatus.value = t.status;
            }

            formModal.classList.add("show");
        }

        document.getElementById("addButton").addEventListener("click", function () {
            openForm();
        });

        document.getElementById("cancelForm").addEventListener("click", function () {
            formModal.classList.remove("show");
        });

        // clicking the dark area outside the box also closes it
        formModal.addEventListener("click", function (event) {
            if (event.target === formModal) {
                formModal.classList.remove("show");
            }
        });

        document.getElementById("saveForm").addEventListener("click", function () {

            var name = formName.value.trim();
            var description = formDesc.value.trim();
            var status = formStatus.value;

            // check that nothing is empty
            if (name === "" || description === "") {
                formError.textContent = "Please fill in the type name and the description.";
                return;
            }

            if (editingId === null) {

                types.push({ id: nextId, name: name, description: description, status: status });
                nextId = nextId + 1;

                // TODO: send this to PHP so it gets saved in the database
                showToast("Question type added.");

            } else {

                var t = findType(editingId);
                t.name = name;
                t.description = description;
                t.status = status;

                // TODO: send this change to PHP so it gets saved in the database
                showToast(formatId(editingId) + " was updated.");
            }

            formModal.classList.remove("show");

            updateStats();
            showTable();
        });


        // ---------- 9. NOTIFICATION BUTTON ----------
        document.getElementById("notificationButton").addEventListener("click", function () {
            showToast("You have 3 new notifications.");
        });


        // ---------- 10. OTHER SIDEBAR LINKS ----------
        // the pages that don't exist yet just show a message
        var sidebarLinks = document.querySelectorAll(".sidebar-menu a");

        for (var i = 0; i < sidebarLinks.length; i++) {
            sidebarLinks[i].addEventListener("click", function (event) {
                if (this.getAttribute("href") === "#") {
                    event.preventDefault();
                    showToast("That page is not built yet.");
                }
            });
        }

        // ---------- ACCOUNT MENU (3 dots) ----------
var accountButton = document.getElementById("accountMenuButton");
var accountMenu = document.getElementById("accountMenu");

accountButton.addEventListener("click", function (event) {
    event.stopPropagation();
    accountMenu.classList.toggle("show");
    accountButton.classList.toggle("open");
});

// clicking anywhere else (or pressing Esc) closes it
document.addEventListener("click", function () {
    accountMenu.classList.remove("show");
    accountButton.classList.remove("open");
});

document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        accountMenu.classList.remove("show");
        accountButton.classList.remove("open");
    }
});

        // ---------- 11. START ----------
        updateStats();
        showTable();

