
        // ---------- 1. DATA ----------
        // TODO: later get these lists from the database with PHP
        var courses = [
            { id: 1, name: "BS Information Technology", status: "Active"  },
            { id: 2, name: "BS Computer Science",       status: "Active"  },
            { id: 3, name: "BS Information Systems",    status: "Active"  },
            { id: 4, name: "BS Engineering",            status: "Active"  },
            { id: 5, name: "BS Architecture",           status: "Pending" }
        ];

        var subjects = [
            { id: 1, name: "CS101 - Data Structures",      course: "BS Computer Science",       status: "Active"  },
            { id: 2, name: "CS102 - Algorithms",           course: "BS Computer Science",       status: "Active"  },
            { id: 3, name: "IT102 - Web Development",      course: "BS Information Technology", status: "Active"  },
            { id: 4, name: "IT103 - Software Engineering", course: "BS Information Technology", status: "Active"  },
            { id: 5, name: "IS101 - Database Management",  course: "BS Information Systems",    status: "Pending" }
        ];

        // the id the next new item will get
        var nextCourseId = 6;
        var nextSubjectId = 6;

        // which toggle is open: courses or subjects
        var currentTab = "courses";

        // when editing, this holds the id being edited (null = adding new)
        var editingId = null;


        // ---------- 2. GET ELEMENTS ----------
        var toast = document.getElementById("toast");
        var tableHead = document.getElementById("tableHead");
        var tableBody = document.getElementById("tableBody");
        var showingText = document.getElementById("showingText");

        var searchInput = document.getElementById("searchInput");
        var statusFilter = document.getElementById("statusFilter");
        var addButton = document.getElementById("addButton");

        var formModal = document.getElementById("formModal");
        var formError = document.getElementById("formError");
        var formName = document.getElementById("formName");
        var formCourse = document.getElementById("formCourse");
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

        // so someone can't type html into the name box
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

        // the list for the tab that is open
        function currentList() {
            return currentTab === "courses" ? courses : subjects;
        }

        function findItem(id) {
            var list = currentList();
            for (var i = 0; i < list.length; i++) {
                if (list[i].id === id) {
                    return list[i];
                }
            }
            return null;
        }

        // the word used on buttons and messages
        function itemWord() {
            return currentTab === "courses" ? "course" : "subject";
        }


        // ---------- 5. SUMMARY CARDS ----------
        function updateStats() {

            var active = 0;
            var pending = 0;
            var all = courses.concat(subjects);

            for (var i = 0; i < all.length; i++) {
                if (all[i].status === "Active") { active++; }
                if (all[i].status === "Pending") { pending++; }
            }

            document.getElementById("statCourses").textContent = courses.length;
            document.getElementById("statSubjects").textContent = subjects.length;
            document.getElementById("statActive").textContent = active;
            document.getElementById("statPending").textContent = pending;
        }


        // ---------- 6. SHOW THE TABLE ----------
        function showTable() {

            var list = currentList();
            var searchText = searchInput.value.toLowerCase().trim();
            var status = statusFilter.value;
            var result = [];

            // search + status filter
            for (var i = 0; i < list.length; i++) {

                var item = list[i];

                var matchesSearch = true;
                if (searchText !== "") {
                    matchesSearch = item.name.toLowerCase().indexOf(searchText) !== -1;
                    if (currentTab === "subjects" && item.course.toLowerCase().indexOf(searchText) !== -1) {
                        matchesSearch = true;
                    }
                }

                var matchesStatus = (status === "all" || item.status === status);

                if (matchesSearch && matchesStatus) {
                    result.push(item);
                }
            }

            // table heading changes with the toggle
            if (currentTab === "courses") {
                tableHead.innerHTML = "<tr><th>ID</th><th>Course Name</th><th>Status</th><th>Actions</th></tr>";
            } else {
                tableHead.innerHTML = "<tr><th>ID</th><th>Subject Name</th><th>Course</th><th>Status</th><th>Actions</th></tr>";
            }

            var html = "";

            for (var j = 0; j < result.length; j++) {

                var r = result[j];

                html += "<tr>";
                html += "<td class='cell-id'>" + formatId(r.id) + "</td>";
                html += "<td>" + makeSafe(r.name) + "</td>";

                if (currentTab === "subjects") {
                    html += "<td class='cell-muted'>" + makeSafe(r.course) + "</td>";
                }

                html += "<td><span class='status " + r.status.toLowerCase() + "'>" + r.status + "</span></td>";
                html += "<td>";
                html += "<button class='action-btn' onclick='viewItem(" + r.id + ")'>View</button>";
                html += "<button class='action-btn' onclick='openForm(" + r.id + ")'>Edit</button>";
                html += "<button class='action-btn delete' onclick='deleteItem(" + r.id + ")'>Delete</button>";
                html += "</td>";
                html += "</tr>";
            }

            var columns = (currentTab === "courses") ? 4 : 5;

            if (result.length === 0) {
                html = "<tr class='empty-row'><td colspan='" + columns + "'>No " + itemWord() + "s found. Try a different search or filter.</td></tr>";
                showingText.textContent = "Showing 0 of " + list.length + " " + itemWord() + "s";
            } else {
                showingText.textContent = "Showing 1–" + result.length + " of " + result.length + " " + itemWord() + "s";
            }

            tableBody.innerHTML = html;
        }

        searchInput.addEventListener("input", showTable);
        statusFilter.addEventListener("change", showTable);


        // ---------- 7. TOGGLE (COURSES / SUBJECTS) ----------
        function setTab(name) {

            currentTab = name;

            var buttons = document.querySelectorAll(".toggle-btn");
            for (var i = 0; i < buttons.length; i++) {
                if (buttons[i].getAttribute("data-tab") === name) {
                    buttons[i].classList.add("active");
                } else {
                    buttons[i].classList.remove("active");
                }
            }

            // search box and add button use the right word
            var word = itemWord();
            searchInput.placeholder = "Search " + word + "s...";
            addButton.textContent = "+ Add " + word.charAt(0).toUpperCase() + word.slice(1);

            searchInput.value = "";
            statusFilter.value = "all";

            showTable();
        }

        var toggleButtons = document.querySelectorAll(".toggle-btn");
        for (var t = 0; t < toggleButtons.length; t++) {
            toggleButtons[t].addEventListener("click", function () {
                setTab(this.getAttribute("data-tab"));
            });
        }

        // clicking a summary card opens the matching view
        var statCards = document.querySelectorAll(".stat-card");
        for (var s = 0; s < statCards.length; s++) {
            statCards[s].addEventListener("click", function () {
                var jump = this.getAttribute("data-jump");

                if (jump === "courses" || jump === "subjects") {
                    setTab(jump);
                } else {
                    // Active / Pending: filter the table that is open
                    statusFilter.value = jump;
                    showTable();
                }
            });
        }


        // ---------- 8. VIEW AND DELETE ----------
        function viewItem(id) {
            var item = findItem(id);
            // TODO: open a real details page
            var extra = (currentTab === "subjects") ? " (" + item.course + ")" : "";
            showToast(formatId(item.id) + ": " + item.name + extra + " - " + item.status);
        }

        function deleteItem(id) {
            var item = findItem(id);

            // ask first so nothing gets deleted by accident
            var sure = confirm("Delete " + itemWord() + " " + formatId(item.id) + "?\n\n" + item.name);

            if (sure === false) {
                return;
            }

            var list = currentList();
            var newList = [];
            for (var i = 0; i < list.length; i++) {
                if (list[i].id !== id) {
                    newList.push(list[i]);
                }
            }

            if (currentTab === "courses") {
                courses = newList;
            } else {
                subjects = newList;
            }

            // TODO: also delete it from the database with PHP

            updateStats();
            showTable();
            showToast(formatId(id) + " was deleted.");
        }


        // ---------- 9. ADD / EDIT POPUP ----------
        // openForm() with no id = add new, openForm(id) = edit that one
        function openForm(id) {

            var word = itemWord();
            var Word = word.charAt(0).toUpperCase() + word.slice(1);

            editingId = (id === undefined) ? null : id;
            formError.textContent = "";

            document.getElementById("modalLabel").textContent = word.toUpperCase() + "S";
            document.getElementById("nameLabel").textContent = Word + " name";
            formName.placeholder = (currentTab === "courses") ? "BS Information Technology" : "CS101 - Data Structures";

            // subjects also pick a course
            var courseGroup = document.getElementById("courseGroup");
            if (currentTab === "subjects") {
                courseGroup.style.display = "block";
                var options = "";
                for (var i = 0; i < courses.length; i++) {
                    options += "<option value=\"" + makeSafe(courses[i].name) + "\">" + makeSafe(courses[i].name) + "</option>";
                }
                formCourse.innerHTML = options;
            } else {
                courseGroup.style.display = "none";
            }

            if (editingId === null) {
                document.getElementById("modalTitle").textContent = "Add " + word;
                document.getElementById("saveForm").textContent = "Add " + Word;
                formName.value = "";
                formStatus.value = "Active";
            } else {
                var item = findItem(editingId);
                document.getElementById("modalTitle").textContent = "Edit " + word;
                document.getElementById("saveForm").textContent = "Save Changes";
                formName.value = item.name;
                formStatus.value = item.status;
                if (currentTab === "subjects") {
                    formCourse.value = item.course;
                }
            }

            formModal.classList.add("show");
        }

        addButton.addEventListener("click", function () {
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
            var status = formStatus.value;

            // check that nothing is empty
            if (name === "") {
                formError.textContent = "Please enter the " + itemWord() + " name.";
                return;
            }

            if (editingId === null) {

                // new items start with the status picked in the popup
                if (currentTab === "courses") {
                    courses.push({ id: nextCourseId, name: name, status: status });
                    nextCourseId = nextCourseId + 1;
                } else {
                    subjects.push({ id: nextSubjectId, name: name, course: formCourse.value, status: status });
                    nextSubjectId = nextSubjectId + 1;
                }

                // TODO: send this to PHP so it gets saved in the database
                showToast(itemWord().charAt(0).toUpperCase() + itemWord().slice(1) + " added.");

            } else {

                var item = findItem(editingId);
                item.name = name;
                item.status = status;
                if (currentTab === "subjects") {
                    item.course = formCourse.value;
                }

                // TODO: send this change to PHP so it gets saved in the database
                showToast(formatId(editingId) + " was updated.");
            }

            formModal.classList.remove("show");

            updateStats();
            showTable();
        });


        // ---------- 10. NOTIFICATION BUTTON ----------
        document.getElementById("notificationButton").addEventListener("click", function () {
            showToast("You have 3 new notifications.");
        });


        // ---------- 11. OTHER SIDEBAR LINKS ----------
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


        // ---------- 12. START ----------
        updateStats();
        showTable();
