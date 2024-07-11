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
    <style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 350px;
            width: 100%;
            position: relative;
            text-align: center;
            margin-top: 50vh;
            margin-bottom: 10vh; 
        }
        .img-fluid {
            border: 5px solid #007bff;
            padding: 5px;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            transition: transform 0.3s ease-in-out;
        }
        .img-fluid:hover {
            transform: scale(1.1);
        }
        h3 {
            font-size: 1.75rem;
            margin-bottom: 15px;
            color: #333;
        }
        strong {
            color: #007bff;
            font-size: 1.1rem;
        }
        .balance {
            font-size: 1.25rem;
            margin: 10px 0;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 25px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            cursor: pointer;
            color: #fff;
            text-decoration: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .mt-3 {
            margin-top: 1.5rem !important;
        }
        .text-center {
            text-align: center;
        }
        /* Additional Styles */
        .container {
            padding: 30px; /* Adjusted padding */
        }
        .img-fluid {
            margin-bottom: 20px; /* Spacing below profile picture */
        }
        .btn-primary {
            margin-top: 20px; /* Spacing above the button */
        }
        .balance {
            color: #6c757d; /* Adjusted balance text color */
        }
        .btn-primary {
            font-weight: bold; /* Increased button font weight */
        }
    </style>
</head>
<body>
    <div class="container mt-5 d-flex justify-content-center">
        <div class="row w-100">
            <div class="col-md-12 text-center mb-4">
                <img src="userprofile/<?php echo ($user['profilepic'] ? htmlspecialchars($user['profilepic']) : 'defaultprofile.jpg'); ?>" alt="Profile Picture" class="img-fluid">
            </div>
            <div class="col-md-12 text-center">
                <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                <div class="balance">
                    <strong>Balance:</strong> <?php echo htmlspecialchars($user['money']); ?>
                </div>
                <div class="mt-3">
                    <a href="index.php?page=deposit" class="btn btn-primary">Deposit</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
