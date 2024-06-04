<?php
include "configASL.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name'])) {
        $selectedFaculty = explode('-', $_POST['name']);
       // $faculty_name = sanitizeInput($selectedFaculty[1]);
        $faculty_id = sanitizeInput($selectedFaculty[0]);

        $result = mysqli_query($al, "SELECT t_image,t_name FROM add_teacher WHERE t_id='$faculty_id'");
        $row = mysqli_fetch_array($result);
        $faculty_name = $row['t_name'];
        $faculty_image = $row['t_image'];
    }
}
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    // Now you have the $id_from_step_2 available for use in this step  
} 

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


// Accessing department, year, semester, and division from the session

$department = sanitizeInput($_SESSION['department']);
$year = sanitizeInput($_SESSION['year']);
$semester = sanitizeInput($_SESSION['semester']);
$division = sanitizeInput($_SESSION['division']);
$academic_year = sanitizeInput($_SESSION['academic_year']);
?>

<!doctype html>
<html>
<!-- Designed & Developed by Ashish Labade (Tech Vegan) www.ashishvegan.com | Not for Commercial Use-->
<head>
    <meta charset="utf-8">
    <title>Student Feedback System</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    

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
        
        <h2>Step IV</h2>
        <form method="post" action="feedback_step_5.php">
            <div id = "faculty-details">
            <div id="table">
            <div class="tr">
                    <div class="td">
                        <div class="form-grp">
                             <label>Faculty Image </label>
                             
                             <div class="td">
                        <?php
                        if (!empty($faculty_image) && file_exists('teacher_images/' . $faculty_image)) {
                            echo '<img src="teacher_images/' . htmlspecialchars($faculty_image) . '" alt="Faculty Image" width="50" height="50" />';
                        } else {
                            echo 'No Image';
                        }
                        ?>
                    </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <div class="tr">
                    <div class="td">
                        <div class="form-grp">
                          
                             
                                <input type="hidden" class="input-field" disabled size="25" value="<?php echo htmlspecialchars($faculty_id); ?>" />
                                <input type="hidden" class="input-field" value="<?php echo htmlspecialchars($faculty_id); ?>" name="faculty_id" />
                              
                        </div>
                    </div>
                </div>

                <div class="tr">
                    <div class="td">
                        <div class="form-grp">
                             <label >Faculty Name </label>
                             <div class="field">
                             <input type="text" class="input-field" disabled  value="<?php echo htmlspecialchars($faculty_name); ?>" readonly />
                             <input type="hidden" class="input-field" value="<?php echo htmlspecialchars($faculty_name); ?>" name="faculty_name" />
                              </div>
                        </div>
                    </div>
                </div>

                <div class="tr">
                    <div class="td">
                        <div class="form-grp">
                             <label >Faculty Subject </label>
                             <?php
                                    // Fetch the faculty subject from the faculty table
                                    $facultySubjectQuery = mysqli_prepare($al, "SELECT subject FROM faculty WHERE faculty_id = ? AND department = ? AND year = ? AND semester = ? AND division = ? AND academic_year = ? AND id=?");
                                    mysqli_stmt_bind_param($facultySubjectQuery, "sssssss", $faculty_id, $department, $year, $semester, $division, $academic_year,$id);
                                    mysqli_stmt_execute($facultySubjectQuery);
                                    mysqli_stmt_bind_result($facultySubjectQuery, $faculty_subject);
                                    mysqli_stmt_fetch($facultySubjectQuery);
                                    mysqli_stmt_close($facultySubjectQuery);
                                    
                                    $faculty_subject = sanitizeInput($faculty_subject);
                                ?>
                                    <div class="field">
                                        <input type="text" class="input-field" disabled size="25" value="<?php echo htmlspecialchars($faculty_subject); ?>" />
                                        <input type="hidden" value="<?php echo htmlspecialchars($faculty_subject); ?>" name="subject" />
                                    </div>
                        </div>
                    </div>
                </div>

                
         </div>
    </div>
            <hr style="width:100%;">

            <?php
            for ($i = 1; $i <= 14; $i++) {
                // Fetch Questions for ID $i
                $questionResult = mysqli_query($al, "SELECT * FROM questions WHERE id = '$i'");
                $question = mysqli_fetch_assoc($questionResult);

                ?>
                <div class="tddd">
                    <span class="text"><?php echo $i; ?>. <?php echo $question['questions']; ?> : <br><br>
                        <?php
                        $optionsResult = mysqli_query($al, "SELECT * FROM options WHERE id = '$i'");
                        $options = mysqli_fetch_assoc($optionsResult);
                        
                        // Display all option values
                        for ($j = 1; $j <= 3; $j++) {
                            $optionValue = $options['opt' . $j];
                            ?>
                            <label class="option">
                                <input type="radio" required value="<?php echo $j; ?>" name="q<?php echo $i; ?>" />
                                <?php echo $optionValue; ?>
                            </label>
                        <?php } ?>
                    </span>
                </div>
                <hr style="width:100%;">
            <?php } ?>

            <input type="button" class = "button1" onClick="window.location='feedback_step_2.php'" value="BACK">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" class = "button1" value="SUBMIT" onClick="return confirm('Are you sure?')" />
        </form>
        <br>
        <br>
    </div>
    <script type="text/javascript">
        console.log('ID:', '<?php echo htmlspecialchars($id); ?>');
        console.log('Faculty ID:', '<?php echo htmlspecialchars($faculty_id); ?>');
        console.log('Faculty Name:', '<?php echo htmlspecialchars($faculty_name); ?>');
        console.log('Department:', '<?php echo htmlspecialchars($department); ?>');
        console.log('Semester:', '<?php echo htmlspecialchars($semester); ?>');
        console.log('Year:', '<?php echo htmlspecialchars($year); ?>');
        console.log('Academic:', '<?php echo htmlspecialchars($academic_year); ?>');
        console.log('division:', '<?php echo htmlspecialchars($division); ?>');
    </script>
</body>
</html>
