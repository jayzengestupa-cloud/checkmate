 
        var reports = [
            { id: 1, type: "Inappropriate", title: "Spam content",     student: "Daniel Cruz",  reporter: "Maria Santos",    date: "May 10, 2025", status: "Pending",
              details: "The student keeps posting the same unrelated link in several question threads." },
            { id: 2, type: "Duplicate",     title: "Duplicate question", student: "Liza Gomez",   reporter: "Pedro Reyes",     date: "May 9, 2025",  status: "Review",
              details: "The same question was submitted twice with only the wording changed." },
            { id: 3, type: "Inappropriate", title: "Off-topic content",  student: "Mark Tan",     reporter: "Ana Lopez",       date: "May 8, 2025",  status: "Resolved",
              details: "A question about a video game was posted under the Algebra course." },
            { id: 4, type: "Harassment",    title: "Unfair behavior",    student: "Joel Navarro", reporter: "Carlos Garcia",   date: "May 7, 2025",  status: "Pending",
              details: "The student left rude comments on a classmate's answer during a collaboration." },
            { id: 5, type: "Plagiarism",    title: "Copy of homework",   student: "Kim Ramos",    reporter: "Juan Dela Cruz",  date: "May 6, 2025",  status: "Review",
              details: "The submitted answer matches another student's work almost word for word." },
            { id: 6, type: "Other",         title: "Wrong category",     student: "Ella Mendoza", reporter: "Maria Santos",    date: "May 5, 2025",  status: "Pending",
              details: "The question was filed under the wrong subject and course." }
        ];

        // the report that is open in the popup
        var viewingId = null;


        // ---------- 2. GET ELEMENTS ----------
        var toast = document.getElementById("toast");
        var tableBody = document.getElementById("tableBody");
        var showingText = document.getElementById("showingText");

        var searchInput = document.getElementById("searchInput");
        var typeFilter = document.getElementById("typeFilter");
        var statusFilter = document.getElementById("statusFilter");

        var viewModal = document.getElementById("viewModal");
        var viewStatus = document.getElementById("viewStatus");


        // ---------- 3. TOAST ----------
        function showToast(message) {
            toast.textContent = message;
            toast.classList.add("show");

            setTimeout(function () {
                toast.classList.remove("show");
            }, 2500);
        }


        // ---------- 4. SMALL HELPERS ----------

        // so someone can't type html into a name or title
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

        function findReport(id) {
            for (var i = 0; i < reports.length; i++) {
                if (reports[i].id === id) {
                    return reports[i];
                }
            }
            return null;
        }


        // ---------- 5. SHOW THE TABLE ----------
        // returns the reports that match the search box and both filters
        function getFiltered() {

            var searchText = searchInput.value.toLowerCase().trim();
            var type = typeFilter.value;
            var status = statusFilter.value;
            var result = [];

            for (var i = 0; i < reports.length; i++) {

                var r = reports[i];

                // check the search box (title, reported student or reporter)
                var matchesSearch = true;
                if (searchText !== "") {
                    matchesSearch = r.title.toLowerCase().indexOf(searchText) !== -1 ||
                                    r.student.toLowerCase().indexOf(searchText) !== -1 ||
                                    r.reporter.toLowerCase().indexOf(searchText) !== -1;
                }

                var matchesType = (type === "all" || r.type === type);
                var matchesStatus = (status === "all" || r.status === status);

                if (matchesSearch && matchesType && matchesStatus) {
                    result.push(r);
                }
            }

            return result;
        }

        function showTable() {

            var result = getFiltered();
            var html = "";

            for (var j = 0; j < result.length; j++) {

                var r = result[j];

                html += "<tr>";
                html += "<td class='cell-id'>" + formatId(r.id) + "</td>";
                html += "<td>" + makeSafe(r.type) + "</td>";
                html += "<td>" + makeSafe(r.title) + "</td>";
                html += "<td>" + makeSafe(r.student) + "</td>";
                html += "<td class='cell-muted'>" + makeSafe(r.reporter) + "</td>";
                html += "<td class='cell-muted'>" + makeSafe(r.date) + "</td>";
                html += "<td><span class='status " + r.status.toLowerCase() + "'>" + r.status + "</span></td>";
                html += "<td><button class='action-btn' onclick='openView(" + r.id + ")'>View</button></td>";
                html += "</tr>";
            }

            if (result.length === 0) {
                html = "<tr class='empty-row'><td colspan='8'>No reports found. Try a different search or filter.</td></tr>";
                showingText.textContent = "Showing 0 of " + reports.length + " reports";
            } else {
                showingText.textContent = "Showing 1–" + result.length + " of " + reports.length + " reports";
            }

            tableBody.innerHTML = html;
        }

        searchInput.addEventListener("input", showTable);
        typeFilter.addEventListener("change", showTable);
        statusFilter.addEventListener("change", showTable);


        // ---------- 6. VIEW POPUP ----------
        function openView(id) {

            var r = findReport(id);
            viewingId = id;

            document.getElementById("viewLabel").textContent = "REPORT " + formatId(r.id);
            document.getElementById("viewTitle").textContent = r.title;
            document.getElementById("viewStudent").textContent = r.student;
            document.getElementById("viewReporter").textContent = r.reporter;
            document.getElementById("viewType").textContent = r.type;
            document.getElementById("viewDate").textContent = r.date;
            document.getElementById("viewDetails").textContent = r.details;
            viewStatus.value = r.status;

            viewModal.classList.add("show");
        }

        document.getElementById("closeView").addEventListener("click", function () {
            viewModal.classList.remove("show");
        });

        // clicking the dark area outside the box also closes it
        viewModal.addEventListener("click", function (event) {
            if (event.target === viewModal) {
                viewModal.classList.remove("show");
            }
        });

        document.getElementById("saveView").addEventListener("click", function () {

            var r = findReport(viewingId);
            r.status = viewStatus.value;

            // TODO: send this change to PHP so it gets saved in the database

            viewModal.classList.remove("show");

            showTable();
            showToast(formatId(r.id) + " was updated.");
        });


        // ---------- 7. EXPORT ----------
        // downloads the reports that are currently shown as a csv file
        function csvSafe(text) {
            return '"' + text.replace(/"/g, '""') + '"';
        }

        document.getElementById("exportButton").addEventListener("click", function () {

            var result = getFiltered();

            if (result.length === 0) {
                showToast("There are no reports to export.");
                return;
            }

            var csv = "ID,Type,Title,Reported Student,Reported By,Date,Status\n";

            for (var i = 0; i < result.length; i++) {
                var r = result[i];
                csv += [
                    formatId(r.id),
                    csvSafe(r.type),
                    csvSafe(r.title),
                    csvSafe(r.student),
                    csvSafe(r.reporter),
                    csvSafe(r.date),
                    r.status
                ].join(",") + "\n";
            }

            var blob = new Blob([csv], { type: "text/csv" });
            var link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "checkmate_reports.csv";
            link.click();

            showToast("Reports exported.");
        });


        // ---------- 8. NOTIFICATION BUTTON ----------
        document.getElementById("notificationButton").addEventListener("click", function () {
            showToast("You have 3 new notifications.");
        });


        // ---------- 9. START ----------
        showTable();


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
