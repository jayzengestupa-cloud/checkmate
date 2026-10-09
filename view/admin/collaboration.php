<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CHECKMATE - Collaborations</title>

    <!-- Same stylesheet as the other admin pages -->
    <link rel="stylesheet" href="../../asset/css/admin_home.css">
    <link rel="stylesheet" href="../../asset/css/collaboration.css">
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
                    <!-- this is the current page so it is active -->
                    <a href="collaboration.php" class="active" data-page="collaborations">
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
                    Collaborations
                </div>

                <div class="topbar-sub">
                    Monitor collaboration requests and active student partnerships.
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

            <!-- Summary cards (click one to jump to the matching view) -->
            <div class="stat-row">

                <div class="stat-card" data-jump="Pending">
                    <div class="stat-icon">◔</div>
                    <div class="stat-info">
                        <div class="stat-label">Pending Requests</div>
                        <div class="stat-number" id="statPending">0</div>
                    </div>
                    <div class="stat-arrow">→</div>
                </div>

                <div class="stat-card" data-jump="active">
                    <div class="stat-icon green">♞</div>
                    <div class="stat-info">
                        <div class="stat-label">Active Collaborations</div>
                        <div class="stat-number" id="statActive">12</div>
                    </div>
                    <div class="stat-arrow">→</div>
                </div>

                <div class="stat-card" data-jump="Accepted">
                    <div class="stat-icon blue">✓</div>
                    <div class="stat-info">
                        <div class="stat-label">Accepted This Week</div>
                        <div class="stat-number" id="statAccepted">0</div>
                    </div>
                    <div class="stat-arrow">→</div>
                </div>

                <div class="stat-card" data-jump="Rejected">
                    <div class="stat-icon red">✕</div>
                    <div class="stat-info">
                        <div class="stat-label">Rejected</div>
                        <div class="stat-number" id="statRejected">0</div>
                    </div>
                    <div class="stat-arrow">→</div>
                </div>

            </div>


            <!-- Tabs -->
            <div class="tabs">
                <button class="tab active" data-tab="requests">▤ Requests</button>
                <button class="tab" data-tab="active">♞ Active Collaborations</button>
                <button class="tab" data-tab="history">◷ History</button>
            </div>


            <!-- Collaboration requests table -->
            <div class="panel" id="requestsPanel">

                <div class="panel-head">
                    <div class="panel-title" id="requestsTitle">Collaboration Requests</div>
                    <div class="panel-sub" id="requestsSub">Review and manage incoming collaboration requests.</div>
                </div>

                <div class="table-wrap">

                    <table class="collab-table">

                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th colspan="2">Requested By</th>
                                <th colspan="2">Requested To</th>
                                <th>Collaboration Topic</th>
                                <th>Requested On</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <!-- rows are filled in by the JavaScript below -->
                        <tbody id="requestsBody"></tbody>

                    </table>

                </div>

                <div class="panel-footer">
                    <div class="showing-text" id="showingText"></div>

                    <!-- TODO: make pagination work when there are more requests -->
                    <div class="pagination">
                        <button class="page-btn">‹</button>
                        <button class="page-btn current">1</button>
                        <button class="page-btn">›</button>
                    </div>
                </div>

            </div>


            <!-- Active collaborations -->
            <div class="panel" id="activePanel">

                <div class="panel-head">
                    <div class="panel-title">Active Collaborations</div>
                    <div class="panel-sub">View currently ongoing student partnerships.</div>
                </div>

                <div class="active-grid" id="activeGrid"></div>

                <div class="panel-footer">
                    <div class="showing-text" id="activeShowing"></div>

                    <!-- TODO: make pagination work when there are more than 6 -->
                    <div class="pagination">
                        <button class="page-btn">‹</button>
                        <button class="page-btn current">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">›</button>
                    </div>
                </div>

            </div>

        </section>

    </main>


    <!-- TOAST MESSAGE (styled in style.css) -->
    <div class="toast" id="toast"></div>

    <script src="../../asset/js/collaboration.js"></script>

</body>
</html>