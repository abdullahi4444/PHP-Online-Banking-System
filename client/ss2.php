<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];

if (isset($_POST['deposit'])) {
    $tr_code = $_POST['tr_code'];
    $account_id = $_GET['account_id'];
    $acc_name = $_POST['acc_name'];
    $account_number = $_GET['account_number'];
    $acc_type = $_POST['acc_type'];
    //$acc_amount  = $_POST['acc_amount'];
    $tr_type  = $_POST['tr_type'];
    $tr_status = $_POST['tr_status'];
    $client_id  = $_GET['client_id'];
    $client_name  = $_POST['client_name'];
    $client_national_id  = $_POST['client_national_id'];
    $transaction_amt = $_POST['transaction_amt'];
    $client_phone = $_POST['client_phone'];

    //Few fields to hold funds transfers
    $receiving_acc_no = $_POST['receiving_acc_no'];
    $receiving_acc_name = $_POST['receiving_acc_name'];
    $receiving_acc_holder = $_POST['receiving_acc_holder'];

    //Notication
    $notification_details = "$client_name Has Transfered $ $transaction_amt From Bank Account $account_number To Bank Account $receiving_acc_no";


    /*
            *You cant transfer money from an bank account that has no money in it so
            *Lets Handle that here.
            */
    $result = "SELECT SUM(transaction_amt) FROM  iB_Transactions  WHERE account_id=?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('i', $account_id);
    $stmt->execute();
    $stmt->bind_result($amt);
    $stmt->fetch();
    $stmt->close();




    if ($transaction_amt > $amt) {
        $transaction_error  =  "You Do Not Have Sufficient Funds In Your Account For Transfer Your Current Account Balance Is $ $amt";
    } else {


        //Insert Captured information to a database table
        $query = "INSERT INTO iB_Transactions (tr_code, account_id, acc_name, account_number, acc_type,  tr_type, tr_status, client_id, client_name, client_national_id, transaction_amt, client_phone, receiving_acc_no, receiving_acc_name, receiving_acc_holder) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $notification = "INSERT INTO  iB_notifications (notification_details) VALUES (?)";

        $stmt = $mysqli->prepare($query);
        $notification_stmt = $mysqli->prepare($notification);

        //bind paramaters
        $rc = $stmt->bind_param('sssssssssssssss', $tr_code, $account_id, $acc_name, $account_number, $acc_type, $tr_type, $tr_status, $client_id, $client_name, $client_national_id, $transaction_amt, $client_phone, $receiving_acc_no, $receiving_acc_name, $receiving_acc_holder);
        $rc = $notification_stmt->bind_param('s', $notification_details);

        $stmt->execute();
        $notification_stmt->execute();


        //declare a varible which will be passed to alert function
        if ($stmt && $notification_stmt) {
            $success = "Money Transfered";
        } else {
            $err = "Please Try Again Or Try Later";
        }
    }
}



?>