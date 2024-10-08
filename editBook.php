<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $books = getBooks();
    $count = 0;
    foreach ($books as $book) {
        if ($book['bookid'] == $_GET['bookid']) {
            $count = $book['count'];
            $dayAdded = $book['dayAdded'];
            break;
        }
    }

    $formattedBookCount = sprintf("%05d", $count);

    $date = $_POST['date'];
    $parts = explode('-', $date);
    $monthNum = $parts[1];
    $day = $parts[2];
    $year = $parts[0];

    // Convert the month number to month name
    $monthText = date("F", mktime(0, 0, 0, $monthNum, 10));
    $month = substr($monthText, 0, 3);

    $bookcategory = substr($_POST['category'], 0, 3);

    $booktitle = preg_replace('/\s+/', '', $_POST['booktitle']);
    $booktitle = substr($booktitle, 0, 2);

    # Generate a unique book ID
    $newBookId = strtoupper($booktitle) . strtoupper($month) . $dayAdded . $year . '-' . strtoupper($bookcategory) . $formattedBookCount;

    editBook($_GET['bookid'], $newBookId, $_POST['booktitle'], $_POST['author'],$monthNum, $day, $year, $_POST['category'], $_POST['archived']);

    header('Location: adminDashBoard.php?page=updateSuccess');
}

if (isset($_GET['bookid'])) {
    $bookId = getBookId($_GET['bookid']);
    $bookdate = $bookId['year'] . '-' . $bookId['month'] . '-' . $bookId['day'];
    if ($bookId !== null) {
        if ($bookId['borrowed'] == 1) {
            echo '<div class="alert alert-warning">This book is currently borrowed and cannot be edited.</div>';
        } else {
?>
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Edit Book</h3>
    </div>
    <form action="adminDashBoard.php?page=edit&bookid=<?php echo $bookId['bookid']; ?>" method="post">
        <div class="card-body">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" name="booktitle" value="<?php echo htmlspecialchars($bookId['booktitle']); ?>" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" name="author" placeholder="Enter author" value="<?php echo htmlspecialchars($bookId['author']); ?>" required>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" name="date" value="<?php echo htmlspecialchars($bookdate); ?>" required>
            </div>
            <div class="form-group">
                <label for="category">Genre</label>
                <select class="form-control" name="category" value="<?php echo htmlspecialchars($bookId['category']); ?>" required>
                    <option value="">Select genre</option>
                    <option value="Action">Action</option>
                    <option value="Adventure">Adventure</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Drama">Drama</option>
                    <option value="Horror">Horror</option>
                    <option value="Mystery">Mystery</option>
                    <option value="Romance">Romance</option>
                    <option value="Thriller">Thriller</option>
                    <option value="Fiction">Fiction</option>
                </select>
            </div>
            <div class="form-group">
                <label for="archive">Is the book archived</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="archived" id="archiveYes" value="1" <?php if ($bookId['archived'] == 1) echo "checked"; ?> required>
                    <label class="form-check-label" for="archiveYes">
                        Yes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="archived" id="archiveNo" value="0" <?php if ($bookId['archived'] == 0) echo "checked"; ?> required>
                    <label class="form-check-label" for="archiveNo">
                        No
                    </label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-info">Update Book</button>
            <button type="button" class="btn btn-default" onclick="window.location.href='adminDashBoard.php?page=viewBook';">Cancel</button>
        </div>
    </form>
</div>
<?php
        }
    } else {
        echo '<div class="alert alert-warning">Book not found.</div>';
    }
} else {
    echo '<div class="alert alert-danger">No book ID specified.</div>';
}
?>