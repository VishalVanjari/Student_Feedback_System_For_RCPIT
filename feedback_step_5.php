<?php
include "configASL.php";
session_start();

if (!empty($_POST)) {
    $id = sanitizeInput($_POST['id']);
    $faculty_id = sanitizeInput($_POST['faculty_id']);
    $q1 = sanitizeInput($_POST['q1']);
    $q2 = sanitizeInput($_POST['q2']);
    $q3 = sanitizeInput($_POST['q3']);
    $q4 = sanitizeInput($_POST['q4']);
    $q5 = sanitizeInput($_POST['q5']);
    $q6 = sanitizeInput($_POST['q6']);
    $q7 = sanitizeInput($_POST['q7']);
    $q8 = sanitizeInput($_POST['q8']);
    $q9 = sanitizeInput($_POST['q9']);
    $q10 = sanitizeInput($_POST['q10']);
    $q11 = sanitizeInput($_POST['q11']);
    $q12 = sanitizeInput($_POST['q12']);
    $q13 = sanitizeInput($_POST['q13']);
    $q14 = sanitizeInput($_POST['q14']);
    $total = $q1 + $q2 + $q3 + $q4 + $q5 + $q6 + $q7 + $q8 + $q9 + $q10 + $q11 + $q12 + $q13 + $q14;
    $per = ($total / 70) * 100;

    // Fetch faculty name from add_teacher table
    $facultyQuery = mysqli_prepare($al, "SELECT t_name, t_department FROM add_teacher WHERE t_id = ?");
    mysqli_stmt_bind_param($facultyQuery, "s", $faculty_id);
    mysqli_stmt_execute($facultyQuery);
    mysqli_stmt_bind_result($facultyQuery, $faculty_name, $faculty_department);
    mysqli_stmt_fetch($facultyQuery);
    mysqli_stmt_close($facultyQuery);
    $department = sanitizeInput($_SESSION['department']);
    $year = sanitizeInput($_SESSION['year']);
    $semester = sanitizeInput($_SESSION['semester']);
    $division = sanitizeInput($_SESSION['division']);
    $academic_year = sanitizeInput($_SESSION['academic_year']);
    $x = mysqli_prepare($al, "INSERT INTO feeds (faculty_id, name, department,year,academic_year,semester,division, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, total, percent)
        VALUES (?, ?, ?,?,?,?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?,?,?,?,?)");
    mysqli_stmt_bind_param($x, "sssssssssssssssssssssss", $faculty_id, $faculty_name, $faculty_department,$year,$academic_year,$semester,$division, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10,$q11,$q12,$q13,$q14, $total, $per);
    mysqli_stmt_execute($x);
    mysqli_stmt_close($x);

    // if ($x == true) {
    //     ?>
    
     <?php
    // }
}


// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
<br>
<br>
<br>
<br>
<script type="text/javascript">
        console.log('Previous Faculty ID:', '<?php echo htmlspecialchars($faculty_id); ?>');
        console.log('Previous  ID:', '<?php echo htmlspecialchars($id); ?>');
    </script>
<div id="content" align="center">
<br>
<br>
<span class="SubHead">Student Feedback Step V</span>
<br>

<form method="POST" action="feedback_step_4.php">
    <div id="table">
        <!-- Displaying the department, year, semester, and division values -->
        
 <?php
        // Check if the faculty ID is the last entry in the database
$isLastID = false;
$result = mysqli_query($al, "SELECT id FROM faculty where department='$department' AND year='$year' AND semester='$semester' AND division='$division' AND academic_year='$academic_year' ORDER BY id DESC LIMIT 1");
$lastID = mysqli_fetch_array($result);
if ($id == $lastID['id']) {
    $isLastID = true;
}

//Set the appropriate form action based on faculty ID position
$formAction = $isLastID ? "index.php" : "feedback_step_4.php";
        if($isLastID)
{
    header("location:index.php");
    exit();
} ?>
        <!-- Rest of the form code -->

        <div class="tr">
            <div class="td">
                <label>Faculty:</label>
            </div>
            
            <div class="td">
            <select name="name" required>
                <option value=""> - - Select Faculty - -</option>
                <?php
                // Modify the SQL query to select only the name field
                $faculty_query = mysqli_query($al, "SELECT id,faculty_id, name FROM faculty WHERE department='$department' AND academic_year='$academic_year' AND semester='$semester' AND division='$division' AND year='$year' AND id > '$id' ORDER BY id ASC LIMIT 1");
                
                while ($faculty_data = mysqli_fetch_array($faculty_query)) {
                    $faculty_id = htmlspecialchars($faculty_data['faculty_id']);
                            $name = htmlspecialchars($faculty_data['name']);
                            $id = htmlspecialchars($faculty_data['id']);
                            $_SESSION['id'] = $id; 
                            echo "<option value='$faculty_id'>$name</option>";

                }

                ?>
            </select>
                <input type="hidden" name="faculty_id" value="">
            </div>
        </div>
    </div>
                <br>
    <div class="tdd">
        <input type="button" class = "button1" onClick="window.location='feedback_step_4.php'" value="BACK">&nbsp;&nbsp;&nbsp;&nbsp;
        
        <!-- <input type="button" onClick="window.location='exit.php'" value="EXIT">&nbsp;&nbsp;&nbsp;&nbsp; -->
        <input type="submit" class = "button1" value="NEXT" />
    </div>
</form>
<br>
</div>
<script type="text/javascript">
        console.log('Faculty ID:', '<?php echo htmlspecialchars($faculty_id); ?>');
        console.log('Faculty Name:', '<?php echo htmlspecialchars($faculty_name); ?>');
        console.log('Faculty Subject:', '<?php echo htmlspecialchars($subject); ?>');
         console.log('Department:', '<?php echo htmlspecialchars($department); ?>');
        console.log('Semester:', '<?php echo htmlspecialchars($semester); ?>');
        console.log('Year:', '<?php echo htmlspecialchars($year); ?>');
        console.log('AcaYear:', '<?php echo htmlspecialchars($academic_year); ?>');
        console.log('division:', '<?php echo htmlspecialchars($division); ?>');
    </script>
    </section>
</body>
</html>
