<?php
include 'db_connection.php';

// Fetch data from the database including phone, address, father's name, mother's name, and citizenship number
$sql = "SELECT id, first_name, last_name, email, phone, address, father_name, mother_name, citizenship_number, profile_pic FROM members";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Purwatole Youth Group</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff; /* White */
            margin: 0;
            padding: 0;
            color: #333333; /* Dark grey */
        }

        header {
            background-color: #007bff; /* Blue */
            color: #ffffff; /* White */
            padding: 20px 0;
            text-align: center;
            margin-bottom: 20px;
            
        }

        .container {
            max-width: 100%;
            margin: 20px auto;
            padding: 20px;
            background-color: #f2f2f2; /* Light grey */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto; /* Enable horizontal scrolling on small screens */
        }

        h1, h2 {
            margin: 0;
        }

        h2 {
            margin-top: 20px;
            margin-bottom: 10px;
            color: #333333; /* Dark grey */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 2px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #dddddd; /* Light grey */
            text-align: left;
            border-radius: 1px;

        }

        th {
            background-color: #007bff; /* Blue */
            color: #ffffff; /* White */
        }

        tr:hover {
            background-color: #f5f5f5; /* Light grey */
        }

        img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 50%;
        }

        .btn {
            background-color: #007bff; /* Blue */
            color: #ffffff; /* White */
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3; /* Dark blue */
        }
    </style>
</head>
<body>
<header>
    <h1>Admin Panel - Purwatole Youth Group</h1>
</header>

<div class="container">
    <h2>Members Information</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Father's Name</th>
            <th>Mother's Name</th>
            <th>Citizenship Number</th>
            <th>Profile Picture</th>
            <th>Action</th>
        </tr>
        <?php
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['address']}</td>
                <td>{$row['father_name']}</td>
                <td>{$row['mother_name']}</td>
                <td>{$row['citizenship_number']}</td>
                <td><img src='{$row['profile_pic']}' alt='Profile Picture'></td>
                <td><button class='btn' onclick='deleteUser({$row['id']})'>Delete</button></td>
            </tr>";
        }
        ?>
    </table>

<script>
    // JavaScript function to delete a user
    function deleteUser(id) {
        // Create an AJAX request to delete_user.php
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Reload the page to reflect changes
                location.reload();
            }
        };
        xhttp.open("POST", "delete_user.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + id);
    }

    // JavaScript function to delete all users
    function deleteAllUsers() {
        // Create an AJAX request to delete_all_users.php
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Reload the page to reflect changes
                location.reload();
            }
        };
        xhttp.open("GET", "delete_all_users.php", true);
        xhttp.send();
    }
</script>

</body>
</html>

<?php
$conn->close();
?>
