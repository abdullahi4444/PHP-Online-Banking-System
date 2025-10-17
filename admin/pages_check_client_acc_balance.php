<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

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
        /*  Im About to do something stupid buh lets do it
         *  get the sumof all deposits(Money In) then get the sum of all
         *  Transfers and Withdrawals (Money Out).
         * Then To Calculate Balance and rate,
         * Take the rate, compute it and then add with the money in account and 
         * Deduce the Money out
         *
         */

        //get the total amount deposited
        $account_id = $_GET['account_id'];
        $result = "SELECT SUM(transaction_amt) FROM iB_Transactions WHERE  account_id = ? AND  tr_type = 'Deposit' ";
        $stmt = $mysqli->prepare($result);
        $stmt->bind_param('i', $account_id);
        $stmt->execute();
        $stmt->bind_result($deposit);
        $stmt->fetch();
        $stmt->close();

        //get total amount withdrawn
        $account_id = $_GET['account_id'];
        $result = "SELECT SUM(transaction_amt) FROM iB_Transactions WHERE  account_id = ? AND  tr_type = 'Withdrawal' ";
        $stmt = $mysqli->prepare($result);
        $stmt->bind_param('i', $account_id);
        $stmt->execute();
        $stmt->bind_result($withdrawal);
        $stmt->fetch();
        $stmt->close();

        //get total amount transfered
        $account_id = $_GET['account_id'];
        $result = "SELECT SUM(transaction_amt) FROM iB_Transactions WHERE  account_id = ? AND  tr_type = 'Transfer' ";
        $stmt = $mysqli->prepare($result);
        $stmt->bind_param('i', $account_id);
        $stmt->execute();
        $stmt->bind_result($Transfer);
        $stmt->fetch();
        $stmt->close();



        $account_id = $_GET['account_id'];
        $ret = "SELECT * FROM  iB_bankAccounts WHERE account_id =? ";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $account_id);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        $cnt = 1;
        while ($row = $res->fetch_object()) {
            //compute rate
            $banking_rate = ($row->acc_rates) / 100;
            //compute Money out
            $money_out = $withdrawal + $Transfer;
            //compute the balance
            $money_in = $deposit - $money_out;
            //get the rate
            $rate_amt = $banking_rate * $money_in;
            //compute the intrest + balance 
            $totalMoney = $rate_amt + $money_in;

        ?>
            <div class="content-wrapper" style="background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                <!-- Content Header (Page header) -->
                <section class="content-header" style="padding: 20px; background: #ffffff; border-bottom: 1px solid #eaeff5;">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <h1 style="margin: 0; font-weight: 600; color: #2d3748; font-size: 1.8rem;"><?php echo $row->client_name; ?> iBanking Account Balance</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol style="display: flex; justify-content: flex-end; margin: 0; padding: 0; list-style: none;">
                                    <li style="margin-left: 10px;"><a href="pages_dashboard.php" style="color: #4a5568; text-decoration: none;">Dashboard</a></li>
                                    <li style="margin-left: 10px;"><a href="pages_balance_enquiries.php" style="color: #4a5568; text-decoration: none;"> / Finances</a></li>
                                    <li style="margin-left: 10px;"><a href="pages_balance_enquiries.php" style="color: #4a5568; text-decoration: none;"> / Balances / </a></li>
                                    <li style="margin-left: 10px; color: #a0aec0;"><?php echo $row->client_name; ?> Accs</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content" style="background: #f9fafb; padding: 20px 0;">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-12">
                            <!-- Main content -->
                            <div id="balanceSheet" class="invoice p-4 mb-4" style="background: #fff; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.08);">
                            <!-- Title row -->
                            <div class="row mb-3">
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                <h4 class="mb-0" style="font-weight: 700; color: #2c3e50;">
                                    <i class="fas fa-bank" style="color: #27ae60;"></i> iBanking Corporation Balance Enquiry
                                </h4>
                                <small style="color: #666; font-weight: 500;">Date: <?php echo date('d/m/Y'); ?></small>
                                </div>
                            </div>

                            <!-- Account info rows -->
                            <div class="row invoice-info mb-4" style="border-bottom: 1px solid #eee; padding-bottom: 20px;">
                                <div class="col-sm-6">
                                <h5 style="font-weight: 600; color: #34495e; margin-bottom: 10px;">Account Holder</h5>
                                <address style="font-size: 15px; color: #555;">
                                    <strong><?php echo $row->client_name; ?></strong><br>
                                    Client No: <?php echo $row->client_number; ?><br>
                                    Email: <?php echo $row->client_email; ?><br>
                                    Phone: <?php echo $row->client_phone; ?><br>
                                    ID No: <?php echo $row->client_national_id; ?>
                                </address>
                                </div>
                                <div class="col-sm-6">
                                <h5 style="font-weight: 600; color: #34495e; margin-bottom: 10px;">Account Details</h5>
                                <address style="font-size: 15px; color: #555;">
                                    <strong><?php echo $row->acc_name; ?></strong><br>
                                    Acc No: <?php echo $row->account_number; ?><br>
                                    Type: <?php echo $row->acc_type; ?><br>
                                    Interest Rate: <?php echo $row->acc_rates; ?> %
                                </address>
                                </div>
                            </div>

                            <!-- Summary table -->
                            <div class="row mb-4">
                                <div class="col-12 table-responsive">
                                <table class="table table-hover table-bordered table-striped" style="font-size: 16px;">
                                    <thead style="background: #27ae60; color: #fff;">
                                    <tr>
                                        <th>Deposits</th>
                                        <th>Withdrawals</th>
                                        <th>Transfers</th>
                                        <th>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>$ <?php echo number_format($deposit, 2); ?></td>
                                        <td>$ <?php echo number_format($withdrawal, 2); ?></td>
                                        <td>$ <?php echo number_format($Transfer, 2); ?></td>
                                        <td>$ <?php echo number_format($money_in, 2); ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>

                            <!-- Detailed balance info -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                <!-- You can add more notes or info here -->
                                </div>
                                <div class="col-md-6">
                                <p class="lead" style="font-weight: 600; font-size: 18px; color: #2c3e50;">
                                    Balance Checked On: <?php echo date('d-M-Y'); ?>
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" style="font-size: 16px;">
                                    <tbody>
                                        <tr>
                                        <th style="width:50%;">Funds In:</th>
                                        <td>$ <?php echo number_format($deposit, 2); ?></td>
                                        </tr>
                                        <tr>
                                        <th>Funds Out</th>
                                        <td>$ <?php echo number_format($money_out, 2); ?></td>
                                        </tr>
                                        <tr>
                                        <th>Sub Total:</th>
                                        <td>$ <?php echo number_format($money_in, 2); ?></td>
                                        </tr>
                                        <tr>
                                        <th>Banking Interest:</th>
                                        <td>$ <?php echo number_format($rate_amt, 2); ?></td>
                                        </tr>
                                        <tr>
                                        <th>Total Balance:</th>
                                        <td><strong style="color: #27ae60;">$ <?php echo number_format($totalMoney, 2); ?></strong></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>

                            <!-- Print button row -->
                            <div class="row no-print">
                                <div class="col-12 d-flex justify-content-end">
                                <button type="button" id="print" onclick="printContent('balanceSheet');"
                                    class="btn btn-success" style="font-weight: 600; padding: 10px 20px;">
                                    <i class="fas fa-print"></i> Print
                                </button>
                                </div>
                            </div>
                            </div><!-- /.invoice -->
                        </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->

                    <script>
                        // Print function
                        function printContent(elementId) {
                        const originalContent = document.body.innerHTML;
                        const printContent = document.getElementById(elementId).innerHTML;
                        document.body.innerHTML = printContent;
                        window.print();
                        document.body.innerHTML = originalContent;
                        location.reload(); // reload page to restore event listeners etc.
                        }
                    </script>
                    </section>
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
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <script>
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>
    <script>
        //print balance sheet
        function printContent(el) {
            var restorepage = $('body').html();
            var printcontent = $('#' + el).clone();
            $('body').empty().html(printcontent);
            window.print();
            $('body').html(restorepage);
        }
    </script>
</body>

</html>