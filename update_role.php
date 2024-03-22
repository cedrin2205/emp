<?php
// Include database connection
include "database.php";

// Check if LRN and new role are set
if (isset($_POST['lrn'], $_POST['role'])) {
    // If multiple LRN and role pairs are sent as arrays, we handle them individually
    $lrns = $_POST['lrn'];
    $roles = $_POST['role'];

    // Prepare the SQL statement
    $sql = "UPDATE registrar SET role = ? WHERE lrn = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Initialize an empty array to store success messages
    $successMessages = [];

    // Iterate over each LRN and role pair
    foreach ($lrns as $index => $lrn) {
        $role = $roles[$index];

        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "ss", $role, $lrn);
        if (mysqli_stmt_execute($stmt)) {
            // Role updated successfully for this LRN
            $successMessages[] = "Role updated successfully for LRN: $lrn";
        } else {
            // Error updating role for this LRN
            $successMessages[] = "Error updating role for LRN: $lrn - " . mysqli_error($conn);
        }
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Close the MySQLi connection
    mysqli_close($conn);

    // Send the success messages as a JSON response
    echo json_encode($successMessages);
} else {
    // LRN or role not set
    echo "LRN or role not provided";
}
?>
