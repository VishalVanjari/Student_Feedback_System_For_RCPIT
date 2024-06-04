<?php
include "configASL.php";
session_start();

$department = "";
$year = "";

$division = "";
$academicYear = "";
$semester = "";

$query = mysqli_query($al, "SELECT department, password FROM admin WHERE aid='1'");
$row = mysqli_fetch_array($query);
if ($row) {
    $academic_year = $row['department'];
    $semester = $row['password'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $academic_year = $_GET['academic_year'];
$semester = $_GET['semester'];
$department = $_POST['department'];
$year = $_POST['year'];
$division = $_POST['division'];

}

function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}
?>

<!doctype html>
<html>
<!-- Designed & Developed by Ashish Labade (Tech Vegan) www.ashishvegan.com | Not for Commercial Use-->
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
        <!-- <h2>Student Feedback Step I</h2> -->
        <form method="POST" action="feedback_step_2.php">
        
        <div id="table">
                <div class="tr">
                    <div class="td">
                        <label>Academic Year</label>
                    </div>
                  <div class="field">
                    <input type="text" class="input-field" name="academic_year" value="<?php echo htmlspecialchars($academic_year, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                 </div>
                </div>
                <br>
                <div class="tr">
                    <div class="td">
                        <label>Semester</label>
                    </div>
                  <div class="field">
                    <input type="text" class="input-field" name="semester" value="<?php echo htmlspecialchars($semester, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                 </div>
                </div>
                <br>
                <div class="tr">
                    <div class="td">
                        <div class="form-group">
                             <label >Department :</label>
                                <select name="department" id="department" required>
                                    <option value="">- - Department - -</option>
                                        <?php
                                        $departments = array();
                                        $stmt = mysqli_prepare($al, "SELECT DISTINCT department FROM faculty ORDER BY department ASC");
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_bind_result($stmt, $dept);
                                        while (mysqli_stmt_fetch($stmt)) {
                                            $departments[] = $dept;
                                        }
                                        mysqli_stmt_close($stmt);
                                        foreach ($departments as $dept) {
                                            echo '<option value="' . htmlspecialchars($dept, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($dept, ENT_QUOTES, 'UTF-8') . '</option>';
                                        }
                                        ?>
                                </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="tr">
                    <div class="td">
                      <div class="form-group">
                          <label for="year">Year :</label>
                                <select name="year" required>
                                    <option value="">- - Year - -</option>
                                        <?php
                                        $years = array();
                                        $stmt = mysqli_prepare($al, "SELECT DISTINCT year FROM faculty ORDER BY year ASC");
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_bind_result($stmt, $yr);
                                        while (mysqli_stmt_fetch($stmt)) {
                                            $years[] = $yr;
                                        }
                                        mysqli_stmt_close($stmt);
                                        foreach ($years as $yr) {
                                            echo '<option value="' . htmlspecialchars($yr, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($yr, ENT_QUOTES, 'UTF-8') . '</option>';
                                        }
                                        ?>
                                 </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="tr">
                    <div class="td">
                        <div class="form-group">
                            <label>Division :</label>
                                <select name="division" required>
                                    <option value="">- - Division - -</option>
                                        <?php
                                        $divisions = array();
                                        $stmt = mysqli_prepare($al, "SELECT DISTINCT division FROM faculty ORDER BY division ASC");
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_bind_result($stmt, $div);
                                        while (mysqli_stmt_fetch($stmt)) {
                                            $divisions[] = $div;
                                        }
                                        mysqli_stmt_close($stmt);
                                        foreach ($divisions as $div) {
                                            echo '<option value="' . htmlspecialchars($div, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($div, ENT_QUOTES, 'UTF-8') . '</option>';
                                        }
                                        ?>
                              </select>
                        </div>
                    </div>
                </div>
                <br>

            <div class="tdd">
                <input type="button" class = "button1" onClick="window.location='index.php'" value="BACK">&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" class = "button1" value="NEXT" />
            </div>
        </form>
    </div>
</section>
</body>
</html>
