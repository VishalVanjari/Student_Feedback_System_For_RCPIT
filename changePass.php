<?php
include("configASL.php");
session_start();
if (!isset($_SESSION['aid'])) {
    header("location:index_2.php");
    exit;
}

$aid = $_SESSION['aid'];
$stmt = mysqli_prepare($al, "SELECT * FROM admin WHERE aid=?");
mysqli_stmt_bind_param($stmt, "s", $aid);
mysqli_stmt_execute($stmt);
$admin = mysqli_stmt_get_result($stmt)->fetch_assoc();

if (empty($admin)) {
    header("location:index_2.php");
    exit;
}

$oldPassword = $admin['password'];

if (!empty($_POST)) {
    $p1 = $_POST['p1'];
    $p2 = $_POST['p2'];
    $p3 = $_POST['p3'];

    // Password criteria
    $minLength = 8; // Minimum password length
    $complexityPattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).*$/'; // Complex password pattern

    if ($oldPassword !== $p1) {
        $errorMessage = "Incorrect old password";
    } elseif ($p2 !== $p3) {
        $errorMessage = "New password and confirm password do not match";
    } elseif (strlen($p2) < $minLength) {
        $errorMessage = "New password must be at least $minLength characters long";
    } elseif (!preg_match($complexityPattern, $p2)) {
        $errorMessage = "New password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character";
    } else {
        $stmt = mysqli_prepare($al, "UPDATE admin SET password=? WHERE aid=?");
        mysqli_stmt_bind_param($stmt, "ss", $p2, $aid);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $successMessage = "Successfully changed password";
        } else {
            $errorMessage = "Failed to change password";
        }
    }
}
?>

<!doctype html>
<html>
<!-- Designed & Developed by Ashish Labade (Tech Vegan) www.ashishvegan.com | Not for Commercial Use -->
<head>
    <meta charset="utf-8">
    <title>Student Feedback System</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<section id="intro">
<div class="nav-container">
<div class="logo">
                <img class="rcpitlogo" src="footerlogo.png" alt="Logo">
            </div>
            <h2>R. C. Patel Institute of Technology</h2>
            <br><br>
            <br><br>
            <span>STUDENT FEEDBACK SYSTEM</span>
        </div>
    <br>
    <br>
    <br>
    <br>

    <div id="content" align="center">
        <h2>change  Password</h2><br>
        <form method="post" action="" enctype="multipart/form-data">
            <div id="table">
            <div class="tr">
                    <div class="td">
                         <label>Old Password</label>
                     </div>
                    <div class="field">
                        <input type="password" class="input-field" name="p1" size="25" required placeholder="Enter Old Password">
                    </div>
            </div>
            <br>

            <div class="tr">
                    <div class="td">
                         <label>New Password</label>
                     </div>
                    <div class="field">
                        <input type="password" class="input-field" name="p2" size="25" required placeholder="Enter New Password" />
                    </div>
            </div>
            <br>

            <div class="tr">
                    <div class="td">
                         <label>Confirm Password</label>
                     </div>
                    <div class="field">
                        <input type="password" class="input-field" name="p3" size="25" required placeholder="Confirm New Password" />
                    </div>
            </div>
            <br>
            <?php if (!empty($_POST) && isset($errorMessage)) : ?>
                    <div class="tr">
                        <div class="td"></div>
                        <div class="td" style="color: red;">
                            <?php echo $errorMessage; ?>
                        </div>
                    </div>
                <?php elseif (!empty($_POST) && isset($successMessage)) : ?>
                    <div class="tr">
                        <div class="td"></div>
                        <div class="td" style="color: green;">
                            <?php echo $successMessage; ?>
                        </div>
                    </div>
                <?php endif; ?>
               
            </div><br>
            <div class="tdd">
                <input type="submit" class="button1" value="CHANGE PASSWORD" />
            </div>
        </form>
        <br>
        
        <input type="button" class="button1" onClick="window.location='home.php'" value="BACK">
        <br>
        <br>
    </div>
</section>
</body>
</html>
