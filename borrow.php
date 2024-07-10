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
                            <th>Status</th>
                        </tr>
                </thead>
                <tbody>
                    <?php
                    include_once 'functions.php';
                    $books = getBooks();
                    if (count($books) > 0) {
                        $availableBook = array_filter($books, function($book) {
                            return !isBookBorrowed($book['bookid']);
                        });

                        if (count($availableBook) > 0) {
                            foreach ($availableBook as $book) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($book['booktitle']) . "</td>";
                                echo "<td>" . htmlspecialchars($book['author']) . "</td>";
                                echo "<td>" . htmlspecialchars(date('m-d-Y', strtotime($book['month'] . '/' . $book['day'] . '/' . $book['year']))) . "</td>";
                                echo "<td>" . htmlspecialchars($book['category']) . "</td>";
                                echo "<td>" . htmlspecialchars($book['status']) . "</td>";
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
