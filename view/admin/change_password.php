<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CHECKMATE - Change Password</title>
    <link rel="stylesheet" href="../../asset/css/admin_home.css">
    <link rel="stylesheet" href="../../asset/css/change_password.css">


</head>

<body>

   
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
                    Change Password
                </div>

                <div class="topbar-sub">
                    Update the password you use to sign in to CHECKMATE.
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

            <div class="password-layout">

                <!-- Form -->
                <div class="panel">
                    <div class="panel-body">

                        <div class="panel-label">ACCOUNT</div>
                        <h2 class="panel-title">Change password</h2>

                        <div class="form-group">
                            <label for="currentPassword">Current password</label>
                            <div class="input-wrap">
                                <input type="password" id="currentPassword" class="form-input" autocomplete="current-password">
                                <button type="button" class="toggle-btn" data-target="currentPassword">Show</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="newPassword">New password</label>
                            <div class="input-wrap">
                                <input type="password" id="newPassword" class="form-input" autocomplete="new-password">
                                <button type="button" class="toggle-btn" data-target="newPassword">Show</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirmPassword">Confirm new password</label>
                            <div class="input-wrap">
                                <input type="password" id="confirmPassword" class="form-input" autocomplete="new-password">
                                <button type="button" class="toggle-btn" data-target="confirmPassword">Show</button>
                            </div>
                        </div>

                        <!-- error message shows here -->
                        <div class="form-error" id="formError"></div>

                        <div class="form-buttons">
                            <a href="admin_home.html" class="btn-outline">Cancel</a>
                            <button class="btn-gold" id="saveButton">Update Password</button>
                        </div>

                    </div>
                </div>


                <!-- Rules (turn green as the new password meets them) -->
                <div class="panel">
                    <div class="panel-body">

                        <div class="panel-label">REQUIREMENTS</div>
                        <h2 class="panel-title">Password rules</h2>

                        <ul class="rule-list">
                            <li id="ruleLength"><span class="rule-mark">✓</span>At least 8 characters</li>
                            <li id="ruleUpper"><span class="rule-mark">✓</span>One uppercase letter</li>
                            <li id="ruleLower"><span class="rule-mark">✓</span>One lowercase letter</li>
                            <li id="ruleNumber"><span class="rule-mark">✓</span>One number</li>
                            <li id="ruleMatch"><span class="rule-mark">✓</span>Both new passwords match</li>
                        </ul>

                    </div>
                </div>

            </div>

        </section>

    </main>


    <div class="toast" id="toast"></div>

    <script scr="../../asset/js/change_password.js"></script>
  
</body>
</html>