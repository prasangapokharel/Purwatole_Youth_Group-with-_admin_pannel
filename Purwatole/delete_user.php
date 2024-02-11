<?php
include 'db_connection.php';

// Check if user ID is provided via POST request
if (isset($_POST['id'])) {
    // Sanitize the user ID
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // SQL to delete user by ID
    $sql = "DELETE FROM members WHERE id = $id";

    // Execute the deletion query
    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "No user ID provided.";
}

// Close the database connection
$conn->close();
?>
