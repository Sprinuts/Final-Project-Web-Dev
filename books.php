<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Books</h3>
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
                    // Include the file that contains the getBooks() function
                    include_once 'functions.php';
                    
                    $books = getBooks();
                    if (count($books) > 0) {
                        foreach ($books as $book) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($book['booktitle']) . "</td>";
                            echo "<td>" . htmlspecialchars(date('m-d-Y', strtotime($book['month'] . '/' . $book['day'] . '/' . $book['year']))) . "</td>";
                            echo "<td>" . htmlspecialchars($book['category']) . "</td>";
                            echo "<td>" . htmlspecialchars($book['status']) . "</td>";
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
