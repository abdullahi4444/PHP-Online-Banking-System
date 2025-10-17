<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
//fire staff
if (isset($_GET['fireStaff'])) {
  $id = intval($_GET['fireStaff']);
  $adn = "DELETE FROM  iB_staff  WHERE staff_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $info = "iBanking Staff Account Deleted";
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

<body class="hold-transition sidebar-mini">
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
          <div class="row align-items-center">
            <div class="col-sm-6">
              <h1 style="margin: 0; font-weight: 600; color: #2d3748; font-size: 1.8rem;">iBanking Staffs</h1>
            </div>
            <div class="col-sm-6">
              <ol style="display: flex; justify-content: flex-end; margin: 0; padding: 0; list-style: none;">
                <li style="margin-left: 10px;"><a href="pages_dashboard.php" style="color: #4a5568; text-decoration: none;">Dashboard</a></li>
                <li style="margin-left: 10px;"><a href="pages_manage_staff.php" style="color: #4a5568; text-decoration: none;">/ iBank Staffs /</a></li>
                <li style="margin-left: 10px; color: #a0aec0;">Manage Staffs</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content" style="padding-top: 20px; background: #f7f9fc;">
        <div class="row">
          <div class="col-12">
            <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.05); overflow: hidden;">
              <div class="card-header" style="background-color: #fff; padding: 20px 24px; border-bottom: 1px solid #eee;">
                <h3 class="card-title" style="margin: 0; font-size: 18px; font-weight: 600; color: #333;">Select on any action options to manage your staffs</h3>
              </div>
              <div class="card-body" style="background-color: #ffffff; overflow-x: auto;">
                <table id="example1" class="table table-hover table-bordered table-striped" style="width: 100%; border-collapse: collapse; background-color: #fff; font-size: 15px; border-radius: 8px; overflow: hidden;">
                  <thead style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white;">
                    <tr>
                      <th style="padding: 12px;">#</th>
                      <th style="padding: 12px;">Name</th>
                      <th style="padding: 12px;">Staff Number</th>
                      <th style="padding: 12px;">Contact</th>
                      <th style="padding: 12px;">Email</th>
                      <th style="padding: 12px;">Gender</th>
                      <th style="padding: 12px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $ret = "SELECT * FROM iB_staff ORDER BY RAND()";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $cnt = 1;
                    while ($row = $res->fetch_object()) {
                    ?>
                    <tr style="transition: background 0.3s;" onmouseover="this.style.backgroundColor='#f9f9f9'" onmouseout="this.style.backgroundColor='#ffffff'">
                      <td style="padding: 10px;"><?php echo $cnt; ?></td>
                      <td style="padding: 10px;"><?php echo $row->name; ?></td>
                      <td style="padding: 10px;"><?php echo $row->staff_number; ?></td>
                      <td style="padding: 10px;"><?php echo $row->phone; ?></td>
                      <td style="padding: 10px;"><?php echo $row->email; ?></td>
                      <td style="padding: 10px;"><?php echo $row->sex; ?></td>
                      <td style="padding: 10px; white-space: nowrap;">
                        <a href="pages_view_staff.php?staff_number=<?php echo $row->staff_number; ?>" style="display: inline-flex;align-items: center;gap: 6px;padding: 8px 18px;background: linear-gradient(135deg, #6a11cb, #2575fc);color: white;border-radius: 8px;text-decoration: none;font-weight: 600;font-size: 14px;box-shadow: 0 4px 12px rgba(38, 66, 255, 0.4);transition: background 0.3s ease, box-shadow 0.3s ease;border: none;cursor: pointer; margin-left:40px;" onmouseover="this.style.background='linear-gradient(135deg, #2575fc, #6a11cb)'; this.style.boxShadow='0 6px 18px rgba(38, 66, 255, 0.6)';" onmouseout="this.style.background='linear-gradient(135deg, #6a11cb, #2575fc)'; this.style.boxShadow='0 4px 12px rgba(38, 66, 255, 0.4)';">
                          <i class="fas fa-cogs"></i> Manage
                        </a>

                        <a href="pages_manage_staff.php?fireStaff=<?php echo $row->staff_id; ?>" style="display: inline-flex;align-items: center;gap: 6px;padding: 8px 18px;background: linear-gradient(135deg, #ff416c, #ff4b2b);color: white;border-radius: 8px;text-decoration: none;font-weight: 600;font-size: 14px;box-shadow: 0 4px 12px rgba(255, 65, 108, 0.5);transition: background 0.3s ease, box-shadow 0.3s ease;border: none;cursor: pointer;" onmouseover="this.style.background='linear-gradient(135deg, #ff4b2b, #ff416c)'; this.style.boxShadow='0 6px 18px rgba(255, 65, 108, 0.7)';" onmouseout="this.style.background='linear-gradient(135deg, #ff416c, #ff4b2b)'; this.style.boxShadow='0 4px 12px rgba(255, 65, 108, 0.5)';">
                          <i class="fas fa-trash"></i> Delete
                        </a>
                      </td>
                    </tr>
                    <?php $cnt++; } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
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