<?php
// Include database connection
include "database.php";

// Check if LRN and role are set
if (isset($_POST['lrn'], $_POST['role'])) {
    // Get LRN and role from the form
    $lrn = $_POST['lrn'];
    $role = $_POST['role'];

    // Prepare the SQL statement to insert or update the role in the registrar table
    $sql_select = "SELECT * FROM registrar WHERE lrn = ?";
    $stmt_select = mysqli_prepare($conn, $sql_select);

    if ($stmt_select) {
        mysqli_stmt_bind_param($stmt_select, "s", $lrn);
        mysqli_stmt_execute($stmt_select);
        mysqli_stmt_store_result($stmt_select);

        if (mysqli_stmt_num_rows($stmt_select) > 0) {
            // If LRN exists, update the role
            $sql_update = "UPDATE registrar SET role = ? WHERE lrn = ?";
            $stmt_update = mysqli_prepare($conn, $sql_update);

            if ($stmt_update) {
                mysqli_stmt_bind_param($stmt_update, "ss", $role, $lrn);
                if (mysqli_stmt_execute($stmt_update)) {
                    // Update successful, redirect back to admin.php with notification
                    header("Location: admin.php?notification=Role updated successfully");
                    exit();
                } else {
                    // Error updating role
                    header("Location: admin.php?notification=Error updating role: " . mysqli_error($conn));
                    exit();
                }
                mysqli_stmt_close($stmt_update);
            } else {
                // Error preparing update statement
                header("Location: admin.php?notification=Error preparing update statement: " . mysqli_error($conn));
                exit();
            }
        } else {
            // If LRN does not exist, insert new user
            $sql_insert = "INSERT INTO registrar (lrn, role) VALUES (?, ?)";
            $stmt_insert = mysqli_prepare($conn, $sql_insert);

            if ($stmt_insert) {
                mysqli_stmt_bind_param($stmt_insert, "ss", $lrn, $role);
                if (mysqli_stmt_execute($stmt_insert)) {
                    // Insert successful, redirect back to admin.php with notification
                    header("Location: admin.php?notification=User added successfully");
                    exit();
                } else {
                    // Error inserting user
                    header("Location: admin.php?notification=Error adding user: " . mysqli_error($conn));
                    exit();
                }
                mysqli_stmt_close($stmt_insert);
            } else {
                // Error preparing insert statement
                header("Location: admin.php?notification=Error preparing insert statement: " . mysqli_error($conn));
                exit();
            }
        }
        // Close the statement
        mysqli_stmt_close($stmt_select);
    } else {
        // Error preparing select statement
        header("Location: admin.php?notification=Error preparing select statement: " . mysqli_error($conn));
        exit();
    }
} else {
    // LRN or role not set
    header("Location: admin.php?notification=LRN or role not provided");
    exit();
}

// Close the MySQLi connection
mysqli_close($conn);
?>
