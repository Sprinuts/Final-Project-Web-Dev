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

// Check if a valid video ID is passed and rent has not yet been confirmed
if (isset($_GET['id']) && !isset($_GET['confirm'])) {
    $videoId = htmlspecialchars($_GET['id']);
    $video = getVideoById($videoId); // Retrieve video details

    if ($video) {
        // Display rent confirmation form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rent Video</title>
</head>
<body>
    <div class="container">
        <?php displayAlert(); // Display alert if there is one ?>
        <h1 style="padding-top: 20px;">Rent Video</h1>
        <p>Are you sure you want to rent this video?</p>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Title: <?= htmlspecialchars($video['title']) ?></h5>
                <p class="card-text">Director: <?= htmlspecialchars($video['director']) ?></p>
                <p class="card-text">Release Year: <?= htmlspecialchars($video['release_year']) ?></p>
                <p class="card-text">Casting Members: <?= htmlspecialchars($video['casting_members']) ?></p>
                <p class="card-text">Genre: <?= htmlspecialchars($video['genre']) ?></p>
                <p class="card-text">Description/Synopsis: <?= htmlspecialchars($video['description']) ?></p>
                <p class="card-text">Cost:  <?= htmlspecialchars($video['cost']) ?></p>
            </div>
        </div>
        <div>
            <!-- JavaScript for confirmation dialog -->
            <script>
                function confirmRent() {
                    if (confirm("Are you sure you want to rent this video?")) {
                        window.location.href = "renting.php?confirm=yes&id=<?= $videoId; ?>";
                    }
                }
            </script>
            <!-- Rent and cancel buttons -->
            <button onclick="confirmRent()" class="btn btn-info">Rent</button>
            <a href="index.php?page=rent" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</body>
</html>
<?php
    } else {
        setAlert("Video not found.", "danger");
        header('Location: index.php?page=rent');
        exit();
    }
} elseif (isset($_GET['confirm']) && $_GET['confirm'] == 'yes' && isset($_GET['id'])) {
    // Confirm rent
    if (rentVideo($_GET['id'])) {
        setAlert('Successfully rented a video.', 'success');
        $_SESSION['isVideoRented'][] = $_GET['id']; // Add rented video to session
    } else {
        setAlert('Insufficient balance.', 'danger');
    }
    header('Location: index.php?page=renting&id=' . $_GET['id']); // Stay on the same page after processing rent
    exit();
} else {
    // No ID was provided
    setAlert('No video ID specified.', 'danger');
    header('Location: index.php?page=rent');
    exit();
}
?>
