<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CHECKMATE - Students</title>

    <!-- Same stylesheet as the dashboard (sidebar, topbar, toast, etc.) -->
     <link rel="stylesheet" href="../../asset/css/admin_home.css">
    <link rel="stylesheet" href="../../asset/css/student.css">
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
                    Students
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

            <!-- Search, filters and add button -->
            <div class="toolbar">

                <div class="search-box">
                    <span class="search-icon">⌕</span>
                    <input type="text" id="searchInput" class="search-input"
                           placeholder="Search by name, student ID, or email...">
                </div>

                <select id="courseFilter" class="filter-select">
                    <option value="all">All Courses</option>
                    <option value="BSIT">BSIT</option>
                    <option value="BSCS">BSCS</option>
                    <option value="BSE">BSE</option>
                    <option value="BSEE">BSEE</option>
                </select>

                <select id="yearFilter" class="filter-select">
                    <option value="all">All Year Levels</option>
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                </select>

                <button class="btn-gold" id="addStudentButton">+ Add Student</button>

            </div>


            <!-- Students table -->
            <div class="table-wrap">

                <table class="students-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Student ID</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <!-- rows are filled in by the JavaScript below -->
                    <tbody id="studentsBody"></tbody>

                </table>

            </div>


            <!-- Count + pagination -->
            <div class="table-footer">

                <div class="showing-text" id="showingText"></div>

                <!-- TODO: make pagination work when there are more students -->
                <div class="pagination">
                    <button class="page-btn">‹</button>
                    <button class="page-btn current">1</button>
                    <button class="page-btn">›</button>
                </div>

            </div>

        </section>

    </main>


    <!-- =========================================
         ADD STUDENT POPUP
         ========================================= -->

    <div class="modal-overlay" id="addModal">

        <div class="modal">

            <div class="modal-label">STUDENT RECORDS</div>
            <h2 class="modal-title">Add student</h2>

            <div class="form-group">
                <label for="newName">Full Name</label>
                <input type="text" id="newName" class="form-input" placeholder="Juan Dela Cruz">
            </div>

            <div class="form-row">

                <div class="form-group">
                    <label for="newStudentId">Student ID</label>
                    <input type="text" id="newStudentId" class="form-input" placeholder="2025-12345">
                </div>

                <div class="form-group">
                    <label for="newEmail">Email</label>
                    <input type="text" id="newEmail" class="form-input" placeholder="name@ncst.edu.ph">
                </div>

            </div>

            <div class="form-row">

                <div class="form-group">
                    <label for="newCourse">Course</label>
                    <select id="newCourse" class="filter-select">
                        <option value="BSIT">BSIT</option>
                        <option value="BSCS">BSCS</option>
                        <option value="BSE">BSE</option>
                        <option value="BSEE">BSEE</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="newYear">Year Level</label>
                    <select id="newYear" class="filter-select">
                        <option value="1st Year">1st Year</option>
                        <option value="2nd Year">2nd Year</option>
                        <option value="3rd Year">3rd Year</option>
                        <option value="4th Year">4th Year</option>
                    </select>
                </div>

            </div>

            <!-- error message shows here -->
            <div class="form-error" id="formError"></div>

            <div class="modal-buttons">
                <button class="btn-outline" id="cancelAdd">Cancel</button>
                <button class="btn-gold" id="saveAdd">Add Student</button>
            </div>

        </div>

    </div>


    <!-- TOAST MESSAGE (styled in style.css) -->
    <div class="toast" id="toast"></div>


    <!-- =========================================
         JAVASCRIPT
         ========================================= -->
        <script src="../../asset/js/student.js"></script>

</body>
</html>