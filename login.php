<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jaysql";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query to check if the user exists in the database
    $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User is authenticated
        $row = $result->fetch_assoc();
        if ($row["username"] == "admin") {
            // Redirect to edit.php for admin user
            session_start();
            $_SESSION["username"] = $row["username"];

            header("Location: adminDashBoard.php");
            exit(); 
        } else {
            // Start session and store username
            session_start();
            $_SESSION["username"] = $row["username"];
            
            // Redirect to index.php for other users
            header("Location: index.php");
            exit();
        }
    } else {
        // Invalid credentials, show error message
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f3e9; /* Beige background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            background: linear-gradient(135deg, #f7f3e9, #e2dbc6);
        }

        h2 {
            text-align: center;
            color: #5a5a5a; /* Dark grey color */
            margin-bottom: 20px;
            font-size: 28px;
            letter-spacing: 1px;
        }

        form {
            width: 100%;
            max-width: 400px;
            background-color: #fff5e6; /* Light beige background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        form:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 10px;
            text-align: left; /* Align labels to the left */
            color: #5a5a5a; /* Dark grey color */
            font-size: 16px;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
            background-color: #f9f6f1; /* Very light beige background */
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #d4a373;
            box-shadow: 0 0 8px rgba(212, 163, 115, 0.7);
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #d4a373; /* Beige button color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            margin-top: 15px;
        }

        input[type="submit"]:hover {
            background-color: #c0895c; /* Darker beige on hover */
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .signup-link {
            color: #5a5a5a; /* Dark grey color */
            text-decoration: none;
            font-size: 14px;
            margin-top: 10px;
            text-align: left; /* Align link text to the left */
            transition: color 0.7s;
        }

        .signup-link a {
            color: #5a5a5a; /* Dark grey color */
            text-decoration: none;
            transition: color 0.7s;
        }

        .signup-link a:hover {
            text-decoration: underline;
            color: #3c3c3c; /* Darker grey on hover */
        }
    </style>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="username">
            <i class="fas fa-user" style="color: #d4a373;"></i> <!-- Font Awesome icon for username -->
            Username:
        </label>
        <input type="text" name="username" required><br><br>
        <label for="password">
            <i class="fas fa-lock" style="color: #d4a373;"></i> <!-- Font Awesome icon for password -->
            Password:
        </label>
        <input type="password" name="password" required><br><br>
        <div class="signup-link">
            New here? <a href="signup.php">Sign up</a>
        </div>
        <input type="submit" value="Login">
    </form>

    <!-- Font Awesome CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>