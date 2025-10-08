<?php
session_start();
include 'backend/db.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'login';
$error = '';
$success = '';

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    
    $sql = "SELECT id, nama_lengkap, email, password FROM customer_users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['customer_id'] = $user['id'];
            $_SESSION['customer_name'] = $user['nama_lengkap'];
            $_SESSION['customer_email'] = $user['email'];
            
            // Redirect to checkout if came from checkout
            $redirect = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : 'index.php';
            unset($_SESSION['redirect_after_login']);
            header("Location: $redirect");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak terdaftar!";
    }
}

// Handle registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $nama_lengkap = $conn->real_escape_string($_POST['nama_lengkap']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = $conn->real_escape_string($_POST['phone']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    
    // Validation
    if ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak sama!";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    } else {
        // Check if email already exists
        $check_sql = "SELECT id FROM customer_users WHERE email = '$email'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            // Hash password and insert user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO customer_users (nama_lengkap, email, password, phone, alamat) 
                    VALUES ('$nama_lengkap', '$email', '$hashed_password', '$phone', '$alamat')";
            
            if ($conn->query($sql)) {
                $success = "Registrasi berhasil! Silakan login.";
                $action = 'login';
            } else {
                $error = "Terjadi kesalahan: " . $conn->error;
            }
        }
    }
}

include 'includes/header.php';
?>

<main>
    <div style="max-width: 500px; margin: 2rem auto;">
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-bottom: 2rem;">
            <button onclick="showLogin()" id="loginBtn" class="btn <?php echo $action == 'login' ? '' : 'btn-secondary'; ?>">Login</button>
            <button onclick="showRegister()" id="registerBtn" class="btn <?php echo $action == 'register' ? '' : 'btn-secondary'; ?>">Daftar</button>
        </div>
        
        <!-- Login Form -->
        <div id="loginForm" style="display: <?php echo $action == 'login' ? 'block' : 'none'; ?>;">
            <h2>Login Pelanggan</h2>
            <form method="post">
                <label>Email:</label>
                <input type="email" name="email" required>
                
               <label>Password:</label>
                <div style="position: relative;">
                <input type="password" name="password" id="password" required style="padding-right: 40px;">
                <span onclick="togglePassword()" style="
                    position: absolute;
                    right: 10px;
                    top: 38%;
                    transform: translateY(-50%);
                    cursor: pointer;
                    font-size: 18px;
                    color: #6b5b47;
                ">👁️</span>
                </div>

                
                <button type="submit" name="login">Login</button>
            </form>
        </div>
        
        <!-- Registration Form -->
        <div id="registerForm" style="display: <?php echo $action == 'register' ? 'block' : 'none'; ?>;">
            <h2>Daftar Akun Baru</h2>
           <form action="backend/register.php" method="POST">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama" required>

                <label>Email:</label>
                <input type="email" name="email" required>

                <label>Password:</label>
<div style="position: relative;">
    <input type="password" name="password" id="password" required style="padding-right: 40px;">
    <span onclick="togglePassword()">👁️</span>
</div>

<label>Konfirmasi Password:</label>
<div style="position: relative;">
    <input type="password" name="confirm_password" id="confirm_password" required style="padding-right: 40px;">
    <span onclick="togglePasswordConfirm()">👁️</span>
</div>


                <label>No. Telepon:</label>
                <input type="text" name="telepon">

                <label>Alamat:</label>
                <textarea name="alamat"></textarea>

                <button type="submit">Daftar</button>
            </form>

        </div>
    </div>
</main>

<script>
function showLogin() {
    document.getElementById('loginForm').style.display = 'block';
    document.getElementById('registerForm').style.display = 'none';
    document.getElementById('loginBtn').className = 'btn';
    document.getElementById('registerBtn').className = 'btn btn-secondary';
    window.history.pushState({}, '', '?action=login');
}

function showRegister() {
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('registerForm').style.display = 'block';
    document.getElementById('loginBtn').className = 'btn btn-secondary';
    document.getElementById('registerBtn').className = 'btn';
    window.history.pushState({}, '', '?action=register');
}

function togglePassword() {
    const passwordInput = document.getElementById("password");
    const icon = document.querySelector("i.fa-eye, i.fa-eye-slash");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

<?php include 'includes/footer.php'; ?>