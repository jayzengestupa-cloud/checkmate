<?php
session_start();
require "../../config/config.php";   // your connection file

// the name of this file, like "subject_course.php"
// the sidebar uses it to know which link is the active one
$current_page = basename($_SERVER["PHP_SELF"]);

// make mysqli throw real errors and read text correctly
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn->set_charset("utf8mb4");

// only admins can open this page
// (CHANGE 'role' and the login path if yours are different)
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../../authentication/Login/login.php");
    exit;
}

// short helper for printing safe text in html
function e($text) {
    return htmlspecialchars((string)$text, ENT_QUOTES, "UTF-8");
}

// token used to protect add / edit / delete
if (empty($_SESSION["csrf"])) {
    $_SESSION["csrf"] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION["csrf"];


// ---------- the admin's own info (for the sidebar profile) ----------
// the login saves the admin's id in the session
$admin_id = (int)$_SESSION["user_id"];

// default values, in case the query finds nothing
$admin_name = "Administrator";
$admin_student_id = "";
$admin_initials = "A";

$stmt = $conn->prepare("SELECT first_name, last_name, student_id FROM users WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($admin) {
    // full name = first name + last name
    $full_name = trim(trim((string)$admin["first_name"]) . " " . trim((string)$admin["last_name"]));

    if ($full_name != "") {
        $admin_name = $full_name;
    }

    $admin_student_id = (string)$admin["student_id"];

    // initials = first letter of the first name + first letter of the last name
    $first_letter = substr(trim((string)$admin["first_name"]), 0, 1);
    $last_letter = substr(trim((string)$admin["last_name"]), 0, 1);
    $letters = strtoupper($first_letter . $last_letter);

    if ($letters != "") {
        $admin_initials = $letters;
    }
}


// ---------- courses (with how many questions use each one) ----------
$courses = [];
$result = $conn->query(
    "SELECT c.id, c.course_name AS name, c.status,
            (SELECT COUNT(*) FROM questions q WHERE q.question_course = c.course_name) AS used
     FROM question_courses c
     ORDER BY c.id"
);
while ($row = $result->fetch_assoc()) {
    $row["id"] = (int) $row["id"];
    $row["used"] = (int) $row["used"];
    $courses[] = $row;
}

// ---------- subjects (with how many questions use each one) ----------
$subjects = [];
$result = $conn->query(
    "SELECT s.id, s.subject_name AS name, s.status,
            (SELECT COUNT(*) FROM questions q WHERE q.subject = s.subject_name) AS used
     FROM question_subjects s
     ORDER BY s.id"
);
while ($row = $result->fetch_assoc()) {
    $row["id"] = (int) $row["id"];
    $row["used"] = (int) $row["used"];
    $subjects[] = $row;
}

// ---------- sidebar numbers ----------
$studentCount = (int) $conn->query("SELECT COUNT(*) AS c FROM users WHERE role = 'student'")->fetch_assoc()["c"];
$pendingReports = (int) $conn->query("SELECT COUNT(*) AS c FROM reports WHERE status = 'Pending'")->fetch_assoc()["c"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CHECKMATE - Subjects & Courses</title>

    <link rel="stylesheet" href="../../asset/css/admin_home.css?v=<?= filemtime(__DIR__ . '/../../asset/css/admin_home.css') ?>">
    <link rel="stylesheet" href="../../asset/css/subject_course.css?v=<?= filemtime(__DIR__ . '/../../asset/css/subject_course.css') ?>">
</head>

<body>

    <!-- =========================================
         SIDEBAR
         ========================================= -->

    <aside class="sidebar">

        <!-- Logo (same look as the student page) -->
        <div class="logo-area">
            <div class="logo-piece">♞</div>

            <div class="logo-text">
                <h1>CHECKMATE</h1>
                <span>ADMINISTRATION</span>
            </div>
        </div>

        <div class="sidebar-section">

            <div class="sidebar-title">
                OVERVIEW
            </div>

            <ul class="sidebar-menu">

                <li>
                    <a href="admin_home.php" class="<?php if ($current_page == 'admin_home.php') { echo 'active'; } ?>">
                        <span class="menu-icon">⌂</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="student.php" class="<?php if ($current_page == 'student.php') { echo 'active'; } ?>">
                        <span class="menu-icon">♟</span>
                        <span>Students</span>
                        <span class="menu-count"><?= $studentCount ?></span>
                    </a>
                </li>

                <li>
                    <a href="question_ad.php" class="<?php if ($current_page == 'question_ad.php') { echo 'active'; } ?>">
                        <span class="menu-icon">?</span>
                        <span>Questions</span>
                    </a>
                </li>

                <li>
                    <a href="collaboration.php" class="<?php if ($current_page == 'collaboration.php') { echo 'active'; } ?>">
                        <span class="menu-icon">♞</span>
                        <span>Collaborations</span>
                    </a>
                </li>

            </ul>

        </div>

        <div class="sidebar-section">

            <div class="sidebar-title">
                MANAGEMENT
            </div>

            <ul class="sidebar-menu">

                <li>
                    <a href="subject_course.php" class="<?php if ($current_page == 'subject_course.php') { echo 'active'; } ?>">
                        <span class="menu-icon">◇</span>
                        <span>Subjects & Courses</span>
                    </a>
                </li>

                <li>
                    <a href="question_type.php" class="<?php if ($current_page == 'question_type.php') { echo 'active'; } ?>">
                        <span class="menu-icon">≡</span>
                        <span>Question Types</span>
                    </a>
                </li>

                <li>
                    <a href="report.php" class="<?php if ($current_page == 'report.php') { echo 'active'; } ?>">
                        <span class="menu-icon">▤</span>
                        <span>Reports</span>
                        <?php if ($pendingReports > 0): ?>
                            <span class="menu-dot"></span>
                        <?php endif; ?>
                    </a>
                </li>

            </ul>

        </div>

        <!-- ADMIN PROFILE (bottom of sidebar, same look as the student profile) -->
        <div class="sidebar-account">

            <div class="sidebar-user">

                <!-- circle with the initials -->
                <div class="user-avatar">
                    <?= e($admin_initials) ?>
                </div>

                <div class="user-information">

                    <!-- the admin's real name from the database -->
                    <strong><?= e($admin_name) ?></strong>

                    <span>
                        Administrator <br>
                        <?= e($admin_student_id) ?>
                    </span>

                </div>

                <!-- three dots, opens the small menu above -->
                <button class="user-more" id="accountMenuButton" type="button" aria-label="More options">⋮</button>

            </div>

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

        <!-- TOP BAR (breadcrumb like the student page) -->
        <header class="topbar">

            <div class="topbar-left">

                <span class="topbar-label">
                    ADMIN WORKSPACE
                </span>

                <span class="topbar-divider">
                    /
                </span>

                <span class="topbar-current">
                    Subjects & Courses
                </span>

            </div>

            <div class="topbar-right">

                <button class="notification" id="notificationButton">

                    ♧

                    <?php if ($pendingReports > 0): ?>
                        <span class="notification-count"><?= $pendingReports ?></span>
                    <?php endif; ?>

                </button>

            </div>

        </header>


        <section class="content">

            <!-- the sentence that used to be under the title in the top bar -->
            <p class="page-intro">
                Manage subjects and courses offered in the system.
            </p>

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

                <div class="stat-card" data-jump="Inactive">
                    <div class="stat-icon red">✕</div>
                    <div class="stat-info">
                        <div class="stat-label">Inactive</div>
                        <div class="stat-number" id="statInactive">0</div>
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
                    <option value="Inactive">Inactive</option>
                </select>

                <button class="btn-gold" id="addButton">+ Add Course</button>

            </div>


            <!-- Table -->
            <div class="panel">

                <div class="table-wrap">

                    <table class="data-table">

                        <thead id="tableHead"></thead>

                        <!-- rows are filled in by subject_course.js -->
                        <tbody id="tableBody"></tbody>

                    </table>

                </div>

                <div class="panel-footer">
                    <div class="showing-text" id="showingText"></div>
                    <div class="pagination" id="pagination"></div>
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
                <input type="text" id="formName" class="form-input" maxlength="100" placeholder="BSIT">
            </div>

            <div class="form-group">
                <label for="formStatus">Status</label>
                <select id="formStatus" class="filter-select">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>

            <div class="form-error" id="formError"></div>

            <div class="modal-buttons">
                <button class="btn-outline" id="cancelForm">Cancel</button>
                <button class="btn-gold" id="saveForm">Save</button>
            </div>

        </div>

    </div>


    <div class="toast" id="toast"></div>

    <!-- data from the database, used by subject_course.js -->
    <script>
        var courses = <?= json_encode($courses, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?>;
        var subjects = <?= json_encode($subjects, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?>;
        var csrfToken = <?= json_encode($csrf) ?>;
        var pendingReports = <?= $pendingReports ?>;
    </script>

    <script src="../../asset/js/subject_course.js"></script>

</body>
</html>