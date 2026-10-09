<?php

session_start();

if (!isset($_SESSION["student_id"]) || $_SESSION["role"] != "student") {
    header("Location: ../../authentication/Login/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CHECKMATE - Student Home</title>

    <!-- Bootstrap 5.3.3 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- CHECKMATE Student Home CSS -->
    <link
        rel="stylesheet"
        href="../../asset/css/student_home.css"
    >

    <!-- Force CHECKMATE link styling -->
    <style>
        a.logout-link,
        a.logout-link:link,
        a.logout-link:visited,
        a.logout-link:hover,
        a.logout-link:active,
        a.logout-link:focus {
            color: #b08c4d !important;

            text-decoration: none !important;
            text-decoration-line: none !important;
            text-decoration-style: none !important;
            text-decoration-color: transparent !important;

            border: none !important;
            outline: none !important;
            box-shadow: none !important;

            background: transparent !important;

            font-size: 12px;
            letter-spacing: 1.8px;
            font-weight: 700;

            cursor: pointer;
        }

        a.logout-link:hover {
            color: #d0a55c !important;
        }

        a.new-question-button,
        a.new-question-button:link,
        a.new-question-button:visited,
        a.new-question-button:hover,
        a.new-question-button:active,
        a.new-question-button:focus {
            text-decoration: none !important;
            text-decoration-line: none !important;

            outline: none !important;
            box-shadow: none !important;
        }
    </style>

</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <!-- LOGO -->
        <div class="logo-area">

            <div class="logo-piece">
                ♟
            </div>

            <div class="logo-text">

                <h1>CHECKMATE</h1>

                <span>
                    STUDENT COLLABORATION
                </span>

            </div>

        </div>

        <!-- NEW QUESTION -->
        <a
            href="questions.php"
            class="new-question-button"
        >

            <span class="button-icon">
                +
            </span>

            <span>
                New Question
            </span>

        </a>

        <!-- MAIN MENU -->
        <div class="sidebar-section">

            <div class="section-title">
                WORKSPACE
            </div>

            <!-- HOME -->
            <a
                href="student_home.php"
                class="menu-item active"
            >

                <span class="menu-icon">
                    ⌂
                </span>

                <span>
                    Home
                </span>

            </a>

            <!-- QUESTIONS -->
            <a
                href="questions.php"
                class="menu-item"
            >

                <span class="menu-icon">
                    ?
                </span>

                <span>
                    Questions
                </span>

            </a>

            <!-- MY QUESTIONS -->
            <a
                href="#"
                class="menu-item"
            >

                <span class="menu-icon">
                    ♧
                </span>

                <span>
                    My Questions
                </span>

            </a>

            <!-- COLLABORATION -->
            <a
                href="#"
                class="menu-item"
            >

                <span class="menu-icon">
                    ♟
                </span>

                <span>
                    Collaboration
                </span>

            </a>

            <!-- MESSAGES -->
            <a
                href="#"
                class="menu-item"
            >

                <span class="menu-icon">
                    ✉
                </span>

                <span>
                    Messages
                </span>

                <span class="notification">
                    2
                </span>

            </a>

        </div>

        <!-- USER -->
        <div class="sidebar-user">

            <div class="user-avatar">
                S
            </div>

            <div class="user-information">

                <strong>
                    Student Name
                </strong>

                <span>
                    Program and Student Name
                </span>

            </div>

            <button
                type="button"
                class="user-more"
                aria-label="More options"
            >
                ⋮
            </button>

        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left">

                <span class="topbar-label">
                    STUDENT WORKSPACE
                </span>

                <span class="topbar-divider">
                    /
                </span>

                <span class="topbar-current">
                    Home
                </span>

            </div>

            <div class="topbar-right">

                <a
                    href="../../authentication/Login/logout.php"
                    class="logout-link"
                    style="
                        color:#b08c4d !important;
                        text-decoration:none !important;
                        border:none !important;
                        outline:none !important;
                        box-shadow:none !important;
                        background:transparent !important;
                    "
                >
                    LogOut
                </a>

            </div>

        </header>

        <!-- WELCOME SECTION -->
        <section class="welcome-section">

            <div class="welcome-small">
                ♟ YOUR MOVE
            </div>

            <h2>
                What are you working on?
            </h2>

            <p>
                Ask a question, find a peer, and make your next move.
            </p>

        </section>

        <!-- QUICK QUESTION BOX -->
        <section class="ask-box">

            <div class="ask-box-top">

                <div class="ask-icon">
                    ?
                </div>

                <div>

                    <h3>
                        Ask a Question
                    </h3>

                    <p>
                        Share what you're stuck on with your classmates.
                    </p>

                </div>

            </div>

            <!-- This box is a shortcut to questions.php -->
            <div id="questionForm">

                <textarea
                    id="questionInput"
                    class="question-input"
                    placeholder="What would you like to ask?"
                    aria-label="Write a question"
                ></textarea>

                <div class="ask-bottom">

                    <div class="ask-options">

                        <!-- ATTACHMENT -->
                        <button
                            type="button"
                            class="ask-option"
                            id="attachmentButton"
                        >

                            <span>
                                ＋
                            </span>

                            Attachment

                        </button>

                        <!-- SUBJECT -->
                        <button
                            type="button"
                            class="ask-option"
                            id="subjectButton"
                        >

                            <span>
                                ＋
                            </span>

                            Subject

                        </button>

                        <!-- QUESTION TYPE -->
                        <button
                            type="button"
                            class="ask-option"
                            id="typeButton"
                        >

                            <span>
                                ＋
                            </span>

                            Question Type

                        </button>

                    </div>

                    <!-- MAKE A MOVE -->
                    <button
                        type="button"
                        class="ask-button"
                        id="askButton"
                    >

                        Make a Move

                        <span>
                            →
                        </span>

                    </button>

                </div>

            </div>

        </section>

        <!-- DASHBOARD -->
        <section class="dashboard-section">

            <!-- QUICK MOVES -->
            <div class="quick-heading">

                <div class="heading-label">
                    QUICK MOVES
                </div>

                <h2>
                    Choose your next move
                </h2>

            </div>

            <!-- QUICK CARDS -->
            <div class="quick-grid">

                <!-- BROWSE QUESTIONS -->
                <div
                    class="quick-card"
                    onclick="window.location.href='questions.php'"
                    role="link"
                    tabindex="0"
                    onkeydown="if(event.key === 'Enter' || event.key === ' '){event.preventDefault();window.location.href='questions.php';}"
                >

                    <div class="quick-card-icon">
                        ♧
                    </div>

                    <div class="quick-card-content">

                        <h4>
                            Browse Questions
                        </h4>

                        <p>
                            See what your classmates are asking.
                        </p>

                    </div>

                    <div class="card-arrow">
                        →
                    </div>

                </div>

                <!-- COLLABORATE -->
                <div
                    class="quick-card"
                    onclick="showToast('Collaboration feature coming soon.')"
                    role="button"
                    tabindex="0"
                    onkeydown="if(event.key === 'Enter' || event.key === ' '){event.preventDefault();showToast('Collaboration feature coming soon.');}"
                >

                    <div class="quick-card-icon">
                        ♟
                    </div>

                    <div class="quick-card-content">

                        <h4>
                            Collaborate
                        </h4>

                        <p>
                            Find classmates to work and learn with.
                        </p>

                    </div>

                    <div class="card-arrow">
                        →
                    </div>

                </div>

            </div>

            <!-- TWO COLUMN DASHBOARD -->
            <div class="dashboard-columns mt-3">

                <!-- RECENT QUESTIONS -->
                <div class="dashboard-panel">

                    <div class="panel-header">

                        <div>

                            <div class="panel-label">
                                RECENT
                            </div>

                            <h3>
                                Questions
                            </h3>

                        </div>

                        <a
                            href="questions.php"
                            class="view-all"
                        >

                            View All

                            <span>
                                →
                            </span>

                        </a>

                    </div>

                    <div class="questions-list">

                        <!-- QUESTION 1 -->
                        <div class="question-item">

                            <div class="question-number">
                                01
                            </div>

                            <div class="question-content">

                                <div class="question-text">
                                    Umiinom ba ng tubig yung isda?
                                </div>

                                <div class="question-meta">

                                    <span>
                                        Kapatid Ni Rene
                                    </span>

                                    <span>
                                        •
                                    </span>

                                    <span>
                                        2 min ago
                                    </span>

                                </div>

                            </div>

                            <div class="question-arrow">
                                →
                            </div>

                        </div>

                        <!-- QUESTION 2 -->
                        <div class="question-item">

                            <div class="question-number">
                                02
                            </div>

                            <div class="question-content">

                                <div class="question-text">
                                    paano po maglagay ng file sa gdrive?
                                </div>

                                <div class="question-meta">

                                    <span>
                                        maui moana
                                    </span>

                                    <span>
                                        •
                                    </span>

                                    <span>
                                        8 min ago
                                    </span>

                                </div>

                            </div>

                            <div class="question-arrow">
                                →
                            </div>

                        </div>

                        <!-- QUESTION 3 -->
                        <div class="question-item">

                            <div class="question-number">
                                03
                            </div>

                            <div class="question-content">

                                <div class="question-text">
                                    Bat ba ginawa yung
                                </div>

                                <div class="question-meta">

                                    <span>
                                        andrea brilyante
                                    </span>

                                    <span>
                                        •
                                    </span>

                                    <span>
                                        15 min ago
                                    </span>

                                </div>

                            </div>

                            <div class="question-arrow">
                                →
                            </div>

                        </div>

                    </div>

                </div>

                <!-- COLLABORATION -->
                <div class="dashboard-panel">

                    <div class="panel-header">

                        <div>

                            <div class="panel-label">
                                YOUR PEERS
                            </div>

                            <h3>
                                Collaboration
                            </h3>

                        </div>

                        <a
                            href="#"
                            class="view-all"
                            onclick="showToast('Collaboration page coming soon.'); return false;"
                        >

                            View All

                            <span>
                                →
                            </span>

                        </a>

                    </div>

                    <div class="collaboration-list">

                        <!-- COLLABORATOR 1 -->
                        <div class="collaboration-item">

                            <div class="collaborator-avatar">
                                J
                            </div>

                            <div class="collaborator-info">

                                <div class="collaborator-name">
                                    jayzen titum
                                </div>

                                <div class="collaborator-status active">
                                    ● Active
                                </div>

                            </div>

                            <button
                                type="button"
                                class="open-button"
                                onclick="showToast('Opening collaboration...')"
                                aria-label="Open collaboration with Jayzen Titum"
                            >
                                →
                            </button>

                        </div>

                        <!-- COLLABORATOR 2 -->
                        <div class="collaboration-item">

                            <div class="collaborator-avatar">
                                D
                            </div>

                            <div class="collaborator-info">

                                <div class="collaborator-name">
                                    dds james
                                </div>

                                <div class="collaborator-status pending">
                                    ● Pending
                                </div>

                            </div>

                            <button
                                type="button"
                                class="open-button"
                                onclick="showToast('Collaboration request pending.')"
                                aria-label="View collaboration request from DDS James"
                            >
                                →
                            </button>

                        </div>

                    </div>

                    <div class="panel-footer-note">
                        Connect with classmates and learn together.
                    </div>

                </div>

            </div>

        </section>

        <!-- FOOTER -->
        <footer class="chess-footer">

            <div class="footer-piece">
                ♟
            </div>

            <div class="footer-text">

                <strong>
                    Every question is a move.
                </strong>

                <span>
                    Learn together. Move forward.
                </span>

            </div>

            <div class="footer-piece">
                ♟
            </div>

        </footer>

    </main>

    <!-- TOAST -->
    <div
        class="toast"
        id="toast"
        role="status"
        aria-live="polite"
    ></div>

    <!-- BOOTSTRAP 5.3.3 JAVASCRIPT -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>

    <!-- CHECKMATE JAVASCRIPT -->
    <script src="../../asset/js/student_home.js"></script>

    <!-- MAKE A MOVE SHORTCUT -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const askButton = document.getElementById("askButton");

            if (askButton) {
                askButton.addEventListener("click", function () {
                    window.location.href = "questions.php";
                });
            }
        });
    </script>

</body>

</html>