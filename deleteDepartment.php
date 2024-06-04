<?php
include("configASL.php");

if (isset($_GET['id'])) {
    $departmentId = $_GET['id'];

    // Delete the department record from the admin table
    $deleteQuery = "DELETE FROM admin WHERE aid=?";
    $stmt = mysqli_prepare($al, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "s", $departmentId);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "<script type='application/javascript'>alert('Department record deleted successfully.');</script>";
    } else {
        echo "<script type='application/javascript'>alert('Failed to delete department record.');</script>";
    }

    mysqli_stmt_close($stmt);
}

// Redirect back to the admin table page
header("Location: add_department.php");
exit();
?>
