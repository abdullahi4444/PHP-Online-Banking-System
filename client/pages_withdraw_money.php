<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];

if (isset($_POST['withdrawal'])) {
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
    //$acc_new_amt = $_POST['acc_new_amt'];
    //$notification_details = $_POST['notification_details'];
    $notification_details = "$client_name Has Withdrawn $ $transaction_amt From Bank Account $account_number";

    /*
    * The below code will handle the withdrwawal process that is first it 
      checks if the selected back account has the any amount and secondly the money withdrawed should 
      no be be greater than the existing amount.
    *   
    */

    $result = "SELECT SUM(transaction_amt) FROM  iB_Transactions  WHERE account_id=?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('i', $account_id);
    $stmt->execute();
    $stmt->bind_result($amt);
    $stmt->fetch();
    $stmt->close();


    if ($transaction_amt > $amt) {
        $err = "You Do Not Have Sufficient Funds In Your Account.Your Existing Amount is $ $amt";
    } else {


        //Insert Captured information to a database table
        $query = "INSERT INTO iB_Transactions (tr_code, account_id, acc_name, account_number, acc_type,  tr_type, tr_status, client_id, client_name, client_national_id, transaction_amt, client_phone) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $notification = "INSERT INTO  iB_notifications (notification_details) VALUES (?)";
        $stmt = $mysqli->prepare($query);
        $notification_stmt = $mysqli->prepare($notification);
        //bind paramaters
        $rc = $stmt->bind_param('ssssssssssss', $tr_code, $account_id, $acc_name, $account_number, $acc_type, $tr_type, $tr_status, $client_id, $client_name, $client_national_id, $transaction_amt, $client_phone);
        $rc = $notification_stmt->bind_param('s', $notification_details);
        $stmt->execute();
        $notification_stmt->execute();
        //declare a varible which will be passed to alert function
        if ($stmt && $notification_stmt) {
            $success = "Funds Withdrawled";
        } else {
            $err = "Please Try Again Or Try Later";
        }

        /*
    if(isset($_POST['deposit']))
    {
       $account_id = $_GET['account_id'];
       $acc_amount = $_POST['acc_amount'];
        
        //Insert Captured information to a database table
        $query="UPDATE  iB_bankAccounts SET acc_amount=? WHERE account_id=?";
        $stmt = $mysqli->prepare($query);
        //bind paramaters
        $rc=$stmt->bind_param('si', $acc_amount, $account_id);
        $stmt->execute();

        //declare a varible which will be passed to alert function
        if($stmt )
        {
            $success = "Money Deposited";
        }
        else
        {
            $err = "Please Try Again Or Try Later";
        }   
    }   
    */
    }
}
?>
<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include("dist/_partials/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("dist/_partials/nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("dist/_partials/sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <?php
        $account_id = $_GET['account_id'];
        $ret = "SELECT * FROM  iB_bankAccounts WHERE account_id = ? ";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $account_id);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        $cnt = 1;
        while ($row = $res->fetch_object()) {



        ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Withdraw Money</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="pages_deposits">iBank Finances</a></li>
                                    <li class="breadcrumb-item"><a href="pages_deposits">Withdrawal</a></li>
                                    <li class="breadcrumb-item active"><?php echo $row->acc_name; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content" style="padding: 2rem; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
                    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto;">
                        <div class="row" style="display: flex; flex-wrap: wrap; margin: 0 -15px;">
                            <!-- left column -->
                            <div class="col-md-12" style="width: 100%; padding: 0 15px;">
                                <!-- general form elements -->
                                <div class="card card-purple" style="border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; transform: translateY(0);">
                                    <div class="card-header" style="background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%); padding: 1.5rem; border-bottom: none;">
                                        <h3 class="card-title" style="margin: 0; color: white; font-size: 1.5rem; font-weight: 600; letter-spacing: 0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">Withdrawal Request</h3>
                                    </div>
                                    <!-- form start -->
                                    <form method="post" enctype="multipart/form-data" role="form" style="padding: 0;">
                                        <div class="card-body" style="padding: 2rem; background-color: white;">

                                            <div class="row" style="display: flex; flex-wrap: wrap; margin: 0 -15px 20px -15px;">
                                                <div class="col-md-4 form-group" style="width: 33.33%; padding: 0 15px; margin-bottom: 1.5rem;">
                                                    <label for="exampleInputEmail1" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.9rem;">Client Name</label>
                                                    <input type="text" readonly name="client_name" value="<?php echo $row->client_name; ?>" required class="form-control" id="exampleInputEmail1" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; line-height: 1.5; color: #495057; background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 8px; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
                                                </div>
                                                <div class="col-md-4 form-group" style="width: 33.33%; padding: 0 15px; margin-bottom: 1.5rem;">
                                                    <label for="exampleInputPassword1" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.9rem;">Client National ID No.</label>
                                                    <input type="text" readonly value="<?php echo $row->client_national_id; ?>" name="client_national_id" required class="form-control" id="exampleInputEmail1" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; line-height: 1.5; color: #495057; background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 8px; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
                                                </div>
                                                <div class="col-md-4 form-group" style="width: 33.33%; padding: 0 15px; margin-bottom: 1.5rem;">
                                                    <label for="exampleInputEmail1" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.9rem;">Client Phone Number</label>
                                                    <input type="text" readonly name="client_phone" value="<?php echo $row->client_phone; ?>" required class="form-control" id="exampleInputEmail1" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; line-height: 1.5; color: #495057; background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 8px; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
                                                </div>
                                            </div>

                                            <div class="row" style="display: flex; flex-wrap: wrap; margin: 0 -15px 20px -15px;">
                                                <div class="col-md-4 form-group" style="width: 33.33%; padding: 0 15px; margin-bottom: 1.5rem;">
                                                    <label for="exampleInputEmail1" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.9rem;">Account Name</label>
                                                    <input type="text" readonly name="acc_name" value="<?php echo $row->acc_name; ?>" required class="form-control" id="exampleInputEmail1" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; line-height: 1.5; color: #495057; background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 8px; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
                                                </div>
                                                <div class="col-md-4 form-group" style="width: 33.33%; padding: 0 15px; margin-bottom: 1.5rem;">
                                                    <label for="exampleInputPassword1" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.9rem;">Account Number</label>
                                                    <input type="text" readonly value="<?php echo $row->account_number; ?>" name="account_number" required class="form-control" id="exampleInputEmail1" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; line-height: 1.5; color: #495057; background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 8px; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
                                                </div>
                                                <div class="col-md-4 form-group" style="width: 33.33%; padding: 0 15px; margin-bottom: 1.5rem;">
                                                    <label for="exampleInputEmail1" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.9rem;">Account Type | Category</label>
                                                    <input type="text" readonly name="acc_type" value="<?php echo $row->acc_type; ?>" required class="form-control" id="exampleInputEmail1" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; line-height: 1.5; color: #495057; background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 8px; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
                                                </div>
                                            </div>

                                            <div class="row" style="display: flex; flex-wrap: wrap; margin: 0 -15px 20px -15px;">
                                                <div class="col-md-6 form-group" style="width: 50%; padding: 0 15px; margin-bottom: 1.5rem;">
                                                    <label for="exampleInputEmail1" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.9rem;">Transaction Code</label>
                                                    <?php
                                                    //PHP function to generate random account number
                                                    $length = 20;
                                                    $_transcode =  substr(str_shuffle('0123456789QWERgfdsazxcvbnTYUIOqwertyuioplkjhmPASDFGHJKLMNBVCXZ'), 1, $length);
                                                    ?>
                                                    <input type="text" name="tr_code" readonly value="<?php echo $_transcode; ?>" required class="form-control" id="exampleInputEmail1" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; line-height: 1.5; color: #495057; background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 8px; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
                                                </div>

                                                <div class="col-md-6 form-group" style="width: 50%; padding: 0 15px; margin-bottom: 1.5rem;">
                                                    <label for="exampleInputPassword1" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.9rem;">Amount Withdraw</label>
                                                    <input type="text" name="transaction_amt" required class="form-control" id="exampleInputEmail1" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; line-height: 1.5; color: #495057; background-color: white; border: 1px solid #ced4da; border-radius: 8px; transition: all 0.3s ease; box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);">
                                                </div>
                                                
                                                <div class="col-md-4 form-group" style="display:none; width: 33.33%; padding: 0 15px; margin-bottom: 1.5rem;">
                                                    <label for="exampleInputPassword1" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.9rem;">Transaction Type</label>
                                                    <input type="text" name="tr_type" value="Withdrawal" required class="form-control" id="exampleInputEmail1" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; line-height: 1.5; color: #495057; background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 8px; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
                                                </div>
                                                <div class="col-md-4 form-group" style="display:none; width: 33.33%; padding: 0 15px; margin-bottom: 1.5rem;">
                                                    <label for="exampleInputPassword1" style="display: block; margin-bottom: 0.5rem; color: #495057; font-weight: 500; font-size: 0.9rem;">Transaction Status</label>
                                                    <input type="text" name="tr_status" value="Success " required class="form-control" id="exampleInputEmail1" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; line-height: 1.5; color: #495057; background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 8px; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer" style="padding: 1.5rem; background-color: #f8f9fa; border-top: 1px solid rgba(0,0,0,0.03); text-align: right;">
                                            <button type="submit" name="withdrawal" class="btn btn-success" style="display: inline-flex; align-items: center; justify-content: center; padding: 0.65rem 1.75rem; font-size: 0.95rem; font-weight: 500; line-height: 1.5; color: white; text-align: center; text-decoration: none; vertical-align: middle; cursor: pointer; user-select: none; background: linear-gradient(135deg, #e74c3c 0%, #f39c12 100%); border: none; border-radius: 8px; box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3); transition: all 0.3s ease; position: relative; overflow: hidden;">
                                                <span style="position: relative; z-index: 2;">Withdraw Funds</span>
                                                <span style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 100%); transform: translateY(100%); transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div><!-- /.container-fluid -->
                </section>

                <style>
                    /* Add this to your head section for hover effects */
                    .card.card-purple:hover {
                        transform: translateY(-5px) !important;
                        box-shadow: 0 15px 35px rgba(108, 92, 231, 0.2) !important;
                    }
                    
                    input[type="text"]:not([readonly]):focus {
                        border-color: #a29bfe !important;
                        box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.25) !important;
                        outline: 0;
                    }
                    
                    .btn-success:hover {
                        transform: translateY(-2px) !important;
                        box-shadow: 0 7px 20px rgba(231, 76, 60, 0.4) !important;
                    }
                    
                    .btn-success:hover span:last-child {
                        transform: translateY(0) !important;
                    }
                    
                    /* Special styling for the amount input */
                    input[name="transaction_amt"]:focus {
                        border-color: #e74c3c !important;
                        box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.25) !important;
                    }
                </style>
                <!-- /.content -->
            </div>
        <?php } ?>
        <!-- /.content-wrapper -->
        <?php include("dist/_partials/footer.php"); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>