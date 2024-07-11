<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once 'functions.php';

if (isset($_GET['bookid'])) {
    $bookid = htmlspecialchars($_GET['bookid']);
    $book = getBookId($bookid);
    if ($book !== null) {
?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Book Details</h3> 
        </div>
        <div class="card-body">
            <h5 class="card-title">Title: <?= htmlspecialchars($book['booktitle']) ?></h5>
            <p class="card-text">Author: <?= htmlspecialchars($book['author']) ?></p>
            <p class="card-text">Release Date: <?= htmlspecialchars(date('m-d-Y', strtotime($book['month'] . '/' . $book['day'] . '/' . $book['year']))) ?></p>
            <p class="card-text">Category: <?= htmlspecialchars($book['category']) ?></p>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-secondary" onclick="history.back();">Back</button>
        </div>
    </div>
</div>
<?php
    } else {
        echo '<div class="alert alert-warning">Book not found.</div>';
    }
} else {
    echo '<div class="alert alert-danger">No book ID specified.</div>';
}
?>