<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CHECKMATE - Reports</title>

    <!-- Same stylesheet as the other admin pages -->
    <link rel="stylesheet" href="../../asset/css/admin_home.css">
    <link rel="stylesheet" href="../../asset/css/report.css">

 
</head>

<body>

    <!-- =========================================
         SIDEBAR
         ========================================= -->

    <aside class="sidebar">

        <!-- Logo -->
        <div class="logo">
            <span>♞</span>
            CHECKMATE
        </div>

        <!-- Account Type -->
        <div class="admin-label">
            ADMINISTRATION
        </div>


        <!-- OVERVIEW MENU -->
        <div class="sidebar-section">

            <div class="sidebar-title">
                OVERVIEW
            </div>

           <ul class="sidebar-menu">

                <li>
                    <a href="admin_home.php" data-page="dashboard">
                        <span class="menu-icon">⌂</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="student.php" data-page="students">
                        <span class="menu-icon">♟</span>
                        <span>Students</span>
                        <span class="menu-count">8</span>
                    </a>
                </li>

                <li>
                    <a href="question_ad.php" data-page="questions">
                        <span class="menu-icon">?</span>
                        <span>Questions</span>
                    </a>
                </li>

                <li>
                    <a href="collaboration.php" data-page="collaborations">
                        <span class="menu-icon">♞</span>
                        <span>Collaborations</span>
                    </a>
                </li>

            </ul>


        </div>


        <!-- MANAGEMENT MENU -->
        <div class="sidebar-section">

            <div class="sidebar-title">
                MANAGEMENT
            </div>

            <ul class="sidebar-menu">

                <li>
                    <a href="subject_course.php" data-page="subjects">
                        <span class="menu-icon">◇</span>
                        <span>Subjects & Courses</span>
                    </a>
                </li>

                <li>
                    <a href="question_type.php" data-page="types">
                        <span class="menu-icon">≡</span>
                        <span>Question Types</span>
                    </a>
                </li>

                <li>
                    <!-- this is the current page so it is active -->
                    <a href="report.php" class="active" data-page="reports">
                        <span class="menu-icon">▤</span>
                        <span>Reports</span>
                        <span class="menu-dot"></span>
                    </a>
                </li>

            </ul>

        </div>


        <!-- ADMIN ACCOUNT (bottom of sidebar) -->
        <!-- ADMIN ACCOUNT (bottom of sidebar) -->
<!-- ADMIN ACCOUNT (bottom of sidebar) -->
<div class="sidebar-account">

    <div class="sidebar-account-user">

        <div class="sidebar-account-avatar">
            A
        </div>

        <div class="sidebar-account-info">
            <strong>Administrator</strong>
            <span>CHECKMATE Admin</span>
        </div>

        <!-- three dots (vertical) on the right side of the profile -->
        <button class="account-menu-btn" id="accountMenuButton" title="Account options" aria-label="Account options">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>

    <!-- menu that opens when the 3 dots are clicked -->
    <div class="account-menu" id="accountMenu">
        <a href="change_password.html">
            <span class="account-menu-icon">⚿</span>
            <span>Change Password</span>
        </a>
        <a href="../../authentication/Login/logout.php" class="menu-logout">
            <span class="account-menu-icon">⏻</span>
            <span>Log Out</span>
        </a>
    </div>

</div>
    </aside>


    <!-- =========================================
         MAIN CONTENT
         ========================================= -->

    <main class="main">

        <!-- TOP BAR -->
        <header class="topbar">

            <div class="topbar-left">

                <div class="topbar-label">
                    ADMINISTRATION
                </div>

                <div class="topbar-title">
                    Reports
                </div>

                <div class="topbar-sub">
                    Review and manage reported students, flagged content and reports.
                </div>

            </div>

            <div class="topbar-right">

                <!-- Notifications -->
                <button class="notification" id="notificationButton">

                    ♧

                    <span class="notification-count">
                        3
                    </span>

                </button>

            </div>

        </header>


        <!-- PAGE CONTENT -->
        <section class="content">

            <!-- Search, type filter, status filter and export button -->
            <div class="toolbar">

                <div class="search-box">
                    <span class="search-icon">⌕</span>
                    <input type="text" id="searchInput" class="search-input"
                           placeholder="Search reports or students...">
                </div>

                <select id="typeFilter" class="filter-select">
                    <option value="all">All Types</option>
                    <option value="Inappropriate">Inappropriate</option>
                    <option value="Duplicate">Duplicate</option>
                    <option value="Harassment">Harassment</option>
                    <option value="Plagiarism">Plagiarism</option>
                    <option value="Other">Other</option>
                </select>

                <select id="statusFilter" class="filter-select">
                    <option value="all">All Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Review">Review</option>
                    <option value="Resolved">Resolved</option>
                </select>

                <button class="btn-gold" id="exportButton">⇩ Export</button>

            </div>


            <!-- Table -->
            <div class="panel">

                <div class="table-wrap">

                    <table class="data-table">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Reported Student</th>
                                <th>Reported By</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <!-- rows are filled in by the JavaScript below -->
                        <tbody id="tableBody"></tbody>

                    </table>

                </div>

                <div class="panel-footer">
                    <div class="showing-text" id="showingText"></div>

                    <!-- TODO: make pagination work when there are more reports -->
                    <div class="pagination">
                        <button class="page-btn">‹</button>
                        <button class="page-btn current">1</button>
                        <button class="page-btn">›</button>
                    </div>
                </div>

            </div>

        </section>

    </main>


    <!-- =========================================
         VIEW REPORT POPUP
         ========================================= -->

    <div class="modal-overlay" id="viewModal">

        <div class="modal">

            <div class="modal-label" id="viewLabel">REPORT</div>
            <h2 class="modal-title" id="viewTitle">Report title</h2>

            <div class="detail-grid">

                <div class="detail-item">
                    <span>Reported student</span>
                    <strong id="viewStudent"></strong>
                </div>

                <div class="detail-item">
                    <span>Reported by</span>
                    <strong id="viewReporter"></strong>
                </div>

                <div class="detail-item">
                    <span>Type</span>
                    <strong id="viewType"></strong>
                </div>

                <div class="detail-item">
                    <span>Date</span>
                    <strong id="viewDate"></strong>
                </div>

            </div>

            <div class="detail-box" id="viewDetails"></div>

            <div class="form-group">
                <label for="viewStatus">Status</label>
                <select id="viewStatus" class="filter-select">
                    <option value="Pending">Pending</option>
                    <option value="Review">Review</option>
                    <option value="Resolved">Resolved</option>
                </select>
            </div>

            <div class="modal-buttons">
                <button class="btn-outline" id="closeView">Close</button>
                <button class="btn-gold filled" id="saveView">Save Changes</button>
            </div>

        </div>

    </div>


    <!-- TOAST MESSAGE (styled in style.css) -->
    <div class="toast" id="toast"></div>


    <!-- =========================================
         JAVASCRIPT
         ========================================= -->

         <script src=../../asset/js/report.js></script>
  

</body>
</html>