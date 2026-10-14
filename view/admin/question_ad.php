<?php
session_start();
require "../../config/config.php";   // your connection file (CHANGE the name/path if it is different)

// the name of this file, like "question_ad.php"
// the sidebar uses it to know which link is the active one
$current_page = basename($_SERVER["PHP_SELF"]);

// make mysqli throw real errors and read/write Filipino/emoji text correctly
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

// token used to protect the delete button
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


// ---------- questions (with the name of the student who asked) ----------
$sql = "SELECT q.question_id AS id,
               q.question,
               q.status,
               q.subject,
               q.question_type AS type,
               q.question_course AS course,
               TRIM(CONCAT(COALESCE(u.first_name, ''), ' ', COALESCE(u.last_name, ''))) AS student
        FROM questions q
        LEFT JOIN users u ON u.id = q.user_id
        ORDER BY q.question_id DESC";

$questions = [];
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $row["id"] = (int) $row["id"];
    if ($row["student"] === "") {
        $row["student"] = "Unknown";
    }
    $questions[] = $row;
}

// ---------- subjects for the filter ----------
$subjects = [];
$result = $conn->query("SELECT subject_name FROM question_subjects WHERE status = 'Active' ORDER BY subject_name");
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row["subject_name"];
}

// ---------- statuses for the filter ----------
$statuses = [];
$result = $conn->query("SELECT DISTINCT status FROM questions WHERE status IS NOT NULL ORDER BY status");
while ($row = $result->fetch_assoc()) {
    $statuses[] = $row["status"];
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

    <title>CHECKMATE - Questions</title>

    <!-- filemtime() is the time the file was last saved, so the browser only reloads the CSS when you edit it -->
    <link rel="stylesheet" href="../../asset/css/admin_home.css?v=<?= filemtime(__DIR__ . '/../../asset/css/admin_home.css') ?>">
    <link rel="stylesheet" href="../../asset/css/question_ad.css?v=<?= filemtime(__DIR__ . '/../../asset/css/question_ad.css') ?>">
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
                    Questions
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
                Review and moderate student questions.
            </p>

            <!-- Search and filters -->
            <div class="toolbar">

                <div class="search-box">
                    <span class="search-icon">⌕</span>
                    <input type="text" id="searchInput" class="search-input"
                           placeholder="Search questions or students...">
                </div>

                <select id="categoryFilter" class="filter-select">
                    <option value="all">All Subjects</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?= e($subject) ?>"><?= e($subject) ?></option>
                    <?php endforeach; ?>
                </select>

                <select id="statusFilter" class="filter-select">
                    <option value="all">All Status</option>
                    <?php foreach ($statuses as $status): ?>
                        <option value="<?= e($status) ?>"><?= e($status) ?></option>
                    <?php endforeach; ?>
                </select>

            </div>


            <!-- Questions table -->
            <div class="table-wrap">

                <table class="questions-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Student</th>
                            <th>Subject</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <!-- rows are filled in by question_ad.js -->
                    <tbody id="questionsBody"></tbody>

                </table>

            </div>


            <div class="table-footer">

                <div class="showing-text" id="showingText"></div>

            </div>

        </section>

    </main>


    <div class="toast" id="toast"></div>

    <!-- data from the database, used by question_ad.js -->
    <script>
        var questions = <?= json_encode($questions, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?>;
        var csrfToken = <?= json_encode($csrf) ?>;
        var pendingReports = <?= $pendingReports ?>;
    </script>

    <script src="../../asset/js/question_ad.js"></script>

</body>
</html>