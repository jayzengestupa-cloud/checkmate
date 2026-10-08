<?php
session_start();

require_once "../../config/config.php";

if (!isset($_SESSION["student_id"]) || $_SESSION["student_id"] == "") {
    header("Location: ../../authentication/Login/login.php");
    exit();
}

$student_id = $_SESSION["student_id"];

$stmt = $conn->prepare(
    "SELECT id, full_name, student_id
     FROM users
     WHERE student_id = ?
     LIMIT 1"
);

if (!$stmt) {
    die("User query failed: " . $conn->error);
}

$stmt->bind_param("s", $student_id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();

if (!$user) {
    die("Student account not found.");
}

$user_id = $user["id"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $question = trim($_POST["question"] ?? "");

    if ($question == "") {
        die("Please enter a question.");
    }

    $stmt = $conn->prepare(
        "INSERT INTO questions
        (user_id, question, status, create_at)
        VALUES (?, ?, 'Active', NOW())"
    );

    if (!$stmt) {
        die("Insert prepare failed: " . $conn->error);
    }

    $stmt->bind_param("is", $user_id, $question);

    if (!$stmt->execute()) {
        die("Insert failed: " . $stmt->error);
    }

    $stmt->close();

    header("Location: questions.php");
    exit();
}


$questions = [];

$stmt = $conn->prepare(
    "SELECT
        q.question_id,
        q.question,
        q.create_at,
        u.full_name,
        u.student_id
     FROM questions q
     INNER JOIN users u ON q.user_id = u.id
     WHERE q.status = 'Active'
     ORDER BY q.create_at DESC"
);

if (!$stmt) {
    die("Question query failed: " . $conn->error);
}

$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CHECKMATE - Questions</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../../asset/css/question.css">

</head>

<body>

<aside class="sidebar">

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


    <a href="student_home.php" class="new-question-button">

        <span class="button-icon">
            +
        </span>

        <span>
            New Question
        </span>

    </a>


    <div class="sidebar-section">

        <div class="section-title">
            WORKSPACE
        </div>


        <a href="student_home.php" class="menu-item">

            <span class="menu-icon">
                ⌂
            </span>

            <span>
                Home
            </span>

        </a>


        <a href="questions.php" class="menu-item active">

            <span class="menu-icon">
                ?
            </span>

            <span>
                Questions
            </span>

        </a>


        <a href="#" class="menu-item">

            <span class="menu-icon">
                ♧
            </span>

            <span>
                My Questions
            </span>

        </a>


        <a href="#" class="menu-item">

            <span class="menu-icon">
                ♟
            </span>

            <span>
                Collaboration
            </span>

        </a>


        <a href="#" class="menu-item">

            <span class="menu-icon">
                ✉
            </span>

            <span>
                Messages
            </span>

        </a>

    </div>


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

        <button class="user-more">
            ⋮
        </button>

    </div>

</aside>


<main class="main-content">

    <header class="topbar">

        <div class="topbar-left">

            <span class="topbar-label">
                STUDENT WORKSPACE
            </span>

            <span class="topbar-divider">
                /
            </span>

            <span class="topbar-current">
                Questions
            </span>

        </div>


        <div class="topbar-right">

            <a href="../../authentication/Login/logout.php">
                LogOut
            </a>

        </div>

    </header>


    <section class="questions-page">

        <div class="page-heading">

            <span class="heading-label">
                PEER QUESTIONS
            </span>

            <h2>
                Questions
            </h2>

            <p>
                See what other students are asking and share your own question.
            </p>

        </div>


        <section class="ask-question-box">

            <div class="ask-heading">

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


            <form method="POST">

                <textarea
                    name="question"
                    placeholder="What do you need help with?"
                    required
                ></textarea>


                <div class="ask-form-bottom">

                    <span>
                        Ask your question to other students.
                    </span>

                    <button type="submit">
                        Post Question →
                    </button>

                </div>

            </form>

        </section>


        <section class="questions-section">

            <div class="section-heading">

                <span class="heading-label">
                    COMMUNITY
                </span>

                <h3>
                    Questions
                </h3>

            </div>


            <div class="search-box">

                <input
                    type="text"
                    id="searchQuestions"
                    placeholder="Search questions..."
                >

            </div>


            <div class="questions-list" id="questionsList">

                <?php if (count($questions) > 0): ?>

                    <?php foreach ($questions as $row): ?>

                        <div class="question-card">

                            <div class="question-icon">
                                ♟
                            </div>


                            <div class="question-details">

                                <h3>
                                    <?= htmlspecialchars($row["question"]) ?>
                                </h3>


                                <div class="question-meta">

                                    <span>
                                        <?= htmlspecialchars($row["full_name"]) ?>
                                    </span>

                                    <span>
                                        ·
                                    </span>

                                    <span>
                                        <?= date(
                                            "M d, Y h:i A",
                                            strtotime($row["create_at"])
                                        ) ?>
                                    </span>

                                </div>

                            </div>


                            <div class="question-arrow">
                                →
                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="no-questions">

                        <div>
                            ♟
                        </div>

                        <h3>
                            No questions yet
                        </h3>

                        <p>
                            There are no questions yet.
                        </p>

                    </div>

                <?php endif; ?>

            </div>

        </section>

    </section>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="../../asset/js/question.js"></script>

</body>

</html>

<?php
$conn->close();
?>