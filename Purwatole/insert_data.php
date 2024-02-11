<?php
// Include database connection file
require_once 'db_connection.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $first_name = $last_name = $phone = $address = $father_name = $mother_name = $email = $citizenship_number = $profile_pic_path = "";

    // Validate and sanitize form data
    $first_name = trim($_POST["firstName"]);
    $last_name = trim($_POST["lastName"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $father_name = trim($_POST["fatherName"]);
    $mother_name = trim($_POST["motherName"]);
    $email = trim($_POST["email"]);
    $citizenship_number = trim($_POST["citizenshipNumber"]);

    // Check if all required fields are filled
    if (empty($first_name) || empty($last_name) || empty($phone) || empty($address) || empty($father_name) || empty($mother_name) || empty($email) || empty($citizenship_number) || empty($_FILES["profilePic"]["name"])) {
        echo "All fields are required.";
        exit;
    }

    // Check if file was uploaded without errors
    if ($_FILES["profilePic"]["error"] == 0) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES["profilePic"]["name"]);
        $target_file = $target_dir . $file_name;

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            exit;
        }

        // Check file size
        if ($_FILES["profilePic"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            exit;
        }

        // Move the uploaded file to the specified directory
        if (!move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }

        $profile_pic_path = $target_file;
    } else {
        echo "Error uploading file.";
        exit;
    }

    // Prepare an INSERT statement
    $sql = "INSERT INTO members (first_name, last_name, phone, address, father_name, mother_name, email, citizenship_number, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the statement
        $stmt->bind_param("sssssssss", $first_name, $last_name, $phone, $address, $father_name, $mother_name, $email, $citizenship_number, $profile_pic_path);

        // Execute the statement
        if ($stmt->execute()) {
            // Registration successful
            echo "Registration successful.";
        } else {
            // SQL error
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
}
?>
