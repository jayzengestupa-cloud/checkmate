<?php

require_once "../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = $_POST["full_name"];
    $student_id = $_POST["student_id"];
    $email = $_POST["email"];
    $course = $_POST["course"];
    $year_level = $_POST["year_level"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check password
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash password
    $hashed_password = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    // Insert student
    $sql = "INSERT INTO students
            (full_name, student_id, email, course, year_level, password)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssss",
        $full_name,
        $student_id,
        $email,
        $course,
        $year_level,
        $hashed_password
    );

    if ($stmt->execute()) {

        echo "Account created successfully!";

    } else {

        echo "Error: " . $stmt->error;

    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign up - CheckMate</title>
  <link rel="stylesheet" href="/checkmate/asset/css/register.css">
</head>
<body>

  <!-- logo -->
  <div class="logo">
    <!-- simple chess knight icon -->
    <svg viewBox="0 0 24 24"><path d="M7 21h12v-2H7v2zm1-3h10c0-3 1-5 1-8 0-4-3-7-7-7l-1-2-2 3C6 5 4 8 4 10l3 2 2-2 1 1c-2 2-2 4-2 7z"/></svg>
    CHECKMATE
  </div>
  <div class="logo-line"></div>

  <!-- sign up card -->
  <div class="card">
    <p class="small-title">CREATE YOUR ACCOUNT</p>
    <h1>Sign up to CheckMate</h1>
    <p class="subtitle">Join our community and start asking, answering, and learning together.</p>

    <form id="signupForm" novalidate>

      <!-- row 1: full name + student id -->
      <div class="row">
        <div class="field">
          <label for="fullName">Full Name</label>
          <div class="input-box">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>
            <input type="text" id="fullName" placeholder="Enter your full name">
          </div>
        </div>
        <div class="field">
          <label for="studentId">Student ID</label>
          <div class="input-box">
            <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="2"/><path d="M14 10h4M14 14h4M6 16c0-1.5 1.5-2 3-2s3 .5 3 2"/></svg>
            <input type="text" id="studentId" maxlength="10" placeholder="Enter your student ID">
          </div>
        </div>
      </div>

      <!-- email -->
      <div class="field">
        <label for="email">Email Address</label>
        <div class="input-box">
          <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
          <input type="email" id="email" placeholder="Enter your email address">
        </div>
      </div>

      <!-- row 2: course + year level -->
      <div class="row">
        <div class="field">
          <label for="course">Course</label>
          <div class="input-box">
            <svg viewBox="0 0 24 24"><path d="M2 9l10-5 10 5-10 5L2 9z"/><path d="M6 11v5c3 3 9 3 12 0v-5"/></svg>
            <select id="course">
              <option value="">Select your course</option>
              <!-- TODO: replace these with the real courses of the school -->
              <option>BS Information Technology</option>
              <option>BS Computer Science</option>
              <option>BS Information Systems</option>
              <option>BS Engineering</option>
            </select>
          </div>
        </div>
        <div class="field">
          <label for="year">Year Level</label>
          <div class="input-box">
            <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
            <select id="year">
              <option value="">Select your year level</option>
              <option>1st Year</option>
              <option>2nd Year</option>
              <option>3rd Year</option>
              <option>4th Year</option>
            </select>
          </div>
        </div>
      </div>

      <!-- role (student or admin only) -->
      <div class="field">
        <label for="role">Role</label>
        <div class="input-box">
          <svg viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6l8-3z"/></svg>
          <select id="role">
            <option value="">Select your role</option>
            <option value="student">Student</option>
            <option value="admin">Admin</option>
          </select>
        </div>
      </div>

      <!-- password -->
      <div class="field">
        <label for="password">Password</label>
        <div class="input-box">
          <svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 018 0v4"/></svg>
          <input type="password" id="password" placeholder="Enter your password">
          <button type="button" class="eye-btn" data-target="password" aria-label="Show password">
            <svg viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-10-8-10-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 10 8 10 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><path d="M1 1l22 22"/></svg>
          </button>
        </div>
      </div>

      <!-- confirm password -->
      <div class="field">
        <label for="confirm">Confirm Password</label>
        <div class="input-box">
          <svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 018 0v4"/></svg>
          <input type="password" id="confirm" placeholder="Confirm your password">
          <button type="button" class="eye-btn" data-target="confirm" aria-label="Show password">
            <svg viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-10-8-10-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 10 8 10 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><path d="M1 1l22 22"/></svg>
          </button>
        </div>
      </div>

      <!-- terms checkbox -->
      <div class="terms">
        <input type="checkbox" id="agree">
        <label for="agree">I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a></label>
      </div>

      <!-- no <a> around this button, register.js does the redirect after the account is saved -->
      <button type="submit" class="create-btn">Create Account <span class="arrow">&rarr;</span></button>
      <p class="error" id="errorMsg"></p>
    </form>

    <p class="signin-text">Already have an account? <a href="/checkmate/authentication/Login/login.php">Sign in</a></p>
  </div>

  <script src="/checkmate/asset/js/register.js"></script>

</body>
</html>