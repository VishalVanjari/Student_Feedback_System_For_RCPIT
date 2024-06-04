<?php
include("configASL.php");

// Check if faculty_id is set
if (isset($_GET['faculty_id'])) {
    $faculty_id = $_GET['faculty_id'];

    // Prepare delete statement to prevent SQL injection
    $deleteFeedsStmt = mysqli_prepare($al, "DELETE FROM feeds WHERE faculty_id = ?");

    // Bind parameter to the prepared statement
    mysqli_stmt_bind_param($deleteFeedsStmt, "s", $faculty_id);

    // Execute the delete statement
    mysqli_stmt_execute($deleteFeedsStmt);

    // Check if any rows were affected
    if (mysqli_stmt_affected_rows($deleteFeedsStmt) > 0) {
        echo "<script type='text/javascript'>alert('Successfully deleted');</script>";
    } else {
        echo "<script type='text/javascript'>alert('Failed to delete');</script>";
    }

    // Close the prepared statement
    mysqli_stmt_close($deleteFeedsStmt);
}

// Redirect to feeds.php
echo "<script type='text/javascript'>window.location='feeds.php';</script>";
