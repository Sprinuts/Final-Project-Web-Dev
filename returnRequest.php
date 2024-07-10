<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'functions.php';

$returnRequests = getReturnRequests();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Return Requests</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($returnRequests) > 0) {
                    foreach ($returnRequests as $request) {
                        $bookTitle = getBookTitle($request['borrowedid']);
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($bookTitle) . "</td>";
                        echo "<td>
                            <form method='post' action=''>
                                <button type='submit' class='btn btn-success'>Approve</button>
                            </form>
                            <a href='adminDashBoard.php?page=rejectReturn&requestid={$request['borrowedid']}' class='btn btn-danger'>Reject</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' class='text-center'>No return requests found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
