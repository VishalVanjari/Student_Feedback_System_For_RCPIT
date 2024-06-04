<?php
include("configASL.php");
session_start();
if (!isset($_SESSION['aid'])) {
    header("location:index_2.php");
    exit;
}

$aid = $_SESSION['aid'];
$x = mysqli_prepare($al, "SELECT * FROM admin WHERE aid=?");
mysqli_stmt_bind_param($x, "s", $aid);
mysqli_stmt_execute($x);
$y = mysqli_stmt_get_result($x);
$admin = mysqli_fetch_array($y);

if (empty($admin)) {
    header("location:index_2.php");
    exit;
}

$department = $admin['department'];

if (!empty($_POST)) {
    $fc = trim($_POST['fc']);
    $department = $admin['department'];

    // Check if department and image are set
    if (isset($_POST['department']) && isset($_FILES['teacher_image'])) {
        $department = trim($_POST['department']);

        $teacher_image = $_FILES['teacher_image'];
        $image_name = $teacher_image['name'];
        $image_tmp_name = $teacher_image['tmp_name'];
        $image_destination = 'teacher_images/' . $image_name;

        // Check file type
        $image_file_type = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($image_file_type, $allowed_extensions)) {
            echo "<script type='application/javascript'>alert('Invalid file format. Allowed formats: jpg, jpeg, png, gif.');</script>";
            exit;
        }

        // Move the uploaded image file to the destination directory
        if (move_uploaded_file($image_tmp_name, $image_destination)) {
            $u = mysqli_prepare($al, "INSERT INTO add_teacher (t_name, t_department, t_image)
                                    VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($u, "sss", $fc, $department, $image_name);
            mysqli_stmt_execute($u);

            if (mysqli_stmt_affected_rows($u) > 0) {
                echo "<script type='application/javascript'>alert('Successfully added');</script>";
            } else {
                echo "<script type='application/javascript'>alert('Failed to add teacher');</script>";
            }
        } else {
            echo "<script type='application/javascript'>alert('Failed to upload teacher image.');</script>";
        }
    } else {
        echo "<script type='application/javascript'>alert('Department or image not set.');</script>";
    }
}
?>

<!doctype html>
<html>
<!-- Designed & Developed by Ashish Labade (Tech Vegan) www.ashishvegan.com | Not for Commercial Use -->
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
            <h2>Add Faculty</h2>
            <br>
        <form method="post" action="" enctype="multipart/form-data">
                <div id="table">
                    <div class="tr">
                        <div class="td">
                        <div class="form-group">
                            <label>Faculty : </label>
                        <div class="field">
                        <input type="text" class="input-field" name="fc" size="25" required placeholder="Enter Faculty Name" />
                        </div>
                        </div>
                        </div>
                    </div><br>

                    <div class="tr">
                        <div class="td">
                        <div class="form-group">
                            <label>Department : </label>
                        <div class="field">
                        <input type="text" class="input-field" name="department" size="25" required placeholder="Enter Department" value="<?php echo htmlspecialchars($department); ?>" readonly />
                        </div>
                        </div>
                        </div>
                    </div><br>
                    
                
                    <div class="tr">
                        <div class="td">
                        <div class="form-group">
                            <label>Image : </label>
                        <div class="field">
                        <input type="file" class="input-field" name="teacher_image" accept="image/*" required />
                        </div>
                        </div>
                        </div>
                    </div><br>
                
            <div class="tdd">
            <input type="button" class = "button1" onClick="window.location='home.php'" value="BACK">
                <input type="submit" class = "button1" value="ADD FACULTY" />

            </div>
        </form>
        <br>
        <br>
</section>
<div class="content-1" >
<h2 style = "margin-top:10px;text-align:center;color:black">Faculty List</h2>
        <br>
        <br>
        <table border="0" cellpadding="3" cellspacing="3">
            <tr style="font-weight:bold;">
                <td>Sr. No.</td>
                <td>Teacher ID</td>
                <td>Teacher Name</td>
                <td>Teacher Department</td>
                <td>Teacher Image</td>
                <td>Delete</td>
            </tr>
            <?php
            $sr = 1;
            $h = mysqli_prepare($al, "SELECT * FROM add_teacher WHERE t_department=? ORDER BY CAST(t_id AS UNSIGNED) ASC");
            mysqli_stmt_bind_param($h, "s", $department);
            mysqli_stmt_execute($h);
            $result = mysqli_stmt_get_result($h);
            while ($j = mysqli_fetch_array($result)) :
                ?>
                <tr>
                    <td><?php echo $sr; ?></td>
                    <td><?php echo htmlspecialchars($j['t_id']); ?></td>
                    <td><?php echo htmlspecialchars($j['t_name']); ?></td>
                    <td><?php echo htmlspecialchars($j['t_department']); ?></td>
                    <td>
                        <?php
                        $teacher_image = $j['t_image'];
                        if (!empty($teacher_image) && file_exists('teacher_images/' . $teacher_image)) {
                            echo '<img src="teacher_images/' . $teacher_image . '" alt="Teacher Image" width="50" height="50" />';
                        } else {
                            echo 'No Image';
                        }
                        ?>
                    </td>
                    <td align="center"><a href="delete.php?del=<?php echo htmlspecialchars($j['t_id']); ?>" onClick="return confirm('Are you sure?')" style="text-decoration:none;font-size:18px;color:rgba(255,0,4,1.00);">[x]</a></td>
                </tr>
            <?php
                $sr++;
            endwhile;
            ?>
        </table>
        <br>
        
        <br>
        <br>
</div>
        
    </div>
</body>
</html>
