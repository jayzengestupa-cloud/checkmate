
        // ---------- 1. DATA ----------
        // TODO: later get this list from the database with PHP
        var questions = [
            { id: 1, question: "How to solve a binary tree?",                  student: "Juan Dela Cruz", category: "Data Structures", status: "Published" },
            { id: 2, question: "What is the difference between stack and queue?", student: "Maria Santos",   category: "CS Fundamentals", status: "Published" },
            { id: 3, question: "How to configure XAMPP?",                       student: "Pedro Reyes",    category: "Tools & Setup",   status: "Pending"   },
            { id: 4, question: "What is polymorphism?",                         student: "Ana Lopez",      category: "OOP",             status: "Published" },
            { id: 5, question: "What is the DBMS exam?",                        student: "Carlos Garcia",  category: "Web Development", status: "Pending"   }
        ];

        // the id the next new question will get
        var nextId = 6;


        // ---------- 2. GET ELEMENTS ----------
        var toast = document.getElementById("toast");
        var questionsBody = document.getElementById("questionsBody");
        var showingText = document.getElementById("showingText");

        var searchInput = document.getElementById("searchInput");
        var categoryFilter = document.getElementById("categoryFilter");
        var statusFilter = document.getElementById("statusFilter");

        var addModal = document.getElementById("addModal");
        var formError = document.getElementById("formError");


        // ---------- 3. TOAST ----------
        function showToast(message) {
            toast.textContent = message;
            toast.classList.add("show");

            setTimeout(function () {
                toast.classList.remove("show");
            }, 2500);
        }


        // ---------- 4. MAKE TEXT SAFE ----------
        // so someone can't type html into the title box
        function makeSafe(text) {
            text = text.replace(/&/g, "&amp;");
            text = text.replace(/</g, "&lt;");
            text = text.replace(/>/g, "&gt;");
            text = text.replace(/"/g, "&quot;");
            return text;
        }


        // ---------- 5. MAKE THE ID LOOK LIKE #001 ----------
        function formatId(number) {
            var text = "00" + number;
            // keep the last 3 characters (so 1 becomes 001, 12 becomes 012)
            if (number >= 100) {
                text = "" + number;
            } else {
                text = text.slice(-3);
            }
            return "#" + text;
        }


        // ---------- 6. SHOW THE TABLE ----------
        // loops through the list and builds one row for each question
        function showTable(list) {

            var html = "";

            for (var i = 0; i < list.length; i++) {

                var q = list[i];

                // class name for the badge color (published or pending)
                var statusClass = q.status.toLowerCase();

                html += "<tr>";
                html += "<td class='cell-id'>" + formatId(q.id) + "</td>";
                html += "<td><div class='question-cell' question=\"" + makeSafe(q.question) + "\">" + makeSafe(q.question) + "</div></td>";
                html += "<td>" + makeSafe(q.student) + "</td>";
                html += "<td class='cell-muted'>" + makeSafe(q.category) + "</td>";
                html += "<td><span class='status " + statusClass + "'>" + q.status + "</span></td>";
                html += "<td>";
                html += "<button class='action-btn' onclick='viewQuestion(" + q.id + ")'>View</button>";
                html += "<button class='action-btn' onclick='editQuestion(" + q.id + ")'>Edit</button>";
                html += "<button class='action-btn delete' onclick='deleteQuestion(" + q.id + ")'>Delete</button>";
                html += "</td>";
                html += "</tr>";
            }

            // if nothing matches, show a message
            if (list.length === 0) {
                html = "<tr class='empty-row'><td colspan='6'>No questions found. Try a different search or filter.</td></tr>";
                showingText.textContent = "Showing 0 of " + questions.length + " questions";
            } else {
                showingText.textContent = "Showing 1–" + list.length + " of " + list.length + " questions";
            }

            questionsBody.innerHTML = html;
        }


        // ---------- 7. SEARCH AND FILTERS ----------
        function applyFilters() {

            var searchText = searchInput.value.toLowerCase().trim();
            var category = categoryFilter.value;
            var status = statusFilter.value;

            var result = [];

            for (var i = 0; i < questions.length; i++) {

                var q = questions[i];

                // check the search box (title or author)
                var matchesSearch = true;
                if (searchText !== "") {
                    matchesSearch = q.question.toLowerCase().indexOf(searchText) !== -1 ||
                                    q.student.toLowerCase().indexOf(searchText) !== -1;
                }

                // check the category filter
                var matchesCategory = (category === "all" || q.category === category);

                // check the status filter
                var matchesStatus = (status === "all" || q.status === status);

                // only keep the question if all 3 are true
                if (matchesSearch && matchesCategory && matchesStatus) {
                    result.push(q);
                }
            }

            showTable(result);
        }

        searchInput.addEventListener("input", applyFilters);
        categoryFilter.addEventListener("change", applyFilters);
        statusFilter.addEventListener("change", applyFilters);


        // ---------- 8. VIEW, EDIT AND DELETE BUTTONS ----------
        // find the question with the matching id
        function findQuestion(id) {
            for (var i = 0; i < questions.length; i++) {
                if (questions[i].id === id) {
                    return questions[i];
                }
            }
            return null;
        }

        function viewQuestion(id) {
            var q = findQuestion(id);
            // TODO: open a real question page
            showToast("Viewing " + formatId(q.id) + ": " + q.question);
        }

        function editQuestion(id) {
            var q = findQuestion(id);
            // TODO: open an edit form
            showToast("Editing " + formatId(q.id) + "...");
        }

        function deleteQuestion(id) {
            var q = findQuestion(id);

            // ask first so nothing gets deleted by accident
            var sure = confirm("Delete question " + formatId(q.id) + "?\n\n" + q.question);

            if (sure === false) {
                return;
            }

            // build a new list without that question
            var newList = [];
            for (var i = 0; i < questions.length; i++) {
                if (questions[i].id !== id) {
                    newList.push(questions[i]);
                }
            }
            questions = newList;

            // TODO: also delete it from the database with PHP

            applyFilters();
            showToast("Question " + formatId(id) + " was deleted.");
        }


        // ---------- 9. ADD QUESTION POPUP ----------
        document.getElementById("addQuestionButton").addEventListener("click", function () {
            formError.textContent = "";
            addModal.classList.add("show");
        });

        document.getElementById("cancelAdd").addEventListener("click", function () {
            addModal.classList.remove("show");
        });

        // clicking the dark area outside the box also closes it
        addModal.addEventListener("click", function (event) {
            if (event.target === addModal) {
                addModal.classList.remove("show");
            }
        });

        document.getElementById("saveAdd").addEventListener("click", function () {

            var question = document.getElementById("newquestion").value.trim();
            var student = document.getElementById("newstudent").value.trim();
            var category = document.getElementById("newCategory").value;

            // check that nothing is empty
            if (question === "" || student === "") {
                formError.textContent = "Please fill in the question and the student.";
                return;
            }

            // make the new question, new ones start as Pending
            var newQuestion = {
                id: nextId,
                question: question,
                student: student,
                category: category,
                status: "Pending"
            };

            questions.push(newQuestion);
            nextId = nextId + 1;

            // TODO: send this to PHP so it gets saved in the database

            // clear the form and close the popup
            document.getElementById("newTitle").value = "";
            document.getElementById("newstudent").value = "";
            addModal.classList.remove("show");

            applyFilters();
            showToast("Question added.");
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
        // show all questions when the page first loads
        showTable(questions);
