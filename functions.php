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

function getBooks() {
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT * FROM books";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $books = array();
        while ($row = $result->fetch_assoc()) {
            // Modify the "archived" value
            if ($row['archived'] == 0) {
                $row['archived'] = "No";
            } elseif ($row['archived'] == 1) {
                $row['archived'] = "Yes";
            }
            $books[] = $row;
        }
        return $books;
    } else {
        return array();
    }
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