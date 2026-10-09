
        // ---------- 1. DATA ----------
        // TODO: later get this list from the database (checkmate_db) with PHP
        var students = [
            { id: 1, name: "Juan Dela Cruz", studentId: "2025-62390", email: "juan@ncst.edu.ph",   course: "BSIT", year: "2nd Year", status: "Verified" },
            { id: 2, name: "Maria Santos",    studentId: "2025-62931", email: "maria@ncst.edu.ph",  course: "BSCS", year: "2nd Year", status: "Verified" },
            { id: 3, name: "Pedro Reyes",     studentId: "2025-60895", email: "pedro@ncst.edu.ph",  course: "BSE",  year: "3rd Year", status: "Verified" },
            { id: 4, name: "Ana Lopez",       studentId: "2025-65417", email: "ana@ncst.edu.ph",    course: "BSIT", year: "1st Year", status: "Pending"  },
            { id: 5, name: "Carlos Garcia",   studentId: "2025-11111", email: "carlos@ncst.edu.ph", course: "BSEE", year: "2nd Year", status: "Verified" }
        ];


        // ---------- 2. GET ELEMENTS ----------
        var toast = document.getElementById("toast");
        var studentsBody = document.getElementById("studentsBody");
        var showingText = document.getElementById("showingText");

        var searchInput = document.getElementById("searchInput");
        var courseFilter = document.getElementById("courseFilter");
        var yearFilter = document.getElementById("yearFilter");

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
        // so someone can't type html into the name box
        function makeSafe(text) {
            text = text.replace(/&/g, "&amp;");
            text = text.replace(/</g, "&lt;");
            text = text.replace(/>/g, "&gt;");
            text = text.replace(/"/g, "&quot;");
            return text;
        }


        // ---------- 5. SHOW THE TABLE ----------
        // loops through the list and builds one row for each student
        function showTable(list) {

            var html = "";

            for (var i = 0; i < list.length; i++) {

                var s = list[i];

                // class name for the badge color (verified or pending)
                var statusClass = s.status.toLowerCase();

                html += "<tr>";
                html += "<td><span class='cell-id'>" + s.id + "</span></td>";
                html += "<td>" + makeSafe(s.name) + "</td>";
                html += "<td>" + makeSafe(s.studentId) + "</td>";
                html += "<td class='cell-muted'>" + makeSafe(s.email) + "</td>";
                html += "<td>" + s.course + "</td>";
                html += "<td>" + s.year + "</td>";
                html += "<td><span class='status " + statusClass + "'>" + s.status + "</span></td>";
                html += "<td>";
                html += "<button class='action-btn' onclick='viewStudent(" + s.id + ")'>View</button>";
                html += "<button class='action-btn' onclick='editStudent(" + s.id + ")'>Edit</button>";
                html += "</td>";
                html += "</tr>";
            }

            // if nothing matches, show a message
            if (list.length === 0) {
                html = "<tr class='empty-row'><td colspan='8'>No students found. Try a different search or filter.</td></tr>";
                showingText.textContent = "Showing 0 of " + students.length + " students";
            } else {
                showingText.textContent = "Showing 1–" + list.length + " of " + list.length + " students";
            }

            studentsBody.innerHTML = html;
        }


        // ---------- 6. SEARCH AND FILTERS ----------
        function applyFilters() {

            var searchText = searchInput.value.toLowerCase().trim();
            var course = courseFilter.value;
            var year = yearFilter.value;

            var result = [];

            for (var i = 0; i < students.length; i++) {

                var s = students[i];

                // check the search box (name, student id or email)
                var matchesSearch = true;
                if (searchText !== "") {
                    matchesSearch = s.name.toLowerCase().indexOf(searchText) !== -1 ||
                                    s.studentId.toLowerCase().indexOf(searchText) !== -1 ||
                                    s.email.toLowerCase().indexOf(searchText) !== -1;
                }

                // check the course filter
                var matchesCourse = (course === "all" || s.course === course);

                // check the year level filter
                var matchesYear = (year === "all" || s.year === year);

                // only keep the student if all 3 are true
                if (matchesSearch && matchesCourse && matchesYear) {
                    result.push(s);
                }
            }

            showTable(result);
        }

        searchInput.addEventListener("input", applyFilters);
        courseFilter.addEventListener("change", applyFilters);
        yearFilter.addEventListener("change", applyFilters);


        // ---------- 7. VIEW AND EDIT BUTTONS ----------
        // find the student with the matching id
        function findStudent(id) {
            for (var i = 0; i < students.length; i++) {
                if (students[i].id === id) {
                    return students[i];
                }
            }
            return null;
        }

        function viewStudent(id) {
            var s = findStudent(id);
            // TODO: open a real student profile page
            showToast("Viewing " + s.name + " (" + s.studentId + ")");
        }

        function editStudent(id) {
            var s = findStudent(id);
            // TODO: open an edit form
            showToast("Editing " + s.name + "...");
        }


        // ---------- 8. ADD STUDENT POPUP ----------
        document.getElementById("addStudentButton").addEventListener("click", function () {
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

            var name = document.getElementById("newName").value.trim();
            var studentId = document.getElementById("newStudentId").value.trim();
            var email = document.getElementById("newEmail").value.trim().toLowerCase();
            var course = document.getElementById("newCourse").value;
            var year = document.getElementById("newYear").value;

            // check that nothing is empty
            if (name === "" || studentId === "" || email === "") {
                formError.textContent = "Please fill in all the fields.";
                return;
            }

            // student id must look like 2025-12345 (4 digits, dash, 5 digits)
            var idPattern = /^\d{4}-\d{5}$/;
            if (!idPattern.test(studentId)) {
                formError.textContent = "Student ID must look like 2025-12345.";
                return;
            }

            // email must be an NCST email
            if (email.indexOf("@ncst.edu.ph") === -1 || email.indexOf("@ncst.edu.ph") !== email.length - 12) {
                formError.textContent = "Please use an NCST email (@ncst.edu.ph).";
                return;
            }

            // check if the student id is already in the list
            for (var i = 0; i < students.length; i++) {
                if (students[i].studentId === studentId) {
                    formError.textContent = "That Student ID is already registered.";
                    return;
                }
            }

            // make the new student, new ones start as Pending
            var newStudent = {
                id: students.length + 1,
                name: name,
                studentId: studentId,
                email: email,
                course: course,
                year: year,
                status: "Pending"
            };

            students.push(newStudent);

            // TODO: send this to PHP so it gets saved in the database

            // clear the form and close the popup
            document.getElementById("newName").value = "";
            document.getElementById("newStudentId").value = "";
            document.getElementById("newEmail").value = "";
            addModal.classList.remove("show");

            applyFilters();
            showToast(name + " was added.");
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
        // show all students when the page first loads
        showTable(students);
