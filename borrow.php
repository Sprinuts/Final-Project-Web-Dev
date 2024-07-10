<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'functions.php';
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $borrowedBooks = getBorrowedBooks($username);
    if ($borrowedBooks) {
        echo "<div class='alert alert-danger'>You have already borrowed 2 books. Please return a book before borrowing another.</div>";
    } else{
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Available Books</h3>
    </div>
    <div class="card-body">
        <div style="height: 600px; overflow: auto;">
            <table class="table table-bordered">
                <thead>
                        <tr>
                            <th>Title</th>
                            <th>Release Date</th>
                            <th>Category</th>
                        </tr>
                </thead>
                <tbody>
                    <?php
                    $books = getBooks();
                    if (count($books) > 0) {
                        $availableBook = array_filter($books, function($book) {
                            return !isBookBorrowed($book['bookid']);
                        });

                        if (count($availableBook) > 0) {
                            foreach ($availableBook as $book) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($book['booktitle']) . "</td>";
                                echo "<td>" . htmlspecialchars(date('m-d-Y', strtotime($book['month'] . '/' . $book['day'] . '/' . $book['year']))) . "</td>";
                                echo "<td>" . htmlspecialchars($book['category']) . "</td>";
                                echo "<td>
                                    <a href='index.php?page=borrowBook&bookid={$book['bookid']}' class='btn btn-info'>Borrow</a>
                                    <a href='index.php?page=viewDetail&bookid={$book['bookid']}' class='btn btn-primary'>View Details</a>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No videos available to rent</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No videos available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
}
}
?>