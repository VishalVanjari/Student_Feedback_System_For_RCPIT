<?php
include("configASL.php");
session_start();
if (!isset($_SESSION['aid'])) {
    header("location:index_2.php");
    exit(); // Stop further execution
}

$aid = $_SESSION['aid'];
$query = "SELECT * FROM admin WHERE aid=?";
$stmt = mysqli_prepare($al, $query);
mysqli_stmt_bind_param($stmt, "s", $aid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$y = mysqli_fetch_array($result);
$name = $y['name'];

if (!empty($_POST)) {
    $faculty_id = $_POST['faculty_id'];
    $academic_year = $_POST['academic_year'];
    $semester = $_POST['semester'];
    // Fetch Name
    $nameQuery = "SELECT * FROM faculty WHERE faculty_id=?";
    $nameStmt = mysqli_prepare($al, $nameQuery);
    mysqli_stmt_bind_param($nameStmt, "s", $faculty_id);
    mysqli_stmt_execute($nameStmt);
    $nameResult = mysqli_stmt_get_result($nameStmt);
    $name = mysqli_fetch_array($nameResult);

    $result = mysqli_query($al, "SELECT t_image FROM add_teacher WHERE t_id='$faculty_id'");
    $row = mysqli_fetch_array($result);
    $faculty_image = $row['t_image'];

    $questionCounts = array();
    $questionPercentages = array();
    $sql = "SELECT * FROM feeds WHERE faculty_id=? AND academic_year=? AND semester=?";
    $sqlStmt = mysqli_prepare($al, $sql);
    mysqli_stmt_bind_param($sqlStmt, "sss", $faculty_id,$academic_year,$semester);
    mysqli_stmt_execute($sqlStmt);
    $sqlResult = mysqli_stmt_get_result($sqlStmt);
    $totalRows = mysqli_num_rows($sqlResult);
    $s = 0;

    $ratingCounts = array();

    // Initialize the ratingCounts array for each question
    for ($i = 1; $i <= 14; $i++) {
        $ratingCounts[$i] = array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0
        );
    }

    while ($z = mysqli_fetch_array($sqlResult)) {
        for ($i = 1; $i <= 14; $i++) {
            $questionCounts[$i] += $z['q' . $i];
        }
        $total = array_sum($questionCounts);
        $s++;
        for ($j = 1; $j <= 14; $j++) {
            $rating = $z['q' . $j];
            $ratingCounts[$j][$rating]++;
        }
    }

    $ratingPercentages = array();

    foreach ($ratingCounts as $questionNumber => $ratings) {
        $ratingPercentages[$questionNumber] = array();

        foreach ($ratings as $rating => $count) {
            $percentage = ($count / $s) * 100;
            $ratingPercentages[$questionNumber][$rating] = round($percentage);
        }
    }
}
?>

<!doctype html>
<html>
<!-- Designed & Developed by Ashish Labade (Tech Vegan) www.ashishvegan.com | Not for Commercial Use -->
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

    <div id="content-t" align="center" style="width:1200px;">
    
        <h2>Student Feedback</h2>
    <br>
        <table border="0" cellpadding="6" cellspacing="6">
            <tr>
                <td style="font-weight:bold;">Faculty Name :</td>
                <td><?php echo htmlspecialchars($name['name']); ?></td>

                <td style="font-weight:bold;">Academic Year :</td>
                <td><?php echo $academic_year; ?></td>

                <td style="font-weight:bold;">Semester :</td>
                <td><?php echo $semester; ?></td>
            </tr>

            <tr>
                <td style="font-weight:bold;">Faculty Image :</td>
                <td>
                    <?php
                    if (!empty($faculty_image) && file_exists('teacher_images/' . htmlspecialchars($faculty_image))) {
                        echo '<img src="teacher_images/' . htmlspecialchars($faculty_image) . '" alt="Faculty Image" width="50" height="50" />';
                    } else {
                        echo 'No Image';
                    }
                    ?>
                </td>
                
            </tr>

            <tr style="font-weight:bold;" colspan="6">
                <td >Delete :</td>
                <td align="center" >
                    <a href="deleteFeedback.php?faculty_id=<?php echo htmlspecialchars($faculty_id); ?>"
                       onClick="return confirm('Are you sure?')"
                       style="text-decoration:none;font-size:18px;color:rgba(255,0,4,1.00);">Delete</a>
                </td>
                <td style="font-weight:bold;">a. Count </td>
                <td style="font-weight:bold;">a. Multiplied </td>
                <td style="font-weight:bold;">a. Sub Total </td>
                <td style="font-weight:bold;">b. Count </td>
                <td style="font-weight:bold;">b. Multiplied </td>
                <td style="font-weight:bold;">b. Sub Total </td>
                <td style="font-weight:bold;">c. Count </td>
                <td style="font-weight:bold;">c. Multiplied </td>
                <td style="font-weight:bold;">c. Sub Total </td>
                <td style="font-weight:bold;">Obtained </td>
                <td style="font-weight:bold;">Total </td>
                <td style="font-weight:bold;">Percentage </td>
            </tr>

            <?php 
for ($i = 1; $i <= 14; $i++):
    $roundedValue = round($questionCounts[$i] / $s); // Calculate rounded value
    $totalSum += $roundedValue;
    $questionResult = mysqli_query($al, "SELECT * FROM questions WHERE id = '$i'");
    $question = mysqli_fetch_assoc($questionResult);
    
    // Calculation for a.count, a.multiplied, and a.subtotal
    $aCount = $ratingCounts[$i][1];
    $aMultiplied = 1;
    $aSubtotal = $aCount * $aMultiplied;
     // Add a.subtotal to obtained

    // Calculation for b.count, b.multiplied, and b.subtotal
    $bCount = $ratingCounts[$i][2];
    $bMultiplied = 3;
    $bSubtotal = $bCount * $bMultiplied;
     // Add b.subtotal to obtained

    // Calculation for c.count, c.multiplied, and c.subtotal
    $cCount = $ratingCounts[$i][3];
    $cMultiplied = 6;
    $cSubtotal = $cCount * $cMultiplied;
     // Add c.subtotal to obtained

    ?>

    <tr style="font-weight:bold;">
        <td><?php echo $i; ?>. <?php echo $question['questions']; ?>:</td>
        <td><?php echo round($questionCounts[$i] / $s); ?>/3</td>
        <td><?php echo $aCount; ?></td>
        <td><?php echo $aMultiplied; ?></td>
        <td><?php echo $aSubtotal; ?></td>
        <td><?php echo $bCount; ?></td>
        <td><?php echo $bMultiplied; ?></td>
        <td><?php echo $bSubtotal; ?></td>
        <td><?php echo $cCount; ?></td>
        <td><?php echo $cMultiplied; ?></td>
        <td><?php echo $cSubtotal; ?></td>

<?php
        $obtained =$aSubtotal + $bSubtotal + $cSubtotal; 
        $finalObtained +=$obtained;
        $totalObtained = $s * 6;
        $finalTotalObtained = $s * 84;
        $percentObtained = ($obtained/$totalObtained)*100;
        $percentObtained = number_format($percentObtained, 2);
        ?>
        <td><?php echo $obtained; ?></td>
        <td><?php echo $totalObtained; ?></td>
        <td><?php echo $percentObtained; ?>%</td>
        
        
    </tr>
<?php endfor; ?>

<tr>
    <td style="font-weight:bold;">Total Students:</td>
    <td><?php echo $s; ?></td>    
    <td><?php echo " "; ?></td>
    <td><?php echo " "; ?></td>
    <td><?php echo " "; ?></td>
    <td><?php echo " "; ?></td>
    <td><?php echo " "; ?></td>
    <td><?php echo " "; ?></td>
    <td><?php echo " "; ?></td>
    <td><?php echo " "; ?></td>
    <td><?php echo " "; ?></td>
    <td><?php echo $finalObtained; ?></td>
    <td><?php echo $finalTotalObtained; ?></td>
    <?php
    $finalPercentObtained = ($finalObtained/$finalTotalObtained)*10;
        $finalPercentObtained = number_format($finalPercentObtained, 2);
    ?>
    <td><?php echo $finalPercentObtained; ?></td>
</tr>

<tr>
    <td style="font-weight:bold;">Total:</td>
    <td><?php echo $totalSum; ?>/42</td>
</tr>

<tr>
    <td style="font-weight:bold;">overall feedback</td>
    <td style="font-weight:bold;">
        <?php
        if ($finalPercentObtained >= 0.00 && $finalPercentObtained <= 1.99) {
            echo "Poor";
        } elseif ($finalPercentObtained >= 2.00 && $finalPercentObtained <= 3.99) {
            echo "Unsatisfactory";
        } elseif ($finalPercentObtained >= 4.00 && $finalPercentObtained <= 5.99) {
            echo "Satisfactory";
        } elseif ($finalPercentObtained >= 6.00 && $finalPercentObtained <= 7.99) {
            echo "Good";
        } elseif ($finalPercentObtained >= 8.00 && $finalPercentObtained <= 10.00) {
            echo "Excellent";
        }
        ?>
    </td>
</tr>
        </table>

        <div class="caption">Inventory</div>	
<div id="table">
	<div class="header-row row">
    <span class="cell primary">Vehcile</span>
    <span class="cell">Exterior</span>
     <span class="cell">Interior</span>
    <span class="cell">Engine</span>
    <span class="cell">Trans</span>
  </div>
  <div class="row">
	<input type="radio" name="expand">
    <span class="cell primary" data-label="Vehicle">2013 Subaru WRX</span>
    <span class="cell" data-label="Exterior">World Rally Blue</span>
     <span class="cell" data-label="Interior">Black</span>
     <span class="cell" data-label="Engine">2.5L H4 Turbo</span>
    <span class="cell" data-label="Trans"><a href="">5 Speed</a></span>
  </div>
  <div class="row">
	<input type="radio" name="expand">
    <span class="cell primary" data-label="Vehicle">2013 Subaru WRX STI</span>
    <span class="cell" data-label="Exterior">Crystal Black Silica</span>
     <span class="cell" data-label="Interior">Black</span>
     <span class="cell" data-label="Engine">2.5L H4 Turbo</span>
     <span class="cell" data-label="Trans">6 Speed</span>
  </div>
  <div class="row">
	<input type="radio" name="expand">
    <span class="cell primary" data-label="Vehicle">2013 Subaru BRZ</span>
    <span class="cell" data-label="Exterior">Dark Grey Metallic</span>
     <span class="cell" data-label="Interior">Black</span>
     <span class="cell" data-label="Engine">2.0L H4</span>
     <span class="cell" data-label="Trans">6 Speed</span>
  </div>
  <div class="row">
	<input type="radio" name="expand">
    <span class="cell primary" data-label="Vehicle">2013 Subaru Legacy</span>
    <span class="cell" data-label="Exterior">Satin White Pearl</span>
     <span class="cell" data-label="Interior">Black</span>
     <span class="cell" data-label="Engine">2.5L H4</span>
     <span class="cell" data-label="Trans">Auto</span>
  </div>
  <div class="row">
	<input type="radio" name="expand">
    <span class="cell primary" data-label="Vehicle">2013 Subaru Legacy</span>
    <span class="cell" data-label="Exterior">Twilight Blue Metallic</span>
     <span class="cell" data-label="Interior">Black</span>
     <span class="cell" data-label="Engine">2.5L H4</span>
     <span class="cell" data-label="Trans">Auto</span>
  </div>
  <div class="row">
	<input type="radio" name="expand">
    <span class="cell primary" data-label="Vehicle">2013 Subaru Forester</span>
    <span class="cell" data-label="Exterior">Ice Silver Metallic</span>
     <span class="cell" data-label="Interior">Black</span>
     <span class="cell" data-label="Engine">2.5L H4 Turbo</span>
     <span class="cell" data-label="Trans">Auto</span>
  </div>
</div>

        <br>
        <br>
        <input type="button" onClick="window.print();" value="PRINT">&nbsp;
        <input type="button" onClick="window.location='feeds.php'" value="BACK">

        <br>
        <br>
    </div>
    </section>
</body>
</html>
