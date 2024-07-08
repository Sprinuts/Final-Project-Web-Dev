<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jaysql";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function addBook($bookId, $booktitle, $month, $day, $year, $category, $archived) {
    global $conn; // Assuming $conn is the database connection object

    $sql = "INSERT INTO books (bookId, booktitle, month, day, year, category, archived) 
            VALUES ('$bookId','$booktitle', '$month', '$day', '$year', '$category', '$archived')";

    if ($conn->query($sql) === TRUE) {
        echo "Video added successfully";
    } else {
        echo "Error adding book: " . $conn->error;
    }
}


?>