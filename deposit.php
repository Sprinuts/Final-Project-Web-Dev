<?php
include_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    requestDeposit($_POST['addBalance']);
    header("Location: index.php?page=depositSuccess");
}
$username = $_SESSION['username'];
$user = getUserInfo($username);
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Account Balance</h3>
    </div>
    <div class="card-body">
        <h4>Current Balance: $<?php echo htmlspecialchars($user['money']); ?></h4>
        <form id="addBalanceForm" method="post" action="index.php?page=deposit">
            <div class="form-group">
                <label for="addBalance">Add Balance</label>
                <input type="number" class="form-control" name="addBalance" id="addBalance" placeholder="Enter amount" min="0.01" max="9999999.99" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Balance</button>
        </form>
    </div>
</div>