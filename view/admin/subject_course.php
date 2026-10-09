<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CHECKMATE - Subjects & Courses</title>

    <!-- Same stylesheet as the other admin pages -->
         <link rel="stylesheet" href="../../asset/css/admin_home.css">
    <link rel="stylesheet" href="../../asset/css/subject_course.css">

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
                    <!-- this is the current page so it is active -->
                    <a href="subject_course.php" class="active" data-page="subjects">
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
                    <a href="report.php" data-page="reports">
                        <span class="menu-icon">▤</span>
                        <span>Reports</span>
                        <span class="menu-dot"></span>
                    </a>
                </li>

            </ul>

        </div>


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
                    Subjects & Courses
                </div>

                <div class="topbar-sub">
                    Manage subjects and courses offered in the system.
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

            <!-- Summary cards -->
            <div class="stat-row">

                <div class="stat-card" data-jump="courses">
                    <div class="stat-icon">◇</div>
                    <div class="stat-info">
                        <div class="stat-label">Total Courses</div>
                        <div class="stat-number" id="statCourses">0</div>
                    </div>
                    <div class="stat-arrow">→</div>
                </div>

                <div class="stat-card" data-jump="subjects">
                    <div class="stat-icon blue">≡</div>
                    <div class="stat-info">
                        <div class="stat-label">Total Subjects</div>
                        <div class="stat-number" id="statSubjects">0</div>
                    </div>
                    <div class="stat-arrow">→</div>
                </div>

                <div class="stat-card" data-jump="Active">
                    <div class="stat-icon green">✓</div>
                    <div class="stat-info">
                        <div class="stat-label">Active</div>
                        <div class="stat-number" id="statActive">0</div>
                    </div>
                    <div class="stat-arrow">→</div>
                </div>

                <div class="stat-card" data-jump="Pending">
                    <div class="stat-icon">◔</div>
                    <div class="stat-info">
                        <div class="stat-label">Pending</div>
                        <div class="stat-number" id="statPending">0</div>
                    </div>
                    <div class="stat-arrow">→</div>
                </div>

            </div>


            <!-- Courses / Subjects toggle -->
            <div class="toggle">
                <button class="toggle-btn active" data-tab="courses">Courses</button>
                <button class="toggle-btn" data-tab="subjects">Subjects</button>
            </div>


            <!-- Search, status filter and add button -->
            <div class="toolbar">

                <div class="search-box">
                    <span class="search-icon">⌕</span>
                    <input type="text" id="searchInput" class="search-input"
                           placeholder="Search courses...">
                </div>

                <select id="statusFilter" class="filter-select">
                    <option value="all">All Status</option>
                    <option value="Active">Active</option>
                    <option value="Pending">Pending</option>
                </select>

                <button class="btn-gold" id="addButton">+ Add Course</button>

            </div>


            <!-- Table -->
            <div class="panel">

                <div class="table-wrap">

                    <table class="data-table">

                        <thead id="tableHead"></thead>

                        <!-- rows are filled in by the JavaScript below -->
                        <tbody id="tableBody"></tbody>

                    </table>

                </div>

                <div class="panel-footer">
                    <div class="showing-text" id="showingText"></div>

                    <!-- TODO: make pagination work when there are more items -->
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
         ADD / EDIT POPUP
         ========================================= -->

    <div class="modal-overlay" id="formModal">

        <div class="modal">

            <div class="modal-label" id="modalLabel">COURSES</div>
            <h2 class="modal-title" id="modalTitle">Add course</h2>

            <div class="form-group">
                <label for="formName" id="nameLabel">Course name</label>
                <input type="text" id="formName" class="form-input" placeholder="BS Information Technology">
            </div>

            <!-- only shown for subjects: which course the subject belongs to -->
            <div class="form-group" id="courseGroup" style="display:none;">
                <label for="formCourse">Course</label>
                <select id="formCourse" class="filter-select"></select>
            </div>

            <div class="form-group">
                <label for="formStatus">Status</label>
                <select id="formStatus" class="filter-select">
                    <option value="Active">Active</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>

            <!-- error message shows here -->
            <div class="form-error" id="formError"></div>

            <div class="modal-buttons">
                <button class="btn-outline" id="cancelForm">Cancel</button>
                <button class="btn-gold" id="saveForm">Save</button>
            </div>

        </div>

    </div>


    <!-- TOAST MESSAGE (styled in style.css) -->
    <div class="toast" id="toast"></div>


    <!-- =========================================
         JAVASCRIPT
         ========================================= -->
        <script src="../../asset/js/subject_course.js"></script>

</body>
</html>