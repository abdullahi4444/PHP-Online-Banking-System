<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

//clear notifications and alert user that they are cleared
if (isset($_GET['Clear_Notifications'])) {
  $id = intval($_GET['Clear_Notifications']);
  $adn = "DELETE FROM  iB_notifications  WHERE notification_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $info = "Notifications Cleared";
  } else {
    $err = "Try Again Later";
  }
}
/*
    get all dashboard analytics 
    and numeric values from distinct 
    tables
    */

//return total number of ibank clients
$result = "SELECT count(*) FROM iB_clients";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iBClients);
$stmt->fetch();
$stmt->close();

//return total number of iBank Staffs
$result = "SELECT count(*) FROM iB_staff";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iBStaffs);
$stmt->fetch();
$stmt->close();

//return total number of iBank Account Types
$result = "SELECT count(*) FROM iB_Acc_types";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_AccsType);
$stmt->fetch();
$stmt->close();

//return total number of iBank Accounts
$result = "SELECT count(*) FROM iB_bankAccounts";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_Accs);
$stmt->fetch();
$stmt->close();

//return total number of iBank Deposits
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions WHERE  tr_type = 'Deposit' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_deposits);
$stmt->fetch();
$stmt->close();

//return total number of iBank Withdrawals
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions WHERE  tr_type = 'Withdrawal' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_withdrawal);
$stmt->fetch();
$stmt->close();



//return total number of iBank Transfers
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions WHERE  tr_type = 'Transfer' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_Transfers);
$stmt->fetch();
$stmt->close();

//return total number of  iBank initial cash->balances
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($acc_amt);
$stmt->fetch();
$stmt->close();
//Get the remaining money in the accounts
$TotalBalInAccount = ($iB_deposits)  - (($iB_withdrawal) + ($iB_Transfers));


//ibank money in the wallet
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($new_amt);
$stmt->fetch();
$stmt->close();
//Withdrawal Computations

?>
<!-- Log on to codeastro.com for more projects! -->
<!DOCTYPE html>
<html lang="en">
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
    <div class="content-wrapper" style="background-color: #f5f7fa; min-height: 100vh;">
      <!-- Header -->
      <div class="content-header" style="padding: 20px; background: #ffffff; border-bottom: 1px solid #eaeff5;">
        <div class="container-fluid">
          <div class="row align-items-center">
            <div class="col-sm-6">
              <h1 style="margin: 0; font-weight: 600; color: #2d3748; font-size: 1.8rem;">Admin Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol style="display: flex; justify-content: flex-end; margin: 0; padding: 0; list-style: none;">
                <li style="margin-left: 10px;"><a href="#" style="color: #4a5568; text-decoration: none;">Home</a></li>
                <li style="margin-left: 10px; color: #a0aec0;">/ Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <section class="content" style="padding-top: 20px;">
        <div class="container-fluid">
          
          <!-- Stats Row 1 -->
          <div class="row" style="margin-bottom: 20px;">
            
            <!-- Clients Card -->
            <div class="col-12 col-sm-6 col-md-3" style="margin-bottom: 20px;">
              <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 0 15px rgba(59, 130, 246, 0.8); height: 100%; border: 1px solid #dbeafe;">
                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                  <div style="width: 50px; height: 50px; background: #e0f2fe; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px;box-shadow: 0 0 10px rgba(37, 99, 235, 0.7); ">
                    <i class="fas fa-users" style="color: #3b82f6; font-size: 1.2rem;"></i>
                  </div>
                  <div>
                    <div style="color: #718096; font-size: 0.9rem; font-weight: 500;">Clients</div>
                    <div style="color: #1a202c; font-size: 1.5rem; font-weight: 700;"><?php echo $iBClients; ?></div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Staffs Card -->
            <div class="col-12 col-sm-6 col-md-3" style="margin-bottom: 20px;">
              <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 0 15px rgba(239, 68, 68, 0.6); height: 100%; border: 1px solid #fee2e2;">
                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                  <div style="width: 50px; height: 50px; background: #fee2e2; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 0 10px rgba(220, 38, 38, 0.7);">
                    <i class="fas fa-user-tie" style="color: #ef4444; font-size: 1.2rem;"></i>
                  </div>
                  <div>
                    <div style="color: #718096; font-size: 0.9rem; font-weight: 500;">Staffs</div>
                    <div style="color: #1a202c; font-size: 1.5rem; font-weight: 700;"><?php echo $iBStaffs; ?></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Account Types Card -->
            <div class="col-12 col-sm-6 col-md-3" style="margin-bottom: 20px;">
              <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 0 15px rgba(16, 185, 129, 0.5); height: 100%; border: 1px solid #d1fae5;">
                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                  <div style="width: 50px; height: 50px; background: #d1fae5; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 0 10px rgba(16, 185, 129, 0.7);">
                    <i class="fas fa-briefcase" style="color: #10b981; font-size: 1.2rem;"></i>
                  </div>
                  <div>
                    <div style="color: #718096; font-size: 0.9rem; font-weight: 500;">Account Types</div>
                    <div style="color: #1a202c; font-size: 1.5rem; font-weight: 700;"><?php echo $iB_AccsType; ?></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Accounts Card -->
            <div class="col-12 col-sm-6 col-md-3" style="margin-bottom: 20px;">
              <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 0 15px rgba(139, 92, 246, 0.5); height: 100%; border: 1px solid #ede9fe;">
                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                  <div style="width: 50px; height: 50px; background: #ede9fe; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 0 10px rgba(139, 92, 246, 0.7);">
                    <i class="fas fa-users" style="color: #8b5cf6; font-size: 1.2rem;"></i>
                  </div>
                  <div>
                    <div style="color: #718096; font-size: 0.9rem; font-weight: 500;">Accounts</div>
                    <div style="color: #1a202c; font-size: 1.5rem; font-weight: 700;"><?php echo $iB_Accs; ?></div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          
          <!-- Stats Row 2 -->
          <div class="row" style="margin-bottom: 20px;">
            
            <!-- Deposits Card -->
            <div class="col-12 col-sm-6 col-md-3" style="margin-bottom: 20px;">
              <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 0 15px rgba(37, 99, 235, 0.5); height: 100%; border: 1px solid #dbeafe;">
                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                  <div style="width: 50px; height: 50px; background: #eff6ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 0 10px rgba(37, 99, 235, 0.7);">
                    <i class="fas fa-upload" style="color: #2563eb; font-size: 1.2rem;"></i>
                  </div>
                  <div>
                    <div style="color: #718096; font-size: 0.9rem; font-weight: 500;">Deposits</div>
                    <div style="color: #1a202c; font-size: 1.5rem; font-weight: 700;">$ <?php echo $iB_deposits; ?></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Withdrawals Card -->
            <div class="col-12 col-sm-6 col-md-3" style="margin-bottom: 20px;">
              <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 0 15px rgba(220, 38, 38, 0.5); height: 100%; border: 1px solid #fee2e2;">
                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                  <div style="width: 50px; height: 50px; background: #fef2f2; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 0 10px rgba(220, 38, 38, 0.7);">
                    <i class="fas fa-download" style="color: #dc2626; font-size: 1.2rem;"></i>
                  </div>
                  <div>
                    <div style="color: #718096; font-size: 0.9rem; font-weight: 500;">Withdrawals</div>
                    <div style="color: #1a202c; font-size: 1.5rem; font-weight: 700;">$ <?php echo $iB_withdrawal; ?></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Transfers Card -->
            <div class="col-12 col-sm-6 col-md-3" style="margin-bottom: 20px;">
              <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 0 15px rgba(5, 150, 105, 0.5); height: 100%; border: 1px solid #d1fae5;">
                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                  <div style="width: 50px; height: 50px; background: #ecfdf5; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 0 10px rgba(5, 150, 105, 0.7);">
                    <i class="fas fa-random" style="color: #059669; font-size: 1.2rem;"></i>
                  </div>
                  <div>
                    <div style="color: #718096; font-size: 0.9rem; font-weight: 500;">Transfers</div>
                    <div style="color: #1a202c; font-size: 1.5rem; font-weight: 700;">$ <?php echo $iB_Transfers; ?></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Balance Card -->
            <div class="col-12 col-sm-6 col-md-3" style="margin-bottom: 20px;">
              <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 0 15px rgba(124, 58, 174, 0.5); height: 100%; border: 1px solid #ede9fe;">
                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                  <div style="width: 50px; height: 50px; background: #f5f3ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 0 10px rgba(124, 58, 174, 0.7);">
                    <i class="fas fa-money-bill-alt" style="color: #7c3aed; font-size: 1.2rem;"></i>
                  </div>
                  <div>
                    <div style="color: #718096; font-size: 0.9rem; font-weight: 500;">Wallet Balance</div>
                    <div style="color: #1a202c; font-size: 1.5rem; font-weight: 700;">$ <?php echo $TotalBalInAccount; ?></div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          
          <!-- Analytics Section -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-12">
              <!-- TABLE: Transactions -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Latest Transactions</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6" style="margin-bottom: 20px;">
                      <div style="padding: 15px; height: 100%;">
                        <div id="PieChart" style="height: 300px;"></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div style="padding: 15px; height: 100%;">
                        <div id="AccountsPerAccountCategories" style="height: 300px;"></div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="row" style="margin-top: 20px;">

                  <div class="col-sm-3 col-6" style="margin-bottom: 15px;">
                    <div style="text-align: center;">
                      <div style="font-size: 1.3rem; font-weight: 700; color: #2563eb;">$ <?php echo $iB_deposits; ?></div>
                      <div style="font-size: 0.85rem; color: #718096; font-weight: 500;">TOTAL DEPOSITS</div>
                    </div>
                  </div>

                  <div class="col-sm-3 col-6" style="margin-bottom: 15px;">
                    <div style="text-align: center;">
                      <div style="font-size: 1.3rem; font-weight: 700; color: #dc2626;">$ <?php echo $iB_withdrawal; ?></div>
                      <div style="font-size: 0.85rem; color: #718096; font-weight: 500;">TOTAL WITHDRAWALS</div>
                    </div>
                  </div>

                  <div class="col-sm-3 col-6" style="margin-bottom: 15px;">
                    <div style="text-align: center;">
                      <div style="font-size: 1.3rem; font-weight: 700; color: #059669;">$ <?php echo $iB_Transfers; ?></div>
                      <div style="font-size: 0.85rem; color: #718096; font-weight: 500;">TOTAL TRANSFERS</div>
                    </div>
                  </div>

                  <div class="col-sm-3 col-6" style="margin-bottom: 15px;">
                    <div style="text-align: center;">
                      <div style="font-size: 1.3rem; font-weight: 700; color: #7c3aed;">$ <?php echo $TotalBalInAccount; ?></div>
                      <div style="font-size: 0.85rem; color: #718096; font-weight: 500;">TOTAL MONEY IN ACCOUNT</div>
                    </div>
                  </div>

                </div>

              </div>
            </div>
          </div>
          
          <!-- Transactions Table -->
          <div class="row">
            <div class="col-md-12">
              <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                  <h5 style="margin: 0; font-weight: 600; color: #2d3748;">Latest Transactions</h5>
                  <div>
                    <button style="background: none; border: none; color: #718096; cursor: pointer; margin-left: 10px;">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button style="background: none; border: none; color: #718096; cursor: pointer; margin-left: 10px;">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                
                <div style="overflow-x: auto;">
                  <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                      <tr style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #fff;">
                        <th style="padding: 12px 15px; text-align: left; font-weight: 600;  border-bottom: 1px solid #e2e8f0;">Transaction Code</th>
                        <th style="padding: 12px 15px; text-align: left; font-weight: 600;  border-bottom: 1px solid #e2e8f0;">Account No.</th>
                        <th style="padding: 12px 15px; text-align: left; font-weight: 600;  border-bottom: 1px solid #e2e8f0;">Type</th>
                        <th style="padding: 12px 15px; text-align: left; font-weight: 600;  border-bottom: 1px solid #e2e8f0;">Amount</th>
                        <th style="padding: 12px 15px; text-align: left; font-weight: 600;  border-bottom: 1px solid #e2e8f0;">Acc. Owner</th>
                        <th style="padding: 12px 15px; text-align: left; font-weight: 600;  border-bottom: 1px solid #e2e8f0;">Timestamp</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ret = "SELECT * FROM `iB_Transactions` ORDER BY `iB_Transactions`.`created_at` DESC ";
                      $stmt = $mysqli->prepare($ret);
                      $stmt->execute();
                      $res = $stmt->get_result();
                      while ($row = $res->fetch_object()) {
                        $transTstamp = $row->created_at;
                        if ($row->tr_type == 'Deposit') {
                          $alertClass = "<span style='background-color: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: 500;'>$row->tr_type</span>";
                        } elseif ($row->tr_type == 'Withdrawal') {
                          $alertClass = "<span style='background-color: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: 500;'>$row->tr_type</span>";
                        } else {
                          $alertClass = "<span style='background-color: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: 500;'>$row->tr_type</span>";
                        }
                      ?>
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                          <td style="padding: 12px 15px; color: #2d3748;"><?php echo $row->tr_code; ?></td>
                          <td style="padding: 12px 15px; color: #2d3748;"><?php echo $row->account_number; ?></td>
                          <td style="padding: 12px 15px;"><?php echo $alertClass; ?></td>
                          <td style="padding: 12px 15px; font-weight: 600; color: #2d3748;">$ <?php echo number_format($row->transaction_amt, 2); ?></td>
                          <td style="padding: 12px 15px; color: #2d3748;"><?php echo $row->client_name; ?></td>
                          <td style="padding: 12px 15px; color: #4a5568;"><?php echo date("d-M-Y h:i:s A", strtotime($transTstamp)); ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                
                <div style="margin-top: 20px;">
                  <a href="pages_transactions_engine.php" style="display: inline-block; background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 500; font-size: 0.9rem;">
                    View All Transactions
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include("dist/_partials/footer.php"); ?>

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="dist/js/adminlte.js"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="dist/js/demo.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>

  <!-- PAGE SCRIPTS -->
  <script src="dist/js/pages/dashboard2.js"></script>

  <!--Load Canvas JS -->
  <script src="plugins/canvasjs.min.js"></script>
  <!--Load Few Charts-->
  <script>
    window.onload = function () {

      // Pie Chart for Account Types
      var Piechart = new CanvasJS.Chart("PieChart", {
        exportEnabled: false,
        animationEnabled: true,
        title: {
          text: "Accounts Per Account Types"
        },
        legend: {
          cursor: "pointer",
          itemclick: explodePie
        },
        data: [{
          type: "pie",
          showInLegend: true,
          toolTipContent: "{name}: <strong>{y}</strong>",
          indexLabel: "{name} - {y}",
          dataPoints: [
            {
              y: <?php
                  $result = "SELECT count(*) FROM iB_bankAccounts WHERE acc_type ='Savings'";
                  $stmt = $mysqli->prepare($result);
                  $stmt->execute();
                  $stmt->bind_result($savings);
                  $stmt->fetch();
                  $stmt->close();
                  echo $savings;
                  ?>,
              name: "Savings Acc",
              exploded: true,
              color: "#6FBF73" // moderate green
            },
            {
              y: <?php
                  $result = "SELECT count(*) FROM iB_bankAccounts WHERE acc_type =' Retirement'";
                  $stmt = $mysqli->prepare($result);
                  $stmt->execute();
                  $stmt->bind_result($retirement);
                  $stmt->fetch();
                  $stmt->close();
                  echo $retirement;
                  ?>,
              name: "Retirement Acc",
              exploded: true,
              color: "#F2A65A" // modern orange
            },
            {
              y: <?php
                  $result = "SELECT count(*) FROM iB_bankAccounts WHERE acc_type ='Recurring deposit'";
                  $stmt = $mysqli->prepare($result);
                  $stmt->execute();
                  $stmt->bind_result($recurring);
                  $stmt->fetch();
                  $stmt->close();
                  echo $recurring;
                  ?>,
              name: "Recurring Deposit Acc",
              exploded: true,
              color: "#5DADE2" // calm blue
            },
            {
              y: <?php
                  $result = "SELECT count(*) FROM iB_bankAccounts WHERE acc_type ='Fixed Deposit Account'";
                  $stmt = $mysqli->prepare($result);
                  $stmt->execute();
                  $stmt->bind_result($fixed);
                  $stmt->fetch();
                  $stmt->close();
                  echo $fixed;
                  ?>,
              name: "Fixed Deposit Acc",
              exploded: true,
              color: "#A569BD" // moderate purple
            },
            {
              y: <?php
                  $result = "SELECT count(*) FROM iB_bankAccounts WHERE acc_type ='Current account'";
                  $stmt = $mysqli->prepare($result);
                  $stmt->execute();
                  $stmt->bind_result($current);
                  $stmt->fetch();
                  $stmt->close();
                  echo $current;
                  ?>,
              name: "Current Acc",
              exploded: true,
              color: "#EC7063" // balanced red
            }
          ]
        }]
      });

      // Column Chart for Transactions
      var AccChart = new CanvasJS.Chart("AccountsPerAccountCategories", {
        exportEnabled: false,
        animationEnabled: true,
        title: {
          text: "Transactions Summary"
        },
        axisY: {
          title: "Number of Transactions"
        },
        data: [{
          type: "column",
          color: "#7FB3D5", // base column blue
          dataPoints: [
            {
              label: "Withdrawals",
              y: <?php
                  $result = "SELECT count(*) FROM iB_Transactions WHERE tr_type ='Withdrawal'";
                  $stmt = $mysqli->prepare($result);
                  $stmt->execute();
                  $stmt->bind_result($withdrawals);
                  $stmt->fetch();
                  $stmt->close();
                  echo $withdrawals;
                  ?>,
              color: "#E74C3C" // withdrawal - elegant red
            },
            {
              label: "Deposits",
              y: <?php
                  $result = "SELECT count(*) FROM iB_Transactions WHERE tr_type ='Deposit'";
                  $stmt = $mysqli->prepare($result);
                  $stmt->execute();
                  $stmt->bind_result($deposits);
                  $stmt->fetch();
                  $stmt->close();
                  echo $deposits;
                  ?>,
              color: "#27AE60" // deposits - balanced green
            },
            {
              label: "Transfers",
              y: <?php
                  $result = "SELECT count(*) FROM iB_Transactions WHERE tr_type ='Transfer'";
                  $stmt = $mysqli->prepare($result);
                  $stmt->execute();
                  $stmt->bind_result($transfers);
                  $stmt->fetch();
                  $stmt->close();
                  echo $transfers;
                  ?>,
              color: "#F4D03F" // transfers - gold yellow
            }
          ]
        }]
      });

      Piechart.render();
      AccChart.render();
    }

    function explodePie(e) {
      if (typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
        e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
      } else {
        e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
      }
      e.chart.render();
    }
  </script>


</body>

</html>