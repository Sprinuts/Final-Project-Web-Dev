<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'functions.php';

$returnDepositRequests = returnDepositRequest();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['returnButton'])) {
        $requestId = $_POST['returnButton'];
        depositAprove($requestId);
    } elseif (isset($_POST['rejectButton'])) {
        $requestId = $_POST['rejectButton'];
        cancelRequest($requestId);
        header('Location: index.php?page=deposit');
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
                    <th>Username</th>
                    <th>Amount</th>
                    <th>Approve</th>
                    <th>Reject</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($returnDepositRequests) > 0) {
                    foreach ($returnDepositRequests as $request) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($request['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($request['amount']) . "</td>";
                        echo "<td>
                            <form method='post'>
                                <input type='hidden' name='returnButton' value='{$request['username']}' />
                                <button type='submit' class='btn btn-success'>Approve</button>
                            </form>
                            </td>";
                        echo "<td>
                            <form method='post'>
                                <input type='hidden' name='rejectButton' value='{$request['username']}' />
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
