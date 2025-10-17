<aside class="main-sidebar sidebar-light-primary elevation-4" style="background: linear-gradient(135deg, #ffffff 10%,rgb(192, 218, 252) 100%); border-right: 1px solid #ddd;">
  <?php
  $client_id = $_SESSION['client_id'];
  $ret = "SELECT * FROM  iB_clients  WHERE client_id = ? ";
  $stmt = $mysqli->prepare($ret);
  $stmt->bind_param('i', $client_id);
  $stmt->execute(); //ok
  $res = $stmt->get_result();
  while ($row = $res->fetch_object()) {
    //set automatically logged in user default image if they have not updated their pics
    if ($row->profile_pic == '') {
      $profile_picture = "<img src='../admin/dist/img/user_icon.png' class=' elevation-2' alt='User Image'>
                ";
    } else {
      $profile_picture = "<img src='../admin/dist/img/$row->profile_pic' class='elevation-2' alt='User Image'>
                ";
    }



    /* Persisit System Settings On Brand */
    $ret = "SELECT * FROM `iB_SystemSettings` ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($sys = $res->fetch_object()) {
  ?>

  <a href="pages_dashboard.php" class="brand-link" style="background-color: #e2e8f0; border-bottom: 1px solid #cbd5e1; padding: 0.75rem 1rem;">
    <img src="../admin/dist/img/<?php echo $sys->sys_logo;?>" alt="iBanking Logo" class="brand-image img-circle elevation-3" style="opacity: .9; width: 38px; height: 38px;">
    <span class="brand-text font-weight-light" style="color: #1e293b; font-weight: 600; font-size: 1.15rem;"><?php echo $sys->sys_name;?></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar" style="background: linear-gradient(135deg, #ffffff 10%,rgb(192, 218, 252) 100%);box-shadow: 0 8px 24px rgba(59, 130, 246, 0.15);transition: all 0.4s ease;">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <?php echo str_replace('<img', '<img style="border-radius: 60%;"', $profile_picture); ?>
      </div>
      <div class="info">
        <a href="#" class="d-block" style="color: #334155; font-weight: 600; font-size: 1rem;"><?php echo $row->name; ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
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
        <!-- ./DAshboard -->

        <!--Account -->
        <li class="nav-item">
          <a href="pages_account.php" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
            <i class="nav-icon fas fa-user-tie" style="color: #3b82f6;"></i>
            <p>
              Account
            </p>
          </a>
        </li>
        <!-- ./Account-->

        <!--iBank Accounts-->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
            <i class="nav-icon fas fa-briefcase" style="color: #3b82f6;"></i>
            <p>
              iBank Accounts
              <i class="fas fa-angle-left right" style="color: #3b82f6;"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="pages_open_acc.php" class="nav-link" style="color: #334155; font-weight: 500;">
                <i class="fas fa-lock-open nav-icon" style="color: #9D00FF;"></i>
                <p>Open iBank Acc</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages_manage_acc_openings.php" class="nav-link" style="color: #334155; font-weight: 500;">
                <i class="fas fa-cog nav-icon" style="color: #9D00FF;"></i>
                <p>My iBank Accounts</p>
              </a>
            </li>
          </ul>
        </li>
        <!--./ iBank Acounts-->

        <!--Finances-->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
            <i class="nav-icon fas fa-wallet" style="color: #3b82f6;"></i>
            <p>
              Finances
              <i class="fas fa-angle-left right" style="color: #3b82f6;"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
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
                <i class="fas fa-exchange-alt nav-icon" style="color: #9D00FF;"></i>
                <p>Transfers</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pages_view_client_bank_acc.php" class="nav-link" style="color: #334155; font-weight: 500;">
                <i class="fas fa-money-bill-alt nav-icon" style="color: #9D00FF;"></i>
                <p>Balance Enquiries</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- ./Finances -->

        <li class="nav-header">Advanced Modules</li>
        <li class="nav-item">
          <a href="pages_transactions_engine.php" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
            <i class="nav-icon fas fas fa-history" style="color: #3b82f6;"></i>
            <p>
              Transactions History
            </p>
          </a>
        </li>
        <!--./Transcactions Engine-->

        <!--Financial Reporting-->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link" style="color: #475569; transition: background-color 0.3s, color 0.3s;">
            <i class="nav-icon fas fa-chart-pie" style="color: #3b82f6;"></i>
            <p>
              Finacial Reports
              <i class="fas fa-angle-left right" style="color: #3b82f6;"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
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
                <i class="fas fa-random nav-icon" style="color: #9D00FF;"></i>
                <p>Transfers</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- ./ End financial Reporting-->

        <!-- Log Out -->
        <li class="nav-item logout">
          <a href="pages_logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Log Out
            </p>
          </a>
        </li>
        <!-- ./Log Out -->
      </ul>
    </nav>
  </div>
</aside>
<?php
    }
  } 
?>