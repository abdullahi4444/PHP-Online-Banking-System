<?php
session_start();
include('conf/config.php');

// ClientRegistrationHandler.php
class ClientRegistrationHandler {
    private $mysqli;
    
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    
    public function registerClient($clientData) {
        // Generate client number
        $length = 4;
        $clientNumber = "iBank-CLIENT-" . substr(str_shuffle('0123456789'), 1, $length);
        
        // Hash password
        $hashedPassword = sha1(md5($clientData['password']));
        
        // Prepare query
        $query = "INSERT INTO iB_clients (name, national_id, client_number, phone, email, password, address) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($query);
        
        // Bind parameters
        $stmt->bind_param('sssssss', 
            $clientData['name'],
            $clientData['national_id'],
            $clientNumber,
            $clientData['phone'],
            $clientData['email'],
            $hashedPassword,
            $clientData['address']
        );
        
        // Execute and return status
        return $stmt->execute();
    }
}

// SystemSettings.php - Reusing the same class from previous pages
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

// Process registration if form submitted
if (isset($_POST['create_account'])) {
    $registrationHandler = new ClientRegistrationHandler($mysqli);
    $clientData = [
        'name' => $_POST['name'],
        'national_id' => $_POST['national_id'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'address' => $_POST['address']
    ];
    
    if ($registrationHandler->registerClient($clientData)) {
        $success = "Account Created Successfully";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}

// Get system settings
$settingsHandler = new SystemSettings($mysqli);
$settingsResult = $settingsHandler->getSettings();
$settings = $settingsResult->fetch_object();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("dist/_partials/head.php"); ?>
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Client Registration | <?php echo htmlspecialchars($settings->sys_name); ?></title>
</head>

<body>
    <div class="auth-page auth-container">
        <!-- Graphic Side -->
        <div class="auth-graphic">
            <div class="auth-graphic-content">
                <h2>Join Our Banking Family</h2>
                <p>Create your account to access all our banking services and features.</p>
                <img src="https://cdn-icons-png.flaticon.com/512/6009/6009978.png" alt="Client Registration">
            </div>
        </div>
        
        <!-- Form Side -->
        <div class="auth-form-container">
            <div class="auth-header">
                <h1 class="auth-title"><?php echo htmlspecialchars($settings->sys_name); ?></h1>
                <p class="auth-subtitle">Client Registration</p>
            </div>
            
            <div class="auth-card">
                <div class="auth-card-body">
                    <h2 class="auth-card-title">Create Account</h2>
                    <p class="auth-card-subtitle">Fill in your details to get started</p>
                    
                    <?php if (isset($success)): ?>
                    <div class="auth-success">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (isset($err)): ?>
                    <div class="auth-alert">
                        <?php echo htmlspecialchars($err); ?>
                    </div>
                    <?php endif; ?>
                    
                    <form method="post" class="auth-form">
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="national_id" class="form-label">National ID</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <input type="text" id="national_id" name="national_id" class="form-control" placeholder="Enter your national ID" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your phone number" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="address" class="form-label">Address</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <input type="text" id="address" name="address" class="form-control" placeholder="Enter your address" required>
                            </div>
                        </div>
                        
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
                                <input type="password" id="password" name="password" class="form-control" placeholder="Create a password" required>
                            </div>
                            <div class="password-hint">
                                <small>Use a strong password with at least 8 characters</small>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="create_account" class="btn btn-primary btn-block">
                                Create Account
                            </button>
                        </div>
                    </form>
                    
                    <div class="auth-footer">
                        <p>Already have an account? <a href="pages_client_index.php" class="login-link">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    
    <!-- Password Strength Indicator (optional) -->
    <!-- <script>
    $(document).ready(function() {
        $('#password').on('keyup', function() {
            let password = $(this).val();
            let strength = 0;
            
            // Check length
            if (password.length >= 8) strength++;
            // Check for mixed case
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength++;
            // Check for numbers
            if (password.match(/([0-9])/)) strength++;
            // Check for special chars
            if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength++;
            
            // Visual feedback
            $('.password-hint small').removeClass('weak medium strong');
            if (password.length > 0) {
                if (strength <= 2) {
                    $('.password-hint small').addClass('weak').text('Weak password');
                } else if (strength <= 3) {
                    $('.password-hint small').addClass('medium').text('Medium strength');
                } else {
                    $('.password-hint small').addClass('strong').text('Strong password');
                }
            }
        });
    });
    </script> -->
</body>
</html>