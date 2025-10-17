<?php
session_start();
include('conf/config.php');

// Initialize variables (for safety)
$email = '';
$password = '';

// Authentication logic
class AuthenticationHandler {
    private $mysqli;
    
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function handleLogin($email, $password, $userType = 'client') {
        $hashedPassword = $this->hashPassword($password);
        $table = ($userType === 'admin') ? 'iB_admin' : 'iB_clients';
        $idField = ($userType === 'admin') ? 'admin_id' : 'client_id';
        
        $stmt = $this->mysqli->prepare("SELECT $idField FROM $table WHERE email=? AND password=?");
        $stmt->bind_param('ss', $email, $hashedPassword);
        $stmt->execute();
        $stmt->bind_result($userId);
        $rs = $stmt->fetch();

        if ($rs) {
            $_SESSION["{$userType}_id"] = $userId;
            return true;
        }
        return false;
    }

    private function hashPassword($password) {
        return sha1(md5($password));
    }
}

// System settings class
class SystemSettings {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getSettings() {
        $stmt = $this->mysqli->prepare("SELECT * FROM `iB_SystemSettings`");
        $stmt->execute();
        return $stmt->get_result();
    }
}

$authHandler = new AuthenticationHandler($mysqli);
$settingsHandler = new SystemSettings($mysqli);

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($authHandler->handleLogin($email, $password, 'client')) {
        header("Location: pages_dashboard.php");
        exit();
    } else {
        $err = "Access Denied. Please check your credentials.";
    }
}

$settingsResult = $settingsHandler->getSettings();
$settings = $settingsResult->fetch_object();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("dist/_partials/head.php"); ?>
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Client Login | <?php echo htmlspecialchars($settings->sys_name); ?></title>
</head>

<body>
    <div class="auth-page auth-container">
        <!-- Graphic Side -->
        <div class="auth-graphic">
            <div class="auth-graphic-content">
                <h2>Welcome Back, Client!</h2>
                <p>Access your personal dashboard to manage your accounts and transactions.</p>
                <img src="https://cdn-icons-png.flaticon.com/512/6009/6009978.png" alt="Client Access">
            </div>
        </div>
        
        <!-- Form Side -->
        <div class="auth-form-container">
            <div class="auth-header">
                <h1 class="auth-title"><?php echo htmlspecialchars($settings->sys_name); ?></h1>
            </div>
            
            <div class="auth-card">
                <div class="auth-card-body">
                    <h2 class="auth-card-title">Client Login</h2>
                    <p class="auth-card-subtitle">Log in to start your banking session</p>
                    
                    <?php if (isset($err)): ?>
                    <div class="auth-alert">
                        <?php echo htmlspecialchars($err); ?>
                    </div>
                    <?php endif; ?>
                    
                    <form method="post" class="auth-form" >
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" id="email" name="email" class="form-control"
                                placeholder="Enter your email" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" id="password" name="password" class="form-control"
                                placeholder="Enter your password" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="login" class="btn btn-primary btn-block">
                                Log In as Client
                            </button>
                        </div>
                    </form>

                    
                    <div class="auth-footer">
                        <p>Don't have an account? <a href="pages_client_signup.php" class="register-link">Register here</a></p>
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