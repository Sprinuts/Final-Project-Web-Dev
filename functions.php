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

function addBook($bookId, $booktitle, $author, $month, $day, $year, $dayAdded, $category, $archived) {
    global $conn; // Assuming $conn is the database connection object

    $sql = "INSERT INTO books (bookId, booktitle, author,month, day, year, dayAdded ,category, archived) 
            VALUES ('$bookId','$booktitle', '$author','$month', '$day', '$year', $dayAdded,'$category', '$archived')";

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

function requestDeposit($addBalance){
    global $conn; // Assuming $conn is the database connection object

    $username = $_SESSION['username'];
    $sql = "INSERT INTO depositreq (username, amount) VALUES ('$username', $addBalance)";

    if ($conn->query($sql) === TRUE) {
        echo "Deposit request stored successfully";
    } else {
        echo "Error storing deposit request: " . $conn->error;
    }
}

function getAllUsernames() {
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT username FROM depositreq";
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

function isMoneyNegative($username){
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT money FROM login WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['money'] < 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function depositAprove($username){
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT amount FROM depositreq WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $amount = $row['amount'];

        $sql = "UPDATE login SET money = money + $amount WHERE username = '$username'";
        if ($conn->query($sql) === TRUE) {
            echo "Money updated successfully";
        } else {
            echo "Error updating money: " . $conn->error;
        }
    } else {
        echo "Username not found in depositreq table";
    }

    $sql = "DELETE FROM depositreq WHERE username = '$username'";
    if ($conn->query($sql) === TRUE) {
        echo "Deposit request deleted successfully";
    } else {
        echo "Error deleting deposit request: " . $conn->error;
    }
}

function returnDepositRequest(){
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT * FROM depositreq";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $requests = array();
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }
        return $requests;
    } else {
        return array();
    }
}

function getUserInfo($username) {
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT * FROM login WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return array();
    }
}
function getBorrowedBooks($username) {
    global $conn; // Assuming $conn is the database connection object
    $sql = "SELECT borrowed1, borrowed2 FROM login WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['borrowed1'] != null && $row['borrowed2'] != null) {
            return true;
        }
    } else{
        return false;
    }
}

function getBorrowedBooksList($username) {
    global $conn; // Assuming $conn is the database connection object
    $sql = "SELECT borrowed1, borrowed2 FROM login WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $books = array();
        if ($row['borrowed1'] != null) {
            $books[] = getBookId($row['borrowed1']);
        }
        if ($row['borrowed2'] != null) {
            $books[] = getBookId($row['borrowed2']);
        }
        return $books;
    } else {
        return array();
    }
}

function getBookTitle($bookid){
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT booktitle FROM books WHERE bookid = '$bookid'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row['booktitle'];
    } else {
        return null;
    }
}

function checkBookExists($bookid){
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT * FROM returnreq WHERE borrowedid = '$bookid'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        return true;
    } else {
        return false;
    }
}

function returnRequest($bookid){
    global $conn; // Assuming $conn is the database connection object

    $username = $_SESSION['username'];

    $sql = "INSERT INTO returnreq (borrowedid, username) VALUES ('$bookid', '$username')";

    $sql = "UPDATE books SET isreturning = 1 WHERE bookid = '$bookid'";
    if ($conn->query($sql) === TRUE) {
        echo "Return request updated successfully";
    } else {
        echo "Error storing return request: " . $conn->error;
    }
}

function returnBook($bookid){
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT username FROM returnreq WHERE borrowedid = '$bookid'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
    } else {
        echo "Username not found in returnreq table";
        return;
    }
    $sql = "SELECT borrowed1, borrowed2 FROM login WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['borrowed1'] == $bookid) {
            $sql = "UPDATE login SET borrowed1 = NULL WHERE username = '$username'";
        } elseif ($row['borrowed2'] == $bookid) {
            $sql = "UPDATE login SET borrowed2 = NULL WHERE username = '$username'";
        } else {
            echo "Book not found in user's borrowed list";
            return;
        }

        if ($conn->query($sql) === TRUE) {
            echo "Book removed from user's borrowed list";
        } else {
            echo "Error removing book from user's borrowed list: " . $conn->error;
        }
        
        $sql = "SELECT borrowDate FROM books WHERE bookid = '$bookid'";
        $result = $conn->query($sql);

        // Calculate fine if necessary
        $row = $result->fetch_assoc();
        $borrowDate = $row['borrowDate'];
        $currentDate = date('Y-m-d');
        $daysDiff = (strtotime($currentDate) - strtotime($borrowDate)) / (60 * 60 * 24);
        if ($daysDiff > 7) {
            $daysDiff -= 7; 
            $fine = $daysDiff * 10;
            $sql = "UPDATE login SET money = money - $fine WHERE username = '$username'";
            if ($conn->query($sql) === TRUE) {
                echo "Fine of $fine deducted from user's money";
            } else {
                echo "Error deducting fine from user's money: " . $conn->error;
            }
        }
    } else {
        echo "User not found";
    }

    $sql = "UPDATE books SET borrowed = 0, borrowDate = NULL WHERE bookid = '$bookid'";

    if ($conn->query($sql) === TRUE) {
        echo "Book returned successfully";
    } else {
        echo "Error returning book: " . $conn->error;
    }

    $sql = "DELETE FROM returnreq WHERE borrowedid = '$bookid'";

    if ($conn->query($sql) === TRUE) {
        echo "Return request deleted successfully";
    } else {
        echo "Error deleting return request: " . $conn->error;
    }

    $sql = "UPDATE books SET isreturning = 0 WHERE bookid = '$bookid'";
    if ($conn->query($sql) === TRUE) {
        echo "Return request updated successfully";
    } else {
        echo "Error storing return request: " . $conn->error;
    }
}

function cancelRequest($bookid){
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT username FROM returnreq WHERE borrowedid = '$bookid'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
    } else {
        echo "Username not found in returnreq table";
        return;
    }

    $sql = "DELETE FROM returnreq WHERE borrowedid = '$bookid'";

    if ($conn->query($sql) === TRUE) {
        echo "Return request deleted successfully";
    } else {
        echo "Error deleting return request: " . $conn->error;
    }
}

function getReturnRequests(){
    global $conn; // Assuming $conn is the database connection object

    $sql = "SELECT * FROM returnreq";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $requests = array();
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }
        return $requests;
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

function editBook($bookid, $newBookId, $booktitle, $author, $month, $day, $year, $category, $archived) {
    global $conn; // Assuming $conn is the database connection object

    $sql = "UPDATE books SET bookId = '$newBookId', booktitle = '$booktitle', author = '$author', month = '$month', day = '$day', year = '$year', category = '$category', archived = '$archived' WHERE bookid = '$bookid'";

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

function borrowBook($bookid) {
    global $conn; // Assuming $conn is the database connection object

    $sql = "UPDATE books SET borrowed = 1, borrowDate = CURDATE() WHERE bookid = '$bookid'";

    if ($conn->query($sql) === TRUE) {
        echo "Book borrowed successfully";
    } else {
        echo "Error borrowing book: " . $conn->error;
    }

    $username = $_SESSION['username'];
    $sql = "SELECT borrowed1, borrowed2 FROM login WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['borrowed1'] == null) {
            $sql = "UPDATE login SET borrowed1 = '$bookid' WHERE username = '$username'";
        } elseif ($row['borrowed2'] == null) {
            $sql = "UPDATE login SET borrowed2 = '$bookid' WHERE username = '$username'";
        } else {
            echo "User has already borrowed 2 books";
            return;
        }

        if ($conn->query($sql) === TRUE) {
            echo "Book added to user's borrowed list";
        } else {
            echo "Error adding book to user's borrowed list: " . $conn->error;
        }
    } else {
        echo "User not found";
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