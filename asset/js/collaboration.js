
        // ---------- 1. DATA ----------
        // TODO: later get these lists from the database with PHP
        var requests = [
            { id: 1, from: "Juan Dela Cruz", to: "Maria Santos",  topic: "Data Structures Study Group", date: "May 18, 2025", time: "10:24 AM", status: "Pending"  },
            { id: 2, from: "Pedro Reyes",    to: "Ana Lopez",     topic: "Q&A Review",                  date: "May 17, 2025", time: "03:45 PM", status: "Accepted" },
            { id: 3, from: "Carlos Garcia",  to: "Jose Villanueva", topic: "Study Group",               date: "May 16, 2025", time: "11:20 AM", status: "Accepted" },
            { id: 4, from: "Maria Santos",   to: "Luis Perez",    topic: "Programming Project",         date: "May 15, 2025", time: "04:12 PM", status: "Pending"  },
            { id: 5, from: "Ana Lopez",      to: "Kevin Cruz",    topic: "Q&A Session",                 date: "May 14, 2025", time: "01:07 PM", status: "Rejected" }
        ];

        var activeList = [
            { a: "Juan Dela Cruz", b: "Maria Santos",   topic: "Data Structure Study Group", course: "CS101 - Data Structures",      started: "May 12, 2025" },
            { a: "Pedro Reyes",    b: "Maria Santos",   topic: "Q&A Review",                 course: "CS102 - Algorithms",           started: "May 11, 2025" },
            { a: "Carlos Garcia",  b: "Jose Villanueva", topic: "Web Development Project",   course: "IT102 - Web Development",      started: "May 10, 2025" },
            { a: "Luis Perez",     b: "Carla Garcia",   topic: "Programming Project",        course: "IT103 - Software Engineering", started: "May 10, 2025" },
            { a: "Ana Lopez",      b: "Kevin Cruz",     topic: "Q&A Session",                course: "CS101 - Data Structures",      started: "May 9, 2025"  },
            { a: "Daniel Santos",  b: "Sofia Reyes",    topic: "Study Group",                course: "CS101 - Data Structures",      started: "May 7, 2025"  }
        ];

        // the total shown in the summary card (more exist on page 2)
        var activeTotal = 12;

        // which tab is open: requests, active or history
        var currentTab = "requests";

        // extra filter when a summary card is clicked ("all" = no filter)
        var statusFilter = "all";


        // ---------- 2. GET ELEMENTS ----------
        var toast = document.getElementById("toast");
        var requestsBody = document.getElementById("requestsBody");
        var showingText = document.getElementById("showingText");
        var requestsPanel = document.getElementById("requestsPanel");
        var activePanel = document.getElementById("activePanel");
        var activeGrid = document.getElementById("activeGrid");
        var activeShowing = document.getElementById("activeShowing");
        var requestsTitle = document.getElementById("requestsTitle");
        var requestsSub = document.getElementById("requestsSub");


        // ---------- 3. TOAST ----------
        function showToast(message) {
            toast.textContent = message;
            toast.classList.add("show");

            setTimeout(function () {
                toast.classList.remove("show");
            }, 2500);
        }


        // ---------- 4. SMALL HELPERS ----------

        // so someone can't type html into a name or topic
        function makeSafe(text) {
            text = text.replace(/&/g, "&amp;");
            text = text.replace(/</g, "&lt;");
            text = text.replace(/>/g, "&gt;");
            text = text.replace(/"/g, "&quot;");
            return text;
        }

        // 1 becomes #CR-001
        function formatId(number) {
            var text = "00" + number;
            if (number >= 100) {
                text = "" + number;
            } else {
                text = text.slice(-3);
            }
            return "#CR-" + text;
        }

        // first letters of the name for the round avatar (Juan Dela Cruz -> JD)
        function initials(name) {
            var parts = name.split(" ");
            var letters = parts[0].charAt(0);
            if (parts.length > 1) {
                letters += parts[parts.length - 1].charAt(0);
            }
            return letters.toUpperCase();
        }

        function personHtml(name, small) {
            var cls = small ? "avatar small" : "avatar";
            return "<div class='person'><span class='" + cls + "'>" + initials(name) + "</span>" +
                   "<span>" + makeSafe(name) + "</span></div>";
        }

        function findRequest(id) {
            for (var i = 0; i < requests.length; i++) {
                if (requests[i].id === id) {
                    return requests[i];
                }
            }
            return null;
        }


        // ---------- 5. SUMMARY CARDS ----------
        function updateStats() {

            var pending = 0;
            var accepted = 0;
            var rejected = 0;

            for (var i = 0; i < requests.length; i++) {
                if (requests[i].status === "Pending") { pending++; }
                if (requests[i].status === "Accepted") { accepted++; }
                if (requests[i].status === "Rejected") { rejected++; }
            }

            document.getElementById("statPending").textContent = pending;
            document.getElementById("statAccepted").textContent = accepted;
            document.getElementById("statRejected").textContent = rejected;
            document.getElementById("statActive").textContent = activeTotal;
        }


        // ---------- 6. REQUESTS TABLE ----------
        function showRequests() {

            var list = [];

            for (var i = 0; i < requests.length; i++) {

                var r = requests[i];

                // the History tab only shows requests that were already answered
                if (currentTab === "history" && r.status === "Pending") {
                    continue;
                }

                if (statusFilter !== "all" && r.status !== statusFilter) {
                    continue;
                }

                list.push(r);
            }

            var html = "";

            for (var j = 0; j < list.length; j++) {

                var q = list[j];
                var statusClass = q.status.toLowerCase();

                html += "<tr>";
                html += "<td class='cell-id'>" + formatId(q.id) + "</td>";
                html += "<td>" + personHtml(q.from, false) + "</td>";
                html += "<td class='arrow-cell'>→</td>";
                html += "<td>" + personHtml(q.to, false) + "</td>";
                html += "<td class='arrow-cell'></td>";
                html += "<td class='cell-muted'>" + makeSafe(q.topic) + "</td>";
                html += "<td>" + q.date + "<span class='time-small'>" + q.time + "</span></td>";
                html += "<td><span class='status " + statusClass + "'>" + q.status + "</span></td>";
                html += "<td>";
                html += "<button class='action-btn' onclick='viewRequest(" + q.id + ")'>View</button>";

                // only pending requests can be approved or rejected
                if (q.status === "Pending") {
                    html += "<button class='action-btn approve' onclick='answerRequest(" + q.id + ", \"Accepted\")'>Approve</button>";
                    html += "<button class='action-btn reject' onclick='answerRequest(" + q.id + ", \"Rejected\")'>Reject</button>";
                }

                html += "</td>";
                html += "</tr>";
            }

            if (list.length === 0) {
                html = "<tr class='empty-row'><td colspan='9'>No collaboration requests found.</td></tr>";
                showingText.textContent = "Showing 0 of " + requests.length + " requests";
            } else {
                showingText.textContent = "Showing 1–" + list.length + " of " + list.length + " requests";
            }

            requestsBody.innerHTML = html;
        }


        // ---------- 7. ACTIVE COLLABORATIONS ----------
        function showActive() {

            var html = "";

            for (var i = 0; i < activeList.length; i++) {

                var c = activeList[i];

                html += "<div class='active-card'>";
                html += "<div>";
                html += "<div class='active-people'>" +
                        "<span class='avatar small'>" + initials(c.a) + "</span>" + makeSafe(c.a) +
                        "<span class='swap'>⇄</span>" +
                        "<span class='avatar small'>" + initials(c.b) + "</span>" + makeSafe(c.b) +
                        "</div>";
                html += "<div class='active-meta'><b>Topic:</b> " + makeSafe(c.topic) + "<br>" +
                        "<b>Course:</b> " + makeSafe(c.course) + "</div>";
                html += "</div>";
                html += "<div class='active-right'>";
                html += "<span class='cell-muted' style='font-size:9px'>Started: " + c.started + "</span>";
                html += "<span class='status active'>Active</span>";
                html += "<button class='action-btn' onclick='showToast(\"Viewing collaboration between " + makeSafe(c.a) + " and " + makeSafe(c.b) + ".\")'>View</button>";
                html += "</div>";
                html += "</div>";
            }

            activeGrid.innerHTML = html;
            activeShowing.textContent = "Showing 1–" + activeList.length + " of " + activeTotal + " active collaborations";
        }


        // ---------- 8. APPROVE, REJECT AND VIEW ----------
        function viewRequest(id) {
            var r = findRequest(id);
            // TODO: open a real request page
            showToast(formatId(r.id) + ": " + r.from + " asked " + r.to + " (" + r.status + ")");
        }

        function answerRequest(id, newStatus) {
            var r = findRequest(id);

            var word = (newStatus === "Accepted") ? "approve" : "reject";
            var sure = confirm("Do you want to " + word + " " + formatId(r.id) + "?\n\n" +
                               r.from + " → " + r.to + "\n" + r.topic);

            if (sure === false) {
                return;
            }

            r.status = newStatus;

            // an approved request becomes a new active collaboration
            if (newStatus === "Accepted") {
                activeTotal = activeTotal + 1;
                activeList.unshift({
                    a: r.from,
                    b: r.to,
                    topic: r.topic,
                    course: "Not set yet",
                    started: "Today"
                });
                // keep only the first 6 on this page
                if (activeList.length > 6) {
                    activeList.pop();
                }
            }

            // TODO: also save this answer in the database with PHP

            updateStats();
            showRequests();
            showActive();
            showToast(formatId(r.id) + " was " + newStatus.toLowerCase() + ".");
        }


        // ---------- 9. TABS ----------
        function setTab(name) {

            currentTab = name;

            var tabs = document.querySelectorAll(".tab");
            for (var i = 0; i < tabs.length; i++) {
                if (tabs[i].getAttribute("data-tab") === name) {
                    tabs[i].classList.add("active");
                } else {
                    tabs[i].classList.remove("active");
                }
            }

            // requests tab = both sections, active tab = only active, history = only answered requests
            if (name === "active") {
                requestsPanel.classList.add("hidden");
                activePanel.classList.remove("hidden");
            } else if (name === "history") {
                requestsPanel.classList.remove("hidden");
                activePanel.classList.add("hidden");
                requestsTitle.textContent = "Request History";
                requestsSub.textContent = "Requests that were already approved or rejected.";
            } else {
                requestsPanel.classList.remove("hidden");
                activePanel.classList.remove("hidden");
                requestsTitle.textContent = "Collaboration Requests";
                requestsSub.textContent = "Review and manage incoming collaboration requests.";
            }

            showRequests();
        }

        var tabButtons = document.querySelectorAll(".tab");
        for (var t = 0; t < tabButtons.length; t++) {
            tabButtons[t].addEventListener("click", function () {
                statusFilter = "all";
                setTab(this.getAttribute("data-tab"));
            });
        }

        // clicking a summary card opens the matching view
        var statCards = document.querySelectorAll(".stat-card");
        for (var s = 0; s < statCards.length; s++) {
            statCards[s].addEventListener("click", function () {
                var jump = this.getAttribute("data-jump");

                if (jump === "active") {
                    statusFilter = "all";
                    setTab("active");
                } else {
                    statusFilter = jump;
                    setTab(jump === "Pending" ? "requests" : "history");
                }
            });
        }


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
        showRequests();
        showActive();

