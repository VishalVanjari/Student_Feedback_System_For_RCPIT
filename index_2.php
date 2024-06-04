<?php
include("configASL.php");
session_start();

if (isset($_SESSION['aid'])) {
    header("location:home.php");
    exit();
}

if (!empty($_POST)) {
    $aid = mysqli_real_escape_string($al, $_POST['aid']);
   $pass = mysqli_real_escape_string($al, $_POST['pass']); //department login
   //$pass = mysqli_real_escape_string($al, sha1($_POST['pass'])); // admin login

    $stmt = mysqli_prepare($al, "SELECT * FROM admin WHERE aid = ? AND password = ?");
    mysqli_stmt_bind_param($stmt, "ss", $aid, $pass);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['aid'] = $_POST['aid'];
        header("location:home.php");
        exit();
    } else {
        $error_message = "Incorrect Admin ID or Password";
    }
}
?>
<!doctype html>
<html lang="en">
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
    <br><br><br><br>
    <div id="content" align="center">
        <h2>Admin Login</h2><br>
        <form method="post" action="">
            <div id="table">
                <div class="tr">
                    <div class="td">
                        <label for="aid">Admin ID :</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input-field" name="aid" id="aid" size="25" required>
                    </div>
                </div><br>
                <div class="tr">
                    <div class="td">
                        <label for="pass">Password : </label>
                    </div>
                    <div class="field">
                        <input type="password" class="input-field" name="pass" id="pass" size="25" required>
                    </div>
                </div>
            </div><br>
            <div class="tdd">
                <input type="button" class="button1" onClick="window.location='index.php'" value="BACK">
                <input type="submit" class="button1" value="Login" />
            </div><br>
            <?php if (isset($error_message)): ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </form>
    </div>
</section>
</body>
</html>
