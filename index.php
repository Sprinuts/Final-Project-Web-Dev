<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if session exists
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Connect to the database
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "jaysql";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if username exists in the database
    if ($result->num_rows > 0) {
        // Username is valid
        echo "Username is valid.";
    } else {
        // Username is not valid
        echo "Username is not valid.";
        header("Location: login.php"); // Redirect to login page
        exit(); // Stop further execution
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Session does not exist
    echo "Session does not exist.";
    header("Location: login.php"); // Redirect to login page
    exit(); // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baranda Library</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <?php include 'menu.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <?php
                $page = $_GET['page'] ?? 'home'; // Default to home page if no specific page request
                switch ($page) {
                    case 'books':
                        include 'books.php';
                        break;
                    case 'borrow':
                        include 'borrow.php';
                        break;
                    case 'return':
                        include 'return.php';
                        break;
                    case 'borrowBook':
                        include 'borrowBook.php';
                        break;
                    default:
                        echo '<div class="alert alert-success">Welcome to Baranda Library!</div>';
                        break;
                }
                ?>
            </div>
        </section>
    </div>
    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Baranda Library</strong>
        - All your books right here.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
</div>