
<?php
include("configASL.php");
session_start();
if(!isset($_SESSION['aid'])) {
    header("location:index_2.php");
}
$aid=$_SESSION['aid'];
$x=mysqli_query($al,"select * from admin where aid='$aid'");
$y=mysqli_fetch_array($x);
$department=$y['department'];

if(!empty($_POST)) {
    $fc=$_POST['fc'];
    $department=$_POST['department'];
    $year=$_POST['year'];
    $sem=$_POST['sem'];
    $sub=$_POST['sub'];
    $academic_year = $_POST['academic_year'];

    $divisions = array();
    if ($department == 'Computer' || $department == 'FY-Comp') {
        if (isset($_POST['divA'])) {
            $divisions[] = 'A';
        }

        if (isset($_POST['divB'])) {
            $divisions[] = 'B';
        }

        if (isset($_POST['divC'])) {
            $divisions[] = 'C';
        }
    } elseif ($department == 'ENTC' || $department == 'Mechanical' || $department == 'FY-Entc' || $department == 'FY-Mech') {
        if (isset($_POST['divA'])) {
            $divisions[] = 'A';
        }

        if (isset($_POST['divB'])) {
            $divisions[] = 'B';
        }
    } else {
        if (isset($_POST['div'])) {
            $divisions[] = 'A';
        }
    }

    // Insert each division separately into the database
    foreach ($divisions as $division) {
        $query = mysqli_query($al, "SELECT t_id FROM add_teacher WHERE t_name='$fc' AND t_department='$department'");
        $row = mysqli_fetch_array($query);
        $faculty_id = $row['t_id'];

        $existingRecord = mysqli_query($al, "SELECT * FROM faculty WHERE faculty_id='$faculty_id' 
                                      AND name='$fc' AND department='$department' 
                                      AND year='$year' AND semester='$sem' 
                                      AND subject='$sub' AND division='$division' AND academic_year='$academic_year'");

if(mysqli_num_rows($existingRecord) == 0) {
    $u = mysqli_query($al, "INSERT INTO faculty(faculty_id, name, department, year,academic_year, semester, subject, division) 
                            VALUES ('$faculty_id', '$fc', '$department', '$year', '$academic_year','$sem', '$sub', '$division')");
}

    }

    if ($u) {
        echo "<script type='application/javascript'>alert('Successfully added');</script>";
    }else{
        echo "<script type='application/javascript'>alert('Record Already Present');</script>";
    }
}   
?>
<!doctype html>
<html><!-- Designed & Developed by Ashish Labade (Tech Vegan) www.ashishvegan.com | Not for Commercial Use-->
<head>
<meta charset="utf-8">
<title>Student Feedback System</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="full-background">


    <section id="intro">
<div class="nav-container">
            <div class="logo">
                <img src="rcpit.png" alt="Logo">
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

<h2>ADD FACULTY</h2><br>

<form method="post" action="" >
<div id="table">
    <div class="tr">
            <div class="td">
                
           
            <div class="form-group">
            <label>Faculty : </label>
                <select name="fc" required>
                    <option value="" disabled selected> - - Select Faculty - -</option>
                    <?php
                    $query = mysqli_query($al, "SELECT t_name, t_id FROM add_teacher WHERE t_department='$department'");
                    while ($row = mysqli_fetch_array($query)) {
                        $facultyName = $row['t_name'];
                        $faculty_id = $row['t_id'];
                        ?>
                        <option value="<?php echo $facultyName; ?>"><?php echo $facultyName; ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>
        </div><br>
<div class="tr">
    <div class="td">
       
    
    <div class="form-group">
    <label>Department : </label>
    <div class="field">

   
        <input type="text" name="department" size="25" required placeholder="Enter Department" value="<?php echo $department; ?>" readonly />
    </div>
    </div>
    </div>
</div><br>
    <!-- <div class="tr">
        <div class="td">
            <label>Department : </label>
        </div>
        <div class="td">
            <input type="text" name="department" size="25" required placeholder="Enter Department" />
        </div>
    </div> -->
<div class="tr">
    <div class="td">
        
    
    <div class="form-group">
    <label>Year : </label>
        <select name="year" required onchange="updateSemesterOptions(this.value)">
            <option value="">Select Year</option>
            <option value="FY">FY</option>
            <option value="SY">SY</option>
            <option value="TY">TY</option>
            <option value="B.Tech">B.Tech</option>
        </select>
    </div>
    </div>
</div><br>
<div class="tr">
    <div class="td">
        
    
    <div class="form-group">
    <label>Academic Year : </label>
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
    </div>
    </div>
</div><br>
<div class="tr">
    <div class="td">
       
   
    <div class="form-group">
    <label>Semester : </label>
        <select name="sem" required>
    <option value="">Select Semester</option>
    <option value="1">1</option>
    <option value="2">2</option>
</select>
    </div>
    </div>
</div><br>



    <!-- <div class="tr">
        <div class="td">
            <label>Year : </label>
        </div>
        <div class="td">
            <input type="text" name="year" size="25" required placeholder="Enter Year" />
        </div>
    </div> -->

<!-- <div class="tr">
        <div class="td">
            <label>Semester : </label>
        </div>
        <div class="td">
            <input type="text" name="sem" size="25" required placeholder="Enter Semester" />
        </div>
    </div> -->

    <div class="tr">
        <div class="td">
       
        <div class="form-group">
        <label>Subject : </label>
        <div class="field">
            <input type="text" name="sub" size="25" required placeholder="Enter Subject" />
        </div>    
        </div>
        </div>
    </div><br>
    
    <!-- <div class="tr">
        <div class="td">
            <label>Division : </label>
        </div>
        <div class="td">
            <input type="text" name="div" size="25" required placeholder="Enter Division" />
        </div>
    </div> -->
<div class="tr">
    <div class="td">
       
    
    <div class="form-group">
    <label>Division : </label>
        <?php if ($department == 'Computer' || $department=='FY-Comp') { ?>
            <input type="checkbox" name="divA" value="A" /> A
            <input type="checkbox" name="divB" value="B" /> B
            <input type="checkbox" name="divC" value="C" /> C
        <?php } elseif ($department == 'ENTC' || $department == 'Mechanical' || $department == 'FY-Entc' || $department == 'FY-Mech') { ?>
            <input type="checkbox" name="divA" value="A" /> A
            <input type="checkbox" name="divB" value="B" /> B
        <?php } else { ?>
            <input type="checkbox" name="div" value="A" /> A
        <?php } ?>
    </div>
    </div>
</div><br>
<div class="tdd">
<input type="button" class="button1" onClick="window.location='home.php'" value="BACK">

            <input type="submit" style="margin-left:5px;" class="button1" value="ADD FACULTY" />

        </div>

    
</div>
        
        
    
<br>
<br>
</form>
        </div>
        </div>
    
    
        <div id="content-1" align="center">
    
    
    <h2 style = "color:black">Manage Faculty</h2>
    <br>
    <table border="0" cellpadding="3" cellspacing="3">
    <tr style="font-weight:bold;">
    <td>Sr. No.</td>
    <td>Faculty ID</td>
    <td>Faculty Image</td>
    <td>Name</td>
    <td>Department</td>
    <td>Year</td>
    <td>Academic Year</td>
    <td>Semester</td>
    <td>Subject</td>
    
    <td>Division</td>
    
    <td>Delete</td>
    
    </tr>
    <?php
    $sr=1;
    $h=mysqli_query($al,"SELECT * FROM faculty WHERE department='$department' ORDER BY CAST(faculty_id AS UNSIGNED) ASC");
    while($j=mysqli_fetch_array($h))
    {
        ?>
        <tr>
            <?php
                $facultyId = $j['faculty_id']; // Store faculty ID in a variable

                $result = mysqli_query($al, "SELECT t_image FROM add_teacher WHERE t_id='$facultyId'");
    $row = mysqli_fetch_array($result);
    $faculty_image = $row['t_image'];

            ?>
        <td><?php echo $sr;$sr++;?></td>
        <td><?php echo $j['faculty_id'];?></td>
        <td>
        <?php
        if (!empty($faculty_image) && file_exists('teacher_images/' . $faculty_image)) {
            echo '<img src="teacher_images/' . $faculty_image . '" alt="Faculty Image" width="50" height="50" />';
        } else {
            echo 'No Image';
        }
        ?>
        </td>
        <td><?php echo $j['name'];?></td>
        <td><?php echo $j['department'];?></td>
        <td><?php echo $j['year'];?></td>
        <td><?php echo $j['academic_year'];?></td>
        <td><?php echo $j['semester'];?></td>
        <td><?php echo $j['subject'];?></td>
        
        <td><?php echo $j['division'];?></td>
                
        <td align="center"><a href="deleteFaculty.php?faculty_id=<?php echo $j['faculty_id'];?>&department=<?php echo $j['department'];?>&year=<?php echo $j['year'];?>&semester=<?php echo $j['semester'];?>&division=<?php echo $j['division'];?>&subject=<?php echo $j['subject'];?>" onClick="return confirm('Are you sure?')" style="text-decoration:none;font-size:18px;color:rgba(255,0,4,1.00);">[x]</a></td> 
        </tr>
     <?php } ?>
     </table>
     <br>

<br>
<br>
</div>
</div>
    </section>
</body>
</html>