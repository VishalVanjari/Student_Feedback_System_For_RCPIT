<?php
include("configASL.php");

// Check if all required parameters are set
if (isset($_GET['faculty_id'], $_GET['department'], $_GET['year'], $_GET['semester'], $_GET['division'], $_GET['subject'])) {
    $faculty_id = $_GET['faculty_id'];
    $department = $_GET['department'];
    $year = $_GET['year'];
    $semester = $_GET['semester'];
    $division = $_GET['division'];
    $subject = $_GET['subject'];

    // Prepare delete statement to prevent SQL injection
    $deleteFacultyStmt = mysqli_prepare($al, "DELETE FROM faculty WHERE faculty_id = ? AND department = ? AND year = ? AND semester = ? AND division = ? AND subject=?");

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($deleteFacultyStmt, "ssssss", $faculty_id, $department, $year, $semester, $division,$subject);

    // Execute the delete statement
    mysqli_stmt_execute($deleteFacultyStmt);

    // Check if any rows were affected
    if (mysqli_stmt_affected_rows($deleteFacultyStmt) > 0) {
        echo "<script type='text/javascript'>alert('Successfully deleted');</script>";
    } else {
        echo "<script type='text/javascript'>alert('Failed to delete');</script>";
    }

    // Close the prepared statement
    mysqli_stmt_close($deleteFacultyStmt);
}

// Redirect to manageFaculty.php
echo "<script type='text/javascript'>window.location='manageFaculty.php';</script>";
