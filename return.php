<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'functions.php';

$username = $_SESSION['username'];

$borrowedBooks = getBorrowedBooksList($username);
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Rented Videos</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($borrowedBooks) > 0) {
                    foreach ($borrowedBooks as $bookid) {
                        $bookTitle = getBookTitle($bookid['bookid']);
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($bookTitle) . "</td>";
                        $bookExists = checkBookExists($bookid['bookid']);
                        if (!$bookExists) {
                            echo "<td>
                            <a href='index.php?page=returning&bookid={$bookid['bookid']}' class='btn btn-info'>Return</a>
                            <a href='index.php?page=viewDetail&bookid={$bookid['bookid']}' class='btn btn-primary'>View Details</a>
                            </td>";
                            echo "</tr>";
                        } else {
                            echo "<td>Book is currently in return requests</td>";
                            echo "<td>
                            <a href='index.php?page=viewDetail&bookid={$bookid['bookid']}' class='btn btn-primary'>View Details</a>
                            </td>";
                            echo "</tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='2' class='text-center'>No rented videos found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
