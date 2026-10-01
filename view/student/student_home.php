<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CHECKMATE - Student Home</title>

    <link rel="stylesheet" href="../../asset/css/student_home.css">

</head>


<body>


<!-- =====================================================
     SIDEBAR
===================================================== -->

<aside class="sidebar">


    <!-- LOGO -->

    <div class="logo-area">

        <div class="logo-piece">
            ♞
        </div>

        <div class="logo-text">

            <h1>CHECKMATE</h1>

            <span>
                PEER COLLABORATION
            </span>

        </div>

    </div>



    <!-- NEW QUESTION BUTTON -->

    <button class="new-question-button"
            id="newQuestionButton">

        <span class="button-icon">
            +
        </span>

        <span>
            New Question
        </span>

    </button>



    <!-- WORKSPACE -->

    <div class="sidebar-section">

        <div class="section-title">
            WORKSPACE
        </div>


        <a href="#"
           class="menu-item active"
           data-page="home">

            <span class="menu-icon">
                ⌂
            </span>

            <span>
                Home
            </span>

        </a>


        <a href="#"
           class="menu-item"
           data-page="questions">

            <span class="menu-icon">
                ♟
            </span>

            <span>
                Questions
            </span>

        </a>


        <a href="#"
           class="menu-item"
           data-page="my-questions">

            <span class="menu-icon">
                ☷
            </span>

            <span>
                My Questions
            </span>

        </a>


        <a href="#"
           class="menu-item"
           data-page="collaboration">

            <span class="menu-icon">
                ♞
            </span>

            <span>
                Collaboration
            </span>

        </a>


        <a href="#"
           class="menu-item"
           data-page="messages">

            <span class="menu-icon">
                □
            </span>

            <span>
                Messages
            </span>

            <span class="notification">
                2
            </span>

        </a>

    </div>



    <!-- ACCOUNT -->

    <div class="sidebar-section account-section">

        <div class="section-title">
            ACCOUNT
        </div>


        <a href="#"
           class="menu-item"
           data-page="profile">

            <span class="menu-icon">
                ○
            </span>

            <span>
                Profile
            </span>

        </a>


        <a href="#"
           class="menu-item"
           data-page="settings">

            <span class="menu-icon">
                ⚙
            </span>

            <span>
                Settings
            </span>

        </a>

    </div>



    <!-- USER ACCOUNT -->

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


        <button class="user-more"
                id="userMore">

            ⋮

        </button>

    </div>

</aside>



<!-- =====================================================
     MAIN CONTENT
===================================================== -->

<main class="main-content">


    <!-- =================================================
         TOP BAR
    ================================================= -->

    <header class="topbar">


        <!-- LEFT SIDE -->

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


        <!-- RIGHT SIDE -->

        <div class="topbar-right">

            <button class="help-button"
                    id="helpButton">

                ?

            </button>


            <div class="top-avatar">
                S
            </div>

        </div>

    </header>



    <!-- =================================================
         WELCOME
    ================================================= -->

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



    <!-- =================================================
         ASK QUESTION
    ================================================= -->

    <section class="ask-box"
             id="askBox">


        <div class="ask-box-top">

            <div class="ask-icon">
                ♞
            </div>


            <div>

                <h3>
                    Ask the community
                </h3>

                <p>
                    Share what you need help with.
                </p>

            </div>

        </div>


        <textarea
            id="questionInput"
            class="question-input"
            placeholder="What do you need help with?"></textarea>


        <div class="ask-bottom">


            <div class="ask-options">


                <button class="ask-option"
                        id="attachmentButton">

                    <span>
                        ＋
                    </span>

                    Attachment

                </button>


                <button class="ask-option"
                        id="subjectButton">

                    <span>
                        ◈
                    </span>

                    Subject

                </button>


                <button class="ask-option"
                        id="typeButton">

                    <span>
                        ◇
                    </span>

                    Question Type

                </button>

            </div>


            <button class="ask-button"
                    id="askButton">

                Make a Move

                <span>
                    →
                </span>

            </button>

        </div>

    </section>



    <!-- =================================================
         QUICK MOVES
    ================================================= -->

    <section class="dashboard-section">


        <div class="section-heading">

            <div>

                <span class="heading-label">
                    QUICK MOVES
                </span>

                <h3>
                    Start here
                </h3>

            </div>

        </div>


        <div class="quick-grid">


            <!-- ASK QUESTION -->

            <div class="quick-card"
                 data-action="ask">

                <div class="quick-card-icon">
                    ♟
                </div>


                <div class="quick-card-content">

                    <h4>
                        Ask a Question
                    </h4>

                    <p>
                        Post something you need help with.
                    </p>

                </div>


                <span class="card-arrow">
                    →
                </span>

            </div>



            <!-- BROWSE QUESTIONS -->

            <div class="quick-card"
                 data-action="browse">

                <div class="quick-card-icon">
                    ♜
                </div>


                <div class="quick-card-content">

                    <h4>
                        Browse Questions
                    </h4>

                    <p>
                        See questions from other students.
                    </p>

                </div>


                <span class="card-arrow">
                    →
                </span>

            </div>



            <!-- COLLABORATE -->

            <div class="quick-card"
                 data-action="collaborate">

                <div class="quick-card-icon">
                    ♞
                </div>


                <div class="quick-card-content">

                    <h4>
                        Collaborate
                    </h4>

                    <p>
                        Check your collaboration requests.
                    </p>

                </div>


                <span class="card-arrow">
                    →
                </span>

            </div>


        </div>

    </section>



    <!-- =================================================
         QUESTIONS + COLLABORATION
    ================================================= -->

    <section class="dashboard-section">


        <div class="dashboard-columns">


            <!-- =================================================
                 PEER QUESTIONS
            ================================================= -->

            <div class="dashboard-panel questions-panel">


                <div class="panel-header">

                    <div>

                        <span class="panel-label">
                            PEER QUESTIONS
                        </span>

                        <h3>
                            Recent questions
                        </h3>

                    </div>


                    <button class="view-all"
                            id="viewQuestions">

                        View all

                        <span>
                            →
                        </span>

                    </button>

                </div>



                <div class="questions-list">


                    <!-- QUESTION 1 -->

                    <div class="question-item"
                         data-question="hindi po ba makati kapag puno ng saging?">

                        <div class="question-number">
                            ♟
                        </div>


                        <div class="question-content">

                            <div class="question-text">
                                hindi po ba makati kapag puno ng saging?
                            </div>


                            <div class="question-meta">

                                <span>
                                    ian henerasyon
                                </span>

                                <span>
                                    ·
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

                    <div class="question-item"
                         data-question="paano po maglagay ng file sa gdrive?">

                        <div class="question-number">
                            ♟
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
                                    ·
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

                    <div class="question-item"
                         data-question="nag cha-chat gpt po kaya ang teacher?">

                        <div class="question-number">
                            ♟
                        </div>


                        <div class="question-content">

                            <div class="question-text">
                                nag cha-chat gpt po kaya ang teacher?
                            </div>


                            <div class="question-meta">

                                <span>
                                    andrea brilyante
                                </span>

                                <span>
                                    ·
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



            <!-- =================================================
                 COLLABORATION
            ================================================= -->

            <div class="dashboard-panel collaboration-panel">


                <div class="panel-header">

                    <div>

                        <span class="panel-label">
                            COLLABORATION
                        </span>

                        <h3>
                            Current activity
                        </h3>

                    </div>


                    <button class="view-all"
                            data-page="collaboration">

                        View all

                        <span>
                            →
                        </span>

                    </button>

                </div>



                <div class="collaboration-list">


                    <!-- COLLABORATION 1 -->

                    <div class="collaboration-item">

                        <div class="collaborator-avatar">
                            J
                        </div>


                        <div class="collaborator-info">

                            <div class="collaborator-name">
                                jayzen titum
                            </div>


                            <div class="collaborator-status active">
                                Active collaboration
                            </div>

                        </div>


                        <button class="open-button"
                                data-person="jayzen titum">

                            →

                        </button>

                    </div>



                    <!-- COLLABORATION 2 -->

                    <div class="collaboration-item">

                        <div class="collaborator-avatar">
                            D
                        </div>


                        <div class="collaborator-info">

                            <div class="collaborator-name">
                                dds james
                            </div>


                            <div class="collaborator-status pending">
                                Pending request
                            </div>

                        </div>


                        <button class="open-button"
                                data-person="dds james">

                            →

                        </button>

                    </div>


                </div>


                <div class="panel-footer-note">
                    Collaborations can be opened from your workspace.
                </div>

            </div>

        </div>

    </section>



    <!-- =================================================
         FOOTER
    ================================================= -->

    <footer class="chess-footer">

        <div class="footer-piece">
            ♚
        </div>


        <div class="footer-text">

            <strong>
                Every question is a move.
            </strong>

            <span>
                Find the right peer. Make the right move.
            </span>

        </div>


        <div class="footer-piece">
            ♔
        </div>

    </footer>


</main>



<!-- =====================================================
     TOAST
===================================================== -->

<div class="toast"
     id="toast">
</div>



<!-- JAVASCRIPT -->

<script src="../../asset/css/admin_home.js"></script>

</body>

</html>