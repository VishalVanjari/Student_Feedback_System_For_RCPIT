<?php
include "configASL.php";
session_start();

$department = $year = $semester = $division = $academic_year="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['department'])) {
        $_SESSION['department'] = validateInput($_POST['department']);
        $department = $_SESSION['department'];
    }

    if (isset($_POST['year'])) {
        $_SESSION['year'] = validateInput($_POST['year']);
        $year = $_SESSION['year'];
    }

    if (isset($_POST['semester'])) {
        $_SESSION['semester'] = validateInput($_POST['semester']);
        $semester = $_SESSION['semester'];
    }

    if (isset($_POST['division'])) {
        $_SESSION['division'] = validateInput($_POST['division']);
        $division = $_SESSION['division'];
    }

    if (isset($_POST['academic_year'])) {
        $_SESSION['academic_year'] = validateInput($_POST['academic_year']);
        $academic_year = $_SESSION['academic_year'];
    }
}

function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

$existingFaculty = mysqli_query($al, "SELECT * FROM faculty WHERE department='$department' 
                                           AND year='$year' AND semester='$semester' 
                                           AND division='$division' AND academic_year='$academic_year'");

if (mysqli_num_rows($existingFaculty) == 0) {
    // No faculty record exists, display alert and navigate back to feedback.php
    echo "<script>alert('No faculty record found with the specified values.');</script>";
    echo "<script>window.location.href = 'feedback.php';</script>";
    exit;
}




$faculty_ids = array(); // Initialize an empty array to store faculty IDs

// $faculty_query = mysqli_query($al, "SELECT faculty_id, name, subject FROM faculty WHERE department='$department' AND year='$year' AND semester='$semester' AND division='$division' AND academic_year='$academic_year' ORDER BY faculty_id ASC");

// while ($faculty_data = mysqli_fetch_array($faculty_query)) {
//     $faculty_id = htmlspecialchars($faculty_data['faculty_id']);
//     $name = htmlspecialchars($faculty_data['name']);
//     $subject = htmlspecialchars($faculty_data['subject']);
//     // Store faculty IDs in the array
//     $faculty_ids[] = $faculty_id;
// }
// echo "Faculty IDs: " . implode(', ', $faculty_ids);

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
        <h2>Student Feedback Step II</h2>
        <br>
        <form method="POST" action="feedback_step_4.php">
            <div id="table">
                <!-- <div class="tr">
                    <div class="td">
                        <label>Department:</label>
                    </div>
                    <div class="td">
                        <select name="department" required disabled>
                            <option value="">- - Department - -</option>
                            <?php
                            $department_query = mysqli_query($al, "SELECT DISTINCT department FROM faculty");
                            while ($department_data = mysqli_fetch_array($department_query)) {
                                $dept = htmlspecialchars($department_data['department']);
                                $selected = ($dept === $department) ? 'selected' : '';
                                echo "<option value='$dept' $selected>$dept</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div> -->

                <!-- <div class="tr">
                    <div class="td">
                        <label>Year:</label>
                    </div>
                    <div class="td">
                        <select name="year" required disabled>
                            <option value="">- - Year - -</option>
                            <?php
                            $year_query = mysqli_query($al, "SELECT DISTINCT year FROM faculty");
                            while ($year_data = mysqli_fetch_array($year_query)) {
                                $yr = htmlspecialchars($year_data['year']);
                                $selected = ($yr === $year) ? 'selected' : '';
                                echo "<option value='$yr' $selected>$yr</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div> -->

                <!-- <div class="tr">
                    <div class="td">
                        <label>Semester:</label>
                    </div>
                    <div class="td">
                        <select name="semester" required disabled>
                            <option value="">- - Semester - -</option>
                            <?php
                            $semester_query = mysqli_query($al, "SELECT DISTINCT semester FROM faculty");
                            while ($semester_data = mysqli_fetch_array($semester_query)) {
                                $sem = htmlspecialchars($semester_data['semester']);
                                $selected = ($sem === $semester) ? 'selected' : '';
                                echo "<option value='$sem' $selected>$sem</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div> -->

                <!-- <div class="tr">
                    <div class="td">
                        <label>Division:</label>
                    </div>
                    <div class="td">
                        <select name="division" required disabled>
                            <option value="">- - Division - -</option>
                            <?php
                            $division_query = mysqli_query($al, "SELECT DISTINCT division FROM faculty");
                            while ($division_data = mysqli_fetch_array($division_query)) {
                                $div = htmlspecialchars($division_data['division']);
                                $selected = ($div === $division) ? 'selected' : '';
                                echo "<option value='$div' $selected>$div</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div> -->

                <div class="tr">
                    <div class="td">
                        <label>Faculty</label>
                    </div>
                    <div class="td">
                    <select name="name" required>
                        <option value="">- - Select Faculty - -</option>
                        <?php
                        $faculty_query = mysqli_query($al, "SELECT id,faculty_id, name FROM faculty WHERE department='$department' AND year='$year' AND semester='$semester' AND division='$division' AND academic_year='$academic_year' ORDER BY id ASC LIMIT 1");

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
                <input type="button" class = "button1" onClick="window.location='feedback.php'" value="BACK">
                <input type="button" class = "button1" onClick="window.location='exit.php'" value="EXIT">
                <input type="submit" class = "button1" value="NEXT">
            </div>
        </form>
        <br>
    </div>
    <script type="text/javascript">
        console.log('faculty id :', '<?php echo htmlspecialchars($faculty_id); ?>');
        console.log('id :', '<?php echo htmlspecialchars($id); ?>');
        console.log('Name :', '<?php echo htmlspecialchars($name); ?>');
        console.log('Academic Year :', '<?php echo htmlspecialchars($academic_year); ?>');
        console.log('Semester :', '<?php echo htmlspecialchars($semester); ?>');
        console.log('Department :', '<?php echo htmlspecialchars($department); ?>');
        console.log('Year:', '<?php echo htmlspecialchars($year); ?>');
        console.log('division:', '<?php echo htmlspecialchars($division); ?>');
    </script>
</section>
</body>
</html>
