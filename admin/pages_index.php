<?php
// AuthenticationHandler.php - Separate authentication logic
class AuthenticationHandler {
    private $mysqli;
    
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    
    public function handleLogin($email, $password) {
        $hashedPassword = $this->hashPassword($password);
        $stmt = $this->mysqli->prepare("SELECT email, password, admin_id FROM iB_admin WHERE email=? AND password=?");
        $stmt->bind_param('ss', $email, $hashedPassword);
        $stmt->execute();
        $stmt->bind_result($email, $password, $admin_id);
        $rs = $stmt->fetch();
        
        if ($rs) {
            $_SESSION['admin_id'] = $admin_id;
            return true;
        }
        return false;
    }
    
    private function hashPassword($password) {
        return sha1(md5($password));
    }
}

// SystemSettings.php - Handles system settings
class SystemSettings {
    private $mysqli;
    
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    
    public function getSettings() {
        $ret = "SELECT * FROM `iB_SystemSettings`";
        $stmt = $this->mysqli->prepare($ret);
        $stmt->execute();
        return $stmt->get_result();
    }
}

// Start session and include config
session_start();
include('conf/config.php');

// Initialize handlers
$authHandler = new AuthenticationHandler($mysqli);
$settingsHandler = new SystemSettings($mysqli);

// Process login if form submitted
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if ($authHandler->handleLogin($email, $password)) {
        header("Location: pages_dashboard.php");
        exit();
    } else {
        $err = "Access Denied Please Check Your Credentials";
    }
}

// Get system settings
$settingsResult = $settingsHandler->getSettings();
$settings = $settingsResult->fetch_object();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("dist/_partials/head.php"); ?>
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Admin Login | <?php echo htmlspecialchars($settings->sys_name); ?></title>
</head>

<body>
    <div class="auth-page">
        <div class="auth-container">
            <!-- Graphic Side -->
            <div class="auth-graphic">
                <div class="auth-graphic-content">
                    <h2>Welcome Back!</h2>
                    <p>Access your admin dashboard to manage the system efficiently and securely.</p>
                    <img src="https://static.vecteezy.com/system/resources/thumbnails/009/636/683/small_2x/admin-3d-illustration-icon-png.png" alt="Admin Access">
                </div>
            </div>
            
            <!-- Form Side -->
            <div class="auth-form-container">
                <div class="auth-header">
                    <h1 class="auth-title"><?php echo htmlspecialchars($settings->sys_name); ?></h1>
                </div>
                
                <div class="auth-card">
                    <div class="auth-card-body">
                        <h2 class="auth-card-title">Admin Login</h2>
                        <p class="auth-card-subtitle">Log in to start administrator session</p>
                        
                        <?php if (isset($err)): ?>
                        <div class="auth-alert">
                            <?php echo htmlspecialchars($err); ?>
                        </div>
                        <?php endif; ?>
                        
                        <form method="post" class="auth-form">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" name="login" class="btn btn-primary btn-block">
                                    Log In as Admin
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
     <script>
    // 💡 Clear email and password when returning to login page via back button
    window.addEventListener("pageshow", function (event) {
        // This triggers when user returns using browser back
        if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
            document.getElementById("email").value = '';
            document.getElementById("password").value = '';
        }
    });
    </script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>
</html>