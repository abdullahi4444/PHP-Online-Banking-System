<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
//roll back transaction
if (isset($_GET['RollBack_Transaction'])) {
  $id = intval($_GET['RollBack_Transaction']);
  $adn = "DELETE FROM  iB_Transactions  WHERE tr_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $info = "iBanking Transaction Rolled Back";
  } else {
    $err = "Try Again Later";
  }
}

?>
<!-- Log on to codeastro.com for more projects! -->
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
    <div class="content-wrapper" style="background-color: #f8fafc; min-height: 100vh;">
      <!-- Content Header (Page header) -->
      <section class="content-header" style="padding-top: 20px;">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 style="margin: 0; font-weight: 600; color: #2d3748; font-size: 1.8rem;">iBanking Transaction History</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right" style="padding: 8px 15px; border-radius: 6px;">
                <li class="breadcrumb-item"><a href="pages_dashboard.php" style="color: #4b5563; text-decoration: none;">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="pages_transactions_engine.php" style="color: #4b5563; text-decoration: none;">Transaction History</a></li>
                <li class="breadcrumb-item active" style="color: #3b82f6;">Transactions</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <!-- Main content -->
      <section class="content" style="padding-top: 20px;">
        <div class="row">
          <div class="col-12">
            <div class="card" style="border: none; border-radius: 10px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
              <div class="card-header"  style="background-color: white; border-bottom: 1px solid #e5e7eb; border-radius: 10px 10px 0 0;">
                <h3 class="card-title" style="color: #374151; font-weight: 500; margin: 0;">Select on any action options to manage Transactions</h3>
              </div>
              <div style="overflow-x: auto;" class="card-body">
                <table id="example1" class="table table-hover table-bordered table-striped" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                  <thead style="background-color: #f9fafb;">
                    <tr style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #fff;">
                      <th>#</th>
                      <th>Transaction Code</th>
                      <th>Account No.</th>
                      <th>Type</th>
                      <th>Amount</th>
                      <th>Acc. Owner</th>
                      <th>Timestamp</th>
                      <th>Action</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    //Get latest transactions 
                    $ret = "SELECT * FROM `iB_Transactions` ORDER BY `iB_Transactions`.`created_at` DESC ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    $cnt = 1;
                    while ($row = $res->fetch_object()) {
                      $transTstamp = $row->created_at;
                      if ($row->tr_type == 'Deposit') {
                        $alertClass = "<span style='background-color: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 500;'>$row->tr_type</span>";
                      } elseif ($row->tr_type == 'Withdrawal') {
                        $alertClass = "<span style='background-color: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 500;'>$row->tr_type</span>";
                      } else {
                        $alertClass = "<span style='background-color: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 500;'>$row->tr_type</span>";
                      }
                    ?>

                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row->tr_code; ?></a></td>
                        <td><?php echo $row->account_number; ?></td>
                        <td><?php echo $alertClass; ?></td>
                        <td>$ <?php echo $row->transaction_amt; ?></td>
                        <td><?php echo $row->client_name; ?></td>
                        <td><?php echo date("d-M-Y h:m:s ", strtotime($transTstamp)); ?></td>
                        <td style="padding: 12px 16px;">
                          <a href="pages_transactions_engine.php?RollBack_Transaction=<?php echo $row->tr_id; ?>" 
                            style="display: inline-flex; align-items: center; background-color: #fee2e2; color: #b91c1c; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.75rem; font-weight: 500; transition: all 0.2s ease;"
                            onmouseover="this.style.backgroundColor='#fecaca';" 
                            onmouseout="this.style.backgroundColor='#fee2e2';">
                            <i class="fas fa-power-off" style="margin-right: 6px; font-size: 0.7rem;"></i>
                            Roll Back
                          </a>
                      </td>
                      </tr>
                    <?php $cnt = $cnt + 1;
                    } ?>
                    </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
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
</body>

</html>