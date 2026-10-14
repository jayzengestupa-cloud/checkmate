<?php
session_start();

// if not logged in as admin, go to the login page
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: /checkmate/authentication/Login/login.php");
    exit();
}

// connect to the database (gives us the $conn variable)
require_once "../../config/config.php";

// the name of this file, like "student.php"
// the sidebar uses it to know which link is the active one
$current_page = basename($_SERVER["PHP_SELF"]);


/* =========================================
   SMALL HELPER FUNCTIONS
   ========================================= */

// makes text safe to print inside HTML
function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

// runs a "SELECT COUNT(*)" query and returns the number
function getCount($conn, $sql)
{
    $result = $conn->query($sql);

    // if the query failed, just show 0 instead of crashing the page
    if (!$result) {
        return 0;
    }

    $row = $result->fetch_row();
    return (int)$row[0];
}


/* =========================================
   GET THE ADMIN'S OWN INFO (for the sidebar profile)
   ========================================= */

// the login saves the admin's id in the session
$admin_id = (int)$_SESSION["user_id"];

// default values, in case the query finds nothing
$admin_name = "Administrator";
$admin_student_id = "";
$admin_initials = "A";

$stmt = $conn->prepare("SELECT first_name, last_name, student_id FROM users WHERE id = ? LIMIT 1");

if ($stmt) {
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
}


/* =========================================
   GET THE STUDENTS FROM THE DATABASE
   ========================================= */

// role = 'student' means admins are never listed on this page
$sql = "SELECT id, first_name, last_name, student_id, email, course, year_level
        FROM users
        WHERE role = 'student'
        ORDER BY id ASC";

$result = $conn->query($sql);

$students = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

$total_students = count($students);

// make the Course dropdown from the courses the students really have
$courses = [];

foreach ($students as $s) {
    if (!in_array($s["course"], $courses)) {
        $courses[] = $s["course"];
    }
}

sort($courses);

// pending reports number for the bell (same as the dashboard)
$pending_reports = 0;
$check = $conn->query("SHOW TABLES LIKE 'reports'");

if ($check && $check->num_rows > 0) {
    $pending_reports = getCount($conn, "SELECT COUNT(*) FROM reports WHERE status = 'Pending'");
}

// we have everything we need, so close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CHECKMATE - Students</title>

    <!-- filemtime() is the time the file was last saved, so the link changes whenever you edit the file
         (this stops the browser from showing an old cached copy) -->
    <link rel="stylesheet" href="../../asset/css/admin_home.css?v=<?= filemtime(__DIR__ . '/../../asset/css/admin_home.css') ?>">
    <link rel="stylesheet" href="../../asset/css/student.css?v=<?= filemtime(__DIR__ . '/../../asset/css/student.css') ?>">
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


        <!-- OVERVIEW MENU -->
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
                        <span class="menu-count"><?= $total_students ?></span>
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


        <!-- MANAGEMENT MENU -->
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
                        <span class="menu-dot"></span>
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
                    Students
                </span>

            </div>

            <div class="topbar-right">

                <!-- Notifications (the number is the pending reports) -->
                <button class="notification" id="notificationButton">

                    ♧

                    <?php if ($pending_reports > 0): ?>
                        <span class="notification-count">
                            <?= $pending_reports ?>
                        </span>
                    <?php endif; ?>

                </button>

            </div>

        </header>


        <!-- PAGE CONTENT -->
        <section class="content">

            <!-- Search and filters -->
            <div class="toolbar">

                <div class="search-box">
                    <span class="search-icon">⌕</span>
                    <input type="text" id="searchInput" class="search-input"
                           placeholder="Search by name, student ID, or email...">
                </div>

                <select id="courseFilter" class="filter-select">
                    <option value="all">All Courses</option>

                    <?php foreach ($courses as $course): ?>
                        <option value="<?= e($course) ?>"><?= e($course) ?></option>
                    <?php endforeach; ?>
                </select>

                <select id="yearFilter" class="filter-select">
                    <option value="all">All Year Levels</option>
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                </select>

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
                        </tr>
                    </thead>

                    <tbody id="studentsBody">

                        <?php if ($total_students == 0): ?>

                            <!-- no student accounts in the database yet (the table has 6 columns) -->
                            <tr class="empty-row">
                                <td colspan="6">No students have registered yet.</td>
                            </tr>

                        <?php else: ?>

                            <?php foreach ($students as $s): ?>

                                <?php
                                // join first and last name (some students have no last name)
                                $full_name = trim($s["first_name"] . " " . $s["last_name"]);
                                ?>

                                <!-- the data-* attributes are what the JavaScript uses to filter -->
                                <tr class="student-row"
                                    data-name="<?= e($full_name) ?>"
                                    data-studentid="<?= e($s["student_id"]) ?>"
                                    data-email="<?= e($s["email"]) ?>"
                                    data-course="<?= e($s["course"]) ?>"
                                    data-year="<?= e($s["year_level"]) ?>">

                                    <td><span class="cell-id"><?= (int)$s["id"] ?></span></td>
                                    <td class="cell-name"><?= e($full_name) ?></td>
                                    <td><?= e($s["student_id"]) ?></td>
                                    <td class="cell-muted"><?= e($s["email"]) ?></td>
                                    <td><?= e($s["course"]) ?></td>
                                    <td><?= e($s["year_level"]) ?></td>

                                </tr>

                            <?php endforeach; ?>

                            <!-- shown by the JavaScript when the search/filters match nobody -->
                            <tr class="empty-row" id="noMatchRow" style="display: none;">
                                <td colspan="6">No students found. Try a different search or filter.</td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>


            <!-- Count + pagination -->
            <div class="table-footer">

                <div class="showing-text" id="showingText">
                    Showing <?= $total_students ?> of <?= $total_students ?> students
                </div>

                <!-- the page buttons (‹ 1 2 3 ›) are made by student.js, 10 students per page -->
                <div class="pagination" id="pagination"></div>

            </div>

        </section>

    </main>


    <!-- TOAST MESSAGE -->
    <div class="toast" id="toast"></div>


    <!-- =========================================
         JAVASCRIPT
         ========================================= -->
    <script src="../../asset/js/student.js?v=<?= filemtime(__DIR__ . '/../../asset/js/student.js') ?>"></script>

</body>
</html>