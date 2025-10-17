<aside class="main-sidebar sidebar-light-primary elevation-4" style="background-color: #f9fafb; border-right: 1px solid #ddd;">
  <?php
  $admin_id = $_SESSION['admin_id'];
  $ret = "SELECT * FROM  iB_admin  WHERE admin_id = ? ";
  $stmt = $mysqli->prepare($ret);
  $stmt->bind_param('i', $admin_id);
  $stmt->execute(); //ok
  $res = $stmt->get_result();
  while ($row = $res->fetch_object()) {
    if ($row->profile_pic == '') {
      $profile_picture = "<img src='dist/img/user_icon.png' class='img-circle elevation-2' alt='User Image' style='border: 2px solid #cbd5e1;'>";
    } else {
      $profile_picture = "<img src='dist/img/$row->profile_pic' class='img-circle elevation-2' alt='User Image' style='border: 2px solid #cbd5e1;'>";
    }

    $ret = "SELECT * FROM `iB_SystemSettings` ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res_sys = $stmt->get_result();
    while ($sys = $res_sys->fetch_object()) {
  ?>
  
      <a href="pages_dashboard.php" class="brand-link" style="background-color: #e2e8f0; border-bottom: 1px solid #cbd5e1; padding: 0.75rem 1rem;">
        <img src="dist/img/<?php echo $sys->sys_logo; ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .9; width: 38px; height: 38px;">
        <span class="brand-text font-weight-light" style="color: #1e293b; font-weight: 600; font-size: 1.15rem;"><?php echo $sys->sys_name; ?></span>
      </a>

      <div class="sidebar" style="background-color: #f9fafb;">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <?php echo $profile_picture; ?>
          </div>
          <div class="info">
            <a href="#" class="d-block" style="color: #334155; font-weight: 600; font-size: 1rem;"><?php echo $row->name; ?></a>
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" style="font-weight: 500;">
            
            <li class="nav-item has-treeview">
              <a href="pages_dashboard.php" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
                <i class="nav-icon fas fa-tachometer-alt" style="color: #3b82f6;"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pages_account.php" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
                <i class="nav-icon fas fa-user-secret" style="color: #3b82f6;"></i>
                <p>Account</p>
              </a>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
                <i class="nav-icon fas fa-user-tie" style="color: #3b82f6;"></i>
                <p>
                  Staff
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="background-color: #f1f5f9;">
                <li class="nav-item">
                  <a href="pages_add_staff.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-user-plus nav-icon" style="color: #9D00FF;"></i>
                    <p>Add Staff</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_manage_staff.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-user-cog nav-icon" style="color: #9D00FF;"></i>
                    <p>Manage Staff</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
                <i class="nav-icon fas fa-users" style="color: #3b82f6;"></i>
                <p>
                  Clients
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="background-color: #f1f5f9;">
                <li class="nav-item">
                  <a href="pages_add_client.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-user-plus nav-icon" style="color: #9D00FF;"></i>
                    <p>Add Client</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_manage_clients.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-user-cog nav-icon" style="color: #9D00FF;"></i>
                    <p>Manage Clients</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
                <i class="nav-icon fas fa-briefcase" style="color: #3b82f6;"></i>
                <p>
                  Accounts
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="background-color: #f1f5f9;">
                <li class="nav-item">
                  <a href="pages_add_acc_type.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="far fas fa-plus nav-icon" style="color: #9D00FF"></i>
                    <p>Add Acc Type</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_manage_accs.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-cogs nav-icon" style="color: #9D00FF;"></i>
                    <p>Manage Acc Types</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_open_acc.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-lock-open nav-icon" style="color: #9D00FF;"></i>
                    <p>Open Acc</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_manage_acc_openings.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-cog nav-icon" style="color: #9D00FF;"></i>
                    <p>Manage Acc Openings</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
                <i class="nav-icon fas fa-dollar-sign" style="color: #3b82f6;"></i>
                <p>
                  Finances
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="background-color: #f1f5f9;">
                <li class="nav-item">
                  <a href="pages_deposits.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-upload nav-icon" style="color: #9D00FF;"></i>
                    <p>Deposits</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_withdrawals.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-download nav-icon" style="color: #9D00FF;"></i>
                    <p>Withdrawals</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_transfers.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-random nav-icon" style="color: #9D00FF;"></i>
                    <p>Transfers</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_balance_enquiries.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-money-bill-alt nav-icon" style="color: #9D00FF;"></i>
                    <p>Balance Enquiries</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header" style="color: #3b82f6; font-weight: 600; font-size: 0.85rem; letter-spacing: 1px;">
              Advanced Modules
            </li>
            <li class="nav-item">
              <a href="pages_transactions_engine.php" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
                <i class="nav-icon fas fa-exchange-alt" style="color: #3b82f6;"></i>
                <p>Transactions History</p>
              </a>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
                <i class="nav-icon fas fa-file-invoice-dollar" style="color: #3b82f6;"></i>
                <p>
                  Financial Reports
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="background-color: #f1f5f9;">
                <li class="nav-item">
                  <a href="pages_financial_reporting_deposits.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-file-upload nav-icon" style="color: #9D00FF;"></i>
                    <p>Deposits</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_financial_reporting_withdrawals.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-cart-arrow-down nav-icon" style="color: #9D00FF;"></i>
                    <p>Withdrawals</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_financial_reporting_transfers.php" class="nav-link" style="color: #334155; font-weight: 500;">
                    <i class="fas fa-random nav-icon" style="color: #9D00FF"></i>
                    <p>Transfers</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="pages_system_settings.php" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
                <i class="nav-icon fas fa-cogs" style="color: #3b82f6;"></i>
                <p>System Settings</p>
              </a>
            </li>

            <li class="nav-item logout">
              <a href="pages_logout.php" class="nav-link" style="color: #dc2626; font-weight: 600; transition: background-color 0.3s, color 0.3s;">
                <i class="nav-icon fas fa-power-off" style="color: #dc2626;"></i>
                <p>Log Out</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
</aside>

<?php
    }
  }
?>
