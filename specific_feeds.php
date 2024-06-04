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
            <h2>specific Feedback</h2>
            <br>

            <form method="post" action="specific_feeds_2.php">
                <?php
                if($department == 'Admin User'){
                    ?>
              <div id="table"> 
    
                  <div class="tr">
                    <div class="td">
                        <div class="form-group">
                             <label >Faculty</label>
                                <select name="faculty_id" required>
                                    <option value="NA">- -Select Faculty - -</option>
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
                    <label>Year : </label>
                </div>
                <div class="td">
                    <select name="year" required>
                        <option value="NA" disabled selected> - - Select Year - -</option>
                        <?php
                        $x = mysqli_prepare($al, "SELECT DISTINCT year FROM feeds  GROUP BY year ASC");
                        mysqli_stmt_execute($x);
                        mysqli_stmt_bind_result($x, $year);

                        while (mysqli_stmt_fetch($x)) {
                            ?>
                            <option value="<?php echo htmlspecialchars($year); ?>"><?php echo htmlspecialchars($year); ?></option>
                            <?php
                        }

                        mysqli_stmt_close($x);
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="tr">
                <div class="td">
                    <label>Academic Year : </label>
                </div>
                <div class="td">
                    <select name="academic_year" required>
                        <option value="NA" disabled selected> - - Select Academic Year - -</option>
                        <?php
                        $x = mysqli_prepare($al, "SELECT DISTINCT academic_year FROM feeds  GROUP BY academic_year ASC");
                        mysqli_stmt_execute($x);
                        mysqli_stmt_bind_result($x, $academic_year);

                        while (mysqli_stmt_fetch($x)) {
                            ?>
                            <option value="<?php echo htmlspecialchars($academic_year); ?>"><?php echo htmlspecialchars($academic_year); ?></option>
                            <?php
                        }

                        mysqli_stmt_close($x);
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="tr">
                <div class="td">
                    <label>Semester : </label>
                </div>
                <div class="td">
                    <select name="semester" required>
                        <option value="NA" disabled selected> - - Select Semester - -</option>
                        <?php
                        $x = mysqli_prepare($al, "SELECT DISTINCT semester FROM feeds  GROUP BY semester ASC");
                        mysqli_stmt_execute($x);
                        mysqli_stmt_bind_result($x, $semester);

                        while (mysqli_stmt_fetch($x)) {
                            ?>
                            <option value="<?php echo htmlspecialchars($semester); ?>"><?php echo htmlspecialchars($semester); ?></option>
                            <?php
                        }

                        mysqli_stmt_close($x);
                        ?>
                    </select>
                </div>
            </div>
<br>
            <div class="tr">
                <div class="td">
                    <label>Division : </label>
                </div>
                <div class="td">
                    <select name="division" required>
                        <option value="NA" disabled selected> - - Select Division - -</option>
                        <?php
                        $x = mysqli_prepare($al, "SELECT DISTINCT division FROM feeds  GROUP BY division ASC");
                        mysqli_stmt_execute($x);
                        mysqli_stmt_bind_result($x, $division);

                        while (mysqli_stmt_fetch($x)) {
                            ?>
                            <option value="<?php echo htmlspecialchars($division); ?>"><?php echo htmlspecialchars($division); ?></option>
                            <?php
                        }

                        mysqli_stmt_close($x);
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
       <div class="tr">
                <div class="td">
                    <div class="form-group">
                             <label >Faculty : </label>
                                <select name="faculty_id" required>
                                    <option value="NA"disabled selected>- -Select Faculty - -</option>
                                    <?php
                                    $x = mysqli_prepare($al, "SELECT DISTINCT faculty_id, name FROM feeds WHERE department = ? GROUP BY faculty_id");
                                    mysqli_stmt_bind_param($x, "s", $department);
                                    mysqli_stmt_execute($x);
                                    mysqli_stmt_bind_result($x, $faculty_id, $name);

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
                             <label >Year : </label>
                                <select name="year" required>
                                    <option value="NA" disabled selected>- -Select Faculty - -</option>
                                    <?php
                                        $x = mysqli_prepare($al, "SELECT DISTINCT year FROM feeds WHERE department = ? GROUP BY year ASC");
                                        mysqli_stmt_bind_param($x, "s", $department);
                                        mysqli_stmt_execute($x);
                                        mysqli_stmt_bind_result($x, $year);

                                        while (mysqli_stmt_fetch($x)) {
                                            ?>
                                            <option value="<?php echo htmlspecialchars($year); ?>"><?php echo htmlspecialchars($year); ?></option>
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
                             <label >Academic Year : </label>
                                <select name="academic_year" required>
                                    <option value="NA" disabled selected>- -Select Academic Year - -</option>
                                    <?php
                                        $x = mysqli_prepare($al, "SELECT DISTINCT academic_year FROM feeds WHERE department = ? GROUP BY academic_year ASC");
                                        mysqli_stmt_bind_param($x, "s", $department);
                                        mysqli_stmt_execute($x);
                                        mysqli_stmt_bind_result($x, $academic_year);

                                        while (mysqli_stmt_fetch($x)) {
                                            ?>
                                            <option value="<?php echo htmlspecialchars($academic_year); ?>"><?php echo htmlspecialchars($academic_year); ?></option>
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
                             <label >Semester : </label>
                                <select name="semester" required>
                                    <option value="NA" disabled selected>- -Select Semester - -</option>
                                    <?php
                                        $x = mysqli_prepare($al, "SELECT DISTINCT semester FROM feeds WHERE department = ? GROUP BY semester ASC");
                                        mysqli_stmt_bind_param($x, "s", $department);
                                        mysqli_stmt_execute($x);
                                        mysqli_stmt_bind_result($x, $semester);

                                        while (mysqli_stmt_fetch($x)) {
                                            ?>
                                            <option value="<?php echo htmlspecialchars($semester); ?>"><?php echo htmlspecialchars($semester); ?></option>
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
                             <label >Division : </label>
                                <select name="division" required>
                                    <option value="NA" disabled selected>- -Select Division - -</option>
                                    <?php
                                        $x = mysqli_prepare($al, "SELECT DISTINCT division FROM feeds WHERE department = ? GROUP BY division ASC");
                                        mysqli_stmt_bind_param($x, "s", $department);
                                        mysqli_stmt_execute($x);
                                        mysqli_stmt_bind_result($x, $division);

                                        while (mysqli_stmt_fetch($x)) {
                                            ?>
                                            <option value="<?php echo htmlspecialchars($division); ?>"><?php echo htmlspecialchars($division); ?></option>
                                            <?php
                                        }

                                        mysqli_stmt_close($x);
                                     ?>
                                </select>
                        </div>
                    </div>
                </div>
        <?php
            }
        ?>
        <br>
    <div class="tdd">
        <input type="button" class= "button1"  onClick="window.location='home.php'" value="BACK">&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" class= "button1" value="NEXT" />
    </div>
</form>

<br>
</div>
<script type="text/javascript">
        
        console.log('Department:', '<?php echo htmlspecialchars($department); ?>');
       
    </script>
</body>
</html>
