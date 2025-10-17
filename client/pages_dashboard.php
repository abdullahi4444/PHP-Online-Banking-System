<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];

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
$client_id = $_SESSION['client_id'];
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions WHERE  client_id = ? AND tr_type = 'Deposit' ";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$stmt->bind_result($iB_deposits);
$stmt->fetch();
$stmt->close();

//return total number of iBank Withdrawals
$client_id = $_SESSION['client_id'];
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions WHERE  client_id = ? AND tr_type = 'Withdrawal' ";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$stmt->bind_result($iB_withdrawal);
$stmt->fetch();
$stmt->close();



//return total number of iBank Transfers
$client_id = $_SESSION['client_id'];
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions WHERE  client_id = ? AND tr_type = 'Transfer' ";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$stmt->bind_result($iB_Transfers);
$stmt->fetch();
$stmt->close();

//return total number of  iBank initial cash->balances
$client_id = $_SESSION['client_id'];
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions  WHERE client_id =?";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$stmt->bind_result($acc_amt);
$stmt->fetch();
$stmt->close();
//Get the remaining money in the accounts
$TotalBalInAccount = ($iB_deposits)  - (($iB_withdrawal) + ($iB_Transfers));


//ibank money in the wallet
$client_id = $_SESSION['client_id'];
$result = "SELECT SUM(transaction_amt) FROM iB_Transactions  WHERE client_id = ?";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$stmt->bind_result($new_amt);
$stmt->fetch();
$stmt->close();
//Withdrawal Computations

?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include("dist/_partials/head.php"); ?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

  <div class="wrapper">
    <?php include("dist/_partials/nav.php"); ?>
    <?php include("dist/_partials/sidebar.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #f5f7fa; min-height: 100vh;">
      <div class="content-header" style="padding: 20px; background: #ffffff; border-bottom: 1px solid #eaeff5;">
        <div class="container-fluid">
          <div class="row align-items-center">
            <div class="col-sm-6">
              <h1 style="margin: 0; font-weight: 600; color: #2d3748; font-size: 1.8rem;">Client Dashboard</h1>
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

      <!-- Main content -->
      <section class="content" style="padding-top: 20px;">
        <div class="container-fluid" >
          <div class="row" style="margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 20px;">
          <!-- Deposits -->
          <div class="col-12 col-sm-6 col-md-3" style="flex: 1 1 calc(25% - 20px);">
            <div 
              style="background: white; border-radius: 10px; padding: 20px; border: 1px solid #dbeafe; box-shadow: 0 0 15px rgba(59,130,246,0.8); transition: all 0.4s ease; overflow: hidden;" 
              onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(59,130,246,0.2)'"
              onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 15px rgba(59,130,246,0.8)'"
            >
              <div style="display: flex; align-items: center; margin-bottom: 15px;">
                <div style="width: 50px; height: 50px; background: #e0f2fe; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 0 10px rgba(37,99,235,0.7);">
                  <i class="fas fa-upload" style="color: #3b82f6; font-size: 1.2rem;"></i>
                </div>
                <div>
                  <div style="color: #718096; font-size: 0.9rem; font-weight: 500;">Deposits</div>
                  <div style="color: #1a202c; font-size: 1.5rem; font-weight: 700;">$ <?php echo $iB_deposits; ?></div>
                </div>
              </div>
            </div>
          </div>
          <!-- Withdrawals -->
          <div class="col-12 col-sm-6 col-md-3" style="flex: 1 1 calc(25% - 20px);">
            <div 
              style="background: white; border-radius: 10px; padding: 20px; border: 1px solid #fee2e2; box-shadow: 0 0 15px rgba(239,68,68,0.6); transition: all 0.4s ease; overflow: hidden;" 
              onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(239,68,68,0.2)'"
              onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 15px rgba(239,68,68,0.6)'"
            >
              <div style="display: flex; align-items: center; margin-bottom: 15px;">
                <div style="width: 50px; height: 50px; background: #fee2e2; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 0 10px rgba(220,38,38,0.7);">
                  <i class="fas fa-download" style="color: #ef4444; font-size: 1.2rem;"></i>
                </div>
                <div>
                  <div style="color: #718096; font-size: 0.9rem; font-weight: 500;">Withdrawals</div>
                  <div style="color: #1a202c; font-size: 1.5rem; font-weight: 700;">$ <?php echo $iB_withdrawal; ?></div>
                </div>
              </div>
            </div>
          </div>
          <!-- Transfers -->
          <div class="col-12 col-sm-6 col-md-3" style="flex: 1 1 calc(25% - 20px);">
            <div 
              style="background: white; border-radius: 10px; padding: 20px; border: 1px solid #d1fae5; box-shadow: 0 0 15px rgba(16,185,129,0.5); transition: all 0.4s ease; overflow: hidden;" 
              onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(16,185,129,0.2)'"
              onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 15px rgba(16,185,129,0.5)'"
            >
              <div style="display: flex; align-items: center; margin-bottom: 15px;">
                <div style="width: 50px; height: 50px; background: #d1fae5; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 0 10px rgba(16,185,129,0.7);">
                  <i class="fas fa-random" style="color: #10b981; font-size: 1.2rem;"></i>
                </div>
                <div>
                  <div style="color: #718096; font-size: 0.9rem; font-weight: 500;">Transfers</div>
                  <div style="color: #1a202c; font-size: 1.5rem; font-weight: 700;">$ <?php echo $iB_Transfers; ?></div>
                </div>
              </div>
            </div>
          </div>
          <!-- Wallet Balance -->
          <div class="col-12 col-sm-6 col-md-3" style="flex: 1 1 calc(25% - 20px);">
            <div style="background: white; border-radius: 10px; padding: 20px; border: 1px solid #ede9fe; box-shadow: 0 0 15px rgba(139,92,246,0.5); transition: all 0.4s ease; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(139,92,246,0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 15px rgba(139,92,246,0.5)'">
              <div style="display: flex; align-items: center; margin-bottom: 15px;">
                <div style="width: 50px; height: 50px; background: #ede9fe; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 0 10px rgba(139,92,246,0.7);">
                  <i class="fas fa-money-bill-alt" style="color: #8b5cf6; font-size: 1.2rem;"></i>
                </div>
                <div>
                  <div style="color: #718096; font-size: 0.9rem; font-weight: 500;">Wallet Balance</div>
                  <div style="color: #1a202c; font-size: 1.5rem; font-weight: 700;">$ <?php echo $TotalBalInAccount; ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Main row -->
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
                <table style="width: 100%; border-collapse: separate; border-spacing: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border-radius: 12px; overflow: hidden;">
                  <thead>
                      <tr style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #fff;">
                          <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Transaction Code</th>
                          <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Account No.</th>
                          <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                          <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Amount</th>
                          <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Acc. Owner</th>
                          <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Timestamp</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      $client_id = $_SESSION['client_id'];
                      $ret = "SELECT * FROM iB_Transactions WHERE client_id = ? ORDER BY iB_Transactions.created_at DESC";
                      $stmt = $mysqli->prepare($ret);
                      $stmt->bind_param('i', $client_id);
                      $stmt->execute();
                      $res = $stmt->get_result();
                      $row_count = 0;
                      while ($row = $res->fetch_object()) {
                          $transTstamp = $row->created_at;
                          if ($row->tr_type == 'Deposit') {
                              $alertClass = "<span style='background-color: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center;'><svg style='width: 14px; height: 14px; margin-right: 4px;' fill='none' stroke='currentColor' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 10l7-7m0 0l7 7m-7-7v18'></path></svg>$row->tr_type</span>";
                          } elseif ($row->tr_type == 'Withdrawal') {
                              $alertClass = "<span style='background-color: #fee2e2; color: #991b1b; padding: 6px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center;'><svg style='width: 14px; height: 14px; margin-right: 4px;' fill='none' stroke='currentColor' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 14l-7 7m0 0l-7-7m7 7V3'></path></svg>$row->tr_type</span>";
                          } else {
                              $alertClass = "<span style='background-color: #fef9c3; color: #854d0e; padding: 6px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center;'><svg style='width: 14px; height: 14px; margin-right: 4px;' fill='none' stroke='currentColor' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12'></path></svg>$row->tr_type</span>";
                          }
                          $row_count++;
                      ?>
                          <tr style="background-color: #ffffff; border-bottom: 1px solid #e5e7eb; transition: background 0.3s;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='#ffffff'">
                              <td style="padding: 16px 20px; color: #1f2937; font-weight: 500; border-bottom: 1px solid #e5e7eb;"><?php echo $row->tr_code; ?></td>
                              <td style="padding: 16px 20px; color: #1f2937; font-weight: 500; border-bottom: 1px solid #e5e7eb;"><?php echo $row->account_number; ?></td>
                              <td style="padding: 16px 20px; border-bottom: 1px solid #e5e7eb;"><?php echo $alertClass; ?></td>
                              <td style="padding: 16px 20px; font-weight: 600; color: #1f2937; border-bottom: 1px solid #e5e7eb;">$ <?php echo number_format($row->transaction_amt, 2); ?></td>
                              <td style="padding: 16px 20px; color: #1f2937; font-weight: 500; border-bottom: 1px solid #e5e7eb;"><?php echo $row->client_name; ?></td>
                              <td style="padding: 16px 20px; color: #6b7280; font-size: 0.875rem; border-bottom: 1px solid #e5e7eb;"><?php echo date("d-M-Y h:i:s A", strtotime($transTstamp)); ?></td>
                          </tr>
                      <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div style="margin:20px 0;">
              <style>
                .glow-button {display:inline-block;background:linear-gradient(135deg,#3b82f6 0%,#1d4ed8 100%);color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:600;font-size:0.9rem;box-shadow:0 4px 6px -1px rgba(59,130,246,0.3),0 2px 4px -1px rgba(59,130,246,0.1);transition:all 0.3s ease;position:relative;overflow:hidden;border:none;cursor:pointer;}
                .glow-button:hover {box-shadow:0 0 15px 5px rgba(59,130,246,0.4);transform:translateY(-2px);color:white;}
                .glow-button span.pulse {position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.1);border-radius:50%;transform:scale(0);transition:transform 0.6s ease, opacity 0.6s ease;}
                .glow-button:hover span.pulse {transform:scale(5);opacity:4;}
              </style>
              <a href="pages_transactions_engine.php" class="glow-button">
                View All Transactions
                <span class="pulse" style="display:block;"></span>
              </a>
            </div>

            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
      </section>
    </div>

    <!-- Main Footer -->
    <?php include("dist/_partials/footer.php"); ?>

  </div>

  
  <!-- REQUIRED SCRIPTS -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="dist/js/adminlte.js"></script>
  <script src="dist/js/demo.js"></script>
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <script src="plugins/chart.js/Chart.min.js"></script>
  <script src="dist/js/pages/dashboard2.js"></script>
  <script src="plugins/canvasjs.min.js"></script>

</body>

</html>