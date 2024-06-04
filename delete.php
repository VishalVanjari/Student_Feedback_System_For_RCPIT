<?php
include("configASL.php");

// Check if t_id parameter is set and is numeric
if (isset($_GET['del']) && is_numeric($_GET['del'])) {
    $t_id = $_GET['del'];

    // Prepare delete statements to prevent SQL injection
    $deleteTeacherStmt = mysqli_prepare($al, "DELETE FROM add_teacher WHERE t_id = ?");
    $deleteFacultyStmt = mysqli_prepare($al, "DELETE FROM faculty WHERE faculty_id = ?");
    $deleteFeedsStmt = mysqli_prepare($al, "DELETE FROM feeds WHERE faculty_id = ?");

    // Bind parameter to the prepared statements
    mysqli_stmt_bind_param($deleteTeacherStmt, "s", $t_id);
    mysqli_stmt_bind_param($deleteFacultyStmt, "s", $t_id);
    mysqli_stmt_bind_param($deleteFeedsStmt, "s", $t_id);

    // Execute the delete statements
    mysqli_stmt_execute($deleteTeacherStmt);
    mysqli_stmt_execute($deleteFacultyStmt);
    mysqli_stmt_execute($deleteFeedsStmt);

    // Check if any rows were affected
    if (mysqli_stmt_affected_rows($deleteTeacherStmt) > 0 || mysqli_stmt_affected_rows($deleteFacultyStmt) > 0 || mysqli_stmt_affected_rows($deleteFeedsStmt) > 0) {
        echo "<script type='text/javascript'>alert('Successfully deleted');</script>";
    } else {
        echo "<script type='text/javascript'>alert('Failed to delete');</script>";
    }

    // Close the prepared statements
    mysqli_stmt_close($deleteTeacherStmt);
    mysqli_stmt_close($deleteFacultyStmt);
    mysqli_stmt_close($deleteFeedsStmt);
}

// Redirect to add_teacher.php
echo "<script type='text/javascript'>window.location='add_teacher.php';</script>";
