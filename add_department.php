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
    $username = $_POST['username'];
    $department = $_POST['department'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate password
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        echo "<script type='application/javascript'>alert('Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 digit, 1 special character, and be at least 8 characters long.');</script>";
    } elseif ($password !== $confirmPassword) {
        echo "<script type='application/javascript'>alert('Confirm password does not match.');</script>";
    } else {
        // Insert admin record into the database
        $stmt = mysqli_prepare($al, "INSERT INTO admin (aid, department, password) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $username, $department, $password);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script type='application/javascript'>alert('Successfully added');</script>";
        } else {
            echo "<script type='application/javascript'>alert('Record already present');</script>";
        }
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
        <span class="SubHead">Add Department</span>
        <br>
        <br>
        <form method="post" action="">
            <div id="table">
                <div class="tr">
                    <div class="td">
                        
                    <div class="form-group">
                    <label>Department : </label>
                        <input type="text" name="department" size="25" required placeholder="Enter Department"/>
                    </div>
                    </div>
                </div><br>

                <div class="tr">
                    <div class="td">
                       
                    
                    <div class="form-group">
                    <label>Username : </label>
                        <input type="text" name="username" size="25" required placeholder="Enter Username"/>
                    </div>
                </div></div><br>

                <div class="tr">
                    <div class="td">
                        
                    
                    <div class="form-group">
                    <label>Password : </label>
                        <input type="password" name="password" size="25" required placeholder="Enter Password"/>
                    </div>
                </div></div><br>

                <div class="tr">
                    <div class="td">
                        
                    
                    <div class="form-group">
                    <label>Confirm Password : </label>
                        <input type="password" name="confirm_password" size="25" required placeholder="Confirm Password"/>
                    </div>
                </div></div>
            </div><br>

            <div class="tdd">
            <input type="button" class="button1" onClick="window.location='home.php'" value="BACK">
                <input type="submit" class="button1" value="ADD DEPARTMENT"/>
            </div>
        </form>
</section>
        <br>
        <br>
        <h2 style="color:black;text-align:center">Admin Table</h2>
        <br>
        <br>
        <div class="container-fluid" >
            
        <table border="0" cellpadding="3" cellspacing="3" >
            <tr style="font-weight:bold;">
                <td>Sr. No.</td>
                <td>Username</td>
                <td>Department</td>
                <td>Password</td>
                <td>Delete</td>
            </tr>
            <?php
            $sr = 1;
            $adminRecords = mysqli_query($al, "SELECT * FROM admin");
            while ($row = mysqli_fetch_array($adminRecords)) {
                ?>
                <tr>
                    <td><?php echo $sr; $sr++; ?></td>
                    <td><?php echo $row['aid']; ?></td>
                    <td><?php echo $row['department']; ?></td>
                    <td><?php echo $row['password']; ?></td>
                    <td align="center">
                        <a href="deleteDepartment.php?id=<?php echo $row['aid']; ?>"
                           onClick="return confirm('Are you sure?')"
                           style="text-decoration:none;font-size:18px;color:rgba(255,0,4,1.00);">[x]</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        </div>
        
        <br>
        
        <br>
        <br>
    </div>
</div>
</body>
</html>
