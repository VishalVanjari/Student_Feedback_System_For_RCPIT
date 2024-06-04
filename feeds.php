<?php
include("configASL.php");
session_start();
if (!isset($_SESSION['aid'])) {
    header("location:index_2.php");
    exit();
}

$aid = $_SESSION['aid'];
$x = mysqli_prepare($al, "SELECT department FROM admin WHERE aid = ?");
mysqli_stmt_bind_param($x, "s", $aid);
mysqli_stmt_execute($x);
mysqli_stmt_bind_result($x, $department);
mysqli_stmt_fetch($x);
mysqli_stmt_close($x);
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
    <br><br><br><br>

    <div id="content" align="center">
        <h2>Overall Feedback</h2>
        
        <br>
        <form method="post" action="feeds_2.php">
            <div id="table">
                <div class="tr">
                    <div class="td">
                        
                    
                    <div class="form-group">
                    <label>Faculty</label>
                        <select name="faculty_id" required>
                            <option value="NA" disabled selected> - - Select Faculty - -</option>
                            <?php
                            if ($department == 'Admin User') {
                                $x = mysqli_prepare($al, "SELECT DISTINCT faculty_id, name FROM feeds GROUP BY faculty_id");
                                mysqli_stmt_execute($x);
                                mysqli_stmt_bind_result($x, $faculty_id, $name);
                            } else {
                                $x = mysqli_prepare($al, "SELECT DISTINCT faculty_id, name FROM feeds WHERE department = ? GROUP BY faculty_id");
                                mysqli_stmt_bind_param($x, "s", $department);
                                mysqli_stmt_execute($x);
                                mysqli_stmt_bind_result($x, $faculty_id, $name);
                            }

                            while (mysqli_stmt_fetch($x)) {
                                ?>
                                <option value="<?php echo htmlspecialchars($faculty_id); ?>"><?php echo htmlspecialchars($name); ?></option>
                            <?php
                            }

                            mysqli_stmt_close($x);
                            ?>
                        </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="tr">
                    <div class="td">
                        
                    
                    <div class="form-group">
                    <label>Academic Year</label>
                        <select name="academic_year" required>
                            <option value="">- - Select Academic Year - -</option>
                            <?php
                            $academic_year = array();
                            $stmt = mysqli_prepare($al, "SELECT DISTINCT academic_year FROM feeds ORDER BY academic_year ASC");
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $year);
                            while (mysqli_stmt_fetch($stmt)) {
                                $academic_year[] = $year;
                            }
                            mysqli_stmt_close($stmt);
                            foreach ($academic_year as $year) {
                                echo '<option value="' . htmlspecialchars($year, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($year, ENT_QUOTES, 'UTF-8') . '</option>';
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
                    <label>Semester</label>
                        <select name="semester" required>
                            <option form-group value="">- - Select Semester - -</option>
                            <?php
                            $semester = array();
                            $stmt = mysqli_prepare($al, "SELECT DISTINCT semester FROM feeds ORDER BY semester ASC");
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $sem);
                            while (mysqli_stmt_fetch($stmt)) {
                                $semester[] = $sem;
                            }
                            mysqli_stmt_close($stmt);
                            foreach ($semester as $sem) {
                                echo '<option value="' . htmlspecialchars($sem, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($sem, ENT_QUOTES, 'UTF-8') . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="tdd">
                <input type="button" class = "button1" onClick="window.location='home.php'" value="BACK">&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" class = "button1" value="NEXT" />
            </div>
        </form>

    </div>
</section>
</body>
</html>
