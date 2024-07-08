<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate book ID
    $bookId = substr(strtoupper($_POST['booktitle']), 0, 2) . strtoupper($_POST['month']) . $_POST['day'] . $_POST['year'] . '-' . $_POST['category'];

    // Call the addBook function from functions.php
    addBook($bookId, $_POST['booktitle'], $_POST['month'], $_POST['day'], $_POST['year'], $_POST['category'], $_POST['archived']);

    // Display a success message
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Video added successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
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
                <label for="month">Month</label>
                <input type="text" class="form-control" name="month" placeholder="Enter month" required>
            </div>
            <div class="form-group">
                <label for="day">Day</label>
                <input type="text" class="form-control" name="day" placeholder="Enter day" required>
            </div>
            <div class="form-group">
                <label for="year">Year</label>
                <input type="text" class="form-control" name="year" placeholder="Enter year" required>
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
                <label for="archive">Archive</label>
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
