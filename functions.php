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
                if ($row['borrowed'] == 0 or null){
                    $row['status'] = "Available";
                } else {
                    $row['status'] = "Borrowed";
                }
                $row['archived'] = "Not Archived";
            } elseif ($row['archived'] == 1) {
                $row['archived'] = "Archived";
                $row['status'] = "Archived";
            }
            $books[] = $row;
        }
        return $books;
    } else {
        return array();
    }
}

function addBook($bookId, $booktitle, $month, $day, $year, $dayAdded, $category, $archived) {
    global $conn; // Assuming $conn is the database connection object

    $sql = "INSERT INTO books (bookId, booktitle, month, day, year, category, archived) 
            VALUES ('$bookId','$booktitle', '$month', '$day', '$year', '$category', '$archived')";

    if ($conn->query($sql) === TRUE) {
        //echo "Video added successfully";
    } else {
        echo "Error adding book: " . $conn->error;
    }
}

function getUsername() {
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT username FROM login";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usernames = array();
        while ($row = $result->fetch_assoc()) {
            $usernames[] = $row['username'];
        }
        return $usernames;
    } else {
        return array();
    }
}

function getBookId($bookid) {
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT * FROM books WHERE bookid = '$bookid'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        return $result->fetch_assoc();
    } else {
        return array();
    }
}

function editBook($bookid, $newBookId, $booktitle, $month, $day, $year, $category, $archived) {
    global $conn; // Assuming $conn is the database connection object

    $sql = "UPDATE books SET bookId = '$newBookId', booktitle = '$booktitle', month = '$month', day = '$day', year = '$year', category = '$category', archived = '$archived' WHERE bookid = '$bookid'";

    if ($conn->query($sql) === TRUE) {
        echo "Book edited successfully";
    } else {
        echo "Error editing book: " . $conn->error;
    }
}

function register($username, $password) {
    global $conn; // Assuming $conn is the database connection object

    $sql = "INSERT INTO login (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully";
    } else {
        echo "Error registering user: " . $conn->error;
    }
    
}

function isBookBorrowed($bookid) {
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT borrowed, archived FROM books WHERE bookid = '$bookid'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['archived'] == 1) {
            return true;
        } else {
            return (bool) $row['borrowed'];
        }
    } else {
        return true;
    }
}
?>