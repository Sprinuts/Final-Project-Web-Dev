<?php

include_once 'functions.php'; 
$username = $_SESSION['username'];

$user = getUserInfo($username);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="userprofile/<?php echo ($user['profilepic'] ? htmlspecialchars($user['profilepic']) : 'defaultprofile.jpg'); ?>" alt="Profile Picture" class="img-fluid rounded-circle">
            </div>
            <div class="col-md-8">
                <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                <div>
                    Balance: <?php echo htmlspecialchars($user['money']); ?>
                </div>
                <div>
                    <a href="index.php?page=deposit" class="btn btn-primary">Deposit</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>