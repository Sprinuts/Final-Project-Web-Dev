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

// Check if a valid book ID is passed and return has not yet been confirmed
if (isset($_GET['bookid']) && !isset($_GET['confirm'])) {
    $bookid = htmlspecialchars($_GET['bookid']);
    $book = getBookId($bookid); // Retrieve book details

    if ($book) {
        // Display return confirmation form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Book</title>
</head>
<body>
    <div class="container">
        <?php displayAlert(); // Display alert if there is one ?>
        <h1 style="padding-top: 20px;">Return Book</h1>
        <p>Are you sure you want to return this book?</p>
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
                function confirmReturn() {
                    if (confirm("Are you sure you want to return this book?")) {
                        window.location.href = "returnRequest.php?confirm=yes&bookid=<?= $bookid; ?>";
                    }
                }
            </script>
            <!-- Return and cancel buttons -->
            <button onclick="confirmReturn()" class="btn btn-info">Return</button>
            <a href="index.php?page=return" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</body>
</html>
<?php
    } else {
        setAlert("Book not found.", "danger");
        //header('Location: index.php?page=return');
        exit();
    }
} elseif (isset($_GET['confirm']) && $_GET['confirm'] == 'yes' && isset($_GET['bookid'])) {
    // Confirm return
    $bookid = htmlspecialchars($_GET['bookid']);
    if (returnBook($bookid)) {
        setAlert('Request Sent.', 'success');
        returnBook($bookid);
        header('Location: index.php?page=return');
    } else {
        setAlert('Unsuccessful', 'danger');
    }
    header('Location: index.php?page=returnSuccess'); 
    exit();
} else {
    // No ID was provided
    setAlert('No book ID specified.', 'danger');
    header('Location: index.php?page=return');
    exit();
}
?>