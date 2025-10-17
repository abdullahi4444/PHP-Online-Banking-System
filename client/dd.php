<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();

if (isset($_POST['deposit'])) {
    $tr_code = $_POST['tr_code'];
    $sender_account_number = $_POST['sender_account_number'];
    $transaction_amt = $_POST['transaction_amt'];
    $client_id = $_SESSION['client_id'];
    $client_name = $_SESSION['client_name'];

    // Receiver Info
    $receiving_acc_no = $_POST['receiving_acc_no'];
    $receiving_acc_holder = $_POST['receiving_acc_holder'];

    // ✅ Step 1: Get sender account_id
    $stmt = $mysqli->prepare("SELECT account_id FROM iB_bank_Accounts WHERE account_number = ? AND client_id = ?");
    $stmt->bind_param("si", $sender_account_number, $client_id);
    $stmt->execute();
    $stmt->bind_result($sender_account_id);
    $stmt->fetch();
    $stmt->close();

    // ✅ Step 2: Check if sender has enough balance
    $stmt = $mysqli->prepare("SELECT SUM(transaction_amt) FROM iB_Transactions WHERE account_id = ?");
    $stmt->bind_param("i", $sender_account_id);
    $stmt->execute();
    $stmt->bind_result($sender_balance);
    $stmt->fetch();
    $stmt->close();

    if ($sender_balance < $transaction_amt) {
        echo "<script>alert('Insufficient balance!');</script>";
        exit();
    }

    // ✅ Step 3: Deduct from sender
    $stmt = $mysqli->prepare("INSERT INTO iB_Transactions (account_id, account_number, transaction_amt, tr_type, tr_status, tr_code, client_id, client_name)
                              VALUES (?, ?, ?, 'Debit', 'Success', ?, ?, ?)");
    $stmt->bind_param("isdsss", $sender_account_id, $sender_account_number, $transaction_amt, $tr_code, $client_id, $client_name);
    $stmt->execute();
    $stmt->close();

    // ✅ Step 4: Get receiver account and client ID
    $stmt = $mysqli->prepare("SELECT account_id, client_id FROM iB_Client_Accounts WHERE account_number = ?");
    $stmt->bind_param("s", $receiving_acc_no);
    $stmt->execute();
    $stmt->bind_result($receiver_account_id, $receiver_client_id);
    $stmt->fetch();
    $stmt->close();

    if (!$receiver_account_id) {
        echo "<script>alert('Receiver account not found!');</script>";
        exit();
    }

    // ✅ Step 5: Add to receiver
    $stmt = $mysqli->prepare("INSERT INTO iB_Transactions (account_id, account_number, transaction_amt, tr_type, tr_status, tr_code, client_id, client_name)
                              VALUES (?, ?, ?, 'Credit', 'Success', ?, ?, ?)");
    $stmt->bind_param("isdsss", $receiver_account_id, $receiving_acc_no, $transaction_amt, $tr_code, $receiver_client_id, $receiving_acc_holder);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Transfer Successful');</script>";
    echo "<script>window.location.href='pages_dashboard.php';</script>";
}
?>
