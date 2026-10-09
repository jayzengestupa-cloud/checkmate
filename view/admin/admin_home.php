<?php
session_start();

// if not logged in as admin, go to the login page
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: /checkmate/authentication/Login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CHECKMATE - Admin Dashboard</title>

    <link rel="stylesheet" href="../../asset/css/admin_home.css">

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


        <!-- =====================================
             OVERVIEW MENU
             ===================================== -->

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


        <!-- =====================================
             MANAGEMENT MENU
             ===================================== -->

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


        <!-- =====================================
             ADMIN ACCOUNT
             ===================================== -->

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


        <!-- =====================================
             TOP BAR
             ===================================== -->

        <header class="topbar">

            <div class="topbar-left">

                <div class="topbar-label">
                    ADMINISTRATION
                </div>

                <div class="topbar-title">
                    Dashboard
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



        <!-- =====================================
             PAGE CONTENT
             ===================================== -->

        <section class="content">


            <!-- =================================
                 WELCOME
                 ================================= -->

            <div class="welcome">

                <div class="welcome-label">
                    ♜ SYSTEM OVERVIEW
                </div>

                <h1 class="welcome-title">
                    Welcome back, Administrator.
                </h1>

                <p class="welcome-text">
                    Manage students, questions, collaborations, and system records.
                </p>

            </div>



            <!-- =================================
                 ATTENTION NOTICE
                 ================================= -->

            <div class="notice">

                <div class="notice-left">

                    <div class="notice-icon">
                        ♟
                    </div>

                    <div>

                        <div class="notice-title">
                            Student verification requires attention
                        </div>

                        <div class="notice-text">
                            8 student registrations are currently waiting for verification.
                        </div>

                    </div>

                </div>


                <button class="notice-button" id="verifyButton">
                    Review
                </button>

            </div>



            <!-- =================================
                 SYSTEM OVERVIEW
                 ================================= -->

            <div class="section-heading">

                <div class="section-label">
                    SYSTEM
                </div>

                <h2 class="section-title">
                    Overview
                </h2>

            </div>


            <div class="overview-grid">


                <!-- Registered Students -->
                <div class="overview-card">

                    <div class="overview-card-label">
                        Registered Students
                    </div>

                    <div class="overview-card-number">
                        124
                    </div>

                    <div class="overview-card-description">
                        Total student accounts
                    </div>

                </div>


                <!-- Open Questions -->
                <div class="overview-card">

                    <div class="overview-card-label">
                        Open Questions
                    </div>

                    <div class="overview-card-number">
                        36
                    </div>

                    <div class="overview-card-description">
                        Questions waiting for answers
                    </div>

                </div>


                <!-- Collaborations -->
                <div class="overview-card">

                    <div class="overview-card-label">
                        Collaborations
                    </div>

                    <div class="overview-card-number">
                        19
                    </div>

                    <div class="overview-card-description">
                        Active collaboration requests
                    </div>

                </div>


                <!-- Reports -->
                <div class="overview-card">

                    <div class="overview-card-label">
                        Pending Reports
                    </div>

                    <div class="overview-card-number">
                        5
                    </div>

                    <div class="overview-card-description">
                        Reports requiring review
                    </div>

                </div>

            </div>



            <!-- =================================
                 RECENT INFORMATION
                 ================================= -->

            <div class="panel-grid">


                <!-- =================================
                     RECENT REGISTRATIONS
                     ================================= -->

                <div class="panel">

                    <div class="panel-header">

                        <div>

                            <div class="panel-label">
                                STUDENT VERIFICATION
                            </div>

                            <h2 class="panel-heading">
                                Recent registrations
                            </h2>

                        </div>

                        <a href="students.html" class="panel-link" id="viewStudents">
                            View all →
                        </a>

                    </div>



                    <!-- Student 1 -->

                    <div class="list-row">

                        <div class="list-avatar">
                            J
                        </div>

                        <div class="list-info">

                            <div class="list-name">
                                Jayzen Titum
                            </div>

                            <div class="list-sub">
                                BSIT · 2nd Year
                            </div>

                        </div>

                        <!-- was class "pending" but the text says Verified, so changed it to verified -->
                        <span class="status verified">
                            Verified
                        </span>

                    </div>



                    <!-- Student 2 -->

                    <div class="list-row">

                        <div class="list-avatar">
                            M
                        </div>

                        <div class="list-info">

                            <div class="list-name">
                                Maui Moana
                            </div>

                            <div class="list-sub">
                                BSIT · 2nd Year
                            </div>

                        </div>

                        <span class="status pending">
                            Pending
                        </span>

                    </div>



                    <!-- Student 3 -->

                    <div class="list-row">

                        <div class="list-avatar">
                            I
                        </div>

                        <div class="list-info">

                            <div class="list-name">
                                Ian Henerasyon
                            </div>

                            <div class="list-sub">
                                BSIT · 2nd Year
                            </div>

                        </div>

                        <span class="status verified">
                            Verified
                        </span>

                    </div>



                    <!-- Student 4 -->

                    <div class="list-row">

                        <div class="list-avatar">
                            D
                        </div>

                        <div class="list-info">

                            <div class="list-name">
                                dds James
                            </div>

                            <div class="list-sub">
                                BSIT · 2nd Year
                            </div>

                        </div>

                        <span class="status pending">
                            Pending
                        </span>

                    </div>

                </div>



                <!-- =================================
                     RECENT REPORTS
                     ================================= -->

                <div class="panel">

                    <div class="panel-header">

                        <div>

                            <div class="panel-label">
                                REPORTS
                            </div>

                            <h2 class="panel-heading">
                                Recent reports
                            </h2>

                        </div>

                        <a href="#" class="panel-link" id="viewReports">
                            View all →
                        </a>

                    </div>



                    <!-- Report 1 -->

                    <div class="list-row">

                        <div class="list-avatar">
                            !
                        </div>

                        <div class="list-info">

                            <div class="list-name">
                                Inappropriate question
                            </div>

                            <div class="list-sub">
                                Report #0042 · 15 min ago
                            </div>

                        </div>

                        <span class="status new">
                            New
                        </span>

                    </div>



                    <!-- Report 2 -->

                    <div class="list-row">

                        <div class="list-avatar">
                            !
                        </div>

                        <div class="list-info">

                            <div class="list-name">
                                Incorrect subject
                            </div>

                            <div class="list-sub">
                                Report #0041 · 42 min ago
                            </div>

                        </div>

                        <span class="status new">
                            New
                        </span>

                    </div>



                    <!-- Report 3 -->

                    <div class="list-row">

                        <div class="list-avatar">
                            ✓
                        </div>

                        <div class="list-info">

                            <div class="list-name">
                                Resolved collaboration
                            </div>

                            <div class="list-sub">
                                Report #0040 · 2 hrs ago
                            </div>

                        </div>

                        <span class="status done">
                            Done
                        </span>

                    </div>



                    <div class="list-row">

                        <div class="list-info">

                            <div class="list-sub">
                                Reports are reviewed by administrators.
                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <!-- =================================
                 QUICK ACCESS
                 ================================= -->

            <div class="quick-access">

                <div class="section-heading">

                    <div class="section-label">
                        MANAGEMENT
                    </div>

                    <h2 class="section-title">
                        Quick access
                    </h2>

                </div>



                <div class="quick-grid">


                    <!-- Enrollment -->

                    <div class="quick-card" data-action="enrollment">

                        <div class="quick-icon">
                            +
                        </div>

                        <div class="quick-info">

                            <div class="quick-title">
                                Enrollment
                            </div>

                            <div class="quick-description">
                                Add or update students
                            </div>

                        </div>

                        <div class="quick-arrow">
                            →
                        </div>

                    </div>



                    <!-- Subjects -->

                    <div class="quick-card" data-action="subjects">

                        <div class="quick-icon">
                            ◇
                        </div>

                        <div class="quick-info">

                            <div class="quick-title">
                                Subjects & Courses
                            </div>

                            <div class="quick-description">
                                Manage academic records
                            </div>

                        </div>

                        <div class="quick-arrow">
                            →
                        </div>

                    </div>



                    <!-- Question Types -->

                    <div class="quick-card" data-action="types">

                        <div class="quick-icon">
                            ≡
                        </div>

                        <div class="quick-info">

                            <div class="quick-title">
                                Question Types
                            </div>

                            <div class="quick-description">
                                Manage question categories
                            </div>

                        </div>

                        <div class="quick-arrow">
                            →
                        </div>

                    </div>



                    <!-- Reports -->

                    <div class="quick-card" data-action="reports">

                        <div class="quick-icon">
                            ▤
                        </div>

                        <div class="quick-info">

                            <div class="quick-title">
                                Reports
                            </div>

                            <div class="quick-description">
                                Review reported content
                            </div>

                        </div>

                        <div class="quick-arrow">
                            →
                        </div>

                    </div>

                </div>

            </div>



            <!-- =================================
                 FOOTER
                 ================================= -->

            <footer class="footer">

                <div class="footer-left">

                    <div class="footer-chess">
                        ♛
                    </div>

                    <div>

                        <div class="footer-title">
                            CHECKMATE ADMIN
                        </div>

                        <div class="footer-subtitle">
                            Keep the board organized.
                        </div>

                    </div>

                </div>


                <div class="footer-links">
                    <span>Verify.</span>
                    <span>Manage.</span>
                    <span>Monitor.</span>
                </div>

            </footer>

        </section>

    </main>



    <!-- =========================================
         TOAST MESSAGE
         ========================================= -->

    <div class="toast" id="toast"></div>


    <!-- JavaScript -->
    <script src="../../asset/js/admin_home.js"></script>

</body>
</html>