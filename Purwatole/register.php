<?php
// Start session (if not already started)
session_start();

// Include database connection file
include 'db_connection.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $first_name = $last_name = $phone = $address = $father_name = $mother_name = $email = $profile_pic_path = "";
    $first_name_err = $last_name_err = $phone_err = $address_err = $father_name_err = $mother_name_err = $email_err = "";

    // Validate form data
    if (empty(trim($_POST["firstName"]))) {
        $first_name_err = "Please enter first name.";
    } else {
        $first_name = trim($_POST["firstName"]);
    }

    // Repeat for other fields (last_name, phone, address, father_name, mother_name, email)
    // ...

    // Check if there are no validation errors
    if (empty($first_name_err) && empty($last_name_err) && empty($phone_err) && empty($address_err) && empty($father_name_err) && empty($mother_name_err) && empty($email_err)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO members (first_name, last_name, phone, address, father_name, mother_name, email, profile_pic_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters to the statement
            $stmt->bind_param("ssssssss", $first_name, $last_name, $phone, $address, $father_name, $mother_name, $email, $profile_pic_path);

            // Set parameters and execute the statement
            $first_name = $_POST["firstName"];
            $last_name = $_POST["lastName"];
            $phone = $_POST["phone"];
            $address = $_POST["address"];
            $father_name = $_POST["fatherName"];
            $mother_name = $_POST["motherName"];
            $email = $_POST["email"];
            // $profile_pic_path = "uploads/" . basename($_FILES["profilePic"]["name"]); // Set the profile pic path

            // Check if the file was uploaded successfully
            // if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $profile_pic_path)) {
                // File uploaded successfully, execute the INSERT statement
                if ($stmt->execute()) {
                    // Registration successful
                    echo "Registration successful.";
                } else {
                    // SQL error
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                // File upload error
                echo "Error uploading file.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futuristic Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            border-radius: 20px 20px 0 0;
        }
        .form-control {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .btn {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3> Registration Sucessfull</h3>
                    </div>
                    <!-- Here you can add the form fields for other data such as last name, phone, address, father name, mother name, email -->
                    <!-- ... -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>
