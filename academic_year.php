<?php
include("configASL.php");
session_start();
if (!isset($_SESSION['aid'])) {
    header("location:index_2.php");
}
$aid = $_SESSION['aid'];
$x = mysqli_query($al, "SELECT * FROM admin WHERE aid='$aid'");
$y = mysqli_fetch_array($x);
$department = $y['department'];

if (!empty($_POST)) {
    $academic_year = $_POST['academic_year'];
$semester = $_POST['semester'];
$aid = '1';
// Update admin record in the database
$stmt = mysqli_prepare($al, "UPDATE admin SET department = ?, password = ? WHERE aid = ?");
mysqli_stmt_bind_param($stmt, "sss", $academic_year, $semester, $aid);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    echo "<script type='application/javascript'>alert('Successfully updated');</script>";
} else {
    echo "<script type='application/javascript'>alert('Failed to update record');</script>";
}

    
}
?>
<!doctype html>
<html>
<!-- Designed & Developed by Ashish Labade (Tech Vegan) www.ashishvegan.com | Not for Commercial Use-->
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
    <br>
    <br>
    <br>
    <br>

    <div id="content" align="center">
        <br>
        <br>
        <span class="SubHead">Add Faculty</span>
        <br>
        <br>
        <form method="post" action="">
            <div id="table">
                <div class="tr">
    <div class="td">
        
    
    <div class="form-group">
    <label>Academic Year  </label>
        <select name="academic_year" required>
            <option value="">Select Academic Year</option>
            <?php
            $currentYear = date('Y');
            for ($i = $currentYear; $i <= $currentYear + 10; $i++) {
                $year = ($i-1) . '-' . $i;
                echo "<option value='$year'>$year</option>";
            }
            ?>
        </select>
    </div></div>
</div><br>
<div class="tr">
    <div class="td">
       
    
    <div class="form-group">
    <label>Semester </label>
        <select name="semester" required>
    <option value="">Select Semester</option>
    <option value="1">1</option>
    <option value="2">2</option>
</select>
    </div></div>
</div><br>
            </div>

            <div class="tdd">
            <input type="button" class="button1" onClick="window.location='home.php'" value="BACK">
                <input type="submit"  class="button1" value="SUBMIT"/>
            </div>
        </form>

        <br>
        <br>
        <span class="SubHead">Current Set Academic Year and Semester</span>
        <br>
        <br>
        <table border="0" cellpadding="3" cellspacing="3" >
            <tr style="font-weight:bold;">
                <td style="color:white;">Academic Year </td>
                <td style="color:white;">Semester</td>
            </tr>
            <?php
            
            $adminRecords = mysqli_query($al, "SELECT * FROM admin where aid='1'");
            while ($row = mysqli_fetch_array($adminRecords)) {
                ?>
                <tr>
                    
                    <td><?php echo $row['department']; ?></td>
                    <td><?php echo $row['password']; ?></td>
                    
                </tr>
            <?php } ?>
        </table>
        
        <br>
        
        <br>
        <br>
    </div>
</div>
            
</body>
</html>
