<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Book</h3>
    </div>
    <form action="addBookProcess.php" method="post"></form>
        <div class="card-body">
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
                <label for="category">Category</label>
                <input type="text" class="form-control" name="category" placeholder="Enter category" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Add Book</button>
        </div>
    </form>
</div>
