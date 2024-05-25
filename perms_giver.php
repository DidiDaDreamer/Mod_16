<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'nick' parameter is set in the POST request
    if(isset($_POST['nick'])) {
        // Retrieve the selected username from the form
        $selectedUsername = $_POST['nick'];

        // Process the selected username here
        // For example, you can update the permissions for the selected user in the database
        // Make sure to handle database operations securely to prevent SQL injection attacks

        // Example: Update permissions for the selected user
        $conexao = mysqli_connect("localhost", "root", "", "crafter");
        $mod_perm = 2;

        if (!$conexao) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Update permissions for the selected user
        $updateQuery = "UPDATE UserAccount SET Perms=? WHERE Username=?";
        $stmt = mysqli_prepare($conexao, $updateQuery);
        mysqli_stmt_bind_param($stmt, "is", $mod_perm, $selectedUsername);
        mysqli_stmt_execute($stmt);

        // Close the database connection
        mysqli_close($conexao);

        // Redirect back to the admin_tools.php page or any other desired page
        header("Location: admin_tools.php");
        exit();
    }
}
?>