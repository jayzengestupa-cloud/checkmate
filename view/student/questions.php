
<?php
session_start();
require_once "../../config/config.php";

if (empty($_SESSION["student_id"])) {
    header("Location: ../../authentication/Login/login.php");
    exit();
}

$student_id = $_SESSION["student_id"];

$stmt = $conn->prepare(
    "SELECT id, full_name, student_id, course
     FROM users WHERE student_id = ? LIMIT 1"
);
if (!$stmt) {
    die("User query failed: " . $conn->error);
}

$stmt->bind_param("s", $student_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    die("Student account not found.");
}

$user_id = (int)$user["id"];
$error = "";

/* Load active dropdown choices */
function loadOptions(mysqli $conn, string $table, string $column): array
{
    // Table and column names are fixed internally below.
    $sql = "SELECT `$column` AS option_name
            FROM `$table`
            WHERE status = 'Active'
            ORDER BY `$column` ASC";

    $result = $conn->query($sql);
    $options = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $options[] = $row["option_name"];
        }
    }

    return $options;
}

$subjects = loadOptions($conn, "question_subjects", "subject_name");
$courses = loadOptions($conn, "question_courses", "course_name");
$types = loadOptions($conn, "question_types", "type_name");

/* Save a new question */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $question = trim($_POST["question"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $course = trim($_POST["question_course"] ?? "");
    $type = trim($_POST["question_type"] ?? "");
    $attachmentName = null;

    if ($question === "") {
        $error = "Please enter your question.";
    } elseif (!in_array($subject, $subjects, true)) {
        $error = "Please select a valid subject.";
    } elseif (!in_array($course, $courses, true)) {
        $error = "Please select a valid course.";
    } elseif (!in_array($type, $types, true)) {
        $error = "Please select a valid question type.";
    }

    /* Handle optional attachment */
    if ($error === "" &&
        isset($_FILES["attachment"]) &&
        $_FILES["attachment"]["error"] !== UPLOAD_ERR_NO_FILE) {

        if ($_FILES["attachment"]["error"] !== UPLOAD_ERR_OK) {
            $error = "The attachment could not be uploaded.";
        } elseif ($_FILES["attachment"]["size"] > 5 * 1024 * 1024) {
            $error = "Attachment must be 5 MB or smaller.";
        } else {
            $originalName = $_FILES["attachment"]["name"];
            $extension = strtolower(
                pathinfo($originalName, PATHINFO_EXTENSION)
            );

            $allowedExtensions = [
                "pdf",
                "doc",
                "docx",
                "ppt",
                "pptx",
                "txt",
                "jpg",
                "jpeg",
                "png",
                "xls",
                "xlsx",
                "csv"
            ];

            if (!in_array($extension, $allowedExtensions, true)) {
                $error = "Allowed files: PDF, DOC, DOCX, PPT, PPTX, TXT, JPG, JPEG, PNG, XLS, XLSX, and CSV.";
            } else {
                $uploadDirectory = "../../uploads/questions/";

                if (!is_dir($uploadDirectory) &&
                    !mkdir($uploadDirectory, 0755, true)) {
                    $error = "Could not create the upload folder.";
                } else {
                    // Generate a safe, unique filename.
                    $attachmentName = bin2hex(random_bytes(16))
                        . "." . $extension;

                    $destination = $uploadDirectory . $attachmentName;

                    if (!move_uploaded_file(
                        $_FILES["attachment"]["tmp_name"],
                        $destination
                    )) {
                        $error = "Could not save the uploaded file.";
                        $attachmentName = null;
                    }
                }
            }
        }
    }

    if ($error === "") {
        $stmt = $conn->prepare(
            "INSERT INTO questions
             (user_id, question, status, create_at,
              subject, question_course, question_type, attachment)
             VALUES (?, ?, 'Active', NOW(), ?, ?, ?, ?)"
        );

        if (!$stmt) {
            $error = "Insert prepare failed: " . $conn->error;
        } else {
            $stmt->bind_param(
                "isssss",
                $user_id,
                $question,
                $subject,
                $course,
                $type,
                $attachmentName
            );

            if ($stmt->execute()) {
                $stmt->close();
                header("Location: questions.php?posted=1");
                exit();
            } else {
                $error = "Could not save your question.";
                $stmt->close();

                // Remove the uploaded file if the database insert fails.
                if ($attachmentName !== null) {
                    $filePath = "../../uploads/questions/" . $attachmentName;
                    if (is_file($filePath)) {
                        unlink($filePath);
                    }
                }
            }
        }
    }
}

/* Load community questions */
$questions = [];

$stmt = $conn->prepare(
    "SELECT q.question_id, q.question, q.create_at,
            q.subject, q.question_course, q.question_type, q.attachment,
            u.full_name, u.student_id
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

function e($value): string
{
    return htmlspecialchars((string)($value ?? ""), ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHECKMATE - Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link rel="stylesheet" href="../../asset/css/question.css">
</head>
<body>

<aside class="sidebar">
    <div class="logo-area">
        <div class="logo-piece">♞</div>
        <div class="logo-text">
            <h1>CHECKMATE</h1>
            <span>PEER COLLABORATION</span>
        </div>
    </div>

    <a href="questions.php" class="new-question-button">
        <span class="button-icon">+</span>
        <span>New Question</span>
    </a>

    <div class="sidebar-section">
        <div class="section-title">WORKSPACE</div>

        <a href="student_home.php" class="menu-item">
            <span class="menu-icon">⌂</span><span>Home</span>
        </a>

        <a href="questions.php" class="menu-item active">
            <span class="menu-icon">?</span><span>Questions</span>
        </a>

        <a href="my_question.php" class="menu-item">
            <span class="menu-icon">♧</span><span>My Questions</span>
        </a>

        <a href="#" class="menu-item">
            <span class="menu-icon">♟</span><span>Collaboration</span>
        </a>

        <a href="#" class="menu-item">
            <span class="menu-icon">✉</span><span>Messages</span>
        </a>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">
            <?= e(strtoupper(substr($user["full_name"], 0, 1))) ?>
        </div>
        <div class="user-information">
            <strong><?= e($user["full_name"]) ?></strong>
            <span><?= e($user["course"]) ?> · <?= e($user["student_id"]) ?></span>
        </div>
        <button class="user-more" type="button" aria-label="More options">⋮</button>
    </div>
</aside>

<main class="main-content">
    <header class="topbar">
        <div class="topbar-left">
            <span class="topbar-label">STUDENT WORKSPACE</span>
            <span class="topbar-divider">/</span>
            <span class="topbar-current">Questions</span>
        </div>
        <div class="topbar-right">
            <a href="../../authentication/Login/logout.php">LogOut</a>
        </div>
    </header>

    <section class="questions-page">
        <div class="page-heading">
            <span class="heading-label">PEER QUESTIONS</span>
            <h2>Questions</h2>
            <p>See what other students are asking and share your own question.</p>
        </div>

        <section class="ask-question-box">
            <div class="ask-heading">
                <div class="ask-icon">♞</div>
                <div>
                    <h3>Ask the community</h3>
                    <p>Share what you need help with.</p>
                </div>
            </div>

            <?php if ($error !== ""): ?>
                <div class="form-message form-message-error">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET["posted"])): ?>
                <div class="form-message form-message-success">
                    Your question was posted successfully.
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">

    <div class="question-composer">

        <div class="question-fields-grid">

            <div class="question-field">
                <select name="subject" id="subject" aria-label="Subject" required>
                    <option value="">Subject +</option>

                    <?php foreach ($subjects as $option): ?>
                        <option value="<?= e($option) ?>"
                            <?= (($_POST["subject"] ?? "") === $option) ? "selected" : "" ?>>
                            <?= e($option) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="question-field">
                <select name="question_course" id="question_course" aria-label="Course" required>
                    <option value="">Course +</option>

                    <?php foreach ($courses as $option): ?>
                        <option value="<?= e($option) ?>"
                            <?= (($_POST["question_course"] ?? "") === $option) ? "selected" : "" ?>>
                            <?= e($option) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="question-field">
                <select name="question_type" id="question_type" aria-label="Question Type" required>
                    <option value="">Question Type +</option>

                    <?php foreach ($types as $option): ?>
                        <option value="<?= e($option) ?>"
                            <?= (($_POST["question_type"] ?? "") === $option) ? "selected" : "" ?>>
                            <?= e($option) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <textarea
            id="question"
            name="question"
            placeholder="What do you need help with?"
            aria-label="Your Question"
            required><?= e($_POST["question"] ?? "") ?></textarea>

        <div class="attachment-toolbar">

            <div class="attachment-menu-container">

                <button
                    type="button"
                    class="attachment-plus"
                    id="attachmentPlus"
                    aria-label="Add attachment"
                    aria-expanded="false">
                    +
                </button>

                <div class="attachment-menu" id="attachmentMenu" hidden>

                    <button
                        type="button"
                        class="attachment-option"
                        data-attachment="photos">
                        <span class="attachment-option-icon">▧</span>
                        <span>Photos</span>
                    </button>

                    <button
                        type="button"
                        class="attachment-option"
                        data-attachment="files">
                        <span class="attachment-option-icon">▤</span>
                        <span>Files</span>
                    </button>

                </div>

            </div>

            <span class="attachment-selected" id="attachmentSelected">
                Add attachment (optional)
            </span>

            <input
                type="file"
                name="attachment"
                id="attachment"
                accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.jpg,.jpeg,.png,.xls,.xlsx,.csv"
                hidden>

        </div>

    </div>

    <div class="ask-form-bottom">
        <span>Ask your question to other students.</span>
        <button type="submit">Post Question →</button>
    </div>

</form>
        </section>

        <section class="questions-section">
            <div class="section-heading">
                <div>
                    <span class="heading-label">COMMUNITY</span>
                    <h3>Questions</h3>
                </div>
            </div>

            <div class="search-box">
                <input type="text" id="searchQuestions"
                       placeholder="Search questions...">
            </div>

            <div class="questions-list" id="questionsList">
                <?php if (count($questions) > 0): ?>
                    <?php foreach ($questions as $row): ?>
                        <div class="question-card">
                            <div class="question-icon">♟</div>

                            <div class="question-details">
                                <h3><?= e($row["question"]) ?></h3>

                                <div class="question-tags">
                                    <span><?= e($row["subject"]) ?></span>
                                    <span><?= e($row["question_course"]) ?></span>
                                    <span><?= e($row["question_type"]) ?></span>
                                </div>

                                <div class="question-meta">
                                    <span><?= e($row["full_name"]) ?></span>
                                    <span>·</span>
                                    <span><?= e(date(
                                        "M d, Y h:i A",
                                        strtotime($row["create_at"])
                                    )) ?></span>
                                </div>

                                <?php if (!empty($row["attachment"])): ?>
                                    <a class="attachment-link"
                                       href="../../uploads/questions/<?= rawurlencode(basename($row["attachment"])) ?>"
                                       target="_blank" rel="noopener">
                                        View attachment ↗
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="question-arrow">→</div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-questions">
                        <div>♟</div>
                        <h3>No questions yet</h3>
                        <p>There are no questions yet.</p>
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