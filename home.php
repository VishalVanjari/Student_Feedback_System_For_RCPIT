<?php
include("configASL.php");
session_start();
if (!isset($_SESSION['aid'])) {
    header("location:index_2.php");
    exit(); // Stop further execution
}

$aid = $_SESSION['aid'];
$query = "SELECT * FROM admin WHERE aid=?";
$stmt = mysqli_prepare($al, $query);
mysqli_stmt_bind_param($stmt, "s", $aid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$y = mysqli_fetch_array($result);
$department = htmlspecialchars($y['department']);
?>

<!doctype html>
<html>
<!-- Designed & Developed by Ashish Labade (Tech Vegan) www.ashishvegan.com | Not for Commercial Use -->
<head>
    <meta charset="utf-8">
    <title>Student Feedback System</title>
    <link href="style.css" rel="stylesheet" type="text/css"/>
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
      
                <div class="ag-format-container">
                <div class="ag-courses_box">
                    <div class="ag-courses_item">
                    <a href="feeds.php" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>
                        <div class="ag-courses-item_title">
                        Overall Feedback
                        </div>
                    </a>
                    </div>

                    <div class="ag-courses_item">
                    <a href="specific_feeds.php" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>
                        <div class="ag-courses-item_title">
                        Specific Feedback
                        </div>
                    </a>
                    </div>

                    <?php
                        if($department == 'Admin User'){
                    ?>
                    <div class="ag-courses_item">
                    <a href="add_department.php" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>
                        <div class="ag-courses-item_title">
                        Add Department
                        </div>
                    </a>
                    </div>
                    <div class="ag-courses_item">
                    <a href="academic_year.php" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>
                        <div class="ag-courses-item_title">
                        Academic Year
                        </div>
                    </a>
                    </div>
                    <?php
                        }else{
                    ?>

                    <div class="ag-courses_item">
                    <a href="manageFaculty.php" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>
                        <div class="ag-courses-item_title">
                        Manage Faculty
                        </div>
                        </a>
                    </div>

                    <div class="ag-courses_item">
                    <a href="add_teacher.php" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>
                        <div class="ag-courses-item_title">
                            Add Faculty
                        </div>
                    </a>
                    </div>
                    <?php
                        } 
                        ?>
                    <div class="ag-courses_item">
                         <a href="changePass.php"  class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>
                        <div class="ag-courses-item_title">
                            Change Password
                        </div>
                    </a>
                    </div>

                    <div class="ag-courses_item">
                         <a href="logout.php"  class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>
                        <div class="ag-courses-item_title">
                        Logout
                        </div>
                    </a>
                    </div>
             </div>
    </section>
</body>
</html>
