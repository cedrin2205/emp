<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Add any necessary CSS links here -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row mt-4">
            <div class="col">
                <h2 style="font-size: medium;">Add User:</h2>
                <form method="post" action="insert_user.php">
                    <div class="mb-3">
                        <label for="lrn" class="form-label">LRN:</label>
                        <input type="text" class="form-control" id="lrn" name="lrn" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role (Strand):</label>
                        <input type="text" class="form-control" id="role" name="role" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
            <div class="col">
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <h2 style="font-size: medium;">Registrar Table:</h2>
                <table class='table table-striped'>
                    <tr>
                        <th>LRN</th>
                        <th>Role (Strand)</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    // Include database connection
                    include "database.php";

                    // Fetch data from the registrar table
                    $sql = "SELECT lrn, role FROM registrar";
                    $result = mysqli_query($conn, $sql);

                    if (!$result) {
                        die("Error in SQL query: " . mysqli_error($conn));
                    }

                    // Display each row as a table row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['lrn']}</td>";
                        echo "<td>{$row['role']}</td>";
                        echo "<td>";
                        echo "<form method='post' action='update_role.php'>";
                        echo "<input type='hidden' name='lrn' value='{$row['lrn']}'>";
                        echo "<select class='form-select' name='role'>";
                        // Add options for different roles/strands
                        // You can customize the options as needed
                        echo "<option value='standby'>Standby</option>";
                        echo "<option value='Humms'>Humms11</option>";
                        echo "<option value='ABM'>ABM11</option>";
                        echo "<option value='ICT'>ICT11</option>";
                        echo "<option value='STEM'>STEM11</option>";
                        echo "<option value='GAS'>GAS11</option>";
                        echo "<option value='HUMMS12'>Humss12</option>";
                        echo "<option value='ABM12'>ABM12</option>";
                        echo "<option value='ICT12'>ICT12</option>";
                        echo "<option value='STEM12'>STEM12</option>";
                        echo "<option value='GAS12'>GAS12</option>";
                        echo "<option value='admin'>admin</option>";
                        
                        
                        // Add more options if necessary
                        echo "</select>";
                        echo "<button type='submit' class='btn btn-primary'>Update</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    // Close the MySQLi connection
                    mysqli_close($conn);
                    ?>
                </table>
            </div>
        </div>
        <?php
        // Display notification if set
        if (isset($_GET['notification'])) {
            echo '<div class="row mt-4"><div class="col"><div class="alert alert-success" role="alert">' . $_GET['notification'] . '</div></div></div>';
        }
        ?>
    </div>
</body>
</html>
