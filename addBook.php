<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the latest book count from the database
    $books = getBooks();
    $latestBook = end($books);
    $count = $latestBook['count'];

    // Format the latest book count
    $formattedBookCount = sprintf("%05d", $count + 1);

    // Check if the book count has reached the maximum limit
    if ($formattedBookCount == "99999") {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Maximum book count reached. Cannot add more books.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    } else {
        // Set the book count
        $bookcount = $formattedBookCount;

        // Get the date from the form
        $date = $_POST['date'];
        $parts = explode('-', $date);
        $monthNum = $parts[1];
        $day = $parts[2];
        $dayAdded = date('d');
        $year = $parts[0];

        // Convert the month number to month name
        $monthText = date("F", mktime(0, 0, 0, $monthNum, 10));
        $month = substr($monthText, 0, 3);

        $bookcategory = substr($_POST['category'], 0, 3);

        $booktitle = preg_replace('/\s+/', '', $_POST['booktitle']);
        $booktitle = substr($booktitle, 0, 2);

        # Generate a unique book ID
        $bookId = strtoupper($booktitle) . strtoupper($month) . $dayAdded . $year . '-' . strtoupper($bookcategory) . $bookcount;

        // Call the addBook function from functions.php
        addBook($bookId, $_POST['booktitle'], $_POST['author'], $monthNum, $day, $year, $dayAdded ,$_POST['category'], $_POST['archived']);

        // Display a success message
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Book added successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}
?>


<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Book</h3>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label for="booktitle">Title</label>
                <input type="text" class="form-control" name="booktitle" placeholder="Enter title" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" name="booktitle" placeholder="Enter author" required>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" name="date" required>
            </div>
            <div class="form-group">
                <label for="category">Genre</label>
                <select class="form-control" name="category" required>
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
                    <input class="form-check-input" type="radio" name="archived" id="archiveYes" value="1" required>
                    <label class="form-check-label" for="archiveYes">
                        Yes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="archived" id="archiveNo" value="0" required>
                    <label class="form-check-label" for="archiveNo">
                        No
                    </label>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Add Book</button>
            </div>
        </form>
    </div>
</div>
