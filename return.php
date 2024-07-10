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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($borrowedBooks) > 0) {
                    foreach ($borrowedBooks as $bookId) {
                        $bookTitle = getBookTitle($bookId); // Assuming you have a function to get the book title based on the book ID
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($bookTitle) . "</td>";
                        echo "<td>
                            <a href='index.php?page=return&bookid={$bookId}' class='btn btn-info'>Return</a>
                            <a href='index.php?page=viewDetail&bookid={$bookId}' class='btn btn-primary'>View Details</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' class='text-center'>No rented videos found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
