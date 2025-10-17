<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];
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
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header" style="padding: 20px; background: #ffffff; border-bottom: 1px solid #eaeff5;">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 style="color: #5e35b1; font-size: 28px; margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Deposits</h1>
            </div>
            <div class="col-sm-6">
              <ol style="display: flex; justify-content: flex-end; margin: 0; padding: 0; list-style: none;">
                <li style="margin-left: 10px;"><a href="pages_dashboard.php" style="color: #4a5568; text-decoration: none;">Dashboard</a></li>
                <li style="margin-left: 10px;"><a href="pages_deposits" style="color: #4a5568; text-decoration: none;"> / iBank Finances / </a></li>
                <li style="margin-left: 10px; color: #a0aec0;">Deposits</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- Log on to codeastro.com for more projects! -->
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Select on any account to deposit money</h3>
              </div>
              <div class="card-body table-responsive">
                <table id="example1" class="table table-bordered table-hover table-striped" style="width: 100%; border-collapse: collapse; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; background-color: #f9fafb; border-radius: 12px; overflow: hidden;">
                  <thead>
                    <tr style="background: linear-gradient(135deg, #1dd1a1, #10ac84); color: #ffffff;">
                      <th>#</th>
                      <th>Name</th>
                      <th>Account No.</th>
                      <th>Rate</th>
                      <th>Acc. Type</th>
                      <th>Acc. Owner</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    //fetch all iB_Accs
                    $client_id = $_SESSION['client_id'];
                    $ret = "SELECT * FROM  iB_bankAccounts  WHERE client_id = ?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('i', $client_id);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    $cnt = 1;
                    while ($row = $res->fetch_object()) {
                      //Trim Timestamp to DD-MM-YYYY : H-M-S
                      $dateOpened = $row->created_at;

                    ?>

                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row->acc_name; ?></td>
                        <td><?php echo $row->account_number; ?></td>
                        <td><?php echo $row->acc_rates; ?>%</td>
                        <td><?php echo $row->acc_type; ?></td>
                        <td><?php echo $row->client_name; ?></td>
                        <td>
                          <a href="pages_deposit_money.php?account_id=<?php echo $row->account_id; ?>&account_number=<?php echo $row->account_number; ?>&client_id=<?php echo $row->client_id; ?>"
                            style="display: inline-flex;align-items: center;margin-left: 55px;margin-right: -35px;gap: 8px;padding-left: 50px;background: linear-gradient(135deg, #1dd1a1, #10ac84);color: white;padding: 10px 18px;font-size: 14px;font-weight: 600;text-decoration: none;border-radius: 12px;box-shadow: 0 8px 20px rgba(16, 172, 132, 0.3);border: 1px solid rgba(255, 255, 255, 0.2);backdrop-filter: blur(8px);transition: all 0.3s ease;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 24px rgba(16,172,132,0.4)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(16,172,132,0.3)'"
                          >
                            <i class="fas fa-money-bill-wave" style="font-size: 16px;"></i>
                            <i class="fas fa-arrow-circle-up" style="font-size: 16px;"></i>
                            <span style="white-space: nowrap; text-align: center;">Deposit Money</span>
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