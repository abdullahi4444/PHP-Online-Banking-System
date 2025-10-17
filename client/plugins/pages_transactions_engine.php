<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];
//roll back transaction
if (isset($_GET['RollBack_Transaction'])) {
  $id = intval($_GET['RollBack_Transaction']);
  $adn = "DELETE FROM  iB_Transactions  WHERE tr_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $info = "Transaction Rolled Back";
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
              <h1 style="margin: 0; font-weight: 600; color: #2d3748; font-size: 1.8rem;">Transaction History</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right" style="padding: 8px 15px; border-radius: 6px;">
                <li class="breadcrumb-item"><a href="pages_dashboard.php" style="color: #4b5563; text-decoration: none;">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="pages_transactions_engine.php" style="color: #4b5563; text-decoration: none;">Transaction History</a></li>
                <li class="breadcrumb-item active" style="color: #3b82f6;">Transactions</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Select on any action options to manage Transactions</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-hover table-striped" style="width: 100%; border-collapse: separate; border-spacing: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border-radius: 12px; overflow: hidden;">
                  <thead>
                    <tr style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #fff;">
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">#</th>
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Transaction Code</th>
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Account No.</th>
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Amount</th>
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Acc. Owner</th>
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Timestamp</th>
                    </tr>
                  </thead>
                  <tbody><!-- Log on to codeastro.com for more projects! -->
                    <?php
                    //Get latest transactions 
                    $client_id = $_SESSION['client_id'];
                    $ret = "SELECT * FROM `iB_Transactions` WHERE client_id =? ORDER BY `iB_Transactions`.`created_at` DESC ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('i', $client_id);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    $cnt = 1;
                    while ($row = $res->fetch_object()) {
                      $transTstamp = $row->created_at;
                      if ($row->tr_type == 'Deposit') {
                        $alertClass = "<span style='background-color: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center;'><svg style='width: 14px; height: 14px; margin-right: 4px;' fill='none' stroke='currentColor' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 10l7-7m0 0l7 7m-7-7v18'></path></svg>$row->tr_type</span>";
                      } elseif ($row->tr_type == 'Withdrawal') {
                        $alertClass = "<span style='background-color: #fee2e2; color: #991b1b; padding: 6px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center;'><svg style='width: 14px; height: 14px; margin-right: 4px;' fill='none' stroke='currentColor' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 14l-7 7m0 0l-7-7m7 7V3'></path></svg>$row->tr_type</span>";
                      } else {
                        $alertClass = "<span style='background-color: #fef9c3; color: #854d0e; padding: 6px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center;'><svg style='width: 14px; height: 14px; margin-right: 4px;' fill='none' stroke='currentColor' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12'></path></svg>$row->tr_type</span>";
                      }
                    ?>

                      <tr style="background-color: #ffffff; border-bottom: 1px solid #e5e7eb; transition: background 0.3s;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='#ffffff'">
                        <td style="padding: 12px; color: #1e293b;"><?php echo $cnt; ?></td>
                        <td style="padding: 12px; color: #1e293b;"><?php echo $row->tr_code; ?></a></td>
                        <td style="padding: 12px; color: #1e293b;"><?php echo $row->account_number; ?></td>
                        <td style="padding: 12px;"><?php echo $alertClass; ?></td>
                        <td style="padding: 12px; color: #0f172a;">$ <?php echo $row->transaction_amt; ?></td>
                        <td style="padding: 12px; color: #334155;"><?php echo $row->client_name; ?></td>
                        <td style="padding: 12px; color: #475569;"><?php echo date("d-M-Y h:m:s ", strtotime($transTstamp)); ?></td>

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
        </div><!-- Log on to codeastro.com for more projects! -->
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