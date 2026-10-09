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

function e($value): string
{
    return htmlspecialchars((string)($value ?? ""), ENT_QUOTES, "UTF-8");
}

/* Pending / Accepted / Rejected (anything else counts as pending) */
function collabStatus($status): string
{
    $key = strtolower(trim((string)$status));
    return in_array($key, ["accepted", "rejected"], true) ? $key : "pending";
}

/* Accept or reject a request that was sent to this student */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $collabId = (int)($_POST["collaboration_id"] ?? 0);
    $action = $_POST["action"] ?? "";
    $result = "failed";

    if ($collabId > 0 && in_array($action, ["accept", "reject"], true)) {
        $newStatus = $action === "accept" ? "Accepted" : "Rejected";

        try {
            // Only the receiver can answer, and only while it is still pending.
            $stmt = $conn->prepare(
                "UPDATE collaborations
                 SET status = ?
                 WHERE collaboration_id = ?
                   AND receiver_id = ?
                   AND status = 'Pending'"
            );

            if ($stmt) {
                $stmt->bind_param("sii", $newStatus, $collabId, $user_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $result = strtolower($newStatus);
                }

                $stmt->close();
            }
        } catch (Throwable $ex) {
            $result = "failed";
        }
    }

    header("Location: collaboration.php?updated=" . $result);
    exit();
}

/* Load every collaboration this student is part of */
$collabs = [];
$loadError = false;

try {
    $stmt = $conn->prepare(
        "SELECT c.collaboration_id, c.question_id, c.requestor_id,
                c.receiver_id, c.status, c.create_at,
                q.question, q.subject, q.question_course,
                q.question_type, q.attachment,
                req.full_name AS requestor_name,
                req.course AS requestor_course,
                req.student_id AS requestor_sid,
                rec.full_name AS receiver_name,
                rec.course AS receiver_course,
                rec.student_id AS receiver_sid
         FROM collaborations c
         INNER JOIN questions q ON c.question_id = q.question_id
         INNER JOIN users req ON c.requestor_id = req.id
         INNER JOIN users rec ON c.receiver_id = rec.id
         WHERE c.requestor_id = ? OR c.receiver_id = ?
         ORDER BY c.create_at DESC"
    );

    if (!$stmt) {
        throw new Exception("Collaboration query failed.");
    }

    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $collabs[] = $row;
    }
    $stmt->close();
} catch (Throwable $ex) {
    $loadError = true;
}

/* Summary numbers */
$receivedCount = 0;
$sentCount = 0;
$activeCount = 0;
$pendingReceived = 0;
$pendingSent = 0;

foreach ($collabs as $c) {
    $isReceiver = (int)$c["receiver_id"] === $user_id;
    $key = collabStatus($c["status"]);

    if ($isReceiver) {
        $receivedCount++;
    } else {
        $sentCount++;
    }

    if ($key === "pending") {
        if ($isReceiver) {
            $pendingReceived++;
        } else {
            $pendingSent++;
        }
    }

    if ($key === "accepted") {
        $activeCount++;
    }
}

$totalCollabs = count($collabs);
$updated = $_GET["updated"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHECKMATE - Collaboration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link rel="stylesheet" href="../../asset/css/question.css">
    <link rel="stylesheet" href="../../asset/css/collaboration_stu.css">
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

        <a href="questions.php" class="menu-item">
            <span class="menu-icon">?</span><span>Questions</span>
        </a>

        <a href="my_question.php" class="menu-item">
            <span class="menu-icon">♧</span><span>My Questions</span>
        </a>

        <a href="collaboration_stu.php" class="menu-item active">
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
            <span class="topbar-current">Collaboration</span>
        </div>
        <div class="topbar-right">
            <a href="../../authentication/Login/logout.php">LogOut</a>
        </div>
    </header>

    <section class="questions-page">

        <div class="page-heading">
            <span class="heading-label">PEER COLLABORATION</span>
            <h2>Collaboration</h2>
            <p>Answer help requests, follow the ones you sent, and open your active collaborations.</p>
        </div>

        <?php if ($loadError): ?>
            <div class="form-message form-message-error">
                Collaboration requests could not be loaded right now.
            </div>
        <?php endif; ?>

        <?php if ($updated === "accepted"): ?>
            <div class="form-message form-message-success">
                Request accepted. The collaboration is now open.
            </div>
        <?php elseif ($updated === "rejected"): ?>
            <div class="form-message form-message-success">
                Request rejected.
            </div>
        <?php elseif ($updated === "failed"): ?>
            <div class="form-message form-message-error">
                That request could not be updated. It may already have been answered.
            </div>
        <?php endif; ?>

        <div class="my-summary">

            <div class="summary-card">
                <span class="summary-label">RECEIVED</span>
                <strong><?= $pendingReceived ?></strong>
                <span class="summary-hint">Waiting for your reply</span>
            </div>

            <div class="summary-card">
                <span class="summary-label">SENT</span>
                <strong><?= $pendingSent ?></strong>
                <span class="summary-hint">Waiting for a response</span>
            </div>

            <div class="summary-card">
                <span class="summary-label">ACTIVE</span>
                <strong><?= $activeCount ?></strong>
                <span class="summary-hint">Open collaborations</span>
            </div>

        </div>

        <section class="questions-section">

            <div class="section-heading">
                <div>
                    <span class="heading-label">YOUR REQUESTS</span>
                    <h3>Collaboration activity</h3>
                </div>
            </div>

            <div class="filter-tabs" role="tablist" aria-label="Filter collaborations">
                <button type="button" class="filter-tab active" data-filter="all">
                    All (<?= $totalCollabs ?>)
                </button>
                <button type="button" class="filter-tab" data-filter="received">
                    Received (<?= $receivedCount ?>)
                </button>
                <button type="button" class="filter-tab" data-filter="sent">
                    Sent (<?= $sentCount ?>)
                </button>
                <button type="button" class="filter-tab" data-filter="active">
                    Active (<?= $activeCount ?>)
                </button>
            </div>

            <div class="search-box">
                <input type="text" id="searchCollaborations"
                       placeholder="Search by question or student...">
            </div>

            <div class="questions-list" id="collabList">

                <?php if ($totalCollabs > 0): ?>

                    <?php foreach ($collabs as $c): ?>
                        <?php
                        $cid = (int)$c["collaboration_id"];
                        $isReceiver = (int)$c["receiver_id"] === $user_id;
                        $key = collabStatus($c["status"]);

                        if ($isReceiver) {
                            $partnerName = $c["requestor_name"];
                            $partnerCourse = $c["requestor_course"];
                            $partnerSid = $c["requestor_sid"];
                            $summary = $partnerName . " asked for your help";
                        } else {
                            $partnerName = $c["receiver_name"];
                            $partnerCourse = $c["receiver_course"];
                            $partnerSid = $c["receiver_sid"];
                            $summary = "You asked " . $partnerName . " for help";
                        }

                        $groups = $isReceiver ? "received" : "sent";
                        if ($key === "accepted") {
                            $groups .= " active";
                        }

                        $dateText = date(
                            "M d, Y h:i A",
                            strtotime($c["create_at"])
                        );
                        ?>

                        <div class="my-question" data-groups="<?= e($groups) ?>">

                            <div class="my-question-header"
                                 role="button"
                                 tabindex="0"
                                 aria-expanded="false"
                                 aria-controls="collab-<?= $cid ?>">

                                <div class="question-icon">♟</div>

                                <div class="question-details">
                                    <h3><?= e($c["question"]) ?></h3>

                                    <div class="question-tags">
                                        <span><?= e($c["subject"]) ?></span>
                                        <span><?= e($c["question_course"]) ?></span>
                                        <span><?= e($c["question_type"]) ?></span>
                                    </div>

                                    <div class="question-meta">
                                        <span><?= e($summary) ?></span>
                                        <span>·</span>
                                        <span><?= e($dateText) ?></span>
                                    </div>

                                    <?php if ($isReceiver && $key === "pending"): ?>
                                        <div class="collab-actions">

                                            <form method="POST">
                                                <input type="hidden" name="collaboration_id" value="<?= $cid ?>">
                                                <input type="hidden" name="action" value="accept">
                                                <button type="submit" class="collab-btn accept">
                                                    ✓ Accept
                                                </button>
                                            </form>

                                            <form method="POST"
                                                  onsubmit="return confirm('Reject this collaboration request?');">
                                                <input type="hidden" name="collaboration_id" value="<?= $cid ?>">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="collab-btn reject">
                                                    ✕ Reject
                                                </button>
                                            </form>

                                        </div>
                                    <?php endif; ?>
                                </div>

                                <span class="answer-badge <?= $key ?>">
                                    <?= e(ucfirst($key)) ?>
                                </span>

                                <div class="question-arrow">→</div>
                            </div>

                            <div class="answers-panel" id="collab-<?= $cid ?>" hidden>

                                <div class="answers-label">
                                    <?= $isReceiver ? "REQUESTED BY" : "REQUESTED TO" ?>
                                </div>

                                <div class="answer-item">

                                    <div class="answer-avatar">
                                        <?= e(strtoupper(substr($partnerName, 0, 1))) ?>
                                    </div>

                                    <div class="answer-body">
                                        <div class="answer-author">
                                            <strong><?= e($partnerName) ?></strong>
                                            <span>
                                                <?= e($partnerCourse) ?> · <?= e($partnerSid) ?>
                                            </span>
                                        </div>

                                        <div class="answer-text">
                                            <?php if ($key === "accepted"): ?>
                                                <?php if ($isReceiver): ?>
                                                    You accepted this request. You are now helping
                                                    <?= e($partnerName) ?> with this question.
                                                <?php else: ?>
                                                    <?= e($partnerName) ?> accepted your request and
                                                    is ready to help with this question.
                                                <?php endif; ?>
                                            <?php elseif ($key === "rejected"): ?>
                                                <?php if ($isReceiver): ?>
                                                    You rejected this request.
                                                <?php else: ?>
                                                    <?= e($partnerName) ?> was not able to help with
                                                    this question.
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if ($isReceiver): ?>
                                                    This request is waiting for your reply.
                                                <?php else: ?>
                                                    Waiting for <?= e($partnerName) ?> to respond.
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>

                                <?php if (!empty($c["attachment"])): ?>
                                    <a class="attachment-link"
                                       href="../../uploads/questions/<?= rawurlencode(basename($c["attachment"])) ?>"
                                       target="_blank" rel="noopener">
                                        View question attachment ↗
                                    </a>
                                <?php endif; ?>

                            </div>

                        </div>

                    <?php endforeach; ?>

                    <div class="no-questions" id="filterEmpty" hidden>
                        <div>♟</div>
                        <h3>No matching collaborations</h3>
                        <p>Try a different filter or search.</p>
                    </div>

                <?php else: ?>

                    <div class="no-questions">
                        <div>♟</div>
                        <h3>No collaborations yet</h3>
                        <p>Requests you send or receive will show up here.</p>
                    </div>

                <?php endif; ?>

            </div>

        </section>

    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../asset/js/collaboration_stu.js"></script>
</body>
</html>

<?php
$conn->close();
?>