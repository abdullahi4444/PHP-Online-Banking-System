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
      <section class="content-header" style="padding: 20px 20px; background-color: #f9f9fb; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <div class="container-fluid" style="max-width: 1200px; margin: auto;">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 style="margin: 0; font-size: 28px; color: #333; font-weight: 600;">
                Report : <span style="color: #007bff;"> Transfers
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="pages_financial_reporting_withdrawals.php">Advanced Reporting</a></li>
                <li class="breadcrumb-item active">Transfers</li>
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
                <h4>All Transactions Under Withdrawal Category</h4>
              </div>
              <div class="card-body table-responsive">
                 <table id="export" class="table table-hover table-bordered table-striped" style="width: 100%; border-collapse: separate; border-spacing: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border-radius: 12px; overflow: hidden;">
                  <thead>
                    <tr style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #fff;">
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">#</th>
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Transaction Code</th>
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Account No.</th>
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Amount</th>
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Acc. Owner</th>
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Receiver's Acc.</th>
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Receiver</th>
                      <th style="padding: 16px 20px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Timestamp</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    //Get latest deposits transactions 
                    $client_id = $_SESSION['client_id'];
                    $ret = "SELECT * FROM  iB_Transactions  WHERE tr_type = 'Transfer'AND client_id =? ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('i', $client_id);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    $cnt = 1;
                    while ($row = $res->fetch_object()) {
                      /* Trim Transaction Timestamp to 
                            *  User Uderstandable Formart  DD-MM-YYYY :
                            */
                      $transTstamp = $row->created_at;
                      //Perfom some lil magic here
                      if ($row->tr_type == 'Deposit') {
                        $alertClass = "<span class='badge badge-success'>$row->tr_type</span>";
                      } elseif ($row->tr_type == 'Withdrawal') {
                        $alertClass = "<span class='badge badge-danger'>$row->tr_type</span>";
                      } else {
                        $alertClass = "<span class='badge badge-warning'>$row->tr_type</span>";
                      }
                    ?>

                      <tr style="background-color: #ffffff; border-bottom: 1px solid #e5e7eb; transition: background 0.3s;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='#ffffff'">
                        <td style="padding: 12px; color: #1e293b;"><?php echo $cnt; ?></td>
                        <td style="padding: 12px; color: #1e293b;"><?php echo $row->tr_code; ?></a></td>
                        <td style="padding: 12px; color: #1e293b;"><?php echo $row->account_number; ?></td>
                        <td style="padding: 12px; color: #1e293b;">$ <?php echo $row->transaction_amt; ?></td>
                        <td style="padding: 12px; color: #1e293b;"><?php echo $row->client_name; ?></td>
                        <td style="padding: 12px; color: #1e293b;"><?php echo $row->receiving_acc_no; ?></td>
                        <td style="padding: 12px; color: #1e293b;"><?php echo $row->receiving_acc_holder; ?></td>
                        <td style="padding: 12px; color: #1e293b;"><?php echo date("d-M-Y h:m:s ", strtotime($transTstamp)); ?></td>
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
  <!-- Data Tables V2.01 -->
  <!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
  <script src="plugins/datatable/button-ext/dataTables.buttons.min.js"></script>
  <script src="plugins/datatable/button-ext/jszip.min.js"></script>
  <script src="plugins/datatable/button-ext/buttons.html5.min.js"></script>
  <script src="plugins/datatable/button-ext/buttons.print.min.js"></script>
  <script>
    $(document).ready(function() {
        // Add custom styles dynamically
        const style = document.createElement('style');
        style.innerHTML = `
            /* Modern soft color buttons with glow */
            .dt-button {
                border: none !important;
                border-radius: 8px !important;
                padding: 10px 20px !important;
                margin: 0 8px 8px 0 !important;
                font-weight: 500 !important;
                transition: all 0.3s ease !important;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;
                display: inline-flex !important;
                align-items: center !important;
                position: relative !important;
                overflow: hidden !important;
            }
            
            /* New color scheme - softer pastels */
            .buttons-copy {
                background: linear-gradient(135deg, #C7D2FE,rgb(3, 45, 253)) !important;
                color: #3730A3 !important;
            }
            .buttons-csv {
                background: linear-gradient(135deg, #BFDBFE,rgb(3, 120, 254)) !important;
                color: #1E40AF !important;
            }
            .buttons-excel {
                background: linear-gradient(135deg, #A7F3D0,rgb(2, 232, 140)) !important;
                color: #065F46 !important;
            }
            .buttons-print {
                background: linear-gradient(135deg, #FDE68A,rgb(255, 197, 6)) !important;
                color: #92400E !important;
            }
            
            /* Hover effects */
            .dt-button:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 6px 12px rgba(0,0,0,0.15) !important;
                filter: brightness(1.05) !important;
            }
            
            /* Glow animation */
            @keyframes glow {
                0% { box-shadow: 0 0 5px rgba(255,255,255,0.5); }
                50% { box-shadow: 0 0 15px rgba(255,255,255,0.8); }
                100% { box-shadow: 0 0 5px rgba(255,255,255,0.5); }
            }
            
            .dt-button::after {
                content: '';
                position: absolute;
                top: -2px;
                left: -2px;
                right: -2px;
                bottom: -2px;
                border-radius: 10px;
                animation: glow 2s infinite;
                opacity: 0.4;
                pointer-events: none;
            }
            
            /* Keep buttons in one line */
            .dt-buttons {
                display: flex !important;
                flex-wrap: wrap !important;
                gap: 8px !important;
                padding: 10px 0 !important;
            }
            
            /* Pagination styling */
            .dataTables_wrapper .paginate_button {
                border-radius: 6px !important;
                padding: 6px 12px !important;
                margin: 0 4px !important;
                transition: all 0.3s ease !important;
            }
            
            .dataTables_wrapper .paginate_button.current {
                background: linear-gradient(135deg, #818CF8, #6366F1) !important;
                color: white !important;
                border: none !important;
            }
            
            /* Search box styling */
            .dataTables_filter input {
                border-radius: 6px !important;
                padding: 8px 12px !important;
                border: 1px solid #E5E7EB !important;
                transition: all 0.3s ease !important;
            }
            
            .dataTables_filter input:focus {
                border-color: #818CF8 !important;
                box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.2) !important;
            }
        `;
        document.head.appendChild(style);

        // Initialize DataTable with all your configurations
        $('#export').DataTable({
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i> Copy',
                    className: 'buttons-copy'
                },
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    className: 'buttons-csv'
                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'buttons-excel'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    className: 'buttons-print'
                }
            ],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 7,
            initComplete: function() {
                // Add Font Awesome if not loaded
                if (!document.querySelector('link[href*="font-awesome"]')) {
                    const fa = document.createElement('link');
                    fa.rel = 'stylesheet';
                    fa.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
                    document.head.appendChild(fa);
                }
                
                // Ensure buttons stay in one line
                $('.dt-buttons').css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'gap': '8px'
                });
            }
        });
    });
  </script>
</body>

</html>