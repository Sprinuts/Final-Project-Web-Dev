<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Books</h3>
    </div>
    <div class="card-body">
        <div style="height: 600px; overflow: auto;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Month</th>
                        <th>Day</th>
                        <th>Year</th>
                        <th>Category</th>
                        <th>Archived</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include the file that contains the getBooks() function
                    include_once 'functions.php';
                    
                    $books = getBooks();
                    if (count($books) > 0) {
                        foreach ($books as $book) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($book['bookid']) . "</td>";
                            echo "<td>" . htmlspecialchars($book['booktitle']) . "</td>";
                            echo "<td>" . htmlspecialchars($book['month']) . "</td>";
                            echo "<td>" . htmlspecialchars($book['day']) . "</td>";
                            echo "<td>" . htmlspecialchars($book['year']) . "</td>";
                            echo "<td>" . htmlspecialchars($book['category']) . "</td>";
                            echo "<td>" . htmlspecialchars($book['archived']) . "</td>";
                            echo "<td>" . htmlspecialchars($book['count']) . "</td>";
                            echo "<td>
                                <a href='adminDashBoard.php?page=edit&bookid={$book['bookid']}' class='btn btn-info'>Edit</a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No books found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>