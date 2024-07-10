<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'functions.php';

// Function to set session alerts
function setAlert($message, $type = 'success') {
    $_SESSION['alert'] = ['message' => $message, 'type' => $type];
}

// Display alert message if set
function displayAlert() {
    if (isset($_SESSION['alert'])) {
        $alertClass = ($_SESSION['alert']['type'] == 'success') ? 'alert-success' : 'alert-danger';
        echo '<div class="alert ' . $alertClass . '">' . $_SESSION['alert']['message'] . '</div>';
        unset($_SESSION['alert']); // Clear the alert message after displaying
    }
}

// Check if a valid book ID is passed and borrow has not yet been confirmed
if (isset($_GET['bookid']) && !isset($_GET['confirm'])) {
    $bookid = htmlspecialchars($_GET['bookid']);
    $book = getBookId($bookid); // Retrieve book details

    if ($book) {
        // Display borrow confirmation form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow Book</title>
</head>
<body>
    <div class="container">
        <?php displayAlert(); // Display alert if there is one ?>
        <h1 style="padding-top: 20px;">Borrow Book</h1>
        <p>Are you sure you want to borrow this book?</p>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Title: <?= htmlspecialchars($book['booktitle']) ?></h5>
                <p class="card-text">Author: <?= htmlspecialchars($book['author']) ?></p>
                <p class="card-text">Release Date: <?= htmlspecialchars(date('m-d-Y', strtotime($book['month'] . '/' . $book['day'] . '/' . $book['year']))) ?></p>
                <p class="card-text">Category: <?= htmlspecialchars($book['category']) ?></p>
            </div>
        </div>
        <div>
            <script>
                function confirmRent() {
                    if (confirm("Are you sure you want to borrow this book?")) {
                        borrowBook($bookid);
                        
                        exit();
                    }
                }
            </script>
            <!-- Rent and cancel buttons -->
            <button onclick="confirmRent()" class="btn btn-info">Borrow</button>
            <a href="index.php?page=borrow" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</body>
</html>
<?php
    } else {
        setAlert("Book not found.", "danger");
        header('Location: index.php?page=borrow');
        exit();
    }
} else {
    // No ID was provided
    setAlert('No book ID specified.', 'danger');
    header('Location: index.php?page=borrow');
    exit();
}
?>
