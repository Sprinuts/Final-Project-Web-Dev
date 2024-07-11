<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'functions.php';

$returnRequests = getReturnRequests();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['returnButton'])) {
        $requestId = $_POST['returnButton'];
        returnBook($requestId);
    } elseif (isset($_POST['rejectButton'])) {
        $requestId = $_POST['rejectButton'];
        cancelRequest($requestId);
        header('Location: index.php?page=returnRequest');
    }
}
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
                    <th>Approve</th>
                    <th>Reject</th>
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
                            <form method='post'>
                                <input type='hidden' name='returnButton' value='{$request['borrowedid']}' />
                                <button type='submit' class='btn btn-success'>Approve</button>
                            </form>
                            </td>";
                        echo "<td>
                            <form method='post'>
                                <input type='hidden' name='rejectButton' value='{$request['borrowedid']}' />
                                <button type='submit' class='btn btn-danger'>Reject</button>
                            </form>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No return requests found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
